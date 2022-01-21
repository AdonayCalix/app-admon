<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[CheckFormat]].
 *
 * @see CheckFormat
 */
class CheckFormatQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return CheckFormat[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CheckFormat|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
