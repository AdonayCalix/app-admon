<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\CheckFormat as BaseCheckFormat;

/**
 * This is the model class for table "check_format".
 */
class CheckFormat extends BaseCheckFormat
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['elaborated_by', 'checked_by', 'authorized_by', 'project_id'], 'required'],
            [['project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['elaborated_by', 'checked_by', 'authorized_by', 'aproved_main_director_by'], 'string', 'max' => 200],
            [['logo_path'], 'string', 'max' => 225]
        ]);
    }
	
}
