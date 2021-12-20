<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\TransferAssignment as BaseTransferAssignment;

/**
 * This is the model class for table "transfer_assignment".
 */
class TransferAssignment extends BaseTransferAssignment
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['transfer_id', 'beneficiary_id', 'amount', 'position', 'reason'], 'required'],
                [['transfer_id', 'beneficiary_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
                [['amount'], 'number'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['position'], 'string', 'max' => 250],
                [['reason'], 'string', 'max' => 500]
            ]);
    }

    public static function getAll(int $transfer_id): array
    {
        return self::find()
            ->select(['id', 'reason', 'beneficiary_id', 'position', 'amount'])
            ->asArray()
            ->all();
    }

}
