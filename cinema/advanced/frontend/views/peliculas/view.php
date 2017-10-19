<?php
$this->title = $model->nombre;

use yii\helpers\Url; 
 ?>
 <div class="container-fluid">
 	<div class="movie-banner" style="background-image: url('<?= (empty($model->contenido['fondo'])) ? '' : $model->contenido['fondo']->url ?>'); background-size: cover; background-position: center;">
 		<div class="row">
 			<div class="col-md-4 col-xs-12">
 				<img src=" <?= (empty($model->contenido['portada'])) ? '' : $model->contenido['portada']->url ?> " alt="<?= (empty($model->contenido['portada'])) ? '' : $model->contenido['portada']->nombre ?>" style="width:240px; height: 320px; margin: 0px; margin: 20px 20px;">
 			</div>
 			<div class="col-md-8 col-xs-12">
 				<h1 style="color: white; text-align: right; margin-right: 20px; text-shadow: 0px 2px 2px rgba(150, 150, 150, 1);"><?= $model->nombre ?></h1>
 				<p style="color: white; font-size: 16px; background: rgba(0, 0, 0, 0.6); border-radius: 5px; margin-right: 20px; padding: 10px;"><?= $model->resena ?></p>
 			</div>
 		</div>
 	</div>
 </div>
 <div class="nav-tabs-custom">
 	<h2>Sobre <?= $model->nombre ?></h2>
 	<ul class="nav nav-tabs">
    	<li class="active"><a data-toggle="tab" href="#reparto">Reparto General</a></li>
	    <li><a data-toggle="tab" href="#galeria">Galeria de imágenes</a></li>
	    <li><a data-toggle="tab" href="#trailer">Trailer Oficial</a></li>
	    <li><a data-toggle="tab" href="#funciones">Ver funciones disponibles</a></li>
  </ul>
  <div class="tab-content" style="margin-top: 15px;">
  	<div id="reparto" class="tab-pane fade in active">
     <div class="box box-solid">
       <div class="box-body">
         <div class="row">
           <?php foreach ($model->participantes as $participante): ?>
            <div class="col-md-2 col-xs-4">
              <div class="thumbnail">
                <img style="height: 220px; width:180px" src="<?= $participante->fotografia ?>">
              </div>
              <div class="caption">
                <p class="text-center"><b><?= $participante->nombres ?></b></p>
              </div>
              </div>
            <?php endforeach; ?>
         </div>
       </div>
     </div> 
    </div>
  	<div id="galeria" class="tab-pane fade in">
  		<div class="row">
      <?php if(!empty($model->contenido['imagenes']) && count($model->contenido['imagenes']) > 0): ?>
		  	<?php foreach ($model->contenido['imagenes'] as $imagen):?>
		  		<div class="col-md-3 col-xs-12">
		  			<img class="img-responsive img-thumbnail" src="<?= $imagen->url ?>" alt="<?= $imagen->nombre ?>" height="480" width="320">
		  		</div>
		  	<?php endforeach; ?>
        <?php else: ?>
                <div class="box box-solid">
                  <div class="box-body">
                    <h2 class="text-center">Imagenes no disponibles</h2>
                  </div>
                </div>
              <?php endif; ?>
		</div>
  	</div>
  	<div id="trailer" class="tab-pane fade in">
  		<div class="panel panel-default">
  			<div class="panel-body">
  				<div class="container-fluid">
		  			<?php if(!empty($model->contenido['trailer']) && count($model->contenido['trailer']) > 0): ?>
              <iframe class="center-block video" src="<?= $model->contenido['trailer']->url ?>" frameborder="0" allowfullscreen></iframe>
              <?php else: ?>
                <div class="box box-solid">
                  <div class="box-body">
                    <h2 class="text-center">Video no disponible</h2>
                  </div>
                </div>
              <?php endif; ?>
		  		</div>
  			</div>
  		</div>
  	</div>
  	<div id="funciones" class="tab-pane fade in">
  		<div class="row">
  		<?php foreach ($proyecciones as $proyeccion): ?>
  			<div class="col-md-4 col-sm-6 col-xs-12">
  				<div class="info-box">
  					<span class="info-box-icon glyphicon glyphicon-film bg-aqua">
  					</span>
  					<div class="info-box-content">
  						<p class="info-box-text">Informacion de la funcion</p>
  							<p class=""><span class="glyphicon glyphicon-calendar"></span> <?= date('d/m - g:i A', strtotime($proyeccion->fecha_funcion)) ?></p>
  							<p class=""><span class="glyphicon glyphicon-usd"></span> <?= $proyeccion->precio ?> (MXN)</p>
  					</div>
  					<div class="progress-group">
                    <span class="progress-text">Boletos Disponibles</span>
                    <span class="progress-number"><b><?= 120 - count($proyeccion->boletos) ?></b>/120</span>
                  </div>
  					<a href=<?= "\"" . Url::to("index.php?r=proyeccion/comprar&id=$proyeccion->id") . "\""?> class="btn btn-default btn-block">
  						<p><span class="glyphicon glyphicon-shopping-cart"></span> Comprar</p>
  					</a>
  				</div>
  			</div>
  		<?php endforeach; ?>
  		</div>
  	</div>
  </div>
 </div>