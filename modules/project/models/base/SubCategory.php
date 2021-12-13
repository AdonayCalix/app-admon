<?php

namespace app\modules\project\models\base;

use app\modules\project\models\SubCategoryQuery;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "sub_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property string $account_number
 * @property string $module
 * @property string $intervention
 * @property string $expense_category
 * @property integer $category_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property \app\modules\project\models\BudgetCategory $category
 */
class SubCategory extends ActiveRecord
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
            'category'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'account_number', 'category_id'], 'required'],
            [['identifier'], 'unique'],
            [['category_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'module', 'intervention'], 'string', 'max' => 225],
            [['identifier'], 'string', 'max' => 100],
            [['expense_category'], 'string', 'max' => 250],
            [['account_number'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'sub_category';
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
            'account_number' => 'Numero de partida',
            'expense_category' => 'Categoria del Gasto',
            'module' => 'Modulo',
            'intervention' => 'Intervencion',
            'category_id' => 'Categoria ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(\app\modules\project\models\BudgetCategory::class, ['id' => 'category_id']);
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
     * @return SubCategoryQuery the active query used by this AR class.
     */
    public static function find(): SubCategoryQuery
    {
        return new SubCategoryQuery(get_called_class());
    }
}
