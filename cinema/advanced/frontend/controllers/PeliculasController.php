<?php

namespace frontend\controllers;

use Yii;
use common\models\Peliculas;
use common\models\Proyeccion;
use yii\web\NotFoundHttpException;

class PeliculasController extends \yii\web\Controller
{
    public function actionCartelera()
    {
    	/*date_default_timezone_set('America/Mexico_City');
    	$inicioSemana = date('Y-m-d', strtotime("Monday this week"));
    	$finSemana = date('Y-m-d', strtotime("Sunday this week"));
    	$proyecciones = Proyeccion::find()->where("fecha_funcion>='$inicioSemana'")
    									  ->andWhere("fecha_funcion<='$finSemana'")
    									  ->all();
    	/*print_r($proyecciones);
    	die();*/
        date_default_timezone_set('America/Mexico_City');
        $inicioSemana = date('Y-m-d H:i:s', strtotime("next hour"));
        $finSemana = date('Y-m-d H:i:s', strtotime("Sunday this week"));
        /*$peliculas = Peliculas::find()->distinct(true)->viaTable('proyecciones', ['pelicula_id' => 'id', "'fecha_funcion'>='$inicioSemana'", "'fecha_funcion'<='$finSemana'"])->all();*/
        $peliculas = Peliculas::find()->distinct(true)->where("id IN (SELECT pelicula_id FROM proyeccion WHERE fecha_funcion>='$inicioSemana' AND fecha_funcion<='$finSemana')")->all();
        return $this->render('cartelera', [
        	'peliculas' => $peliculas
        	]);
    }

    public function actionView($id)
    {
        date_default_timezone_set('America/Mexico_City');
        $inicioSemana = date('Y-m-d H:i:s', strtotime("next hour"));
        $finSemana = date('Y-m-d H:i:s', strtotime("Sunday this week"));
        $model = $this->findModel($id);
        $proyecciones = Proyeccion::find()->where(['pelicula_id' => $id])->andWhere("fecha_funcion>='$inicioSemana' AND fecha_funcion<='$finSemana'")->all();
        return $this->render('view', [
            'model' => $model,
            'proyecciones' => $proyecciones
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Peliculas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
