<?php

namespace app\modules\milk\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\milk\models\Dillers;

/**
 * DillersSearch represents the model behind the search form of `app\modules\milk\models\Dillers`.
 */
class DillersSearch extends Dillers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'phone', 'phone2'], 'integer'],
            [['name', 'address', 'tg_address', 'car_number', 'photo', 'created_at', 'updated_at', 'car'], 'safe'],
            [['status'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Dillers::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'phone' => $this->phone,
            'phone2' => $this->phone2,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'address', $this->address])
            ->andFilterWhere(['ilike', 'tg_address', $this->tg_address])
            ->andFilterWhere(['ilike', 'car_number', $this->car_number])
            ->andFilterWhere(['ilike', 'photo', $this->photo])
            ->andFilterWhere(['ilike', 'car', $this->car]);

        return $dataProvider;
    }
}
