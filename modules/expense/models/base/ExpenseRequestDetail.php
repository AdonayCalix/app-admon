<?php

namespace app\modules\expense\models\base;

use app\modules\expense\models\ExpenseRequestDetailQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery as ActiveQueryAlias;

/**
 * This is the base model class for table "expense_request_detail".
 *
 * @property integer $id
 * @property integer $advance_detail_id
 * @property integer $expense_request_id
 * @property string $amount
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \app\modules\expense\models\AdvanceDetail $advanceDetail
 * @property \app\modules\expense\models\ExpenseRequest $expenseRequest
 */
class ExpenseRequestDetail extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'advanceDetail',
            'expenseRequest'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['advance_detail_id', 'amount'], 'required', 'message' => '{attribute}'],
            [['advance_detail_id', 'expense_request_id', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'expense_request_detail';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'advance_detail_id' => 'Detalle de Gasto',
            'expense_request_id' => 'Anticipo de Gasto',
            'amount' => 'Amount',
        ];
    }
    
    /**
     * @return ActiveQueryAlias
     */
    public function getAdvanceDetail(): ActiveQueryAlias
    {
        return $this->hasOne(\app\modules\expense\models\AdvanceDetail::class, ['id' => 'advance_detail_id']);
    }
        
    /**
     * @return ActiveQueryAlias
     */
    public function getExpenseRequest(): ActiveQueryAlias
    {
        return $this->hasOne(\app\modules\expense\models\ExpenseRequest::class, ['id' => 'expense_request_id']);
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
            ],
        ];
    }


    /**
     * @inheritdoc
     * @return ExpenseRequestDetailQuery the active query used by this AR class.
     */
    public static function find(): ExpenseRequestDetailQuery
    {
        return new ExpenseRequestDetailQuery(get_called_class());
    }
}
