<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\QbMovementLogQuery;
use app\modules\project\models\Project;
use mootensai\relation\RelationTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "qb_movement_log".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $movement_detail_id
 * @property integer $movement_id
 * @property integer $kind
 * @property string $amount
 * @property integer $Code
 * @property string $created_at
 * @property string $number
 * @property string $date
 *
 * @property Project $project
 */
class QbMovementLog extends ActiveRecord
{
    use RelationTrait;


    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'project'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'project_id', 'movement_detail_id', 'movement_id', 'kind', 'amount', 'number', 'date'], 'required'],
            [['id', 'project_id', 'movement_detail_id', 'movement_id', 'kind', 'Code'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'date'], 'safe'],
            [['number'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'qb_movement_log';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'movement_detail_id' => 'Movement Detail ID',
            'movement_id' => 'Movement ID',
            'kind' => 'Kind',
            'amount' => 'Amount',
            'Code' => 'Code',
            'number' => 'Number',
            'date' => 'Date',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProject(): ActiveQuery
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
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
                'value' => new Expression('GETDATE()'),
            ],
        ];
    }


    /**
     * @inheritdoc
     * @return QbMovementLogQuery the active query used by this AR class.
     */
    public static function find(): QbMovementLogQuery
    {
        return new QbMovementLogQuery(get_called_class());
    }
}
