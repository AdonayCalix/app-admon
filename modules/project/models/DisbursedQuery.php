<?php

namespace app\modules\project\models;

/**
 * This is the ActiveQuery class for [[Disbursed]].
 *
 * @see Disbursed
 */
class DisbursedQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Disbursed[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Disbursed|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function init()
    {
        $this->joinWith(
            [
                "project p" => function ($q) {
                    $q->joinWith("userProject up");
                }
            ]
        )->where(["up.user_id" => \Yii::$app->user->id]);

        parent::init();
    }
}
