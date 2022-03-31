<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\BeneficiarySearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Beneficiario';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="beneficiary-index">
    <div class="card">
        <div class="card-body">
            <p>
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Beneficiario', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
            <div class="row">
                <?php
                $gridColumn = [
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
                    'condensed' => true,
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-beneficiary']],
                    'headerContainer' => ['class' => '']
                ]); ?>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>
</div>
