<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Peliculas */

$this->title = 'Actualizar información: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Películas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="peliculas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsContenido' => $modelsContenido,
        'modelsReparto' => $modelsReparto,
        'apiData' => $apiData,
    ]) ?>

</div>
