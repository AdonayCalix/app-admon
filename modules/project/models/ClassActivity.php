<?php

namespace app\modules\project\models;

use Yii;
use \app\modules\project\models\base\ClassActivity as BaseClassActivity;

/**
 * This is the model class for table "class_activity".
 */
class ClassActivity extends BaseClassActivity
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['class_id', 'activity_id', 'created_at'], 'required'],
            [['class_id', 'activity_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ]);
    }
	
}
