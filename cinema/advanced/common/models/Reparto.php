<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reparto".
 *
 * @property integer $id
 * @property integer $pelicula_id
 * @property integer $participante_id
 *
 * @property Peliculas $pelicula
 * @property Participantes $participante
 */
class Reparto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reparto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['participante_id'], 'required'],
            [['pelicula_id', 'participante_id'], 'integer', 'skipOnEmpty' => true],
            [['pelicula_id'], 'exist', 'skipOnError' => true, 'targetClass' => Peliculas::className(), 'targetAttribute' => ['pelicula_id' => 'id']],
            [['participante_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participantes::className(), 'targetAttribute' => ['participante_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pelicula_id' => 'ID de pelicula',
            'participante_id' => 'ID de artista',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPelicula()
    {
        return $this->hasOne(Peliculas::className(), ['id' => 'pelicula_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipante()
    {
        return $this->hasOne(Participantes::className(), ['id' => 'participante_id']);
    }
}
