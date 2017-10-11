<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Participantes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participantes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->dropDownList([ 'actor' => 'Actor', 'director' => 'Director', ], ['prompt' => '']) ?>

    <div>
    	<?= $form->field($model, 'imagen')->fileInput() ?>
    	<p><b>Fotografia actual: <?= ($model->fotografia != null) ? $model->fotografia : 'Ninguna' ?></b></p>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
