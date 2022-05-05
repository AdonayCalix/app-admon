<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\VoluntaryContributionQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery as ActiveQueryAlias;

/**
 * This is the base model class for table "voluntary_contribution".
 *
 * @property integer $id
 * @property string $name
 * @property string $date
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\modules\movement\models\VoluntaryContributionDetail[] $voluntaryContributionDetails
 */
class VoluntaryContribution extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'voluntaryContributionDetails'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'date'], 'required'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 225]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'voluntary_contribution';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'date' => 'Fecha',
        ];
    }

    /**
     * @return ActiveQueryAlias
     */
    public function getVoluntaryContributionDetails(): ActiveQueryAlias
    {
        return $this->hasMany(\app\modules\movement\models\VoluntaryContributionDetail::class, ['voluntary_contribution_id' => 'id']);
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
     * @return VoluntaryContributionQuery the active query used by this AR class.
     */
    public static function find(): VoluntaryContributionQuery
    {
        return new VoluntaryContributionQuery(get_called_class());
    }
}
