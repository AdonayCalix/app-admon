<?php

namespace app\modules\project\models;


use \app\modules\project\models\base\BudgetCategory as BaseBudgetCategory;

/**
 * This is the model class for table "budget_category".
 */
class BudgetCategory extends BaseBudgetCategory
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'identifier', 'budget_id'], 'required'],
            [['budget_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name'], 'string', 'max' => 225],
            [['identifier'], 'string', 'max' => 100]
        ]);
    }
	
}
