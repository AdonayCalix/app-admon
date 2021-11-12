<?php

namespace app\modules\qb\models\base;

use app\modules\qb\models\ListClassQuery;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "list_class".
 *
 * @property integer $id
 * @property string $name
 * @property string $identifier
 * @property string $is_parent
 * @property string $sub_class
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class ListClass extends ActiveRecord
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
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name', 'identifier'], 'string', 'max' => 255],
            ['is_parent', 'validateSubClass'],
            [['sub_class'], 'string', 'max' => 225]
        ];
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function validateSubClass($attribute, $params, $validator, $current)
    {

        if (isset($this->is_parent) && $this->sub_class === null)
            $this->addError('sub_class', 'Debes de indicar la sub clase a la que pertenece');
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'list_class';
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
            'is_parent' => 'Clase principal',
            'sub_class' => 'Sub Clase',
        ];
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
     * @return ListClassQuery the active query used by this AR class.
     */
    public static function find(): ListClassQuery
    {
        return new ListClassQuery(get_called_class());
    }
}
