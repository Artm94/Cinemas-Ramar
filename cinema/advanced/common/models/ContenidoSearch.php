<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Contenido;

/**
 * ContenidoSearch represents the model behind the search form about `backend\models\Contenido`.
 */
class ContenidoSearch extends Contenido
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pelicula_id'], 'integer'],
            [['nombre', 'url', 'tipo'], 'safe'],
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
        $query = Contenido::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

        /*if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'pelicula_id' => $this->pelicula_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'tipo', $this->tipo]);

        return $dataProvider;
    }
}
