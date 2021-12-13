<?php

namespace app\modules\movement\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\movement\models\VoucherFormat;

/**
 * app\modules\movement\models\VoucherFormatSearch represents the model behind the search form about `app\modules\movement\models\VoucherFormat`.
 */
class VoucherFormatSearch extends VoucherFormat
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['path', 'is_active', 'created_at', 'updated_at', 'deleted_at', 'original_name'], 'safe'],
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
        $query = VoucherFormat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id
        ]);

        $query->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'origina_name', $this->original_name])
            ->andFilterWhere(['like', 'is_active', $this->is_active]);

        return $dataProvider;
    }
}
