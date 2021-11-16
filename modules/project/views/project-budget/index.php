<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\ProjectBudgetSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\modules\project\models\Project;
use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Presupuestos/POAS';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="project-budget-index">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">

        <div class="card-header">
            <h6 class="card-subtitle text-muted">
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Presupuesto/POA', ['create'], ['class' => 'btn btn-success']) ?>
            </h6>
        </div>

        <div class="card-body">
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'label' => 'Fila Expandible',
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail' => function ($model, $key, $index) {
                            return Yii::$app->controller->renderPartial('_categoriesDetail', ['model' => $model]);
                        },
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                        'expandOneOnly' => true,
                    ],
                    [
                        'attribute' => 'name',
                        'width' => '20%'
                    ],
                    [
                        'attribute' => 'name',
                        'width' => '20%'
                    ],
                    [
                        'attribute' => 'project_id',
                        'label' => 'Proyecto',
                        'value' => function ($model) {
                            return $model->project->alias;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(Project::find()->asArray()->all(), 'id', 'alias'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-project-budget-search-project_id'],
                        'width' => '20%'
                    ],
                    [
                        'value' => function ($model) {
                            return Html::a('Asignamiento', ['assign-budget', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']);
                        },
                        'format' => 'raw',
                        'width' => '20%'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                    ],
                ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumn,
                    'bsVersion' => '4.x',
                    'pjax' => true,
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-project-budget']]
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$("colgroup").remove()
JS;
$this->registerJs($script);
?>


