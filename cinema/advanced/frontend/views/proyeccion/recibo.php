<?php 
use yii\helpers\Html;
 ?>
<div style="margin: 0px 20px;">
	<div class="callout callout-success">
         <h4>Compra completada</h4>
         <p>Su compra de <?= $proyeccion->pelicula->nombre ?> ha sido registrada correctamente!</p>
    </div>
    <div class="box box-solid">
            <div class="box-header with-border">
            <i class="fa fa-fw fa-edit"></i>
             <h3 class="box-title">Detalles de la compra</h3>
            </div>
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>Nombre de la pelicula:</dt>
                <dd><?= $proyeccion->pelicula->nombre ?></dd>
                <dt>Fecha de la función:</dt>
                <dd><?= date('d-m-Y -- H:i A', strtotime($proyeccion->fecha_funcion)) ?></dd>
                <dt>Sala:</dt>
                <dd><?= $proyeccion->sala->id ?></dd>
                <dt>Boletos comprados:</dt>
                <dd><?= count($compras) ?></dd>
              </dl>
              <?= Html::a('Regresar al inicio',['site/index'], ['class' => 'btn btn-danger']) ?>
              <div class="box box-solid">
              	<div class="box-body">
              		<?php for($i = 0; $i < count($compras); $i++): ?>
              			<div class="row">
              				<div class="col-md-2 col-xs-6">
              					<p>Generar recibo para el boleto <?= $i + 1 ?>:</p>
              				</div>
              				<div class="col-md-4 col-xs-6">
              					<?= Html::a('Generar recibo',['proyeccion/generar-recibo', 'id' => $compras[$i][0]], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
              				</div>
              			</div>
              		<?php endfor; ?>
              	</div>
              </div>
              <p style="color: #d9534f;">*Una vez cerrada esta página no podrá volver a generar su recibo.</p>
            </div>
          </div>
</div>