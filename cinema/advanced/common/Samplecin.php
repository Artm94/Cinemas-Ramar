<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "samplecin".
 *
 * @property string $card_name
 * @property string $card_number
 * @property string $expiration_month
 * @property string $expiration_year
 * @property string $cv_code
 * @property integer $product_quantity
 */
class Samplecin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'samplecin';
    }

    /**
     * @inheritdoc
     */
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

	

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'card_name' => 'Nombre del propietario de la tarjeta',
    		'card_number' => 'Número de Tarjeta',
    		'expiration_month' => 'Mes de expiración',
    		'expiration_year' => 'Año de expiración',
    		'cv_code' => 'Código de validación',
    		'product_quantity' => 'Cantidad de boletos a comprar'
        ];
    }
}
