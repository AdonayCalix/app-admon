<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\movement\models\QbMovementLog;

/**
 * app\models\QbMovementLogSearch represents the model behind the search form about `app\modules\movement\models\QbMovementLog`.
 */
class QbMovementLogSearch extends QbMovementLog
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['project_id', 'movement_detail_id', 'movement_id', 'Code', 'id'], 'integer'],
            [['kind', 'created_at', 'number', 'date'], 'safe'],
            [['amount'], 'number'],
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
        $query = QbMovementLog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 15],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'project_id' => $this->project_id,
            'movement_detail_id' => $this->movement_detail_id,
            'movement_id' => $this->movement_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'kind', $this->kind])
            ->andFilterWhere(['like', 'number', $this->number]);

        if ($this->date <> null)
            $query->andFilterWhere(['like', 'date', date('Y-m-d', strtotime(str_replace('/', '-', $this->date))) ?? null]);

        if ($this->Code <> null && $this->Code == 0)
            $query->andFilterWhere(['Code' => 0]);
        else
            $query->andFilterWhere(['>', 'Code', 0]);

        return $dataProvider;
    }
}
