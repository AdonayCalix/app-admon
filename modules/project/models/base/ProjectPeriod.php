<?php

namespace app\modules\project\models\base;

use app\modules\project\components\CompareDates;
use app\modules\project\components\FormatDate;
use app\modules\project\models\ProjectPeriodQuery;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "project_period".
 *
 * @property integer $id
 * @property string $name
 * @property string $start_date
 * @property string $end_date
 * @property integer $project_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property \app\modules\project\models\Project $project
 */
class ProjectPeriod extends ActiveRecord
{
    use RelationTrait;

    public static $counter = 1;

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
            'project'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name', 'start_date', 'end_date', 'project_id'], 'required'],
            [['start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name'], 'string', 'max' => 225],
            ['start_date', 'validateDates']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'project_period';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'start_date' => 'Inicio',
            'end_date' => 'Salida',
            'project_id' => 'Proyecto ID'
        ];
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
     * @return ProjectPeriodQuery the active query used by this AR class.
     */
    public static function find(): ProjectPeriodQuery
    {
        return new ProjectPeriodQuery(get_called_class());
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function validateDates($attribute, $params, $validator, $current)
    {
        $compareDates = (new CompareDates($this->start_date, $this->end_date, 'd/m/Y'))
            ->changeFormat()
            ->parseToDate();

        if ($compareDates->isStartGreaterThanEnd())
            $this->addError('start_date', "La fecha de inicio, no puede ser despues de la fehca de finalización del periodo $this->name");
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
}