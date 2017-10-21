<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Proyeccion */

$this->title = 'Proyección de: ' . $model->pelicula->nombre . " ($model->fecha_funcion)";
$this->params['breadcrumbs'][] = ['label' => 'Proyecciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proyeccion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sala_id',
            'pelicula_id',
            'fecha_funcion',
            'fin_funcion',
            'precio',
        ],
    ]) ?>

</div>
