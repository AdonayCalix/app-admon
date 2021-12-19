<?php

namespace app\modules\project\models\base;

use app\modules\project\models\TransferQuery;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "transfer".
 *
 * @property integer $id
 * @property string $number
 * @property string $amount
 * @property integer $bank_id
 * @property string $bank_account
 * @property integer $beneficiary_id
 * @property integer $project_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property \app\modules\project\models\Project $project
 * @property \app\modules\project\models\Beneficiary $beneficiary
 */
class Transfer extends ActiveRecord
{
    use RelationTrait;

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'project',
            'beneficiary'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['number', 'amount', 'bank_id', 'bank_account', 'beneficiary_id', 'project_id'], 'required'],
            [['amount'], 'number'],
            [['bank_id', 'beneficiary_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['number', 'bank_account'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'transfer';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'number' => 'No. Cheque/TB',
            'amount' => 'Monto',
            'bank_id' => 'Banco',
            'bank_account' => 'Cuenta',
            'beneficiary_id' => 'Beneficiario',
            'project_id' => 'Proyecto',
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getProject(): ActiveQuery
    {
        return $this->hasOne(\app\modules\project\models\Project::class, ['id' => 'project_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getBeneficiary(): ActiveQuery
    {
        return $this->hasOne(\app\modules\project\models\Beneficiary::class, ['id' => 'beneficiary_id']);
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
     * @return TransferQuery the active query used by this AR class.
     */
    public static function find(): TransferQuery
    {
        return new TransferQuery(get_called_class());
    }
}
