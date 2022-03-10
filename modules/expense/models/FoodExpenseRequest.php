<?php

namespace app\modules\expense\models;

use Yii;
use \app\modules\expense\models\base\FoodExpenseRequest as BaseFoodExpenseRequest;

/**
 * This is the model class for table "food_expense_request".
 */
class FoodExpenseRequest extends BaseFoodExpenseRequest
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['place_id', 'expense_request_id', 'date'], 'required'],
            [['lunch', 'dinner', 'breakfast'], 'number'],
            [['expense_request_id', 'created_by', 'updated_by', 'place_id'], 'integer'],
        ]);
    }
	
}
