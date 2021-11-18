<?php

namespace app\modules\budget\models\base;

use app\modules\budget\models\BudgetPeriodQuery;
use app\modules\project\models\BudgetCategory;
use app\modules\project\models\ProjectPeriod;
use app\modules\project\models\SubCategory;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the base model class for table "budget_period".
 *
 * @property integer $id
 * @property integer $period_id
 * @property integer $sub_category_id
 * @property integer $category_id
 * @property string $amount
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property BudgetCategory $category
 * @property SubCategory $subCategory
 * @property ProjectPeriod $period
 */
class BudgetPeriod extends ActiveRecord
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
            'category',
            'subCategory',
            'period'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['period_id', 'sub_category_id', 'amount'], 'required'],
            [['period_id', 'sub_category_id', 'category_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'budget_period';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'period_id' => 'Period ID',
            'sub_category_id' => 'Sub Category ID',
            'category_id' => 'Category ID',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(BudgetCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSubCategory(): ActiveQuery
    {
        return $this->hasOne(SubCategory::class, ['id' => 'sub_category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPeriod(): ActiveQuery
    {
        return $this->hasOne(ProjectPeriod::class, ['id' => 'period_id']);
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
     * @return BudgetPeriodQuery the active query used by this AR class.
     */
    public static function find(): BudgetPeriodQuery
    {
        return new BudgetPeriodQuery(get_called_class());
    }
}
