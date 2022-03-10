<?php

namespace app\modules\expense\models;

use Yii;
use \app\modules\expense\models\base\ExpenseRequest as BaseExpenseRequest;

/**
 * This is the model class for table "expense_request".
 */
class ExpenseRequest extends BaseExpenseRequest
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['elaborated_at', 'start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['beneficiary_id', 'project_id', 'created_by', 'updated_by', 'requested_day'], 'integer'],
            [['project_id'], 'required'],
            [['position'], 'string', 'max' => 225],
            [['place', 'goal'], 'string', 'max' => 500],
            [['number_transfer'], 'string', 'max' => 20],
            ['start_date', 'validateDatesInAndOut']
        ]);
    }
	
}
