<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\movement\models\VoluntaryContribution;

/**
 * app\models\VoluntaryContributionSearch represents the model behind the search form about `app\modules\movement\models\VoluntaryContribution`.
 */
 class VoluntaryContributionSearch extends VoluntaryContribution
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['name', 'date', 'created_at', 'updated_at'], 'safe'],
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
    public function search($params): ActiveDataProvider
    {
        $query = VoluntaryContribution::find();

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
            'date' => $this->date
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
