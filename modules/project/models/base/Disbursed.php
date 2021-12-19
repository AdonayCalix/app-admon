<?php

namespace app\modules\project\models\base;

use app\modules\project\components\FormatDate;
use app\modules\project\models\DisbursedQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "disbursed".
 *
 * @property integer $id
 * @property integer $period_id
 * @property integer $project_id
 * @property string $amount
 * @property string $date
 * @property string $description
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property \app\modules\project\models\Project $project
 * @property \app\modules\project\models\ProjectPeriod $period
 */
class Disbursed extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'project',
            'period'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['period_id', 'project_id', 'amount', 'date', 'description'], 'required'],
            [['period_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['amount'], 'number'],
            [['description'], 'string', 'max' => '250'],
            [['date', 'created_at', 'updated_at', 'deleted_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'disbursed';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'period_id' => 'Periodo',
            'project_id' => 'Proyecto',
            'amount' => 'Monto',
            'date' => 'Fecha',
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
    public function getPeriod(): ActiveQuery
    {
        return $this->hasOne(\app\modules\project\models\ProjectPeriod::class, ['id' => 'period_id']);
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
     * @return DisbursedQuery the active query used by this AR class.
     */
    public static function find(): DisbursedQuery
    {
        return new DisbursedQuery(get_called_class());
    }

    public function beforeSave($insert): bool
    {
        $this->date = (new FormatDate($this->date, 'd/m/Y', 'Y-m-d'))->change()->asString();
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->date = (new FormatDate($this->date, 'Y-m-d', 'd/m/Y'))->change()->asString();
        parent::afterFind();
    }
}
