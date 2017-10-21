<?php

namespace backend\controllers;

use Yii;
use common\models\Peliculas;
use common\models\PeliculasSearch;
use common\models\Participantes;
use common\models\Contenido;
use common\models\Reparto;
use backend\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\custom\MovieFinder;
use backend\models\ApiOptions;
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
        $modelApiOptions = new ApiOptions();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $flag = true;
            $modelApiOptions->load(Yii::$app->request->post());
            $finder = new MovieFinder('e01a182bdeed3afc056d41564eba1bdd', 'es');
            $movie = (empty($modelApiOptions->movieId)) ? null : $finder->getMovieById($modelApiOptions->movieId);
            //echo "Carga modelo POST";
            $transaction = \Yii::$app->db->beginTransaction();
            try{
                //print_r(Yii::$app->request->post());
                //print_r($modelApiOptions);

                if($modelApiOptions->movieInformation && !empty($movie)){
                        //echo "carga movieInformation";
                    $model->duracion = $movie->runtime;
                    $model->descripcion = $movie->tagline;
                    $model->resena = $movie->overview;
                    $model->save(false);
                        //echo "guarda modelo";
                }else{
                    $model->save(false);
                }
                if($modelApiOptions->movieMediaContent && !empty($movie)){
                        //echo "carga media";
                    $data = array();
                    $data[] = [$model->id,$model->nombre . ' poster',$finder->getImage($movie->poster_path),'portada'];
                    $data[] = [$model->id,$model->nombre . ' backdrop',$finder->getImage($movie->backdrop_path, 'w1920'),'fondo'];
                    $videos = $finder->getVideosById($modelApiOptions->movieId, 'en');
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
                        //echo "guarda media";        
                }else{
                    $modelsContenido = Model::createMultiple(Contenido::classname());
                    Model::loadMultiple($modelsContenido, Yii::$app->request->post());
                            //Valida contenido offline
                    $validContenido = Model::validateMultiple($modelsContenido);
                    if($validContenido){
                        foreach ($modelsContenido as $index => $modelContenido) {
                            $modelContenido->file = UploadedFile::getInstance($modelContenido, "[{$index}]file");
                            if(!empty($modelContenido->file)){
                                $modelContenido->file->saveAs('img/movies/' . $modelContenido->nombre . $modelContenido->tipo . '.' . $modelContenido->file->extension);
                                $modelContenido->url = Url::to('@web') . '/img/movies/' . $modelContenido->nombre . $modelContenido->tipo . '.' . $modelContenido->file->extension;
                            }
                            $modelContenido->pelicula_id = $model->id;
                            if (! ($flag = $modelContenido->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                }
                if($modelApiOptions->movieCredits && !empty($movie)){
                        //echo "carga credits";
                    $participantes = array();
                    $peliculaParticipantes = array();
                    $credits = $movie->credits->cast;
                    foreach ($credits as $actor) {
                        $participante = Participantes::find()->where(['nombres' => $actor->name])->orWhere(['id' => $actor->id])->one();
                        if(empty($participante)){
                            if(!empty($actor->profile_path)){
                                $participantes[] = [$actor->id, $actor->name, "actor", $finder->getImage($actor->profile_path)];
                                $peliculaParticipantes[] = [$model->id, $actor->id];
                            }
                                //echo "agregar actor";
                        }else{
                            $peliculaParticipantes[] = [$model->id, $participante->id];
                                //echo "enlaza actor";
                        }
                    }

                    Yii::$app->db->createCommand()->batchInsert('participantes', ['id', 'nombres', 'tipo', 'fotografia'],$participantes)->execute();
                    Yii::$app->db->createCommand()->batchInsert('reparto', ['pelicula_id', 'participante_id'],$peliculaParticipantes)->execute();
                        //echo "guarda actores y enlaces";
                }else{
                    $modelsReparto = Model::createMultiple(Reparto::classname());
                    Model::loadMultiple($modelsReparto, Yii::$app->request->post());
                    $validReparto = Model::validateMultiple($modelsReparto);
                    if($validReparto){
                        foreach ($modelsReparto as $modelReparto) {
                            $modelReparto->pelicula_id = $model->id;
                            if (!($flag = $modelReparto->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                }

            }catch (Exception $e) {
                $transaction->rollBack();
                echo $e;
            }
            if($flag){
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'modelsContenido' => (empty($modelsContenido)) ? [new Contenido] : $modelsContenido,
                    'modelsReparto' => (empty($modelsReparto)) ? [new Reparto] : $modelsReparto,
                    'apiData' => $modelApiOptions,
                ]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsContenido' => (empty($modelsContenido)) ? [new Contenido] : $modelsContenido,
                'modelsReparto' => (empty($modelsReparto)) ? [new Reparto] : $modelsReparto,
                'apiData' => $modelApiOptions,
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
        $modelApiOptions = new ApiOptions();
        $finder;
        $movie;
        $flag = true;
        if ($model->load(Yii::$app->request->post()) && ($flag = $flag && $model->validate())) {
            $modelApiOptions->load(Yii::$app->request->post());
            $transaction = \Yii::$app->db->beginTransaction();
            try{
                if(!empty($modelApiOptions->movieId)){
                    $finder = new MovieFinder('e01a182bdeed3afc056d41564eba1bdd', 'es');
                    $movie = $finder->getMovieById($modelApiOptions->movieId);
                }
                if($modelApiOptions->movieInformation && !empty($movie)){
                    $model->resena = $movie->overview;
                    $model->descripcion = $movie->tagline;
                    $model->duracion = $movie->runtime;
                }
                $flag = $flag && ($model->save());
                if($modelApiOptions->movieMediaContent && !empty($movie)){
                        //echo "carga media";
                    $data = array();
                    $data[] = [$model->id,$model->nombre . ' poster',$finder->getImage($movie->poster_path),'portada'];
                    $data[] = [$model->id,$model->nombre . ' backdrop',$finder->getImage($movie->backdrop_path, 'w1920'),'fondo'];
                    $videos = $finder->getVideosById($modelApiOptions->movieId, 'en');
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
                        //echo "guarda media";        
                }else{
                    $oldContenidoIDs = ArrayHelper::map($modelsContenido, 'id', 'id');
                    $modelsContenido = Model::createMultiple(Contenido::classname(), $modelsContenido);
                    Model::loadMultiple($modelsContenido, Yii::$app->request->post());
                    $deletedContenidoIDs = array_diff($oldContenidoIDs, array_filter(ArrayHelper::map($modelsContenido, 'id', 'id')));
                    $flag = $flag && Model::validateMultiple($modelsContenido);
                    if($flag){
                        //Elimina de la BD los contenidos eliminados
                        if (! empty($deletedContenidoIDs)) {
                            Contenido::deleteAll(['id' => $deletedContenidoIDs]);
                        }
                        foreach ($modelsContenido as $index => $modelContenido) {
                            $modelContenido->file = UploadedFile::getInstance($modelContenido, "[{$index}]file");
                            if(!empty($modelContenido->file)){
                                $modelContenido->file->saveAs('img/movies/' . $modelContenido->nombre . $modelContenido->tipo . '.' . $modelContenido->file->extension);
                                $modelContenido->url = Url::to('@web') . '/img/movies/' . $modelContenido->nombre . $modelContenido->tipo . '.' . $modelContenido->file->extension;
                            }
                            $modelContenido->pelicula_id = $model->id;
                            if (! ($flag = $modelContenido->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                }

                if($modelApiOptions->movieCredits && !empty($movie)){
                    //echo "carga credits";
                    $participantes = array();
                    $peliculaParticipantes = array();
                    $credits = $movie->credits->cast;
                    foreach ($credits as $actor) {
                        $participante = Participantes::find()->where(['nombres' => $actor->name])->orWhere(['id' => $actor->id])->one();
                        if(empty($participante)){
                            if(!empty($actor->profile_path)){
                                $participantes[] = [$actor->id, $actor->name, "actor", $finder->getImage($actor->profile_path)];
                                $peliculaParticipantes[] = [$model->id, $actor->id];
                            }
                                //echo "agregar actor";
                        }else{
                            $peliculaParticipantes[] = [$model->id, $participante->id];
                                //echo "enlaza actor";
                        }
                    }
                    Reparto::deleteAll(['pelicula_id' => $model->id]);
                    Yii::$app->db->createCommand()->batchInsert('participantes', ['id', 'nombres', 'tipo', 'fotografia'],$participantes)->execute();
                    Yii::$app->db->createCommand()->batchInsert('reparto', ['pelicula_id', 'participante_id'],$peliculaParticipantes)->execute();
                }else{
                    $oldRepartoIDs = ArrayHelper::map($modelsReparto, 'id', 'id');
                    $modelsReparto = Model::createMultiple(Reparto::classname(), $modelsReparto);
                    Model::loadMultiple($modelsReparto, Yii::$app->request->post());
                    $deletedRepartoIDs = array_diff($oldRepartoIDs, array_filter(ArrayHelper::map($modelsReparto, 'id', 'id')));
                    if(Model::validateMultiple($modelsReparto)){
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

            }catch(Exception $e){
                $transaction->rollBack();
                echo $e;
            }
            if($flag){
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'modelsContenido' => (empty($modelsContenido)) ? [new Contenido] : $modelsContenido,
                    'modelsReparto' => (empty($modelsReparto)) ? [new Reparto] : $modelsReparto,
                    'apiData' => $modelApiOptions,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsContenido' => (empty($modelsContenido)) ? [new Contenido] : $modelsContenido,
                'modelsReparto' => (empty($modelsReparto)) ? [new Reparto] : $modelsReparto,
                'apiData' => $modelApiOptions,
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
