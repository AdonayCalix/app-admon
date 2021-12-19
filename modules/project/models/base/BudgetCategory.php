<?php

namespace app\modules\project\models\base;

use app\modules\project\models\BudgetCategoryQuery;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "budget_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property integer $budget_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property \app\modules\project\models\ProjectBudget $budget
 * @property \app\modules\project\models\SubCategory[] $subCategories
 */
class BudgetCategory extends ActiveRecord
{
    use RelationTrait;

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'budget',
            'subCategories'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'identifier', 'budget_id'], 'required'],
            [['budget_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name'], 'string', 'max' => 225],
            [['identifier'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'budget_category';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'identifier' => 'Identificador',
            'budget_id' => 'Presupuesto ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getBudget(): ActiveQuery
    {
        return $this->hasOne(\app\modules\project\models\ProjectBudget::class, ['id' => 'budget_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSubCategories(): ActiveQuery
    {
        return $this->hasMany(\app\modules\project\models\SubCategory::class, ['category_id' => 'id']);
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
     * @return BudgetCategoryQuery the active query used by this AR class.
     */
    public static function find(): BudgetCategoryQuery
    {
        return new BudgetCategoryQuery(get_called_class());
    }
}
