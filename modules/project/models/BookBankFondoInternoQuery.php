<?php

namespace app\modules\project\models;

/**
 * This is the ActiveQuery class for [[BookBankFondoInterno]].
 *
 * @see BookBankFondoInterno
 */
class BookBankFondoInternoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return BookBankFondoInterno[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BookBankFondoInterno|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
