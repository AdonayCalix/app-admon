<?php

namespace app\modules\expense\models\base;

use app\modules\expense\models\FoodExpenseRequestQuery;
use app\modules\project\components\FormatDate;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "food_expense_request".
 *
 * @property integer $id
 * @property string $date
 * @property integer $place_id
 * @property string $lunch
 * @property string $dinner
 * @property integer $expense_request_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $breakfast
 *
 * @property \app\modules\expense\models\ExpenseRequest $expenseRequest
 */
class FoodExpenseRequest extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'expenseRequest'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['place_id', 'expense_request_id', 'date'], 'required'],
            [['lunch', 'dinner', 'breakfast'], 'number'],
            [['expense_request_id', 'created_by', 'updated_by', 'place_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'food_expense_request';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'food_expense_request' => 'Aliemtacion',
            'id' => 'ID',
            'date' => 'Fecha',
            'place_id' => 'Destino',
            'lunch' => 'Almuerzo',
            'dinner' => 'Cena',
            'expense_request_id' => 'Anticipo Gasto',
            'breakfast' => 'Desayuno',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getExpenseRequest(): ActiveQuery
    {
        return $this->hasOne(\app\modules\expense\models\ExpenseRequest::class, ['id' => 'expense_request_id']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('GETDATE()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }


    /**
     * @inheritdoc
     * @return FoodExpenseRequestQuery the active query used by this AR class.
     */
    public static function find(): FoodExpenseRequestQuery
    {
        return new FoodExpenseRequestQuery(get_called_class());
    }

    public function beforeSave($insert): bool
    {
        $this->date = (new FormatDate($this->date, 'd/m/Y', 'Y-m-d'))
            ->change()
            ->asString();

        return parent::beforeSave($insert);
    }
}
