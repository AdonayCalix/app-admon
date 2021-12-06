<?php

namespace app\modules\project\models;

use Yii;
use \app\modules\project\models\base\UserProject as BaseUserProject;

/**
 * This is the model class for table "user_project".
 */
class UserProject extends BaseUserProject
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['position', 'project_id', 'user_id'], 'required'],
                [['project_id', 'user_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['position'], 'string', 'max' => 225]
            ]);
    }
}
