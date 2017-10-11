<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Cartelera de esta semana</h1>
	</div>
	<div class="panel-body">
		<div class="row">
			<?php foreach($peliculas as $pelicula): ?>
				<div class="col-md-3 col-xs-12">
					<div class="thumbnail movie-item">
						<img class="img-responsive" src=" <?= $pelicula->contenido['portada']->url ?> " alt="<?= $pelicula->contenido['portada']->nombre ?>" style="width: 320px;">
						<div class="caption" style="max-height: 400px;">
							<p><strong><p><?= $pelicula->nombre ?></p></strong></p>
							<p class="text-truncate"><?= $pelicula->descripcion ?></p>
							<a href=<?= "\"" . Url::to("index.php?r=peliculas/view&id=$pelicula->id") . "\""?>> <span class="glyphicon glyphicon-film"></span> Mas informacion</a>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>
