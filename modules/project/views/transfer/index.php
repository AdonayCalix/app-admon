<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\TransferSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\modules\project\models\Beneficiary;
use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Transfer';
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
                    ['attribute' => 'number', 'width' => '15%'],
                    ['attribute' => 'amount', 'width' => '20%'],
                    ['attribute' => 'bank_id', 'width' => '25%'],
                    ['attribute' => 'bank_account', 'width' => '25%'],
                   /* [
                        'attribute' => 'project_id',
                        'label' => 'Project',
                        'value' => function ($model) {
                            return $model->project->name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\app\modules\project\models\Project::find()->asArray()->all(), 'id', 'name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Project', 'id' => 'grid-transfer-search-project_id']
                    ],*/
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
