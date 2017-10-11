<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "salas".
 *
 * @property string $id
 * @property integer $disponible
 *
 * @property Proyeccion[] $proyeccions
 */
class Salas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'disponible'], 'required'],
            [['disponible'], 'integer'],
            [['id'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'disponible' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyeccions()
    {
        return $this->hasMany(Proyeccion::className(), ['sala_id' => 'id']);
    }
}
