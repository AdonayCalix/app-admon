<?php

namespace app\modules\project\models;

use Yii;
use \app\modules\project\models\base\BookBank as BaseBookBank;

/**
 * This is the model class for table "book_bank".
 */
class BookBank extends BaseBookBank
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['date', 'beneficiary', 'concept', 'kind', 'project_id'], 'required'],
            [['date'], 'safe'],
            [['project_id'], 'integer'],
            [['number', 'kind', 'income', 'egress'], 'string', 'max' => 20],
            [['beneficiary'], 'string', 'max' => 200],
            [['concept'], 'string', 'max' => 500]
        ]);
    }
	
}
