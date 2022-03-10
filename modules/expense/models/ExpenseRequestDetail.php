<?php

namespace app\modules\expense\models;

use Yii;
use \app\modules\expense\models\base\ExpenseRequestDetail as BaseExpenseRequestDetail;

/**
 * This is the model class for table "expense_request_detail".
 */
class ExpenseRequestDetail extends BaseExpenseRequestDetail
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['advance_detail_id', 'amount'], 'required'],
                [['advance_detail_id', 'expense_request_id', 'created_by', 'updated_by'], 'integer'],
                [['amount'], 'number'],
                [['created_at', 'updated_at'], 'safe']
            ]);
    }

}
