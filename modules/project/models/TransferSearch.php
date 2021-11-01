<?php

namespace app\modules\project\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\project\models\Transfer;

/**
 * app\modules\project\models\TransferSearch represents the model behind the search form about `app\modules\project\models\Transfer`.
 */
 class TransferSearch extends Transfer
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'bank_id', 'beneficiary_id', 'project_id'], 'integer'],
            [['number', 'bank_account', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['amount'], 'number'],
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
        $query = Transfer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'bank_id' => $this->bank_id,
            'beneficiary_id' => $this->beneficiary_id,
            'project_id' => $this->project_id
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'bank_account', $this->bank_account]);

        return $dataProvider;
    }
}
