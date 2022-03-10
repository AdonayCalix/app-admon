<?php

namespace app\modules\expense\models;

/**
 * This is the ActiveQuery class for [[ExpenseRequestDetail]].
 *
 * @see ExpenseRequestDetail
 */
class ExpenseRequestDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ExpenseRequestDetail[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ExpenseRequestDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
