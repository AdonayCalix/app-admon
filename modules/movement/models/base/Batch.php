<?php

namespace app\modules\movement\models\base;

use app\modules\project\models\Project;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "batch".
 *
 * @property integer $id
 * @property string $number
 * @property string $kind
 * @property string $emission_date
 * @property string $process_date
 * @property integer $project_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Project $project
 */
class Batch extends \yii\db\ActiveRecord
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
            [['number', 'kind', 'emission_date', 'project_id'], 'required'],
            [['emission_date', 'process_date', 'created_at', 'updated_at'], 'safe'],
            [['project_id', 'created_by', 'updated_by'], 'integer'],
            [['number'], 'string', 'max' => 100],
            [['kind'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'batch';
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'kind' => 'Kind',
            'emission_date' => 'Emission Date',
            'process_date' => 'Process Date',
            'project_id' => 'Project ID',
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

    public static function find(): \app\modules\movement\models\BatchQuery
    {
        return new \app\modules\movement\models\BatchQuery(get_called_class());
    }
}
