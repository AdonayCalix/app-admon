<?php

namespace app\modules\expense\models;

/**
 * This is the ActiveQuery class for [[Places]].
 *
 * @see Places
 */
class PlacesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Places[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Places|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
