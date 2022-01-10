<?php

namespace app\modules\project\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "book_bank".
 *
 * @property string $date
 * @property string $number
 * @property string $beneficiary
 * @property string $concept
 * @property string $kind
 * @property string $income
 * @property string $egress
 * @property integer $project_id
 */
class BookBank extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['date', 'beneficiary', 'concept', 'kind', 'project_id'], 'required'],
            [['date'], 'safe'],
            [['project_id'], 'integer'],
            [['number', 'kind', 'income', 'egress'], 'string', 'max' => 20],
            [['beneficiary'], 'string', 'max' => 200],
            [['concept'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'book_bank';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'date' => 'Date',
            'number' => 'Number',
            'beneficiary' => 'Beneficiary',
            'concept' => 'Concept',
            'kind' => 'Kind',
            'income' => 'Income',
            'egress' => 'Egress',
            'project_id' => 'Project ID',
        ];
    }

    public static function find(): \app\modules\project\models\BookBankQuery
    {
        return new \app\modules\project\models\BookBankQuery(get_called_class());
    }
}
