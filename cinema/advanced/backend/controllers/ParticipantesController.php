<?php

namespace backend\controllers;

use Yii;
use common\models\Participantes;
use common\models\ParticipantesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * ParticipantesController implements the CRUD actions for Participantes model.
 */
class ParticipantesController extends Controller
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
     * Lists all Participantes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParticipantesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Participantes model.
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
     * Creates a new Participantes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Participantes();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->imagen = UploadedFile::getInstance($model, 'imagen');

            if(!empty($model->imagen)){
                    $model->imagen->saveAs('img/artist/' . $model->nombres . $model->tipo . '.' . $model->imagen->extension);
                    $model->fotografia = Url::to('@web') . '/img/artist/' . $model->nombres . $model->tipo . '.' . $model->imagen->extension;
            }

            if($model->save(false)){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render(['site/error'], ['message' => $model->getFirstError()]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Participantes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $model->imagen = UploadedFile::getInstance($model, 'imagen');

            if(!empty($model->imagen)){
                    $model->imagen->saveAs('img/artist/'  . $model->nombres . $model->tipo . '.' . $model->imagen->extension);
                    $model->fotografia = Url::to('@web') . '/img/artist/' . $model->nombres . $model->tipo . '.' . $model->imagen->extension;
            }

            if($model->save(false)){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render(['site/error'], ['message' => $model->getFirstError()]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Participantes model.
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
     * Finds the Participantes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Participantes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Participantes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
