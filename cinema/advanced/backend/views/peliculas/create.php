<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Peliculas */

$this->title = 'Agregar nueva película';
$this->params['breadcrumbs'][] = ['label' => 'Peliculas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peliculas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsContenido' => $modelsContenido,
        'modelsReparto' => $modelsReparto,
        'apiData' => $apiData
    ]) ?>

</div>
