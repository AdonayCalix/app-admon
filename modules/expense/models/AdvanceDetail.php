<?php

namespace app\modules\expense\models;

use Yii;
use \app\modules\expense\models\base\AdvanceDetail as BaseAdvanceDetail;

/**
 * This is the model class for table "advance_detail".
 */
class AdvanceDetail extends BaseAdvanceDetail
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 100]
        ]);
    }
	
}
