<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\QbMovementLogSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\grid\GridViewInterface;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Bitacora QB';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="qb-movement-log-index">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'project_id',
                        'label' => 'Proyecto',
                        'value' => function ($model) {
                            return $model->project->alias;
                        },
                        'filterType' => GridViewInterface::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Project::find()->asArray()->all(), 'id', 'alias'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-qb-movement-log-search-project_id'],
                        'width' => '20%'
                    ],
                    [
                        'attribute' => 'number',
                        'label' => 'TB/Cheque',
                        'value' => function ($model) {
                            return \yii\bootstrap4\Html::a($model->number, ['movement/update', 'id' => $model->movement_id], ['target' => '_blank']);
                        },
                        'format' => 'raw',
                        'width' => '15%'
                    ],
                    [
                        'attribute' => 'date',
                        'label' => 'Fecha',
                        'filterType' => GridViewInterface::FILTER_DATE,
                        'value' => function ($model) {
                            return date('d/m/Y', strtotime($model->date));
                        },
                        'filterWidgetOptions' => [
                            'id' => 'fecha',
                            'removeButton' => false,
                            'language' => 'es',
                            'options' => [
                                'autocomplete' => 'new-text'
                            ],
                            'pluginOptions' => [
                                'format' => 'dd/mm/yyyy',
                                'autoclose' => true,
                                'todayBtn' => false,
                                'orientation' => 'bottom left'
                            ],
                        ],
                        'width' => '15%',
                    ],
                    [
                        'attribute' => 'kind',
                        'label' => 'Tipo',
                        'width' => '15%'
                    ],
                    [
                        'attribute' => 'amount',
                        'label' => 'Monto',
                        'value' => function ($model) {
                            return 'Lps ' . number_format($model->amount, 2);
                        },
                        'width' => '15%'
                    ],
                    [
                        'attribute' => 'Code',
                        'label' => 'Estado',
                        'filterType' => GridViewInterface::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map([['id' => 0, 'value' => 'Exitoso'], ['id' => 1, 'value' => 'Error']], 'id', 'value'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-qb-movement-log-search-Code'],
                        'value' => function ($model) {
                            return \yii\bootstrap4\Html::a(
                                    $model->Code == 0 ? "Exitoso" : "Error: " . $model->Code,
                                    null,
                                    ['class' => $model->Code == 0 ? 'badge badge-success': 'badge badge-danger']
                            );
                        },
                        'width' => '15%',
                        'format' => 'raw'
                    ],
                ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumn,
                    'pjax' => true,
                    'condensed' => true,
                    'striped' => true,
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-qb-movement-log']],
                    'headerContainer' => ['class' => '']
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>
