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
 * @property \app\modules\movement\models\Beneficiary $beneficiary
 */
class TransferAssignment extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

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
            [['transfer_id', 'beneficiary_id', 'amount', 'position'], 'required'],
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
}
