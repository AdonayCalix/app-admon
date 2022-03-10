<?php

namespace app\modules\expense\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\expense\models\ExpenseRequest;

/**
 * app\modules\expense\models\ExpenseRequestSearch represents the model behind the search form about `app\modules\expense\models\ExpenseRequest`.
 */
 class ExpenseRequestSearch extends ExpenseRequest
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'beneficiary_id', 'project_id', 'created_by', 'updated_by'], 'integer'],
            [['elaborated_at', 'position', 'place', 'goal', 'number_transfer', 'start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = ExpenseRequest::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'beneficiary_id' => $this->beneficiary_id,
            'project_id' => $this->project_id,
        ]);

        $query->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'place', $this->place])
            ->andFilterWhere(['like', 'goal', $this->goal])
            ->andFilterWhere(['like', 'number_transfer', $this->number_transfer]);
            if ($this->elaborated_at <> null)
                $query->andFilterWhere(['like', 'elaborated_at', date('Y-m-d', strtotime(str_replace('/', '-', $this->elaborated_at))) ?? null]);

        return $dataProvider;
    }
}
