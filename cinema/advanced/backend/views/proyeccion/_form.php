<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Salas;
use common\models\Peliculas;
use kartik\datetime\DateTimePicker;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Proyeccion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proyeccion-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=
        $form->field($model, 'sala_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Salas::find()->where(['disponible' => true])->all(), 'id', 'id'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una sala...'],
        'pluginOptions' => [
         'allowClear' => true
                            ],
                      ]);
     ?>

    <?=
        $form->field($model, 'pelicula_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Peliculas::find()->all(), 'id', 'nombre', 'clasificacion'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una pelicula...'],
        'pluginOptions' => [
         'allowClear' => true
                            ],
                      ]);
     ?>

     <?php
     	date_default_timezone_set('America/Mexico_City');
    	echo $form->field($model, 'fecha_funcion')->widget(DateTimePicker::classname(), [
    	'name' => 'datetime_10',
	    'options' => ['placeholder' => 'Seleccione el dia y hora para proyectar la funcion...'],
	    'pluginOptions' => [
	    	'autoclose'=>true,
	        'format' => 'yyyy-mm-dd hh:ii',
	        'startDate' => date('Y-m-d H:i:s'),
	        'todayHighlight' => true
	    ]
    	])
      ?>

    <?= $form->field($model, 'precio')->textInput(['placeholder' => 'Ingrese un precio en pesos (MXN)...']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
