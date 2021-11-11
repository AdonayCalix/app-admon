<?php

namespace app\modules\qb\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\qb\models\ListClass;

/**
 * app\modules\qb\models\ListClassSearch represents the model behind the search form about `app\modules\qb\models\ListClass`.
 */
 class ListClassSearch extends ListClass
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name', 'identifier', 'is_parent', 'sub_class', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
        $query = ListClass::find();

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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'identifier', $this->identifier])
            ->andFilterWhere(['like', 'is_parent', $this->is_parent])
            ->andFilterWhere(['like', 'sub_class', $this->sub_class]);

        return $dataProvider;
    }
}
