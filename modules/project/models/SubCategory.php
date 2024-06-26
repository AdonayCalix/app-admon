<?php

namespace app\modules\project\models;

use \app\modules\project\models\base\SubCategory as BaseSubCategory;

/**
 * This is the model class for table "sub_category".
 */
class SubCategory extends BaseSubCategory
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'account_number', 'category_id'], 'required'],
            [['identifier'], 'unique'],
            [['category_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'module', 'intervention'], 'string', 'max' => 1000],
            [['identifier'], 'string', 'max' => 100],
            [['expense_category'], 'string', 'max' => 250],
            [['account_number'], 'string', 'max' => 10]
        ]);
    }
}
