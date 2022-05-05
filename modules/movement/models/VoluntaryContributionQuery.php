<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[VoluntaryContribution]].
 *
 * @see VoluntaryContribution
 */
class VoluntaryContributionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return VoluntaryContribution[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VoluntaryContribution|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
