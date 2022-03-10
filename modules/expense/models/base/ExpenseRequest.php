<?php

namespace app\modules\expense\models\base;

use app\modules\expense\models\ExpenseRequestQuery;
use app\modules\project\components\CompareDates;
use app\modules\project\components\FormatDate;
use app\modules\project\models\Beneficiary;
use app\modules\project\models\Project;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "expense_request".
 *
 * @property integer $id
 * @property string $elaborated_at
 * @property integer $beneficiary_id
 * @property string $position
 * @property string $place
 * @property string $goal
 * @property string $number_transfer
 * @property string $start_date
 * @property string $end_date
 * @property integer $project_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Project $project
 * @property \app\modules\expense\models\ExpenseRequestDetail[] $expenseRequestDetails
 * @property Beneficiary $beneficiary
 * @property \app\modules\expense\models\FoodExpenseRequest[] $foodExpenseRequests
 */
class ExpenseRequest extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'project',
            'beneficiary',
            'expenseRequestDetails',
            'foodExpenseRequests',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['elaborated_at', 'start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['beneficiary_id', 'project_id', 'created_by', 'updated_by'], 'integer'],
            [['project_id'], 'required'],
            [['position'], 'string', 'max' => 225],
            [['place', 'goal'], 'string', 'max' => 500],
            [['number_transfer'], 'string', 'max' => 20],
            ['start_date', 'validateDatesInAndOut']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'expense_request';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'elaborated_at' => 'Fecha Elaboracion',
            'beneficiary_id' => 'Beneficiario',
            'position' => 'Posicion',
            'place' => 'Lugares Destino',
            'goal' => 'Objetivo',
            'number_transfer' => 'TB/Cheque',
            'start_date' => 'Fecha de Salida',
            'end_date' => 'Fecha de Entrada',
            'project_id' => 'Proyecto',
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getProject(): ActiveQuery
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getExpenseRequestDetails(): ActiveQuery
    {
        return $this->hasMany(\app\modules\expense\models\ExpenseRequestDetail::class, ['expense_request_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFoodExpenseRequests(): ActiveQuery
    {
        return $this->hasMany(\app\modules\expense\models\FoodExpenseRequest::class, ['expense_request_id' => 'id']);
    }

    public function getBeneficiary(): ActiveQuery
    {
        return $this->hasOne(Beneficiary::class, ['id' => 'beneficiary_id']);
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
     * @return ExpenseRequestQuery the active query used by this AR class.
     */
    public static function find(): ExpenseRequestQuery
    {
        return new ExpenseRequestQuery(get_called_class());
    }

    public function afterFind()
    {
        $this->elaborated_at = (new FormatDate($this->elaborated_at, 'Y-m-d', 'd/m/Y'))->change()->asString();
        $this->start_date = (new FormatDate($this->start_date, 'Y-m-d', 'd/m/Y H:i'))->change()->asString();
        $this->end_date = (new FormatDate($this->end_date, 'Y-m-d', 'd/m/Y H:i'))->change()->asString();
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->elaborated_at = (new FormatDate($this->elaborated_at, 'd/m/Y', 'Y-m-d'))
            ->change()
            ->asString();

        $this->start_date = (new FormatDate($this->start_date, 'd/m/Y H:i', 'Y-m-d H:i'))
            ->change()
            ->asString();

        $this->end_date = (new FormatDate($this->end_date, 'd/m/Y H:i', 'Y-m-d H:i'))
            ->change()
            ->asString();

        return parent::beforeSave($insert);
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function validateDatesInAndOut($attribute, $params, $validator, $current)
    {
        $compareDates = (new CompareDates($this->start_date, $this->end_date, 'd/m/Y'))
            ->changeFormat()
            ->parseToDate();

        if ($compareDates->isStartGreaterThanEnd())
            $this->addError('start_date', 'La fecha de salida no puede ser despues que de la entrada');
    }
}
