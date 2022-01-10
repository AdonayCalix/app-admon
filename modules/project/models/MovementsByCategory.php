<?php

namespace app\modules\project\models;

use Yii;
use \app\modules\project\models\base\MovementsByCategory as BaseMovementsByCategory;

/**
 * This is the model class for table "movements_by_category".
 */
class MovementsByCategory extends BaseMovementsByCategory
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['order_number', 'project_id'], 'integer'],
            [['date', 'number', 'name', 'concept', 'project_id'], 'required'],
            [['date'], 'safe'],
            [['excel_date'], 'number'],
            [['number'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 200],
            [['concept'], 'string', 'max' => 500]
        ]);
    }
	
}
