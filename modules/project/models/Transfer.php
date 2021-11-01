<?php

namespace app\modules\project\models;


use \app\modules\project\models\base\Transfer as BaseTransfer;

/**
 * This is the model class for table "transfer".
 */
class Transfer extends BaseTransfer
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['number', 'amount', 'bank_id', 'bank_account', 'beneficiary_id', 'project_id'], 'required'],
            [['amount'], 'number'],
            [['bank_id', 'beneficiary_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['number', 'bank_account'], 'string', 'max' => 100]
        ]);
    }
	
}
