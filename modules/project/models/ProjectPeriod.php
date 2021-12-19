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

        return \Yii::$app->db->createCommand("
            select project_period.id, project_period.name as label from project_period where project_period.project_id = {$project_id}
        ")->queryAll();
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

    public static function getPeriodByDate(string $date, int $projectId): int
    {
        $row = self::find()
            ->where(['project_period.project_id' => $projectId])
            ->andWhere(['<=', 'project_period.start_date', $date])
            ->andWhere(['>=', 'project_period.end_date', $date]);

        return $row->one()->id ?? 0;
    }
}
