<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\VoluntaryContributionDetailQuery;
use app\modules\project\models\Beneficiary;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "voluntary_contribution_detail".
 *
 * @property integer $id
 * @property string $memo
 * @property string $amount
 * @property integer $beneficiary_id
 * @property integer $voluntary_contribution_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Beneficiary $beneficiary
 * @property \app\modules\movement\models\VoluntaryContribution $voluntaryContribution
 */
class VoluntaryContributionDetail extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'beneficiary',
            'voluntaryContribution'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['memo', 'amount', 'beneficiary_id', 'voluntary_contribution_id'], 'required'],
            [['amount'], 'number'],
            [['beneficiary_id', 'voluntary_contribution_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['memo'], 'string', 'max' => 225]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'voluntary_contribution_detail';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'memo' => 'Memo',
            'amount' => 'Monto',
            'beneficiary_id' => 'Beneficiario ID',
            'voluntary_contribution_id' => 'Aporte Voluntario ID',
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
     * @return ActiveQuery
     */
    public function getVoluntaryContribution(): ActiveQuery
    {
        return $this->hasOne(\app\modules\movement\models\VoluntaryContribution::class, ['id' => 'voluntary_contribution_id']);
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
                'updatedAtAttribute' => false,
                'value' => new \yii\db\Expression('GETDATE()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return VoluntaryContributionDetailQuery the active query used by this AR class.
     */
    public static function find(): VoluntaryContributionDetailQuery
    {
        return new VoluntaryContributionDetailQuery(get_called_class());
    }
}
