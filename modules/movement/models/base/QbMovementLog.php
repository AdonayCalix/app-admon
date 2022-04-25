<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\QbMovementLogQuery;
use app\modules\project\models\Project;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "qb_movement_log".
 *
 * @property integer $project_id
 * @property integer $movement_detail_id
 * @property integer $movement_id
 * @property string $kind
 * @property string $amount
 * @property integer $Code
 * @property string $created_at
 * @property string $number
 * @property string $date
 * @property integer $id
 *
 * @property Project $project
 */
class QbMovementLog extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

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
            [['project_id', 'movement_detail_id', 'movement_id', 'kind', 'amount', 'number', 'date'], 'required'],
            [['project_id', 'movement_detail_id', 'movement_id', 'Code'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'date'], 'safe'],
            [['kind', 'number'], 'string', 'max' => 100]
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
            'project_id' => 'Project ID',
            'movement_detail_id' => 'Movement Detail ID',
            'movement_id' => 'Movement ID',
            'kind' => 'Kind',
            'amount' => 'Amount',
            'Code' => 'Code',
            'number' => 'Number',
            'date' => 'Date',
            'id' => 'ID',
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
                'value' => new \yii\db\Expression('GETDATE()'),
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
