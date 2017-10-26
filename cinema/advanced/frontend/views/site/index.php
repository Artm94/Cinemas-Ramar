<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\custom\MovieFinder;
use yii\helpers\Html;
$this->title = 'Pagina de inicio';
?>
<div class="site-index">
	<div id="promoCrousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#promoCrousel" data-slide-to="0" class="active"></li>
			<li data-target="#promoCrousel" data-slide-to="1"></li>
			<li data-target="#promoCrousel" data-slide-to="2"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner">
			<div class="item active">
				<img src="img/signup.jpg" alt="Chicago">
				<div class="carousel-caption">
					<h3>Diversion garantizada</h3>
					<p>En Cinemas <strong>Ramar</strong> encontrarás las películas mas recientes en pantalla grande</p>
				</div>
			</div>

			<div class="item">
				<img src="img/login.jpeg" alt="Los Angeles">
				<div class="carousel-caption">
					<h3>La mejor experiencia</h3>
					<p>En nuestro cine encontrarás las mejores salas, con más de 100 asientos</p>
				</div>
			</div>

			<div class="item">
				<img src="img/mvseat.jpg" alt="New York">
				<div class="carousel-caption">
					<h3>El mejor servicio</h3>
					<p>Compromiso, calidad y creatividad son los principios que guian nuestra labor para ofrecerte el servicio que mereces</p>
				</div>
			</div>
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#promoCrousel" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#promoCrousel" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<div class="panel panel-default" id="cartelera">
		<div class="panel-heading">
			<p id="titulo">Peliculas destacadas de esta semana</p>
		</div>
		<div class="panel-body">
			<?php $columnCount = 0; ?>
			<?php foreach ($peliculas as $pelicula): ?>
				<?php if($columnCount == 0): ?>
					<div class="row">
					<?php endif ?>
					<div class="col-md-3 col-xs-12">
						<div class="thumbnail movie-item">
							<img src="<?= (empty($pelicula->contenido['portada']->url)) ? Url::to('@web/img/') . 'not_avaible_portrait.png' : $pelicula->contenido['portada']->url ?>" alt="Lights" style="width: 320px;">
							<div class="caption" style="max-height: 400px;">
								<p class="text-truncate"><?= $pelicula->descripcion ?></p>
								<a href=<?= "\"" . Url::to("index.php?r=peliculas/view&id=$pelicula->id") . "\""?>> <span class="glyphicon glyphicon-film"></span> Mas informacion</a>
							</div>
						</div>
					</div>
					<?php $columnCount = $columnCount + 1; ?>
					<?php if($columnCount == 4): ?>
					</div>
					<?php $columnCount = 0; ?>
				<?php endif ?>
			<?php endforeach ?>
			<?php if(!$columnCount == 0): ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="panel-footer">
		<?= Html::a('Ver cartelera completa', ['peliculas/cartelera'], ['class' => 'btn btn-primary btn-flat']) ?>
	</div>
</div>
</div>
