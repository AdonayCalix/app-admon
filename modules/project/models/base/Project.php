<?php

namespace app\modules\project\models\base;


use app\modules\project\models\ProjectQuery;
use mootensai\relation\RelationTrait;
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
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property \app\modules\project\models\ProjectBudget[] $projectBudgets
 * @property \app\modules\project\models\ProjectPeriod[] $projectPeriods
 */
class Project extends ActiveRecord
{
    use RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
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
            'projectPeriods'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'alias', 'start_date', 'end_date', 'budget'], 'required'],
            [['start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['budget'], 'number'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name'], 'string', 'max' => 500],
            [['alias'], 'string', 'max' => 100],
            [['frecuency'], 'string', 'max' => 20]
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
}
