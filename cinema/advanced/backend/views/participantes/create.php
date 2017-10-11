<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Participantes */

$this->title = 'Añadir Artista';
$this->params['breadcrumbs'][] = ['label' => 'Artistas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participantes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
