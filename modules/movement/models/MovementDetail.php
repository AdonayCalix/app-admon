<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\MovementDetail as BaseMovementDetail;

/**
 * This is the model class for table "movement_detail".
 */
class MovementDetail extends BaseMovementDetail
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['date', 'concept', 'kind'], 'required'],
            [['date', 'created_at', 'updated_at', 'deleted_at', 'id'], 'safe'],
            [['beneficiary_id', 'transfer_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['amount'], 'number'],
            [['concept'], 'string', 'max' => 500],
            [['kind'], 'string', 'max' => 20],
            ['amount', 'validateSumOfAmount']
        ]);
    }
}
