<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\ProjectPeriodSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\modules\project\models\Project;
use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

$this->title = 'Periodos de Ejecucion';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="project-period-index">

    <div class="card">
        <div class="card-body">

            <p>
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Periodo De Ejecucion', ['create'], ['class' => 'btn btn-success btn-sm']) ?>            </p>
            <?php
            $gridColumn = [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'id', 'visible' => false],
                [
                    'attribute' => 'name',
                    'width' => '30%'
                ],
                [
                    'attribute' => 'start_date',
                    'label' => 'Inicio',
                    'filterType' => GridView::FILTER_DATE,
                    'filterWidgetOptions' => [
                        'id' => 'fecha',
                        'removeButton' => false,
                        'language' => 'es',
                        'options' => [
                            'autocomplete' => 'new-text'
                        ],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                            'todayBtn' => false,
                            'orientation' => 'bottom left'
                        ],
                    ],
                    'width' => '15%',
                ],
                [
                    'attribute' => 'end_date',
                    'label' => 'Final',
                    'filterType' => GridView::FILTER_DATE,
                    'filterWidgetOptions' => [
                        'id' => 'fecha',
                        'removeButton' => false,
                        'language' => 'es',
                        'options' => [
                            'autocomplete' => 'new-text'
                        ],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                            'todayBtn' => false,
                            'orientation' => 'bottom left'
                        ],
                    ],
                    'width' => '15%',
                ],
                [
                    'attribute' => 'project_id',
                    'label' => 'Proyecto',
                    'value' => function ($model) {
                        return $model->project->alias;
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ArrayHelper::map(Project::find()->asArray()->all(), 'id', 'name'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-project-period-search-project_id'],
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
                'pjax' => true,
                'condensed' => true,
                'headerContainer' => ['class' => ''],
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-project-period']]
            ]); ?>

        </div>
