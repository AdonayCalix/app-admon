<?php

namespace app\modules\expense\models;

/**
 * This is the ActiveQuery class for [[FoodExpenseRequest]].
 *
 * @see FoodExpenseRequest
 */
class FoodExpenseRequestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return FoodExpenseRequest[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FoodExpenseRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
