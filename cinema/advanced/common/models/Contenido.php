<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contenido".
 *
 * @property integer $id
 * @property integer $pelicula_id
 * @property string $nombre
 * @property string $url
 * @property string $tipo
 */
class Contenido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public static function tableName()
    {
        return 'contenido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'tipo'], 'required'],
            ['file', 'required', 'skipOnEmpty' => true, 'when' => function($model){
                echo 'Model:'.$model->file;
                return empty($model->url);
            }, 'whenClient' => "function(attribute, value){
                return $('#'+attribute.id).hasClass('no-file');
            }"],
            [['file'], 'image', 'extensions' => 'jpg, png'],
            [['pelicula_id'], 'integer'],
            [['tipo'], 'string'],
            [['nombre', 'url'], 'string', 'max' => 255],
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
            'nombre' => 'Nombre',
            'url' => 'Url',
            'tipo' => 'Tipo',
            'file' => 'Imagen',
        ];
    }
}
