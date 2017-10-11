<?php

namespace backend\controllers;

use Yii;
use common\models\Peliculas;
use common\models\PeliculasSearch;
use common\models\Contenido;
use common\models\Reparto;
use backend\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\base\DynamicModel;
use common\custom\MovieFinder;
use yii\web\UploadedFile;
use yii\helpers\Url;
/**
 * PeliculasController implements the CRUD actions for Peliculas model.
 */
class PeliculasController extends Controller
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
     * Lists all Peliculas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PeliculasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Peliculas model.
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
     * Creates a new Peliculas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Peliculas();
        $modelsContenidos = [new Contenido];
        $modelsRepartos = [new Reparto];

        $apiData = new DynamicModel(['apiFlag']);
        $apiData->addRule(['apiFlag'], 'integer');

        if ($model->load(Yii::$app->request->post())) {
            //Reparto de la pelicula
            $modelsReparto = Model::createMultiple(Reparto::classname());
            Model::loadMultiple($modelsReparto, Yii::$app->request->post());
            // Valida los campos
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsReparto) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        //Cargar contenido
                        if($apiData->load(Yii::$app->request->post()) && $apiData->validate()){
                            //Contenido Online
                            $finder = new MovieFinder('e01a182bdeed3afc056d41564eba1bdd', 'es');
                            $movie = $finder->getMovieById($apiData->apiFlag);
                            $data[] = [$model->id,$model->nombre . ' poster',$finder->getImage($movie->poster_path),'portada'];
                            $data[] = [$model->id,$model->nombre . ' backdrop',$finder->getImage($movie->backdrop_path, 'w1920'),'fondo'];
                            $videos = $finder->getVideosById($apiData->apiFlag, 'en');
                            if(count($videos) > 0){
                                foreach ($videos as $video) {
                                    if($video->site = 'YouTube' && $video->type == 'Trailer'){
                                        $data[] = [$model->id,$video->name,'https://www.youtube.com/embed/'.$video->key,'trailer'];
                                    }
                                }
                            }
                            foreach ($movie->images->backdrops as $image) {
                                $data[] = [$model->id,$model->nombre . ' image',$finder->getImage($image->file_path, 'w1920'),'imagen'];
                            }

                            Yii::$app->db->createCommand()->batchInsert('contenido', ['pelicula_id', 'nombre', 'url', 'tipo'],$data)->execute();

                        }else{
                            //Contenido audiovisual de la pelicula offline
                            $modelsContenido = Model::createMultiple(Contenido::classname());
                            Model::loadMultiple($modelsContenido, Yii::$app->request->post());
                            //Valida contenido offline
                            $validContenido = Model::validateMultiple($modelsContenido);
                            if($validContenido){
                                foreach ($modelsContenido as $index => $modelContenido) {
                                $modelContenido->file = UploadedFile::getInstance($modelContenido, "[{$index}]file");
                                if(!empty($modelContenido->file)){
                                    $modelContenido->file->saveAs('img/movies/' . $modelContenido->nombre . $modelContenido->tipo . '.' . $modelContenido->file->extension);
                                    $modelContenido->url = Url::to('@web') . 'img/movies/' . $modelContenido->nombre . $modelContenido->tipo . '.' . $modelContenido->file->extension;
                                }
                                $modelContenido->pelicula_id = $model->id;
                                if (! ($flag = $modelContenido->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                }
                            }
                        }
                        //Cargar reparto
                        foreach ($modelsReparto as $modelReparto) {
                            $modelReparto->pelicula_id = $model->id;
                            if (!($flag = $modelReparto->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsContenido' => (empty($modelsContenido)) ? [new Contenido] : $modelsContenido,
                'modelsReparto' => (empty($modelsReparto)) ? [new Reparto] : $modelsReparto,
                'apiData' => $apiData,
            ]);
        }
    }

    /**
     * Updates an existing Peliculas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsContenido = Contenido::find()->where(['pelicula_id' => $id])->all();
        $modelsReparto = Reparto::find()->where(['pelicula_id' => $id])->all();

        $apiData = new DynamicModel(['apiFlag']);
        $apiData->addRule(['apiFlag'], 'integer');

        if ($model->load(Yii::$app->request->post())) {
            $oldContenidoIDs = ArrayHelper::map($modelsContenido, 'id', 'id');
            $modelsContenido = Model::createMultiple(Contenido::classname(), $modelsContenido);
            Model::loadMultiple($modelsContenido, Yii::$app->request->post());
            $deletedContenidoIDs = array_diff($oldContenidoIDs, array_filter(ArrayHelper::map($modelsContenido, 'id', 'id')));

            $oldRepartoIDs = ArrayHelper::map($modelsReparto, 'id', 'id');
            $modelsReparto = Model::createMultiple(Reparto::classname(), $modelsReparto);
            Model::loadMultiple($modelsReparto, Yii::$app->request->post());
            $deletedRepartoIDs = array_diff($oldRepartoIDs, array_filter(ArrayHelper::map($modelsReparto, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsContenido) && $valid;
            $valid = Model::validateMultiple($modelsReparto) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        if($apiData->load(Yii::$app->request->post()) && $apiData->validate()){
                            //Contenido Online
                            $finder = new MovieFinder('e01a182bdeed3afc056d41564eba1bdd', 'es');
                            $movie = $finder->getMovieById($apiData->apiFlag);
                            $data[] = [$model->id,$model->nombre . ' poster',$finder->getImage($movie->poster_path),'portada'];
                            $data[] = [$model->id,$model->nombre . ' backdrop',$finder->getImage($movie->backdrop_path, 'w1920'),'fondo'];
                            $videos = $finder->getVideosById($apiData->apiFlag, 'en');
                            if(count($videos) > 0){
                                foreach ($videos as $video) {
                                    if($video->site = 'YouTube' && $video->type == 'Trailer'){
                                        $data[] = [$model->id,$video->name,'https://www.youtube.com/embed/'.$video->key,'trailer'];
                                    }
                                }
                            }
                            foreach ($movie->images->backdrops as $image) {
                                $data[] = [$model->id,$model->nombre . ' image',$finder->getImage($image->file_path, 'w1920'),'imagen'];
                            }
                            Contenido::deleteAll(['pelicula_id' => $model->id]);
                            Yii::$app->db->createCommand()->batchInsert('contenido', ['pelicula_id', 'nombre', 'url', 'tipo'],$data)->execute();

                        }else{
                            //Elimina de la BD los contenidos eliminados
                            if (! empty($deletedContenidoIDs)) {
                                Contenido::deleteAll(['id' => $deletedContenidoIDs]);
                            }
                            foreach ($modelsContenido as $index => $modelContenido) {
                                $modelContenido->file = UploadedFile::getInstance($modelContenido, "[{$index}]file");
                                if(!empty($modelContenido->file)){
                                    $modelContenido->file->saveAs('img/movies/' . $modelContenido->nombre . $modelContenido->tipo . '.' . $modelContenido->file->extension);
                                    $modelContenido->url = Url::to('@web') . 'img/movies/' . $modelContenido->nombre . $modelContenido->tipo . '.' . $modelContenido->file->extension;
                                }
                                $modelContenido->pelicula_id = $model->id;
                                if (! ($flag = $modelContenido->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                            //Elimina de la BD los participantes eliminados
                            if (! empty($deletedRepartoIDs)) {
                                Reparto::deleteAll(['id' => $deletedRepartoIDs]);
                            }
                            foreach ($modelsReparto as $modelReparto) {
                                $modelReparto->pelicula_id = $model->id;
                                if (! ($flag = $modelReparto->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('update', [
            'model' => $model,
            'modelsContenido' => (empty($modelsContenido)) ? [new Contenido] : $modelsContenido,
            'modelsReparto' => (empty($modelsReparto)) ? [new Reparto] : $modelsReparto,
            'apiData' => $apiData,
        ]);
        }
    }

    /**
     * Deletes an existing Peliculas model.
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
     * Finds the Peliculas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Peliculas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Peliculas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
