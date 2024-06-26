<?php

namespace app\modules\project\models\base;

use app\modules\project\components\ArraySum;
use app\modules\project\models\ProjectBudgetQuery;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "project_budget".
 *
 * @property integer $id
 * @property string $name
 * @property string $amount
 * @property integer $project_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property \app\modules\project\models\BudgetCategory[] $budgetCategories
 * @property \app\modules\project\models\Project $project
 */
class ProjectBudget extends ActiveRecord
{
    use RelationTrait;

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'budgetCategories',
            'project'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'amount', 'project_id'], 'required'],
            [['amount'], 'number'],
            [['project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name'], 'string', 'max' => 225],
            ['amount', 'validateBudget']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'project_budget';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'amount' => 'Monto',
            'project_id' => 'Project ID',
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getBudgetCategories(): ActiveQuery
    {
        return $this->hasMany(\app\modules\project\models\BudgetCategory::class, ['budget_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getProject(): ActiveQuery
    {
        return $this->hasOne(\app\modules\project\models\Project::class, ['id' => 'project_id']);
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
                'value' => new Expression('GETDATE()'),
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
     * @return ProjectBudgetQuery the active query used by this AR class.
     */
    public static function find(): ProjectBudgetQuery
    {
        return new ProjectBudgetQuery(get_called_class());
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function validateBudget($attribute, $params, $validator, $current)
    {
        $othersBudgetsOfProject = self::find()
            ->where(['project_budget.project_id' => $this->project_id])
            ->where(['<>', 'project_budget.id', $this->id])
            ->sum('amount');

        /*if (ArraySum::make([$this->amount, $othersBudgetsOfProject]) != $this->project->budget)
            $this->addError('amount', "La suma de los presupuestos debe ser igual al presupuesto del proyecto: {$this->project->budget}");*/
    }
}
