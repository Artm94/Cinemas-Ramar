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
require_once("../../common/custom/conekta-php/lib/Conekta.php");

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
            \Conekta\Conekta::setApiKey("key_RqhwraedesBnkJEvzjMeKw");
            \Conekta\Conekta::setApiVersion("2.0.0");
            $userprofile = PerfilUsuario::findOne(Yii::$app->user->id);
            $user = User::findOne(Yii::$app->user->id);
            $token = Yii::$app->request->post('token');
            $client = $model->card_name;
            $customer;
            if(empty($userprofile->conekta_id)){
                $customer = $this->createCustomer($user, $userprofile);
                $userprofile->conekta_id = $customer->id;
                $userprofile->save();
            }else{
                $customer = \Conekta\Customer::find($userprofile->conekta_id);
            }            
            $compras = array();
            $line_items = array();
            $amount = 0;
            foreach ($model->items as $item) {
            $values = explode(',', $item);
            $boletoId = 'bl' . uniqid();
            $compras[] = [$boletoId, Yii::$app->user->identity->id, $proyeccion->id, $values[1], $values[0], date('Y-m-d H:s:i'), $proyeccion->precio];
            $line_items[] = ['name' => $boletoId, 'unit_price' => ($proyeccion->precio * 100), 'quantity' => 1, 'antifraud_info' => ['starts_at' => strtotime($proyeccion->fecha_funcion), 'ends_at' => strtotime($proyeccion->fin_funcion), 'ticket_class' => 'VIP', 'seat_number' => ($values[1] . $values[0])]];
            $amount += intval($proyeccion->precio)*100;
            }
            $order = $this->createOrder($line_items,$customer,$amount,$token);
            if(isset($order['errorType'])){
                $model->addError('card_number', $order['errorMessage']);
            }else{
                Yii::$app->db->createCommand()->batchInsert('boletos', ['id', 'usuario_id', 'proyeccion_id', 'numero_asiento', 'fila_asiento', 'fecha_compra', 'precio'],$compras)->execute();

            return $this->render('recibo', [
            'proyeccion' => $proyeccion,
            'compras' => $compras,
            ]);
            }             
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

    public function createCustomer($user, $userprofile)
    {        
        try {
          $customer = \Conekta\Customer::create(
            array(
                "name" =>  $userprofile->nombres . ' ' . $userprofile->apellidos,
                "email" => $user->email,
                "phone" => strval($userprofile->telefono),
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
            "metadata" => array("reference" => uniqid(), "more_info" => "Movie ticket"),
            "charges" => array(                
                array(
                    "payment_method" => array( 
                        "token_id" => $token,
                        "type" => "card"                        
                    ),//payment_method
                "amount" => $total
                ) //first charge        
            ) //charges
            )//order
            );
            return $order;
        } catch (\Conekta\ProccessingError $error){
            return ['errorType' => 'ProccessingError', 'errorMessage' => $error->getMessage()];
        } catch (\Conekta\ParameterValidationError $error){
          return ['errorType' => 'ParameterValidationError', 'errorMessage' => $error->getMessage()];
        } catch (\Conekta\Handler $error){
          return ['errorType' => 'Handler', 'errorMessage' => $error->getMessage()];
        }
    }

}
