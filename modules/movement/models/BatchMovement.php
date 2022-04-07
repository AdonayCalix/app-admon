<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\BatchMovement as BaseBatchMovement;

/**
 * This is the model class for table "batch_movement".
 */
class BatchMovement extends BaseBatchMovement
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['movement_id'], 'required'],
            [['movement_id', 'code', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['list_id', 'batch_number'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 20],
        ]);
    }
	
}
