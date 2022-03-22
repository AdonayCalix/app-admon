<?php

namespace app\modules\project\models;

use Yii;
use \app\modules\project\models\base\ChartAccountActivity as BaseChartAccountActivity;

/**
 * This is the model class for table "chart_account_activity".
 */
class ChartAccountActivity extends BaseChartAccountActivity
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['chart_account_id', 'activity_id'], 'required'],
            [['activity_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ]);
    }
	
}
