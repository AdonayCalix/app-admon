<?php

namespace app\modules\movement\models;

use \app\modules\movement\models\base\Movement as BaseMovement;

/**
 * This is the model class for table "movement".
 */
class Movement extends BaseMovement
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['number', 'amount', 'bank_id', 'bank_account', 'project_id'], 'required'],
            [['amount'], 'number'],
            [['bank_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['number', 'bank_account'], 'string', 'max' => 100]
        ]);
    }
	
}
