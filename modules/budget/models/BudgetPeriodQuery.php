<?php

namespace app\modules\budget\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[BudgetPeriod]].
 *
 * @see BudgetPeriod
 */
class BudgetPeriodQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return BudgetPeriod[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BudgetPeriod|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
