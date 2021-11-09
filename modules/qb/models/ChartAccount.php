<?php

namespace app\modules\qb\models;

use \app\modules\qb\models\base\ChartAccount as BaseChartAccount;

/**
 * This is the model class for table "chart_account".
 */
class ChartAccount extends BaseChartAccount
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['account_number', 'name', 'description', 'type', 'currency'], 'required'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'update_at', 'deleted_at'], 'safe'],
            [['account_number'], 'string', 'max' => 20],
            [['name', 'description'], 'string', 'max' => 500],
            [['type'], 'string', 'max' => 100],
            [['currency'], 'string', 'max' => 10]
        ]);
    }
	
}
