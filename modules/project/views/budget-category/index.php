<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\BudgetCategorySearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\modules\project\models\ProjectBudget;
use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

$this->title = 'Categorias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="budget-category-index">
    <div class="card">
        <div class="card-body">
            <p>
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Categoria', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    [
                        'class' => \kartik\grid\ExpandRowColumn::class,
                        'label' => 'Fila Expandible',
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail' => function ($model, $key, $index) {
                            return Yii::$app->controller->renderPartial('_subCategorieDetail', ['model' => $model]);
                        },
                        'expandOneOnly' => false,
                        'width' => '5%'
                    ],
                    [
                        'attribute' => 'identifier',
                        'width' => '10px'
                    ],
                    'name',
                    [
                        'attribute' => 'budget_id',
                        'label' => 'Presupuesto/POA',
                        'value' => function ($model) {
                            return $model->budget->name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(ProjectBudget::find()->asArray()->all(), 'id', 'name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-budget-category-search-budget_id']
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
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-budget-category']]
                ]); ?>
            </div>
        </div>
    </div>
</div>
