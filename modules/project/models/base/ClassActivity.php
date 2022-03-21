<?php

namespace app\modules\project\models\base;

use app\modules\project\models\ClassActivityQuery;
use app\modules\qb\models\ListClass;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "class_activity".
 *
 * @property integer $id
 * @property integer $class_id
 * @property integer $activity_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property ListClass $class
 * @property \app\modules\project\models\SubCategory $activity
 */
class ClassActivity extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'class',
            'activity'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['class_id', 'activity_id', 'created_at'], 'required'],
            [['class_id', 'activity_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'class_activity';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'class_id' => 'Class ID',
            'activity_id' => 'Activity ID',
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getClass(): ActiveQuery
    {
        return $this->hasOne(ListClass::class, ['id' => 'class_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getActivity(): ActiveQuery
    {
        return $this->hasOne(\app\modules\project\models\SubCategory::class, ['id' => 'activity_id']);
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
     * @return ClassActivityQuery the active query used by this AR class.
     */
    public static function find(): ClassActivityQuery
    {
        return new ClassActivityQuery(get_called_class());
    }
}
