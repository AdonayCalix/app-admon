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
    <div class="card">

        <div class="card-body">
            <p>
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Cuenta', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
            <?php
            $gridColumn = [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'id', 'visible' => false],
                'name',
                [
                    'attribute' => 'identifier',
                    'width' => '50%'
                ],
                [
                    'attribute' => 'is_parent',
                    'label' => 'Tipo de Clase',
                    'value' => function ($model) {
                        $name = $model->is_parent === 'Y' ? 'Principal' : 'Sub Clase';
                        $class = $model->is_parent === 'Y' ? 'badge-success' : 'badge-primary';
                        return "<span class='badge {$class}'>{$name}</span>";
                    },
                    'format' => 'raw',
                    'width' => '10%'
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
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-list-class']],
                'headerContainer' => ['class' => '']
            ]); ?>
        </div>
    </div>
</div>

