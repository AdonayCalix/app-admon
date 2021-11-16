<?php

namespace app\modules\project\models;

use \app\modules\project\models\base\ProjectPeriod as BaseProjectPeriod;

/**
 * This is the model class for table "project_period".
 */
class ProjectPeriod extends BaseProjectPeriod
{
    public static function getPeriods(int $budget_id): array
    {
        $project_id = ProjectBudget::findOne($budget_id)->project_id;
        return self::find()
            ->select(['id', 'name AS label'])
            ->where(['project_id' => $project_id])
            ->asArray()
            ->all();
    }

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
