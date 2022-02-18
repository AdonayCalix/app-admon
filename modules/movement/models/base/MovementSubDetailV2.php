<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\MovementDetailV2 as MovementDetailV2Alias;
use app\modules\movement\models\MovementSubDetailV2Query;
use app\modules\project\models\BudgetCategory;
use app\modules\project\models\SubCategory;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "movement_sub_detail_v2".
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
 *
 * @property MovementDetailV2Alias $detail
 * @property BudgetCategory $category
 * @property SubCategory $subCategory
 */
class MovementSubDetailV2 extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'detail',
            'category',
            'subCategory'
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
            ['sub_category_id', 'validateSubCategory']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'movement_sub_detail_v2';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'sub_category_id' => 'Sub Category ID',
            'amount' => 'Amount',
            'chart_account_id' => 'Chart Account ID',
            'class_id' => 'Class ID',
            'detail_id' => 'Detail ID',
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getDetail(): ActiveQuery
    {
        return $this->hasOne(MovementDetailV2Alias::class, ['id' => 'detail_id']);
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
            ]
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
     * @return MovementSubDetailV2Query the active query used by this AR class.
     */
    public static function find(): MovementSubDetailV2Query
    {
        return new MovementSubDetailV2Query(get_called_class());
    }
}
