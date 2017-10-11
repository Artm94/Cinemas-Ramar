<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Boletos;

/**
 * BoletosSearch represents the model behind the search form about `common\models\Boletos`.
 */
class BoletosSearch extends Boletos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fila_asiento', 'fecha_compra'], 'safe'],
            [['usuario_id', 'proyeccion_id', 'numero_asiento'], 'integer'],
            [['precio'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Boletos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //$query->joinWith('proyeccion.pelicula');

        // grid filtering conditions
        $query->andFilterWhere([
            'usuario_id' => $this->usuario_id,
            'numero_asiento' => $this->numero_asiento,
            'fecha_compra' => $this->fecha_compra,
            'precio' => $this->precio,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'fila_asiento', $this->fila_asiento]);
            //->andFilterWhere(['like', 'proyeccion.pelicula.nombre', $this->proyeccion->pelicula_id]);

        return $dataProvider;
    }
}
