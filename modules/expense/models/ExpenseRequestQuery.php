<?php

namespace app\modules\expense\models;

/**
 * This is the ActiveQuery class for [[ExpenseRequest]].
 *
 * @see ExpenseRequest
 */
class ExpenseRequestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ExpenseRequest[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ExpenseRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
