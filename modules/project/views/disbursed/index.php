<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\DisbursedSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Desembolsos';
?>
<div class="disbursed-index">

    <div class="card">
        <div class="card-body">
            <p>
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Desembolso', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    [
                        'attribute' => 'period_id',
                        'value' => function ($model) {
                            return $model->period->name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\ProjectPeriod::find()->asArray()->all(), 'id', 'name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-disbursed-search-period_id']
                    ],
                    [
                        'attribute' => 'project_id',
                        'value' => function ($model) {
                            return $model->project->name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Project::find()->asArray()->all(), 'id', 'name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-disbursed-search-project_id']
                    ],
                    [
                        'attribute' => 'amount',
                        'value' => function ($model) {

                            return number_format($model->amount, 2);
                        }
                    ],
                    'date',
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
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-disbursed']]
                ]); ?>
            </div>
        </div>
    </div>
</div>
