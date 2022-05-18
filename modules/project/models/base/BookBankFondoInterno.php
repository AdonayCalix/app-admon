<?php

namespace app\modules\project\models\base;

use app\modules\project\models\BookBankFondoInternoQuery;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "book_bank_fondo_interno".
 *
 * @property string $date
 * @property double $excel_date
 * @property string $number
 * @property string $beneficiary
 * @property string $concept
 * @property string $kind
 * @property string $income
 * @property string $egress
 */
class BookBankFondoInterno extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['date', 'concept', 'kind'], 'required'],
            [['date'], 'safe'],
            [['excel_date', 'income', 'egress'], 'number'],
            [['number', 'kind'], 'string', 'max' => 20],
            [['beneficiary'], 'string', 'max' => 200],
            [['concept'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'book_bank_fondo_interno';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'date' => 'Date',
            'excel_date' => 'Excel Date',
            'number' => 'Number',
            'beneficiary' => 'Beneficiary',
            'concept' => 'Concept',
            'kind' => 'Kind',
            'income' => 'Income',
            'egress' => 'Egress',
        ];
    }

    /**
     * @inheritdoc
     * @return BookBankFondoInternoQuery the active query used by this AR class.
     */
    public static function find(): BookBankFondoInternoQuery
    {
        return new BookBankFondoInternoQuery(get_called_class());
    }
}
