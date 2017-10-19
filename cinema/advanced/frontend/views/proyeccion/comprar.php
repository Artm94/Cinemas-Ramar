<?php 
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$nombre = $proyeccion->pelicula->nombre;
$this->title = "Comprar boletos para $nombre";
?>

<div class="box box-solid box-success">
	<div class="box-header">
		<h1 id="<?= $proyeccion->id ?>" class="proyection-title">Comprar boletos para <?= $nombre ?></h1>
	</div>
	<div class="box-body">
	<div class="box box-success" style="margin-top: 25px;">
			<div class="box-header">
				<h2>Configuracion de la compra</h2>
			</div>
			<div class="box-body">
				<?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<?= $form->field($model, 'product_quantity')->dropDownList(['1' => '1 boleto', '2' => '2 boletos', '3' => '3 boletos', '4' => '4 boltetos (cantidad máxima por pedido)'], ['prompt' => 'Seleccione la cantidad de boletos a comprar', 'id' => 'counter']) ?>
					</div>
					<div class="col-md-6 col-xs-12">
						<?= $form->field($model, 'card_name')->textInput(['maxlength' => true, 'data-conekta'=>"card[name]"]) ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<?= $form->field($model, 'card_number')->textInput(['maxlength' => 16,  'data-conekta'=>"card[number]"]) ?>
					</div>
					<div class="col-md-2 col-xs-4">
						<?= $form->field($model, 'expiration_month')->textInput(['maxlength' => 2, 'data-conekta'=>"card[exp_month]"]) ?>
					</div>
					<div class="col-md-2 col-xs-4">
						<?= $form->field($model, 'expiration_year')->textInput(['maxlength' => 2, 'data-conekta'=>"card[exp_year]"]) ?>
					</div>
					<div class="col-md-2 col-xs-4">
						<?= $form->field($model, 'cv_code')->textInput(['maxlength' => 3, 'data-conekta'=>"card[cvc]"]) ?>
					</div>
				</div>
				<div id="boleto-items">
				</div>
				<div class="row">
					<div class="col-md-2">Se aceptan las siguientes tarjetas:</div>
					<div class="col-md-4">
						<img class="img-responsive" src="http://i76.imgup.net/accepted_c22e0.png">
					</div>
				</div>
			</div>
		</div>
		<h3 class="text-center">Seleccione los asientos que desee adquirir</h3>
		<div class="table-responsive">
		<table class="table-hover-cell" style="margin-left: auto; margin-right: auto;">
			<tr class="row-seat" rowId="I">
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
			</tr>
			<tr class="row-seat" rowId="H">
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
			</tr>
			<tr class="row-seat" rowId="G">
				<td></td>
				<td></td>
				<td></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="row-seat" rowId="F">
				<td></td>
				<td></td>
				<td></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="row-seat" rowId="E">
				<td></td>
				<td></td>
				<td></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="row-seat" rowId="D">
				<td></td>
				<td></td>
				<td></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="row-seat" rowId="C">
				<td></td>
				<td></td>
				<td></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="row-seat" rowId="B">
				<td></td>
				<td></td>
				<td></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr class="row-seat" rowId="A">
				<td></td>
				<td></td>
				<td></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td class="hover-cell seat"><img class="img-responsive" src="img/seat.png" style="max-width: 50px; max-height: 50px;"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		</div>
		<div class="form-group">
        	<?= Html::submitButton('Finalizar Compra', ['class' => 'btn btn-success pull-right', 'id'=>"comprar"]) ?>
    	</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<!--
     "//cdn.conekta.io/js/latest/conekta.js" agregarlo al asset
-->
<script type="text/javascript">

	function conektaSuccess(token) {
    $('#PaymentData').append($("<input type='hidden' name='token' id='conektaTokenId'>").val(token.id));
    $('#PaymentData').get(0).submit();
  };

  function conektaError (error) {
 	alert(error.error_code+" "+error.param+" "+error.message_to_purchaser);
 }
</script>
<?php $script = <<<JS
	var count = 0;
	var max;
	$(document).ready(function(){
		max = $('#counter').val();
		$.ajax({
			url: 'index.php?r=proyeccion/listar-asientos&id=' + $('.proyection-title').attr('id'),
			type: 'GET',
			success: function(data){
				var dataJson = JSON.parse(data);
				dataJson.forEach(function(element){
					$('[rowId='+ element.fila +']').find('.seat').each(function(index,item){
						var seat = $(item);
						if(seat.index() == (element.numero + 2)){
							seat.addClass('disabled');
						}
					});
				});
			},
			cache: false,
            contentType: false,
            processData: false
		});

		$('body').on('click', '.seat:not(.disabled)', function(){
			var target = $(this);
				if(target.hasClass('marked')){
					target.removeClass('marked');
					count = count - 1;
				}else{
					if(count < max){
						target.addClass('marked');
						count = count + 1;
					}else{
						showWarningBox('No se puede seleccionar este asiento', 'Ha alcanzado el límite de asientos establecido, revise la cantidad de boletos a comprar y vuelva a intentarlo');
					}
				}
		});

		$('body').on('change', '#counter', function(){
			max = $('#counter').val();
			if(count >= max){
				diff = count - max;
				for(i = 0; i < diff;i++){
					$('.marked').last().removeClass('marked');
				}
				count = (isNaN((count = parseInt(max,10)))) ? 0 : count;
			}
		});

		$('body').on('beforeSubmit', 'form#{$model->formName()}', function(event){
			if(count != max){
				showWarningBox('Seleccione su asiento', 'Faltan ' + (max - count) + ' asiento(s) por seleccionar')
				return false;
			}
			var itemCount = 0;
			$('.table-hover-cell').find('.row-seat > .marked').each(function(index,item){
				if(itemCount < count){
					itemCount = itemCount + 1;
					var seat = $(item);
					var seatId = seat.parent().attr('rowId') + ',' + (seat.index() - 2);
					$('#boleto-items').append('<input type="hidden" name="items[]" value="' + seatId + '"></input>');
				}
			});
			Conekta.setPublishableKey("key_KtAU2fwpXrdkBe9WZdjxXxw");
			var \$form = $(this);
		    \$form.find('#comprar').prop('disabled', true);
        	Conekta.token.create($('#PaymentData'), conektaSuccess, conektaError);
			return false;
		});
	});
JS;
$this->registerJs($script);
 ?>