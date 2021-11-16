<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\qb\models\ListClassSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Lista de Clases';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-class-index">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">

        <div class="card-header">
            <h6 class="card-subtitle text-muted">
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Cuenta', ['create'], ['class' => 'btn btn-success']) ?>
            </h6>
        </div>

        <div class="card-body">
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    'name',
                    'identifier',
                    [
                        'attribute' => 'is_parent',
                        'label' => 'Tipo de Clase',
                        'value' => function($model) {
                            $name = $model->is_parent === 'Y' ? 'Principal' : 'Sub Clase';
                            $class = $model->is_parent === 'Y' ? 'badge-success' : 'badge-primary';
                            return "<span class='badge {$class}'>{$name}</span>";
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
                    'condensed' => true,
                    'bsVersion' => '4.x',
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-list-class']],
                ]); ?>
            </div>
        </div>
    </div>
</div>
