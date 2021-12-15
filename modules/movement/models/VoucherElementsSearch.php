<?php

namespace app\modules\movement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\movement\models\VoucherElements;

/**
 * app\modules\movement\models\VoucherElementsSearch represents the model behind the search form about `app\modules\movement\models\VoucherElements`.
 */
 class VoucherElementsSearch extends VoucherElements
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['number', 'emission_date', 'beneficiary', 'concept', 'amount', 'amount_total', 'detail_body', 'header_body', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
        $query = VoucherElements::find();

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
            'project_id' => $this->project_id
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'emission_date', $this->emission_date])
            ->andFilterWhere(['like', 'beneficiary', $this->beneficiary])
            ->andFilterWhere(['like', 'concept', $this->concept])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'detail_body', $this->detail_body])
            ->andFilterWhere(['like', 'header_body', $this->header_body]);

        return $dataProvider;
    }
}
