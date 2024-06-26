<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\PositionSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Position';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-index">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">

        <div class="card-header">
            <h6 class="card-subtitle text-muted">
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Posición', ['create'], ['class' => 'btn btn-success']) ?>
            </h6>
        </div>

        <div class="card-body">
            <div class="row">
                <?php $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    'name',
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
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-position']],
                ]); ?>
            </div>
        </div>
    </div>
    <?php ?>
</div>
