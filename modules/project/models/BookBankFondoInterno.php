<?php

namespace app\modules\project\models;

use Yii;
use \app\modules\project\models\base\BookBankFondoInterno as BaseBookBankFondoInterno;

/**
 * This is the model class for table "book_bank_fondo_interno".
 */
class BookBankFondoInterno extends BaseBookBankFondoInterno
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['date', 'concept', 'kind'], 'required'],
            [['date'], 'safe'],
            [['excel_date', 'income', 'egress'], 'number'],
            [['number', 'kind'], 'string', 'max' => 20],
            [['beneficiary'], 'string', 'max' => 200],
            [['concept'], 'string', 'max' => 500]
        ]);
    }
	
}
