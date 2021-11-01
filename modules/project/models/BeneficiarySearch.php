<?php

namespace app\modules\project\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\project\models\Beneficiary;

/**
 * app\modules\project\models\BeneficiarySearch represents the model behind the search form about `app\modules\project\models\Beneficiary`.
 */
 class BeneficiarySearch extends Beneficiary
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
        $query = Beneficiary::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
