<?php

namespace app\modules\movement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\movement\models\TransferAssignment;

/**
 * app\modules\movement\models\TransferAssignmentSearch represents the model behind the search form about `app\modules\movement\models\TransferAssignment`.
 */
class TransferAssignmentSearch extends TransferAssignment
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'transfer_id', 'beneficiary_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['position', 'reason', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
        $query = TransferAssignment::find()
            ->select(['transfer_id'])
            ->groupBy(['transfer_id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'transfer_id' => $this->transfer_id,
            'beneficiary_id' => $this->beneficiary_id,
            'amount' => $this->amount
        ]);

        $query->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
