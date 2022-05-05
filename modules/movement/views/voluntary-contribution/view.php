<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\VoluntaryContribution */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Voluntary Contribution', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voluntary-contribution-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Voluntary Contribution'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'id',
        'name',
        'date',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
<?php
if($providerVoluntaryContributionDetail->totalCount){
    $gridColumnVoluntaryContributionDetail = [
        ['class' => 'yii\grid\SerialColumn'],
            'id',
            'memo',
            'amount',
            [
                'attribute' => 'beneficiary.id',
                'label' => 'Beneficiary'
            ],
                        'created_by',
            'updated_by',
            'created_at',
            'updated_at',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerVoluntaryContributionDetail,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-voluntary-contribution-detail']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Voluntary Contribution Detail'),
        ],
        'export' => false,
        'columns' => $gridColumnVoluntaryContributionDetail
    ]);
}
?>

    </div>
</div>
