<?php

namespace app\modules\project\models;

use \app\modules\project\models\base\ProjectBudget as BaseProjectBudget;

/**
 * This is the model class for table "project_budget".
 */
class ProjectBudget extends BaseProjectBudget
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['name', 'amount', 'project_id'], 'required'],
                [['amount'], 'number'],
                [['project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['name'], 'string', 'max' => 225],
                ['amount', 'validateBudget']
            ]);
    }

    public static function getCategories(int $id): array
    {

        $project_budget = self::findOne($id);
        $out = [];

        foreach ($project_budget->budgetCategories as $category) {
            $value = [
                'id' => $category->id,
                'name' => $category->name,
            ];

            if ($category->subCategories) {
                $value['activities'] = array_map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'amount' => 0.00,
                        'used' => 0,
                        'aviable' => 0,
                        'percentage' => 0
                    ];
                }, $category->subCategories);
            }

            $out[] = $value;
        }

        return $out;
    }

}
