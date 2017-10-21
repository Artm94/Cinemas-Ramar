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

        <?= $form->field($model, 'duracion')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'clasificacion')->dropDownList([ 'PGEI16' => 'PGEI16', 'PGEI18' => 'PGEI18', ], ['prompt' => 'Seleccione una clasificación']) ?>

        <?= $form->field($model, 'calificacion')->dropDownList(['1' => 'Estrellas: ★', '2' => 'Estrellas: ★★', '3' => 'Estrellas: ★★★', '4' => 'Estrellas: ★★★★', '5' => 'Estrellas: ★★★★★'], ['prompt' => 'Seleccione una calificación']) ?>

        <div class="box box-success collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Busqueda de contenido a traves de internet</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <p>Escriba el nombre de la pelicula de la cual desea tomar la informacion:</p>
                </div>
            </div>
            <div class="row">
                <div id="movie-group" class="input-group margin col-md-6 col-sm-12">
                    <input id="movie-name" type="text" class="form-control">
                    <span class="input-group-btn">
                      <button id="search-movie" type="button" class="btn btn-info btn-flat">Buscar</button>
                  </span>
              </div>
          </div>
          <div id="search-items">

          </div>
          <input id="movieId" type="hidden" name="ApiOptions[movieId]">
          <?= $form->field($apiData, 'movieInformation')->checkbox(['id' => 'infoFlag', "class" => "disabled"]);?>
          <?= $form->field($apiData, 'movieMediaContent')->checkbox(['id' => 'contentFlag', "class" => "disabled"]);?>
          <?= $form->field($apiData, 'movieCredits')->checkbox(['id' => 'creditsFlag', "class" => "disabled"]);?>
      </div>
      <!-- /.box-body -->
  </div>

  <div class="contenido-container">
    <div class="rows contenido-view">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Material audiovisual de la pelicula</h4>
            </div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_contenido', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 999, // the maximum times, an element can be cloned (default 999)
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

<div class="reparto-container">
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
                'limit' => 999, // the maximum times, an element can be cloned (default 999)
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
                        <?php endforeach; ?>
                    </div>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
</div>
</div>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php
$script = <<<JS
var hiddenFieldsContent;
var hiddenFieldsCredits;
$('body').on('change','#movieFlag',function(){
    $('#notice').remove();
    $('#sucess').remove();
    if(this.checked){
        $('#search-movie-form').removeClass("hidden");
    }else{
        $('#search-movie-form').addClass("hidden");
        resetSearchForm();
    }
});
$('body').on('change','#infoFlag',function(){
    $('#notice').remove();
    if(this.checked){
        var id = $('#movieId').val();
        if(!(id == '' || id == undefined)){
            $('#peliculas-descripcion').prop('disabled',true);
            $('#peliculas-resena').prop('disabled',true);
            $('#peliculas-duracion').prop('disabled',true);
        }else{
            $('#movie-group').parent().after('<p id="notice" style="color: red;">No se ha seleccionado una fuente de informacion</p>');
            $(this).prop('checked', false);
            $('.field-infoFlag').trigger('reset');
        }

    }else{
        $('#peliculas-descripcion').prop('disabled',false);
        $('#peliculas-resena').prop('disabled',false);
        $('#peliculas-duracion').prop('disabled',false);
    }
});
$('body').on('change', '#contentFlag', function(){
    $('#notice').remove();
    if(this.checked){
        var id = $('#movieId').val();
        if(!(id == '' || id == undefined)){
            hiddenFieldsContent = $('.contenido-container').html();
            $('.contenido-view').remove();
        }else{
            $('#movie-group').parent().after('<p id="notice" style="color: red;">No se ha seleccionado una fuente de informacion</p>');
            $(this).prop('checked', false);
            $('.field-contentFlag').trigger('reset');
        }
    }else{
        if(!(hiddenFieldsContent == '' || hiddenFieldsContent == undefined)){
            $('.contenido-container').html(hiddenFieldsContent);
            hiddenFieldsContent = '';
            $('.dynamicform_contenido .form-group').trigger('reset');
        }
    }
});
$('body').on('change', '#creditsFlag', function(){
    $('#notice').remove();
    if(this.checked){
        var id = $('#movieId').val();
        if(!(id == '' || id == undefined)){
            hiddenFieldsCredits = $('.reparto-container').html();
            $('.reparto-view').remove();
        }else{
            $('#movie-group').parent().after('<p id="notice" style="color: red;">No se ha seleccionado una fuente de informacion</p>');
            $(this).prop('checked', false);
            $('.field-creditsFlag').trigger('reset');
        }
    }else{
        if(!(hiddenFieldsCredits == '' || hiddenFieldsCredits == undefined)){
            $('.reparto-container').html(hiddenFieldsCredits);
            hiddenFieldsCredits = '';
            $('.dynamicform_reparto .form-group').trigger('reset');
        }
    }
});
$('body').on('click', '#search-movie', function(){
    resetSearchForm();
    var title = $('#movie-name').val();
    if(title == '' || title == undefined){
        $('#peliculas-nombre').attr('aria-invalid',true);
        $('#movie-group').parent().after('<p id="notice" style="color: red;">El nombre de la pelicula no puede quedar vacio</p>');
        return;
    }
    var url = 'https://api.themoviedb.org/3/search/movie?api_key=e01a182bdeed3afc056d41564eba1bdd&language=es-Es&page=1&include_adult=false&query=' + title;
    $.get(url,function(dataJson){
        if(dataJson.total_results > 0){
            var html = '';
            html += '<p class="col-md-12">Seleccione una pelicula</p>';
            var columnCount = 0;
            dataJson.results.forEach(function(element,index){
                if(columnCount == 0){
                    html += '<div class="row">';
                }
                if(element.poster_path !== null){
                    html += '<div class="col-md-3 col-xs-12">';
                    html += '<div name="'+ element.title +'" id="' + element.id + '" class="search-item thumbnail">';
                    html += '<img src="https://image.tmdb.org/t/p/w500/'+ element.poster_path +'" alt="'+ element.title +'" style="height: 240px; width:180px">';
                    html += '<div class="caption">';
                    html += '<p class="text-center"><strong>'+ element.title +'</strong></p>';
                    html += '</div></div>';
                    html += '</div>';
                    columnCount++;
                }
                if(columnCount == 4){
                    html += '</div>';
                    columnCount = 0;
                }
            });
            $('#search-items').html(html);
        }else{
            $('#movie-group').parent().after('<p id="notice" style="color: red;">No se encontro informacion para esta pelicula</p>');
        }
    });
});
$('body').on('click', '.search-item', function(){
    item = $(this);
    var selected = item.attr('id');
    $('#movieId').val(selected);
    $('#search-items').empty();
    $('#movie-group').parent().after('<p id="sucess" style="color: green;">Se usará el contenido audiovisual de la pelicula: '+ item.attr('name') +'</p>');
    $('#infoFlag').removeClass('disabled');
    $('#contentFlag').removeClass('disabled');
    $('#creditsFlag').removeClass('disabled');
});

function resetSearchForm(){
    $('#notice').remove();
    $('#sucess').remove();
    $('.field-infoFlag').trigger('reset');
    $('.field-contentFlag').trigger('reset');
    $('.field-creditsFlag').trigger('reset');
    $('#infoFlag').prop('checked', false);
    $('#contentFlag').prop('checked', false);
    $('#creditsFlag').prop('checked', false);
    if(!(hiddenFieldsContent == '' || hiddenFieldsContent == undefined)){
        $('.contenido-container').html(hiddenFieldsContent);
        hiddenFieldsContent = '';
        $('.dynamicform_contenido .form-group').trigger('reset');
    }
    if(!(hiddenFieldsCredits == '' || hiddenFieldsCredits == undefined)){
        $('.reparto-container').html(hiddenFieldsCredits);
        hiddenFieldsCredits = '';
        $('.dynamicform_reparto .form-group').trigger('reset');
    }
}

JS;
$this->registerJs($script);
?>

<?php ActiveForm::end(); ?>

</div>
