<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "boletos".
 *
 * @property string $id
 * @property integer $usuario_id
 * @property integer $proyeccion_id
 * @property integer $numero_asiento
 * @property integer $fila_asiento
 * @property string $fecha_compra
 * @property double $precio
 *
 * @property User $usuario
 * @property Proyeccion $proyeccion
 */
class Boletos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'boletos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'proyeccion_id', 'numero_asiento', 'fila_asiento', 'fecha_compra', 'precio'], 'required'],
            [['usuario_id', 'proyeccion_id', 'numero_asiento', 'fila_asiento'], 'integer'],
            [['fecha_compra'], 'safe'],
            [['precio'], 'number'],
            [['id'], 'string', 'max' => 64],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['proyeccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proyeccion::className(), 'targetAttribute' => ['proyeccion_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'proyeccion_id' => 'Proyeccion ID',
            'numero_asiento' => 'Numero de Asiento',
            'fila_asiento' => 'Fila de Asiento',
            'fecha_compra' => 'Fecha de Compra',
            'precio' => 'Precio (MXN)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyeccion()
    {
        return $this->hasOne(Proyeccion::className(), ['id' => 'proyeccion_id']);
    }
}
