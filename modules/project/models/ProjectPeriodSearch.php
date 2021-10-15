<?php

namespace app\modules\project\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\project\models\ProjectPeriod;

/**
 * app\modules\project\models\ProjectPeriodSearch represents the model behind the search form about `app\modules\project\models\ProjectPeriod`.
 */
class ProjectPeriodSearch extends ProjectPeriod
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name', 'start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
        $query = ProjectPeriod::find();

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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'project_id' => $this->project_id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
