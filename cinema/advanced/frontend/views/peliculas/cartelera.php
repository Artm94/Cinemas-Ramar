<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h1>Cartelera de esta semana</h1>
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
</div>
