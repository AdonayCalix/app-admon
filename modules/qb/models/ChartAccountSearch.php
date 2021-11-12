<?php

namespace app\modules\qb\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\qb\models\ChartAccount;

/**
 * app\modules\qb\models\ChartAccountSearch represents the model behind the search form about `app\modules\qb\models\ChartAccount`.
 */
class ChartAccountSearch extends ChartAccount
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['account_number', 'name', 'description', 'sub_account', 'type', 'currency', 'created_at', 'update_at', 'deleted_at'], 'safe'],
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
        $query = ChartAccount::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'account_number', $this->account_number])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'sub_account', $this->sub_account])
            ->andFilterWhere(['like', 'is_parent', $this->is_parent])
            ->andFilterWhere(['like', 'identifier', $this->identifier])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'currency', $this->currency]);

        return $dataProvider;
    }
}
