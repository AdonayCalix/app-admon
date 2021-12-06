<?php

namespace app\modules\project\models\base;

use app\modules\project\models\UserProjectQuery;
use webvimark\modules\UserManagement\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "user_project".
 *
 * @property integer $id
 * @property string $position
 * @property integer $project_id
 * @property integer $user_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property \app\modules\project\models\Project $project
 * @property User $user
 */
class UserProject extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct()
    {
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'project',
            'user'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['position', 'project_id', 'user_id'], 'required'],
            [['project_id', 'user_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['position'], 'string', 'max' => 225]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'user_project';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
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
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
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
     * @return UserProjectQuery the active query used by this AR class.
     */
    public static function find(): UserProjectQuery
    {
        return new UserProjectQuery(get_called_class());
    }
}
