<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "peliculas".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $resena
 * @property string $clasificacion
 * @property integer $calificacion
 *
 * @property Contenido $contenido
 * @property Proyeccion[] $proyeccions
 * @property Reparto[] $repartos
 * @property Participantes[] $participantes
 */
class Peliculas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'peliculas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'clasificacion', 'calificacion'], 'required'],
            [['descripcion', 'resena', 'duracion'], 'required', 'skipOnEmpty' => 'true'],
            [['clasificacion'], 'string'],
            [['calificacion', 'duracion'], 'integer'],
            [['nombre', 'descripcion'], 'string','max' => '255'],
            ['resena','string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre de la película',
            'descripcion' => 'Descripcion',
            'resena' => 'Reseña',
            'duracion' => 'Duracion de la pelicula (minutos)',
            'clasificacion' => 'Clasificación',
            'calificacion' => 'Calificación',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContenido()
    {
        $data['portada'] = Contenido::find()->where(['pelicula_id' => $this->id, 'tipo' => 'portada'])->one();
        $data['fondo'] = Contenido::find()->where(['pelicula_id' => $this->id, 'tipo' => 'fondo'])->one();
        $data['trailer'] = Contenido::find()->where(['pelicula_id' => $this->id, 'tipo' => 'trailer'])->one();
        $data['imagenes'] = Contenido::find()->where(['pelicula_id' => $this->id, 'tipo' => 'imagen'])->all();
        return $data;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProyeccions()
    {
        return $this->hasMany(Proyeccion::className(), ['pelicula_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepartos()
    {
        return $this->hasMany(Reparto::className(), ['pelicula_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantes()
    {
        return $this->hasMany(Participantes::className(), ['id' => 'participante_id'])->viaTable('reparto', ['pelicula_id' => 'id']);
    }
}
