<?php

namespace app\modules\movement\models\base;

use app\modules\expense\models\base\ExpenseRequest;
use app\modules\expense\models\ExpenseRequestDetail;
use app\modules\expense\models\ExpenseRequestQuery;
use app\modules\movement\models\TransferAssignmentQuery;
use app\modules\project\models\Beneficiary;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the base model class for table "transfer_assignment".
 *
 * @property integer $id
 * @property integer $number_transfer
 * @property integer $beneficiary_id
 * @property string $amount
 * @property string $position
 * @property string $reason
 * @property integer $created_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $updated_by
 * @property integer $expense_request_id
 *
 * @property \app\modules\movement\models\Movement $transfer
 * @property Beneficiary $beneficiary
 */
class TransferAssignment extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'transfer',
            'beneficiary'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['number_transfer', 'beneficiary_id', 'amount', 'position', 'reason', 'expense_request_id'], 'required'],
            [['number_transfer', 'beneficiary_id', 'created_by', 'deleted_by', 'updated_by', 'expense_request_id'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['position'], 'string', 'max' => 250],
            [['reason'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'transfer_assignment';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'number_transfer' => 'No TB/Cheque',
            'beneficiary_id' => 'Beneficiario',
            'amount' => 'Monto',
            'position' => 'Posicion',
            'reason' => 'Motivo',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getBeneficiary(): ActiveQuery
    {
        return $this->hasOne(Beneficiary::class, ['id' => 'beneficiary_id']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('GETDATE()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ]
        ];
    }

    /**
     * @inheritdoc
     * @return TransferAssignmentQuery the active query used by this AR class.
     */
    public static function find(): TransferAssignmentQuery
    {
        return new TransferAssignmentQuery(get_called_class());
    }

    public function beforeValidate(): bool
    {
        $this->amount = str_replace(',', '', $this->amount);
        return parent::beforeValidate();
    }

    public static function store(ExpenseRequest $expenseRequest)
    {
        $transfer = self::findOne(['expense_request_id' => $expenseRequest->id]) ?? new self;
        $transfer->number_transfer =$expenseRequest->number_transfer ?? '';
        $transfer->expense_request_id = $expenseRequest->id;
        $transfer->beneficiary_id = $expenseRequest->beneficiary_id;
        $transfer->position = $expenseRequest->position ?? '';
        $transfer->reason = $expenseRequest->goal ?? '';
        $transfer->amount = self::getTotalExpenses($expenseRequest);
        $transfer->save(false);
    }

    public static function getTotalExpenses(ExpenseRequest $expenseRequest): float
    {
        $total_breakfast = array_sum(array_column($expenseRequest->foodExpenseRequests, 'breakfast'));
        $total_lunch = array_sum(array_column($expenseRequest->foodExpenseRequests, 'lunch'));
        $total_dinner = array_sum(array_column($expenseRequest->foodExpenseRequests, 'dinner'));
        $total_food = $total_breakfast + $total_lunch + $total_dinner;

        $totalFoodExpense = array_reduce($expenseRequest->foodExpenseRequests, function ($breakfast, $sum) {
            return $breakfast;
        });

        $advance_details = ArrayHelper::toArray($expenseRequest->expenseRequestDetails, [
            ExpenseRequestDetail::class => [
                'amount'
            ]
        ]);

        return $total_food + (array_sum(array_column($advance_details, 'amount')));

    }

}
