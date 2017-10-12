<?php

namespace frontend\controllers;

use Yii;
use common\models\Proyeccion;
use yii\helpers\Json;
use frontend\models\PaymentData;
use common\models\Boletos;
use common\models\PerfilUsuario;
use common\models\User;
use yii\web\NotFoundHttpException;
require_once("../../common/custom/conektasdk/lib/Conekta.php");

class ProyeccionController extends \yii\web\Controller
{
    public function actionComprar($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        date_default_timezone_set('America/Mexico_City');
    	$model = new PaymentData();
        $proyeccion = $this->findModel($id);
        if($model->load(Yii::$app->request->post()) && $model->items = Yii::$app->request->post('items')){
            $userprofile = PerfilUsuario::findOne(Yii::$app->user->id);
            $user=User::findOne(Yii::$app->user->id);
            $token = Yii::$app->request->post('token');            
            //print_r($token);
            //$client = Yii::$app->request->post("PaymentData")['card_name'];
            $client = $model->card_name;
            //print_r($client);            
            $customer = $this->createCustomer($client, $user,$userprofile, $token);
            //echo $customer->id;                    
            //die();
            $src_token = $customer->default_payment_source_id;            
            $compras = array();
            $amount = 0;
            foreach ($model->items as $item) {
            $values = explode(',', $item);
            $compras[] = ['bl' . uniqid(), Yii::$app->user->identity->id, $proyeccion->id, $values[1], $values[0], date('Y-m-d H:s:i'), $proyeccion->precio];
            $amount+= intval($proyeccion->precio);
            }
            $lugar = Yii::$app->request->post('items');
            //print_r($lugar);
            //$lugar_row = explode(",",$lugar[0]);
            //echo $lugar_row[1].$lugar_row[0];
            //print_r($lugar_row);            
            $items = $this->arrayLineItem($compras,$lugar);
            //echo $amount;
            $this->createOrder($items,$customer,$amount,$src_token);
            //print_r($items);            
            die();                   
            Yii::$app->db->createCommand()->batchInsert('boletos', ['id', 'usuario_id', 'proyeccion_id', 'numero_asiento', 'fila_asiento', 'fecha_compra', 'precio'],$compras)->execute();

            return $this->render('recibo', [
            'proyeccion' => $proyeccion,
            'compras' => $compras,
            ]);
        }
        return $this->render('comprar', [
        	'model' => $model,
            'proyeccion' => $proyeccion,
        	]);
    }

    public function actionListarAsientos($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $proyeccion = $this->findModel($id);
        $boletos = $proyeccion->boletos;
        $asientos = array();
        foreach ($boletos as $boleto) {
            $asientos[] = ['fila' => $boleto->fila_asiento, 'numero' => $boleto->numero_asiento];
        }
        return Json::encode($asientos);
    }

    public function actionGenerarRecibo($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $boleto = Boletos::findOne($id);
        if($boleto !== null && $boleto['usuario_id'] == Yii::$app->user->identity->id){
            $pdf = Yii::$app->pdf;
            $pdf->content = $this->renderPartial('boucher', [
                'boleto' => $boleto,
                ]);
            return $pdf->render();
        }else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

     protected function findModel($id)
    {
        if (($model = Proyeccion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('La página solicitada no existe');
        }
    }

    public function createCustomer($client, $user, $userprofile, $token)
    {        
        \Conekta\Conekta::setApiKey("key_RqhwraedesBnkJEvzjMeKw");
        \Conekta\Conekta::setApiVersion("2.0.0");
        try {
          $customer = \Conekta\Customer::create(
            array(
                "name" =>  $client,
                "email" => $user->email,
                "phone" => strval($userprofile->telefono),
                "payment_sources" => array(
                    array(
                        "type" => "card",
                        "token_id" => $token
                    )
                  )
                )
            );
          return $customer;
        } catch (\Conekta\ProccessingError $error){
          echo $error->getMesage();
        } catch (\Conekta\ParameterValidationError $error){
          echo $error->getMessage();
        } catch (\Conekta\Handler $error){
          echo $error->getMessage();
        }
    }

    public function arrayLineItem($compras,$lugar){
        $items = array();
        $indice=0;
        foreach ($compras as $compra) {
            $fecha = date_create();
            $fecha_fin = date_create("10/12/2018");
            $lugar_row = explode(",",$lugar[$indice]);
            $sitio = $lugar_row[1].$lugar_row[0];
            //print_r($lugar_row);
            //$info = array();
            //$info[] = [];
            $items[] = ['name' => $compra[0], 'unit_price' => intval($compra[6])+100, 'quantity'=>1,'antifraud_info'=>array('starts_at'=>date_timestamp_get($fecha), 'ends_at'=>date_timestamp_get($fecha_fin), 'ticket_class'=>"VIP",'seat_number'=>$sitio)];
            $indice++;
        }
        return $items;
    }


    public function createOrder($items,$customer,$total,$token){
        try{
            $order = \Conekta\Order::create(
            array(
                "line_items" => $items
            , //line_items
            "currency" => "MXN",
            "customer_info" => array(
                                    "customer_id" => $customer->id
                                ), //customer_info            
            "metadata" => array("reference" => uniqid(), "more_info" => "some description"),
            "charges" => array(                
                array(
                    "payment_method" => array( 
                        "payment_source_id" => $token,
                        "type" => "card"                        
                    ),//payment_method
                "amount" => $total+200
                ) //first charge        
            ) //charges
            )//order
            );
        } catch (\Conekta\ProccessingError $error){
            echo $error->getMesage();
        } catch (\Conekta\ParameterValidationError $error){
          echo $error->getMessage();
        } catch (\Conekta\Handler $error){
          echo $error->getMessage();
        }
    }

}