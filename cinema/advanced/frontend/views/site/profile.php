<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
$this->title = "Perfil de $profile->nombres  $profile->apellidos";
 ?>
 <div id="profile-content">
<div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div id="profile-content">
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username"><?= $profile->nombres . ' ' . $profile->apellidos ?></h3>
              <h5 class="widget-user-desc"><?= $user->email ?></h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="<?= (($profile->foto_perfil !== null) ? $profile->foto_perfil : 'img/default/profile.png'). '?' . date_timestamp_get(date_create()) ?>" alt="User Avatar" style="width: 90px; height: 90px">
            </div>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-4 col-xs-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?= count($boletos->getModels()) ?></h5>
                    <span class="description-text">COMPRAS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-xs-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"><?= $user->username ?></h5>
                    <span class="description-text">USUARIO</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 col-xs-4">
                  <div class="description-block">
                    <h5 class="description-header"><?= date('F Y', Yii::$app->user->identity->created_at) ?></h5>
                    <span class="description-text">REGISTRO</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <div class="nav-tabs-custom">
          <h2 class="text-center">Administrar perfil</h2>
          <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#perfil">Perfil</a></li>
              <li><a data-toggle="tab" href="#compras">Compras</a></li>
              <li><a data-toggle="tab" href="#credenciales">Cambiar contraseña</a></li>
              <li><a data-toggle="tab" href="#administrar">Cerrar cuenta</a></li>
          </ul>
          <div class="tab-content" style="margin-top: 15px;">
            <div id="perfil" class="tab-pane fade in active">
              <?php $form = ActiveForm::begin(['id' => $profile->formName(), 'options' => ['enctype' => 'multipart/form-data'], 'action' => ['site/update-profile-info'], 'method' => 'post']); ?>

                  <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($profile, 'nombres')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($profile, 'apellidos')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($profile, 'telefono')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($profile, 'file')->fileInput() ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                  </div>

                  <div class="form-group">
                      <?= Html::submitButton('Actualizar informacion', ['class' => 'btn btn-success']) ?>
                  </div>
                  <?php $form = ActiveForm::end(); ?>
            </div>
            <div id="compras" class="tab-pane fade in">
              <?= GridView::widget([
                  'dataProvider' => $boletos,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],

                      'id',
                      [ 'attribute' => 'Pelicula',
                      'value' => 'proyeccion.pelicula.nombre', 
                      ],
                      'fecha_compra',
                      'precio'
                  ],
              ]); ?>
            </div>
            <div id="credenciales" class="tab-pane fade in">
            <?php $form = ActiveForm::begin(['id' => $passwordModel->formName(), 'action' => ['site/change-password'], 'method' => 'post']); ?>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($passwordModel, 'oldPassword')->passwordInput(['maxlength' => true]) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($passwordModel, 'newPassword')->passwordInput(['maxlength' => true]) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($passwordModel, 'confirmPassword')->passwordInput(['maxlength' => true]) ?>
                </div>
              </div>
              <div class="form-group">
                  <?= Html::submitButton('Cambiar contraseña', ['class' => 'btn btn-success']) ?>
              </div>
              <?php $form = ActiveForm::end(); ?>
            </div>
            <div id="administrar" class="tab-pane fade in">
              <div class="callout callout-danger">
                <h4>Atencion!</h4>
                <p>Una vez confirmada la eliminación de su cuenta procederemos a eliminar cualquier dato relacionado con la misma por lo cual usted no podrá volver a acceder a la información dentro de ella.</p>
              </div>
              <?php $form = ActiveForm::begin(['id' => $deleteModel->formName(), 'action' => ['site/delete-account'], 'method' => 'post']); ?>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($deleteModel, 'password')->passwordInput(['maxlength' => true]) ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <?= $form->field($deleteModel, 'confirm')->checkbox(['label' => 'Acepto eliminar los datos de mi cuenta','uncheck' => null, 'value' => 0]);?>
                </div>
              </div>
              <div class="form-group">
                  <?= Html::submitButton('Eliminar cuenta', ['class' => 'btn btn-success']) ?>
              </div>
              <?php $form = ActiveForm::end(); ?>
            </div>
          </div>
          </div>
          </div>

<?php $script = <<< JS
$('body').on('submit', 'form#{$profile->formName()}', function(event){
  event.preventDefault();
    var action = $(this).attr('action');
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: action,
      type: 'POST',
      data: formData,
      success: function(data){
        if(data == 1){
                showSucessBox('Informacion actualizada correctamente', 'Su informacion de perfil fue actualizada correctamente');
                    $('body').on('hidden.bs.modal', '#alert-box', function () {
                      location.reload();
                    });
            }else{
                showWarningBox('Error al actualizar la informacion', 'Compruebe los campos y vuelva a intentarlo');
            }
      },
      cache: false,
      contentType: false,
      processData: false
    });
    return false;
});
$('body').on('submit', 'form#{$passwordModel->formName()}', function(event){
  event.preventDefault;
    var \$form = $(this);
    var action = $(this).attr('action');
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: action,
      type: 'POST',
      data: formData,
      success: function(data){
        if(data == 1){
                showSucessBox('Contraseña actualizada correctamente', 'Su contraseña ha sido cambiada correctamente');
                    $('body').on('hidden.bs.modal', '#alert-box', function () {
                      $(\$form).trigger("reset");
                    });
            }else{
                showWarningBox('Error al actualizar la contraseña', 'Revise que la contraseña actual sea correcta y vuelva a intentarlo');
            }
      },
      cache: false,
      contentType: false,
      processData: false
    });
    return false;
});
$('body').on('submit', 'form#{$deleteModel->formName()}', function(event){
  event.preventDefault;
    var \$form = $(this);
    var action = $(this).attr('action');
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: action,
      type: 'POST',
      data: formData,
      success: function(data){
        console.log(data);
        if(data == 0){
          showDangerBox('Error al eliminar la cuenta', 'Ocurrio un error al eliminar su cuenta, intentelo mas tarde');
        }
      },
      cache: false,
      contentType: false,
      processData: false
    });
    return false;
});
JS;
$this->registerJS($script);
?>