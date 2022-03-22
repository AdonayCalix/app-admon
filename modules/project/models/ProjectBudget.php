<?php

namespace app\modules\project\models;

use app\modules\budget\models\BudgetPeriod;
use app\modules\project\components\GetEgressBySubCategory;
use app\modules\project\components\GetIncomesBySubCategory;
use \app\modules\project\models\base\ProjectBudget as BaseProjectBudget;
use app\modules\qb\models\ChartAccount;
use function Symfony\Component\String\u;

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

    public static function getCategoriesOnly(int $id): array
    {
        $project_budget = self::findOne($id);
        $out = [];

        foreach ($project_budget->budgetCategories as $category) {
            $value = [
                'id' => $category->id,
                'identifier' => $category->identifier,
                'name' => $category->name,
            ];

            if ($category->subCategories) {

                $value['activities'] = array_map(function ($subCategory) {

                    return [
                        'id' => $subCategory->id,
                        'account_number' => $subCategory->account_number,
                        'name' => $subCategory->name,
                        'class_id' => array_column(ClassActivity::find()
                            ->select(['class_id'])
                            ->where(['activity_id' => $subCategory->id])
                            ->asArray()
                            ->all(), 'class_id'),
                        'chart_account_id' => array_column(ChartAccountActivity::find()
                            ->select(['chart_account_id'])
                            ->where(['activity_id' => $subCategory->id])->asArray()->all(), 'chart_account_id')
                    ];
                }, $category->subCategories);
            }

            $out[] = $value;
        }

        return $out;
    }


    public static function getCategories(int $id, int $period_id): array
    {

        $project_budget = self::findOne($id);
        $out = [];

        foreach ($project_budget->budgetCategories as $category) {
            $value = [
                'id' => $category->id,
                'identifier' => $category->identifier,
                'name' => $category->name,
            ];

            if ($category->subCategories) {
                $value['activities'] = array_map(function ($subCategory) use ($period_id) {
                    $amount = BudgetPeriod::getAmount($subCategory->id, $period_id);
                    $used = GetEgressBySubCategory::make($period_id, $subCategory->id) - (GetIncomesBySubCategory::make($period_id, $subCategory->id));
                    $percentage = 0;

                    if ($used > 0 && $amount > 0) {
                        $percentage = round(($used / $amount), 2) * 100;
                    }

                    return [
                        'id' => BudgetPeriod::getId($subCategory->id, $period_id),
                        'account_number' => $subCategory->account_number,
                        'activity_id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'amount' => $amount,
                        'used' => $used,
                        'aviable' => ($amount - $used),
                        'percentage' => $percentage . '%'
                    ];
                }, $category->subCategories);
            }

            $out[] = $value;
        }

        //echo '<pre>' . print_r($out, true). '</pre>';die;
        return $out;
    }
}
