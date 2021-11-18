<?php

namespace app\modules\budget\models;

use \app\modules\budget\models\base\BudgetPeriod as BaseBudgetPeriod;

/**
 * This is the model class for table "budget_period".
 */
class BudgetPeriod extends BaseBudgetPeriod
{
    public static function getId(int $sub_category_id, int $period_id): ?int
    {
        $row = self::findOne(['sub_category_id' => $sub_category_id, 'period_id' => $period_id]);
        return $row->id ?? null;
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['period_id', 'sub_category_id', 'amount'], 'required'],
            [['period_id', 'sub_category_id', 'category_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe']
        ]);
    }

    public static function getAmount(int $sub_category_id, int $period_id): float
    {
        $row = self::findOne(['sub_category_id' => $sub_category_id, 'period_id' => $period_id]);
        return $row->amount ?? 0;
    }

    public static function store(array $posts)
    {
        foreach ($posts as $post) {

            $budget_period = self::findOne($post['id']) ?? new self();

            if ($budget_period->load($post, '') && $budget_period->validate())
                $budget_period->save(false);
        }
    }
}
