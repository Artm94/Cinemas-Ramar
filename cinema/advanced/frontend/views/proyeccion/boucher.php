<?php $this->title = 'Recibo de compra'; ?>
<div class="container">

	<img   src="img/logo1.png" ></img>

	<h1 style=" text-align: center">Recibo de compra</h1>

	<h4>Detalles de la compra</h4>
			<div class="panel panel-default">
				<div class="panel-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Elemento</th>
							<th>Descripcion</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Nombre de la pelicula:</td>
							<td><?= $boleto->proyeccion->pelicula->nombre ?></td>
						</tr>
						<tr>
							<td>Fecha de la funcion:</td>
							<td><?= date('d-m-Y -- H:i A', strtotime($boleto->proyeccion->fecha_funcion)) ?></td>
						</tr>
						<tr>
							<td>Sala:</td>
							<td><?= $boleto->proyeccion->sala->id ?></td>
						</tr>
						<tr>
							<td>Fila:</td>
							<td><?= $boleto->fila_asiento ?></td>
						</tr>
						<tr>
							<td>Numero de asiento:</td>
							<td><?= $boleto->numero_asiento ?></td>
						</tr>
						<tr>
							<td>ID de compra:</td>
							<td><?= $boleto->id ?></td>
						</tr>
						<tr>
							<td>Fecha de compra:</td>
							<td><?= date('d-m-Y -- H:i A', strtotime($boleto->fecha_compra)) ?></td>
						</tr>
						<tr>
							<td>Precio:</td>
							<td>$<?= $boleto->precio ?> MXN</td>
						</tr>
					</tbody>
				</table>
				</div>
			</div>
			<p style="color: red;">Guardar este recibo en un lugar seguro y muestrelo cuando el personal del cine se lo solicite</p>
			
			<p> <b>Dirección:</b> <br> Circunvalación Oriente 54, esq. Tulipanes, Col. Campestre, Las Bajadas, 91967 Veracruz, Ver. </p>

<img  align="center" src="img/dir.png" ></img>
			
			
</div>