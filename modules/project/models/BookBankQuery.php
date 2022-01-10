<?php

namespace app\modules\project\models;

/**
 * This is the ActiveQuery class for [[BookBank]].
 *
 * @see BookBank
 */
class BookBankQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return BookBank[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BookBank|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
