<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Proyeccion */

$this->title = 'Actualizar proyeccion: ' . $model->pelicula->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Proyecciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pelicula->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar información';
?>
<div class="proyeccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
