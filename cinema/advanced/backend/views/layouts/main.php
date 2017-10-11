<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\DashboardAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\PerfilUsuario;
use yii\helpers\Url;

DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="skin-green sidebar-mini">
<?php $this->beginBody() ?>


<div class="wrapper">

<header class="main-header">

   <a href="index.php?r=site" class="navbar-brand logo">
     <span class="logo-mini"><b>C</b>RM</span>
 <!--   <img src="img/logo4.png"> -->
    <span class="logo-lg"><b>Cinemas</b>Ramar</span>
    </a>
	    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
    </nav>
  </header>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <?php if(!Yii::$app->user->isGuest): ?>
        <?php $perfil = PerfilUsuario::findOne(Yii::$app->user->identity->id); ?>
      <div class="user-panel">
        <div class="pull-left image">
          <img style="max-width: 45px; max-height: 45px; min-height: 30px; min-height: 30px;" src="<?= (($perfil->foto_perfil !== null) ? $perfil->foto_perfil : 'img/default/profile.png'). '?' . date_timestamp_get(date_create()) ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Administrador</p>
          <?= Html::a('Cerrar Sesion', ['site/logout'], ['data-method' => 'post']) ?>
        </div>
      </div>
    <?php endif; ?>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MENÚ PRINCIPAL</li>
    <?php if(!Yii::$app->user->isGuest): ?>               
        <li class="treeview">
		<a href="#">
            <i class="fa fa-th"></i> 
			<span>Películas</span>
			<span class="pull-right-container">
			          <i class="fa fa-angle-left pull-right"></i>
            </span>
			</a>
			<ul class="treeview-menu">
			  
            <li><a href="index.php?r=peliculas"><i class="fa fa-circle-o"></i> Listado de películas</a></li>
            <li><a href="index.php?r=peliculas%2Fcreate"><i class="fa fa-circle-o"></i> Añadir nueva Película</a></li>
          </ul>
        </li>
		
		<li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Salas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.php?r=salas"><i class="fa fa-circle-o"></i> Listado de salas</a></li>
            <li><a href="index.php?r=salas%2Fcreate"><i class="fa fa-circle-o"></i> Añadir Sala</a></li>
          
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>Artistas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.php?r=participantes"><i class="fa fa-circle-o"></i> Listado de Artistas</a></li>
            <li><a href="index.php?r=participantes%2Fcreate"><i class="fa fa-circle-o"></i> Añadir un nuevo artistas</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Funciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.php?r=proyeccion"><i class="fa fa-circle-o"></i> Listado de funciones</a></li>
            <li><a href="index.php?r=proyeccion%2Fcreate"><i class="fa fa-circle-o"></i> Programar función</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Perfil</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.php?r=site/update-profile"><i class="fa fa-circle-o"></i> Actualizar datos</a></li>
            <li><a href="index.php?r=site/change-password"><i class="fa fa-circle-o"></i> Cambiar contraseña</a></li>
          </ul>
        </li>
      <?php else: ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Inicio</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.php?r=site/login"><i class="fa fa-circle-o"></i> Iniciar Sesion</a></li>
          </ul>
        </li>
      <?php endif; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
         </ol>
    </section>

    <!-- Main content -->
    <section class="content">
  <!--  <div class="container">
        
        <?= Alert::widget() ?>
		 -->
		
        <?= $content ?>
	</section>

		</div>  

   

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
