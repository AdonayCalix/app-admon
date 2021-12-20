<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\TransferAssignmentQuery;
use app\modules\project\models\Beneficiary;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "transfer_assignment".
 *
 * @property integer $id
 * @property integer $transfer_id
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
            [['transfer_id', 'beneficiary_id', 'amount', 'position', 'reason'], 'required'],
            [['transfer_id', 'beneficiary_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
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
            'transfer_id' => 'No TB/Cheque',
            'beneficiary_id' => 'Beneficiario',
            'amount' => 'Monto',
            'position' => 'Posicion',
            'reason' => 'Motivo',
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getTransfer(): ActiveQuery
    {
        return $this->hasOne(\app\modules\movement\models\Movement::class, ['id' => 'transfer_id']);
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


}
