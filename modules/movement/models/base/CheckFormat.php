<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\CheckFormatQuery;
use app\modules\project\models\Project;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "check_format".
 *
 * @property integer $id
 * @property string $elaborated_by
 * @property string $checked_by
 * @property string $authorized_by
 * @property string $aproved_main_director_by
 * @property string $logo_path
 * @property integer $project_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property Project $project
 */
class CheckFormat extends \yii\db\ActiveRecord
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
            [['elaborated_by', 'checked_by', 'authorized_by', 'project_id'], 'required'],
            [['project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['elaborated_by', 'checked_by', 'authorized_by', 'aproved_main_director_by'], 'string', 'max' => 200],
            [['logo_path'], 'string', 'max' => 225]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'check_format';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'elaborated_by' => 'Elaborado Por',
            'checked_by' => 'Revisado Por',
            'authorized_by' => 'Autorizado Por',
            'aproved_main_director_by' => 'Vo.Bo. Directora Ejecutiva',
            'logo_path' => 'Logo',
            'project_id' => 'Proyecto',
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

    /**
     * @inheritdoc
     * @return CheckFormatQuery the active query used by this AR class.
     */
    public static function find(): CheckFormatQuery
    {
        return new CheckFormatQuery(get_called_class());
    }
}
