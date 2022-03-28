<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\ProjectSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use kartik\grid\GridView;

$this->title = 'Proyecto';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="project-index">

    <div class="card">
        <div class="card-body">
            <p>
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Proyecto', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    [
                        'attribute' => 'name',
                        'width' => '65%'
                    ],
                    [
                        'attribute' => 'alias',
                        'width' => '10%'
                    ],
                   /* [
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
                        'width' => '12%',
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
                        'width' => '12%',
                    ],*/
                    [
                        'attribute' => 'budget',
                        'value' => function ($model) {
                            $formatter = \Yii::$app->formatter;
                            return $formatter->asCurrency($model->budget, "Lps");
                        },
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
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-project']],
                    'headerContainer' => ['class' => '']
                ]); ?>
            </div>
        </div>
    </div>
</div>
