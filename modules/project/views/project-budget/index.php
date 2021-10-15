<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\ProjectBudgetSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\modules\project\models\Project;
use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Project Budget';
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
