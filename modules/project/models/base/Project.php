<?php

namespace app\modules\project\models\base;


use app\modules\project\components\ArraySum;
use app\modules\project\components\CompareDates;
use app\modules\project\components\FormatDate;
use app\modules\project\models\ProjectQuery;
use mootensai\relation\RelationTrait;
use phpDocumentor\Reflection\Types\This;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the base model class for table "project".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $frecuency
 * @property string $start_date
 * @property string $end_date
 * @property string $budget
 * @property string $bank
 * @property string $account_number
 * @property string $initial_balance
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property \app\modules\project\models\ProjectBudget[] $projectBudgets
 * @property \app\modules\project\models\ProjectPeriod[] $projectPeriods
 * @property-read ActiveQuery $userProject
 * @property \app\modules\project\models\UserProject[] $userProjects
 */
class Project extends ActiveRecord
{
    use RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct()
    {
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'projectBudgets',
            'projectPeriods',
            'userProject'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'alias', 'start_date', 'end_date', 'budget', 'bank', 'account_number', 'initial_balance'], 'required'],
            [['start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['budget'], 'number'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name'], 'string', 'max' => 500],
            [['alias'], 'string', 'max' => 100],
            [['frecuency'], 'string', 'max' => 20],
            ['start_date', 'validateDates'],
            ['start_date', 'validateStartDateWithFirstPeriod'],
            ['start_date', 'validateEndDateWithFirstPeriod'],
            ['budget', 'validateBudget']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'alias' => 'Alias',
            'frecuency' => 'Frecuencia',
            'start_date' => 'Fecha de Inicio',
            'end_date' => 'Fecha Final',
            'budget' => 'Presupuesto',
            'bank' => 'Banco',
            'account_number' => 'Numero de Cuenta',
            'initial_balance' => 'Balance Inicial'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProjectBudgets(): ActiveQuery
    {
        return $this->hasMany(\app\modules\project\models\ProjectBudget::class, ['project_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProjectPeriods(): ActiveQuery
    {
        return $this->hasMany(\app\modules\project\models\ProjectPeriod::class, ['project_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserProject(): ActiveQuery
    {
        return $this->hasMany(\app\modules\project\models\UserProject::class, ['project_id' => 'id']);
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
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find(): ProjectQuery
    {
        return (new ProjectQuery(get_called_class()));
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function validateDates($attribute, $params, $validator, $current)
    {
        $compareDates = (new CompareDates($this->start_date, $this->end_date, 'd/m/Y'))
            ->changeFormat()
            ->parseToDate();

        if ($compareDates->isStartGreaterThanEnd())
            $this->addError('start_date', 'La fecha de inicio, no puede ser despues de la fecha de finalización del proyecto');
    }

    public function beforeSave($insert): bool
    {
        $this->start_date = (new FormatDate($this->start_date, 'd/m/Y', 'Y-m-d'))
            ->change()
            ->asString();

        $this->end_date = (new FormatDate($this->end_date, 'd/m/Y', 'Y-m-d'))
            ->change()
            ->asString();

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->start_date = (new FormatDate($this->start_date, 'Y-m-d', 'd/m/Y'))->change()->asString();
        $this->end_date = (new FormatDate($this->end_date, 'Y-m-d', 'd/m/Y'))->change()->asString();
        parent::afterFind();
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function validateStartDateWithFirstPeriod($attribute, $params, $validator, $current)
    {
        if (!isset($this->projectPeriods[0])) {
            $this->addError('', 'Debe de ingresar al menos un periodo de ejecucion');
            return false;
        }

        $compareDates = (new CompareDates($this->start_date, $this->projectPeriods[0]->start_date, 'd/m/Y'))
            ->changeFormat()
            ->parseToDate();

        if (!$compareDates->areDateEquals())
            $this->addError('start_date', 'La fecha de inicio debe ser la misma que la fecha de inicio de los periodos agregados');
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function validateEndDateWithFirstPeriod($attribute, $params, $validator, $current)
    {
        $total_periods = count($this->projectPeriods);

        if ($total_periods <= 0) {
            $this->addError('', 'Debe de ingresar al menos un periodo de ejecucion');
            return false;
        }

        $compareDates = (new CompareDates($this->end_date, $this->projectPeriods[$total_periods - 1]->end_date, 'd/m/Y'))
            ->changeFormat()
            ->parseToDate();

        if (!$compareDates->areDateEquals())
            $this->addError('end_date', 'La fecha de finalizacion debe ser la misma que la fecha de finalizacion de los periodos agregados');
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function validateBudget($attribute, $params, $validator, $current)
    {
        $budgets = array_column($this->projectBudgets, 'amount');

        if ((float)ArraySum::make($budgets) != (float)$this->budget)
            $this->addError('budget', 'La suma de los presupuestos debe ser igual al presupuesto del proyecto');
    }
}
