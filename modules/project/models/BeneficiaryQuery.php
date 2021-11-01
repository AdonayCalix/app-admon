<?php

namespace app\modules\project\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Beneficiary]].
 *
 * @see Beneficiary
 */
class BeneficiaryQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Beneficiary[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Beneficiary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
