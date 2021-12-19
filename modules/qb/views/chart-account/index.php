<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\qb\models\ChartAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


use kartik\grid\GridView;
use webvimark\modules\UserManagement\components\GhostHtml;

$this->title = 'Cuentas QB';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="chart-account-index">

    <div class="card">

        <div class="card-body">

            <p>
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Cuenta', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    'account_number',
                    'name',
                    'type',
                    'currency',
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
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-chart-account']]
                ]); ?>
            </div>
        </div>
</div>
