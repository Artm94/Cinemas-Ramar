<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\PerfilUsuario;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/site-index.css">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-blue">
<?php $this->beginBody();
 ?>
<div class="wrapper">
<header class="main-header">
    <!-- Logo -->
    <a href="index.php?r=site" class="navbar-brand logo">
    <img src="img/logo4.png">
    <span class="logo-lg"><b>Cinemas</b>Ramar</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <?php if(!Yii::$app->user->isGuest): ?>
          <?php $perfil = PerfilUsuario::findOne(Yii::$app->user->identity->id); ?>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= (($perfil->foto_perfil !== null) ? $perfil->foto_perfil : 'img/default/profile.png'). '?' . date_timestamp_get(date_create()) ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="<?= (($perfil->foto_perfil !== null) ? $perfil->foto_perfil : 'img/default/profile.png'). '?' . date_timestamp_get(date_create()) ?>" class="img-circle" alt="User Image">
                <p>
                  <?php 
                  echo $perfil->nombres . ' ' . $perfil->apellidos;
                   ?>
                   <small><strong><?= Yii::$app->user->identity->email ?></strong></small>
                  <small>Miembro desde <?= date('F Y', Yii::$app->user->identity->created_at) ?></small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href=<?= "\"" . Url::to("index.php?r=site/profile") . "\""?> class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <!--<a href="#" class="btn btn-default btn-flat">Sign out</a>-->
                  <?= Html::a('Cerrar Sesion','index.php?r=site/logout', ['class' => 'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                </div>
              </li>
            </ul>
          </li>
          <?php else: ?>
          <li> <?= Html::a('Iniciar Sesion', 'index.php?r=site/login') ?></li>
          <li> <?= Html::a('Registrarse', 'index.php?r=site/signup') ?></li>
          <?php endif ?>
        </ul>
      </div>
    </nav>
</header>
    <div class="content-wrapper container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h7>
    <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
      </h7>
    </section>
    <!-- Main content -->
    <div class="content">
        <?= $content ?>
        </div>
    </div>
</div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Cinemas Ramar <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
