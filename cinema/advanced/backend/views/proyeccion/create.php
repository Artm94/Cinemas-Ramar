<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Proyeccion */

$this->title = 'Crear Proyección';
$this->params['breadcrumbs'][] = ['label' => 'Proyecciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proyeccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
