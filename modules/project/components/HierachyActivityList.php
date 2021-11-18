<?php

namespace app\modules\project\components;

use app\modules\project\models\ProjectBudget;
use phpDocumentor\Reflection\Types\This;

class HierachyActivityList
{
    /**
     * @var int
     */
    private $project_id;
    private $budgets;
    private $options = [];

    public function __construct(int $project_id)
    {
        $this->project_id = $project_id;
    }

    public function setBudgets(): HierachyActivityList
    {
        $this->budgets = ProjectBudget::findAll(['project_id' => $this->project_id]);
        return $this;
    }

    public function setOptions(): HierachyActivityList
    {

        foreach ($this->budgets as $budget) {

            $classBudget = [
                'id' => $budget->id . '-' . $budget->name,
                'label' => $budget->name,
            ];

            if ($budget->budgetCategories) {
                $classBudget['children'] = array_map(function ($activity) {

                    $classActivity = [
                        'id' => $activity->identifier . '-' . $activity->name,
                        'label' => $activity->identifier . '. ' . $activity->name
                    ];

                    if ($activity->subCategories) {
                        $classActivity['children'] = array_map(function ($subActivity) {
                            return [
                                'id' => $subActivity->id,
                                'label' => $subActivity->account_number . '. ' . $subActivity->name
                            ];
                        }, $activity->subCategories);
                    }

                    return $classActivity;
                }, $budget->budgetCategories);
            }

            $this->options[] = $classBudget;
        }

        return $this;
    }

    public function get(): array
    {
        return $this->options ?? [];
    }

}