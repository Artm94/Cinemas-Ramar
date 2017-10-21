<?php

namespace backend\controllers;

use Yii;
use common\models\Proyeccion;
use common\models\ProyeccionSearch;
use common\models\Peliculas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProyeccionController implements the CRUD actions for Proyeccion model.
 */
class ProyeccionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Proyeccion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProyeccionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Proyeccion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Proyeccion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Proyeccion();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $movie = Peliculas::findOne($model->pelicula_id);
            $startTime = $model->fecha_funcion;
            $duracion = $movie->duracion + 15; // 15 minutos de espera entre cada pelicula
            $endTime = date('Y-m-d H:i:s', strtotime("+$duracion minutes", strtotime($startTime)));
            /*echo Proyeccion::find()->where(['and', ['sala_id' => $model->sala_id], ['between', 'fecha_funcion', $startTime, $endTime]])->orWhere(['and', ['sala_id' => $model->sala_id], ['between', 'fin_funcion', $startTime, $endTime]])->orWhere(['and', ['sala_id' => $model->sala_id], ['and', ['and', "'fecha_funcion' <= '$startTime'", "'fecha_funcion' <= '$endTime'"], ['and', "'fin_funcion' >= '$startTime'", "'fin_funcion' >= '$endTime'"]]])->createCommand()->getRawSql();
            die();*/
            $comprobar = Proyeccion::find()->where(['and', ['sala_id' => $model->sala_id], ['between', 'fecha_funcion', $startTime, $endTime]])->orWhere(['and', ['sala_id' => $model->sala_id], ['between', 'fin_funcion', $startTime, $endTime]])->orWhere(['and', ['sala_id' => $model->sala_id], ['and', ['and', "'fecha_funcion' <= '$startTime'", "'fecha_funcion' <= '$endTime'"], ['and', "'fin_funcion' >= '$startTime'", "'fin_funcion' >= '$endTime'"]]])->all();
            if(empty($comprobar)){
                $model->fin_funcion = $endTime;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            $model->addError('fecha_funcion', 'Ya existe una función programada para esta fecha y sala');
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Proyeccion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $movie = Peliculas::findOne($model->pelicula_id);
            $startTime = strtotime($model->fecha_funcion);
                $duracion = $movie->duracion + 15; //15 minutos de espera entre funcion y funcion
                $endTime = strtotime("+$duracion minutes", $startTime);
                $model->fin_funcion = date('Y-m-d H:i:s', $endTime);
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

    /**
     * Deletes an existing Proyeccion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Proyeccion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proyeccion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proyeccion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
