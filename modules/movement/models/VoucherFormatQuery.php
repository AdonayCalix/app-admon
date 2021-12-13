<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[VoucherFormat]].
 *
 * @see VoucherFormat
 */
class VoucherFormatQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return VoucherFormat[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VoucherFormat|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
