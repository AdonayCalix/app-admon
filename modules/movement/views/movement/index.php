<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\TransferSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

$this->title = 'Movimientos';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transfer-index">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">

        <div class="card-header">
            <h6 class="card-subtitle text-muted">
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Transferencia', ['create'], ['class' => 'btn btn-success']) ?>
            </h6>
        </div>

        <div class="card-body">
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    ['attribute' => 'number', 'width' => '20%'],
                    ['attribute' => 'amount', 'width' => '20%'],
                    [
                        'attribute' => 'project_id',
                        'label' => 'Proyecto',
                        'value' => function ($model) {
                            return $model->project->alias;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\app\modules\project\models\Project::find()->asArray()->all(), 'id', 'alias'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-transfer-search-project_id']
                    ],
                    [
                        'value' => function($model) {
                            return GhostHtml::a('Generar Recibo', '#');
                        },
                        'format' => 'raw'
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
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-transfer']],
                    'bsVersion' => '4.x'
                ]); ?>
            </div>
        </div>
    </div>
</div>
