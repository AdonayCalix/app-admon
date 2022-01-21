<?php

namespace app\modules\movement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\movement\models\Movement;

/**
 * app\modules\qb\models\MovementSearch represents the model behind the search form about `app\modules\movement\models\Movement`.
 */
class MovementSearch extends Movement
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'bank_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['number', 'bank_account', 'created_at', 'updated_at', 'deleted_at', 'date'], 'safe'],
            [['amount'], 'number'],
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
    public function search($params)
    {
        $query = Movement::find()
            ->select(['movement.id', 'movement.number', 'movement.amount', 'movement.project_id', 'mv.kind', 'mv.date'])
            ->where(['<>', 'mv.kind', 'Desembolso'])
            ->joinWith('movementDetails mv')
            ->groupBy(['number', 'movement.id', 'movement.amount', 'movement.project_id', 'mv.kind', 'mv.date']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 30],
        ]);

        $dataProvider->sort->attributes['date'] = [
            'asc' => ['date' => SORT_ASC],
            'desc' => ['date' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'amount' => $this->amount,
            'bank_id' => $this->bank_id,
            'project_id' => $this->project_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number]);
        $query->andFilterWhere(['like', 'date', $this->date]);
        $query->andFilterWhere(['like', 'bank_account', $this->bank_account]);

        return $dataProvider;
    }
}
