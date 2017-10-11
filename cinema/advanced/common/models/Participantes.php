<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "participantes".
 *
 * @property integer $id
 * @property string $nombres
 * @property string $apellidos
 * @property string $tipo
 *
 * @property Reparto[] $repartos
 */
class Participantes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $imagen;
    public static function tableName()
    {
        return 'participantes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombres', 'apellidos', 'tipo'], 'required'],
            [['tipo'], 'string'],
            [['imagen'], 'image', 'extensions' => 'jpg, png, gif'],
            [['nombres', 'apellidos'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'tipo' => 'Clase',
            'imagen' => 'Fotografia del artista',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepartos()
    {
        return $this->hasMany(Reparto::className(), ['participante_id' => 'id']);
    }
}
