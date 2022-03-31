<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movement\models\VoucherElementsSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Formato de Elementos Voucher';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voucher-elements-index">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <p>
                    <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Elemenentos Voucher', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                </p>
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    [
                        'attribute' => 'project_id',
                        'label' => 'Project',
                        'value' => function ($model) {
                            return $model->project->name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Project::find()->asArray()->all(), 'id', 'alias'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-voucher-elements-search-project_id']
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
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-voucher-elements']]
                ]); ?>
            </div>
        </div>
    </div>
</div>
