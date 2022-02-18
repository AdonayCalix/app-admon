<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\MovementDetailV2 as BaseMovementDetailV2;

/**
 * This is the model class for table "movement_detail_v2".
 */
class MovementDetailV2 extends BaseMovementDetailV2
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

    public function beforeValidate(): bool
    {
        $this->amount = str_replace(',', '', $this->amount);
        return parent::beforeValidate();
    }
}
