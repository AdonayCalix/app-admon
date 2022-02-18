<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\MovementDetailV2Query;
use app\modules\project\components\ArraySum;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "movement_detail_v2".
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
 * @property \app\modules\movement\models\MovementSubDetailV2[] $movementSubDetailV2s
 */
class MovementDetailV2 extends \yii\db\ActiveRecord
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
            'movementSubDetailV2s'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['date', 'concept', 'kind'], 'required'],
            [['date', 'created_at', 'updated_at', 'deleted_at', 'id'], 'safe'],
            [['beneficiary_id', 'transfer_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['amount'], 'number'],
            [['concept'], 'string', 'max' => 500],
            [['kind'], 'string', 'max' => 20],
            ['amount', 'validateSumOfAmount']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'movement_detail_v2';
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
    public function getMovementSubDetailV2s(): ActiveQuery
    {
        return $this->hasMany(\app\modules\movement\models\MovementSubDetailV2::class, ['detail_id' => 'id']);
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
     * @return MovementDetailV2Query the active query used by this AR class.
     */
    public static function find(): MovementDetailV2Query
    {
        return new MovementDetailV2Query(get_called_class());
    }

    public function validateSumOfAmount($attribute, $params, $validator, $current)
    {
        $amountsSubDetail = [];
        foreach ($this->movementSubDetailV2s as $value)
            $amountsSubDetail[] = str_replace(',', '', $value['amount']);

        $amountOfSubDetails = ArraySum::make($amountsSubDetail);

        if ($amountOfSubDetails != $this->amount) {
            $this->addError('amount', 'La suma del movimiento debe ser igual a la sumatoria de los detalles de esta ' . $this->amount . ' ' . $amountOfSubDetails);
        }
    }
}
