<?php

namespace app\modules\project\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * app\modules\project\models\BudgetCategorySearch represents the model behind the search form about `app\modules\project\models\BudgetCategory`.
 */
 class BudgetCategorySearch extends BudgetCategory
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'budget_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name', 'identifier', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
        $query = BudgetCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'budget_id' => $this->budget_id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'identifier', $this->identifier]);

        return $dataProvider;
    }
}
