<?php

use app\modules\movement\models\MovementDetail;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Transfer */

$this->title = $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Movimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-view">

    <div class="mb-3">
        <h1 class="h4 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Seguro que quieres borrar este registro',
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>

            <div class="row">
                <div class="col-md-12">
                    <?php
                    $gridColumn = [
                        ['attribute' => 'id', 'visible' => false],
                        [
                            'attribute' => 'project_id',
                            'label' => 'Proyecto',
                            'value' => $model->project->alias
                        ],
                        'number',
                        'amount',
                        'bank_account'
                    ];
                    echo \kartik\detail\DetailView::widget([
                        'model' => $model,
                        'attributes' => $gridColumn,
                        'condensed' => true,
                        'hAlign' => 'left',
                        'template' => '<tr><th>{label}</th><td style="width:80%;">{value}</td></tr>'
                    ]);
                    ?>
                </div>
            </div>

            <br>
            <p class="form-control bg-light" style="margin-bottom: 0px">
                <i><strong>Detalles del Movimiento</strong></i>
            </p>

            <?php $gridMovementDetailColums = [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'id', 'visible' => false],
                [
                    'class' => \kartik\grid\ExpandRowColumn::class,
                    'label' => 'Fila Expandible',
                    'format' => 'raw',
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail' => function ($model, $key, $index) {
                        return Yii::$app->controller->renderPartial('_subDetail', ['model' => $model]);
                    },
                    'expandOneOnly' => false,
                    'width' => '5%'
                ],
                [
                    'attribute' => 'date',
                    'width' => '10%'
                ],
                [
                    'attribute' => 'kind',
                    'width' => '10%'
                ],
                [
                    'attribute' => 'amount',
                    'width' => '15%'
                ],
                [
                    'attribute' => 'beneficiary_id',
                    'label' => 'Beneficiario',
                    'value' => function ($model) {
                        return \app\modules\project\models\Beneficiary::findOne($model->beneficiary_id)->name ?? null;
                    }
                ],
                [
                    'attribute' => 'concept',
                ],
            ]; ?>

            <?= GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => MovementDetail::find()->where(['transfer_id' => $model->id]),
                ]),
                'sorter' => false,
                'columns' => $gridMovementDetailColums,
                'pjax' => true,
                'condensed' => true,
                'headerContainer' => ['class' => ''],
                'summary' => false
            ]); ?>

        </div>
    </div>
</div>

<?php
$script = <<< JS
$("colgroup").remove()
JS;
$this->registerJs($script);
?>