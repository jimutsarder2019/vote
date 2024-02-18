<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Voter;

/**
 * VoterSearch represents the model behind the search form of `app\models\Voter`.
 */
class VoterSearch extends Voter
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'call_done', 'visit_done'], 'integer'],
            [['company', 'name', 'ispab_member', 'voter_no', 'mobile1', 'mobile2', 'email', 'thana', 'district', 'address', 'license', 'date'], 'safe'],
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
        $query = Voter::find();

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
        ]);

        $query->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'ispab_member', $this->ispab_member])
            ->andFilterWhere(['like', 'voter_no', $this->voter_no])
            ->andFilterWhere(['like', 'mobile1', $this->mobile1])
            ->andFilterWhere(['like', 'mobile2', $this->mobile2])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'thana', $this->thana])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'license', $this->license])
            ->andFilterWhere(['=', 'call_done', $this->call_done])
            ->andFilterWhere(['=', 'visit_done', $this->visit_done])
            ->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }
}
