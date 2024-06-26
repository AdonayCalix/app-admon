<?php

namespace app\modules\movement\models\base;

use app\modules\budget\Budget;
use app\modules\movement\models\MovementSubDetailQuery;
use app\modules\project\models\BudgetCategory;
use app\modules\project\models\SubCategory;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "movement_sub_detail".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $sub_category_id
 * @property string $amount
 * @property string $chart_account_id
 * @property string $class_id
 * @property integer $detail_id
 * @property integer $created_by
 * @property integer $deleted_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $chart_account_list_id
 * @property string $class_list_id
 *
 * @property BudgetCategory $category
 * @property SubCategory $subCategory
 * @property \app\modules\movement\models\MovementDetail $detail
 */
class MovementSubDetail extends ActiveRecord
{
    use RelationTrait;

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'category',
            'subCategory',
            'detail'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['amount', 'sub_category_id', 'chart_account_id', 'class_id'], 'required'],
            [['category_id', 'detail_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['chart_account_id', 'class_id'], 'string', 'max' => 500],
            [['chart_account_list_id', 'class_list_id'], 'string', 'max' => 100],
            ['sub_category_id', 'validateSubCategory']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'movement_sub_detail';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'sub_category_id' => 'Categoria',
            'amount' => 'Monto',
            'chart_account_id' => 'Cuenta',
            'class_id' => 'Clase',
            'detail_id' => 'Detail ID',
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
    public function getDetail(): ActiveQuery
    {
        return $this->hasOne(\app\modules\movement\models\MovementDetail::class, ['id' => 'detail_id']);
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

    public function validateSubCategory($attribute, $params, $validator, $current)
    {
        $query = 'A-';

        if (substr($this->sub_category_id, 0, strlen($query)) !== $query) {
            $this->addError('', 'Debes de seleccionar una actividad, no un presupuesto o categoria');
        }
    }


    /**
     * @inheritdoc
     * @return MovementSubDetailQuery the active query used by this AR class.
     */
    public static function find(): MovementSubDetailQuery
    {
        return new MovementSubDetailQuery(get_called_class());
    }
}
