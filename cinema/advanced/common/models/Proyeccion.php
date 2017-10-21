<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "proyeccion".
 *
 * @property integer $id
 * @property string $sala_id
 * @property integer $pelicula_id
 * @property string $fecha_funcion
 * @property double $precio
 *
 * @property Boletos[] $boletos
 * @property Salas $sala
 * @property Peliculas $pelicula
 */
class Proyeccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proyeccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sala_id', 'pelicula_id', 'fecha_funcion', 'precio'], 'required'],
            [['pelicula_id'], 'integer'],
            [['fecha_funcion', 'fin_funcion'], 'safe'],
            [['precio'], 'number'],
            [['sala_id'], 'string', 'max' => 10],
            [['sala_id'], 'exist', 'skipOnError' => true, 'targetClass' => Salas::className(), 'targetAttribute' => ['sala_id' => 'id']],
            [['pelicula_id'], 'exist', 'skipOnError' => true, 'targetClass' => Peliculas::className(), 'targetAttribute' => ['pelicula_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sala_id' => 'Sala',
            'pelicula_id' => 'Nombre de la película',
            'fecha_funcion' => 'Fecha de la función',
            'fin_funcion' => 'Termino de la funcion',
            'precio' => 'Precio (MXN)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoletos()
    {
        return $this->hasMany(Boletos::className(), ['proyeccion_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSala()
    {
        return $this->hasOne(Salas::className(), ['id' => 'sala_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelicula()
    {
        return $this->hasOne(Peliculas::className(), ['id' => 'pelicula_id']);
    }
}
