<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\MovementDetailQuery;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "movement_detail".
 *
 * @property integer $id
 * @property string $date
 * @property string $concept
 * @property integer $beneficiary_id
 * @property string $kind
 * @property string $amount
 * @property integer $transfer_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property \app\modules\movement\models\Movement $transfer
 * @property \app\modules\movement\models\MovementSubDetail[] $movementSubDetails
 */
class MovementDetail extends ActiveRecord
{
    use RelationTrait;

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
            'movementSubDetails'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['date', 'concept', 'beneficiary_id', 'kind', 'transfer_id'], 'required'],
            [['date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['beneficiary_id', 'transfer_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['amount'], 'number'],
            [['concept'], 'string', 'max' => 500],
            [['kind'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'movement_detail';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'concept' => 'Concept',
            'beneficiary_id' => 'Beneficiary ID',
            'kind' => 'Kind',
            'amount' => 'Amount',
            'transfer_id' => 'Transfer ID',
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
    public function getMovementSubDetails(): ActiveQuery
    {
        return $this->hasMany(\app\modules\movement\models\MovementSubDetail::class, ['detail_id' => 'id']);
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
                'value' => new Expression('GETDATE()'),
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
     * @return MovementDetailQuery the active query used by this AR class.
     */
    public static function find(): MovementDetailQuery
    {
        return new MovementDetailQuery(get_called_class());
    }
}
