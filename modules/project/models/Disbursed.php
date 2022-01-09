<?php

namespace app\modules\project\models;

use app\modules\movement\models\base\Movement;
use app\modules\movement\models\MovementDetail;
use app\modules\project\components\FormatDate;
use models\ArraySumTest;
use Yii;
use \app\modules\project\models\base\Disbursed as BaseDisbursed;

/**
 * This is the model class for table "disbursed".
 */
class Disbursed extends BaseDisbursed
{
    const CEPROSAF_BENEFICIARY = 1;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['period_id', 'project_id', 'amount', 'date', 'description'], 'required'],
                [['period_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['amount'], 'number'],
                [['description'], 'string', 'max' => '250'],
                [['date', 'created_at', 'updated_at', 'deleted_at'], 'safe']
            ]);
    }

    public function saveMovement(): bool
    {
        $movement = Movement::findOne($this->movement_id) ?? new Movement;
        $movement->project_id = $this->project_id;
        $movement->amount = $this->amount;
        $movement->number = 'DEPOSITO';
        $movement->bank_id = 1;
        $movement->bank_account = '0';
        $movement->save(false);

        $movementDetail = MovementDetail::findOne($movement->id) ?? new MovementDetail;
        $movementDetail->transfer_id = $movement->id;
        $movementDetail->amount = $this->amount;
        $movementDetail->date = (new FormatDate($this->date, 'd/m/Y', 'Y-m-d'))->change()->asString();;
        $movementDetail->kind = 'Desembolso';
        $movementDetail->beneficiary_id = self::CEPROSAF_BENEFICIARY;
        $movementDetail->concept = $this->description;
        $movementDetail->save(false);

        $this->movement_id = $movement->id;
        $this->save(false);
        return true;
    }
}
