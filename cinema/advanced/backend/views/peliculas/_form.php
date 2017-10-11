<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use common\models\Participantes;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Peliculas */
/* @var $form yii\widgets\ActiveForm */
$participantesList = ArrayHelper::map(Participantes::find()->all(), 'id', 'nombres', 'tipo');
?>

<div class="peliculas-form">

    <?php $form = ActiveForm::begin(['options' => [
        'enctype' => 'multipart/form-data',
         'id' => 'dynamic-form'
    ]]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resena')->textarea(['column' => 5]) ?>

    <?= $form->field($model, 'clasificacion')->dropDownList([ 'PGEI16' => 'PGEI16', 'PGEI18' => 'PGEI18', ], ['prompt' => 'Seleccione una clasificación']) ?>

    <?= $form->field($model, 'calificacion')->dropDownList(['1' => 'Estrellas: ★', '2' => 'Estrellas: ★★', '3' => 'Estrellas: ★★★', '4' => 'Estrellas: ★★★★', '5' => 'Estrellas: ★★★★★'], ['prompt' => 'Seleccione una calificación']) ?>

    <?= $form->field($apiData, 'apiFlag')->checkbox(['label' => 'Obtener material audio visual directamente de Internet','uncheck' => null, 'value' => 0, 'class' => 'checkFlag']);?>

    <div class="box box-solid">
                <div id="search-title" class="box-header">
                </div>
                <div class="box-body">
                    <div id="search-items" class="row">
                    </div>
                </div>
            </div>

    <div class="contenido-container">
    <div class="rows contenido-view">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Material audiovisual de la pelicula</h4>
            </div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsContenido[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'nombre',
                    'file',
                    'tipo',
                ],
            ]); ?>
            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsContenido as $i => $modelContenido): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Contenido</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelContenido->isNewRecord) {
                                echo Html::activeHiddenInput($modelContenido, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelContenido, "[{$i}]nombre")->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelContenido, "[{$i}]file")->fileInput(['class' => (empty($modelContenido->url)) ? 'no-file' : 'has-file']) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelContenido, "[{$i}]tipo")->dropDownList([ 'trailer' => 'Trailer', 'imagen' => 'Imagen', 'portada' => 'Portada', 'fondo' => 'Fondo'], ['prompt' => 'Seleccione una opcion...']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>
    </div>

    <div class="rows reparto-view">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Reparto de la pelicula</h4>
            </div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_reparto', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.reparto-items', // required: css class selector
                'widgetItem' => '.reparto', // required: css class
                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-reparto', // css class
                'deleteButton' => '.remove-reparto', // css class
                'model' => $modelsReparto[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'participante_id',
                ],
            ]); ?>
            <div class="reparto-items"><!-- widgetContainer -->
            <?php foreach ($modelsReparto as $i => $modelReparto): ?>
                <div class="reparto panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Integrante del reparto</h3>
                        <div class="pull-right">
                            <button type="button" class="add-reparto btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-reparto btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelReparto->isNewRecord) {
                                echo Html::activeHiddenInput($modelReparto, "[{$i}]id");
                            }
                        ?>
                        <div class="row">
                                <div class="col-sm-4">
                                <?=
                                $form->field($modelReparto, "[{$i}]participante_id")->widget(Select2::classname(), [
                                'data' => $participantesList,
                                'language' => 'es',
                                'options' => ['placeholder' => 'Seleccione un integrante...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                ]);
                                ?>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php
    $script = <<<JS
    var hiddenFields;
    $('body').on('change','.checkFlag',function(){
        if(this.checked){
            //$('.reparto-view').hide();
            var title = $('#peliculas-nombre').val();
            if(title == '' || title == undefined){
                $('#peliculas-nombre').attr('aria-invalid',true);
                $('.checkFlag').parent().after('<p id="notice" style="color: red;">El nombre de la pelicula no puede quedar vacio</p>');
                return;
            }
            var url = 'https://api.themoviedb.org/3/search/movie?api_key=e01a182bdeed3afc056d41564eba1bdd&language=es-Es&page=1&include_adult=false&query=' + title;
            $.get(url,function(dataJson){
                if(dataJson.total_results > 0){
                    var html = '';
                    $('#search-title').html('<p>Seleccione un elemento de la busqueda</p>');
                    dataJson.results.forEach(function(element,index){
                        if(element.poster_path !== null){
                            html += '<div class="col-md-2 col-xs-4">';
                            html += '<div name="'+ element.original_title +'" id="' + element.id + '" class="search-item">';
                            html += '<div class="thumbnail">';
                            html += '<img src="https://image.tmdb.org/t/p/w500/'+ element.poster_path +'" alt="Lights" style="height: 240px; width:180px">';
                            html += '</div>';
                            html += '<div class="caption">';
                            html += '<p class="text-center"><strong>'+ element.original_title +'</strong></p>';
                            html += '</div></div></div>';
                        }
                    });
                    $('#search-items').html(html);
                    $('#peliculas-nombre').prop('readonly',true);
                    hiddenFields = $('.contenido-view').parent().html();
                    $('.contenido-view').remove();
                }else{
                    $('.checkFlag').parent().after('<p id="notice" style="color: red;">No se encontro informacion para esta pelicula</p>');
                }
            });
        }else{
            $('#search-title').empty();
            $('#search-items').empty();
            $('#notice').remove();
            $('#peliculas-nombre').prop('readonly',false);
            $('.checkFlag').val('0');
            if(!(hiddenFields == '' || hiddenFields == undefined)){
                $('.contenido-container').html(hiddenFields);
                hiddenFields = '';
                $('.dynamicform_wrapper .form-group').trigger('reset');
            }
        }
    });

    $('body').on('click', '.search-item', function(){
        item = $(this);
        var selected = item.attr('id');
        $('.checkFlag').val(selected);
        $('#search-items').empty();
        $('.checkFlag').parent().after('<p id="notice" style="color: green;">Se usará el contenido audiovisual de la pelicula: '+ item.attr('name') +'</p>');
    });

JS;
$this->registerJs($script);
    ?>

    <?php ActiveForm::end(); ?>

</div>
