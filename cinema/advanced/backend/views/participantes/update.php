<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Participantes */

$this->title = 'Actualizar informacion del artista: ' . $model->nombres;
$this->params['breadcrumbs'][] = ['label' => 'Artistas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombres, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar información';
?>
<div class="participantes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
