<?php

namespace app\modules\project\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[BudgetCategory]].
 *
 * @see BudgetCategory
 */
class BudgetCategoryQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return BudgetCategory[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BudgetCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
