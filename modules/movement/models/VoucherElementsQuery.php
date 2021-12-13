<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[VoucherElements]].
 *
 * @see VoucherElements
 */
class VoucherElementsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return VoucherElements[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VoucherElements|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
