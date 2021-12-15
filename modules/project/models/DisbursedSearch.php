<?php

namespace app\modules\project\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\project\models\Disbursed;

/**
 * app\modules\movement\models\DisbursedSearch represents the model behind the search form about `app\modules\project\models\Disbursed`.
 */
class DisbursedSearch extends Disbursed
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'period_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['amount'], 'number'],
            [['date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios(): array
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
    public function search($params): ActiveDataProvider
    {
        $query = Disbursed::find();

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
            'period_id' => $this->period_id,
            'project_id' => $this->project_id,
            'amount' => $this->amount,
            'date' => $this->date
        ]);

        return $dataProvider;
    }
}
