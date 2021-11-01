<?php

namespace app\modules\project\models;

use \app\modules\project\models\base\ProjectPeriod as BaseProjectPeriod;

/**
 * This is the model class for table "project_period".
 */
class ProjectPeriod extends BaseProjectPeriod
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'start_date', 'end_date', 'project_id'], 'required'],
            [['start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name'], 'string', 'max' => 225],
            ['start_date', 'validateDates']
        ]);
    }
	
}
