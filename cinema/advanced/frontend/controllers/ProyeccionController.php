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
            $userprofile = PerfilUsuario::findOne(Yii::$app->user->id);
            $user=User::findOne(Yii::$app->user->id);
            $token = Yii::$app->request->post('token');
            $customer_name = $model->card_name;
            $customer = $this->createCustomer($customer_name, $user,$userprofile, $token);
            $total = count($model->items) * $proyeccion->precio;
            $line_items = array(
                'name' => 'Boleto para ' . $proyeccion->pelicula->nombre,
                'unit_price' => intval($proyeccion->precio),
                'quantity' => count($model->items),
                );
            $resp = $this->createOrder($customer, $line_items, $total, $token);
            echo $resp;
            die();
            $compras = array();
            foreach ($model->items as $item) {
            $values = explode(',', $item);
            $compras[] = ['bl' . uniqid(), Yii::$app->user->identity->id, $proyeccion->id, $values[1], $values[0], date('Y-m-d H:s:i'), $proyeccion->precio];
            }
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

    protected function createCustomer($client, $user, $userprofile, $token)
    {
        \Conekta\Conekta::setApiKey("key_RqhwraedesBnkJEvzjMeKw");
        \Conekta\Conekta::setApiVersion("2.0.0");
        try {
          $response = \Conekta\Customer::create(
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
          return $response;
        } catch (\Conekta\ProccessingError $error){
          echo $error->getMesage();
        } catch (\Conekta\ParameterValidationError $error){
          echo $error->getMessage();
        } catch (\Conekta\Handler $error){
          echo $error->getMessage();
        }
    }

    protected function createOrder($customer, $items, $total, $token)
    {
        $customer = json_decode($customer);
        print_r($customer);
        die();
        try{
          $order = \Conekta\Order::create(
            array(
              "line_items" => array(
                $items,
                //first line_item
              ), //line_items
              "shipping_lines" => array(
                array(
                  "amount" => $total,
                   "carrier" => "CINEMAS STUMPY"
                )
              ), //shipping_lines
              "currency" => "MXN",
              "customer_info" => array(
                "customer_id" => $customer->id,
              ), //customer_info
              "shipping_contact" => array(
                "phone" => $customer->phone,
                "receiver" => $customer->name,
                "address" => array(
                  "street1" => "Calle 123 int 2 Col. Chida",
                  "city" => "Cuahutemoc",
                  "state" => "Ciudad de Mexico",
                  "country" => "MX",
                  "postal_code" => "06100",
                  "residential" => true
                )//address
              ), //shipping_contact
              "metadata" => array("reference" => "12987324097", "more_info" => "lalalalala"),
              "charges" => array(
                  array(
                      "payment_method" => array(
                        "token_id" => $token,
                        "payment_source_id" => $customer->default_payment_source,
                              "type" => 'card',
                      )//payment_method
                  ) //first charge
              ) //charges
            )//order
          );
            return $order;
        } catch (\Conekta\ProccessingError $error){
          echo $error->getMesage();
        } catch (\Conekta\ParameterValidationError $error){
          echo $error->getMessage();
        } catch (\Conekta\Handler $error){
          echo $error->getMessage();
        }
    }

}
