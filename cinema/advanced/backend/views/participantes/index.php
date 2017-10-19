<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ParticipantesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Artistas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participantes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Añadir artista', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombres',
            'tipo',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view} {update}'],
        ],
    ]); ?>
</div>
