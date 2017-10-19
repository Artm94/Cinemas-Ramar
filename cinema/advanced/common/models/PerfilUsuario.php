<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "perfil_usuario".
 *
 * @property integer $id
 * @property string $nombres
 * @property string $apellidos
 * @property integer $telefono
 * @property string $foto_perfil
 * @property string $file
 *
 * @property User $id0
 */
class PerfilUsuario extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public $file;
    public static function tableName()
    {
        return 'perfil_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombres', 'apellidos', 'telefono'], 'required', 'message' => 'El campo es requerido'],
            [['nombres', 'apellidos'], 'match', 'pattern' => '/^[a-zA-Záéíóú ]{1,70}$/', 'message' => 'Introduzca un nombre válido de 70 caracteres máximo'],
            [['id'], 'integer'],
            [['conekta_id'], 'string'],
            ['telefono', 'match', 'pattern' => '/^[\d]{10}$/i', 'message' => 'El numero de teléfono debe contener 10 dígitos.'],
            [['file'], 'image', 'extensions' => 'png, jpg'],
            [['nombres', 'apellidos', 'foto_perfil'], 'string', 'max' => 255],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'Foto de Perfil',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'telefono' => 'Teléfono',
            'conekta_id' => 'ID de Conekta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }
}
