<?php

namespace app\modules\project\models;

use \app\modules\project\models\base\Project as BaseProject;

/**
 * This is the model class for table "project".
 */
class Project extends BaseProject
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['name', 'alias', 'start_date', 'end_date', 'budget', 'bank', 'account_number', 'initial_balance', 'date_initial_balance'], 'required'],
                [['start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['budget'], 'number'],
                [['created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['name'], 'string', 'max' => 500],
                [['alias'], 'string', 'max' => 100],
                [['frecuency'], 'string', 'max' => 20],
                ['start_date', 'validateDates'],
                ['start_date', 'validateDates'],
                ['start_date', 'validateStartDateWithFirstPeriod'],
                ['start_date', 'validateEndDateWithFirstPeriod'],
                ['budget', 'validateBudget']
            ]);
    }
}
