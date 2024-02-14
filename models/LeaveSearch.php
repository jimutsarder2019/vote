<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Leave;

/**
 * LeaveSearch represents the model behind the search form of `app\models\Leave`.
 */
class LeaveSearch extends Leave
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user', 'type', 'duration', 'status'], 'integer'],
            [['leave_date', 'reason', 'date'], 'safe'],
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
        $query = Leave::find();

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
            'user' => $this->user,
            'type' => $this->type,
            'duration' => $this->duration,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'leave_date', $this->leave_date])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }
}
