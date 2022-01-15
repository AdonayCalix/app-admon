<?php

namespace app\modules\project\models\base;

use app\modules\project\components\FormatDate;
use app\modules\project\models\MovementsByCategoryQuery;
use app\modules\project\models\ProjectPeriod;
use setasign\Fpdi\PdfParser\Filter\Lzw;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "movements_by_category".
 *
 * @property integer $order_number
 * @property string $date
 * @property string $number
 * @property string $name
 * @property string $concept
 * @property integer $project_id
 * @property double $excel_date
 */
class MovementsByCategory extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['order_number', 'project_id'], 'integer'],
            [['date', 'number', 'name', 'concept', 'project_id'], 'required'],
            [['date'], 'safe'],
            [['excel_date'], 'number'],
            [['number'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 200],
            [['concept'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'movements_by_category';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'order_number' => 'Order Number',
            'date' => 'Date',
            'number' => 'Number',
            'name' => 'Name',
            'concept' => 'Concept',
            'project_id' => 'Project ID',
            'excel_date' => 'Excel Date',
        ];
    }

    /**
     * @inheritdoc
     * @return MovementsByCategoryQuery the active query used by this AR class.
     */
    public static function find(): MovementsByCategoryQuery
    {
        return new MovementsByCategoryQuery(get_called_class());
    }

    public static function get(int $category_id, int $project_id, int $period_id): MovementsByCategoryQuery
    {

        $period = ProjectPeriod::findOne($period_id);

        $start_date = (new FormatDate($period->start_date, 'd/m/Y', 'Y-m-d'))->change()->asString();;
        $end_date = (new FormatDate($period->end_date, 'd/m/Y', 'Y-m-d'))->change()->asString();;

        return self::find()
            ->where(['category_id' => $category_id])
            ->andwhere(['project_id' => $project_id])
            ->andWhere(['between', 'date', $start_date, $end_date]);
    }
}
