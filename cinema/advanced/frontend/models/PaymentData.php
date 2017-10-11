<?php 

namespace frontend\models;

class PaymentData extends \yii\base\Model{
	public $card_name;
	public $card_number;
	public $expiration_month;
	public $expiration_year;
	public $cv_code;
	public $product_quantity;
	public $items = array();

	public function rules()
	{
		return [
		[['card_name', 'card_number', 'expiration_month', 'expiration_year', 'cv_code', 'product_quantity'], 'required', 'message' => 'El campo no puede quedar vacio'],
		['card_name', 'string', 'max' => 140],
		['items', 'safe'],
		['card_number', 'match', 'pattern' => '/^[\d]{16}$/i', 'message' => 'El número de tarjeta debe contener 16 dígitos.'],
		['product_quantity', 'in', 'range' =>range(1,120), 'message' => 'La compra mínima es de 1 boleto y la máxima de 120.'],
		['expiration_month', 'in', 'range' =>range(1,12), 'message' => 'El mes debe ser una cifra entre 1 y 12.'],
		['expiration_year', 'in', 'range' =>range(date("y"), 99), 'message' => 'El año debe encontrarse entre 17 y 99.' ],
		['cv_code',  'match', 'pattern' => '/^[\d]{3}$/i', 'message' => 'El código de validacion debe contener 3 dígitos.'],
		
		];
	}

	public function attributeLabels()
	{
		return [
		'card_name' => 'Nombre del propietario de la tarjeta',
		'card_number' => 'Numero de Tarjeta',
		'expiration_month' => 'Mes de expiracion',
		'expiration_year' => 'Año de expiracion',
		'cv_code' => 'Codigo de validacion',
		'product_quantity' => 'Cantidad de boletos a comprar'
		];
	}

}

?>