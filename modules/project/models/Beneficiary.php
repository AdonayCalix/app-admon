<?php

namespace app\modules\project\models;

use Yii;
use \app\modules\project\models\base\Beneficiary as BaseBeneficiary;

/**
 * This is the model class for table "beneficiary".
 */
class Beneficiary extends BaseBeneficiary
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'required'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name'], 'string', 'max' => 200]
        ]);
    }
	
}
