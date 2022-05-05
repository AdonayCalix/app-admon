<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\VoluntaryContribution as BaseVoluntaryContribution;

/**
 * This is the model class for table "voluntary_contribution".
 */
class VoluntaryContribution extends BaseVoluntaryContribution
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'date'], 'required'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 225]
        ]);
    }
	
}
