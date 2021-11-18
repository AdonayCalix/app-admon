<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Transfer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Transfer'.' '. Html::encode($this->title) ?></h2>
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
        ['attribute' => 'id', 'visible' => false],
        'number',
        'amount',
        'bank_id',
        'bank_account',
        [
            'attribute' => 'beneficiary.name',
            'label' => 'Beneficiary',
        ],
        [
            'attribute' => 'project.name',
            'label' => 'Project',
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>Project<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnProject = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        'alias',
        'frecuency',
        'start_date',
        'end_date',
        'budget',
        'bank',
        'account_number',
    ];
    echo DetailView::widget([
        'model' => $model->project,
        'attributes' => $gridColumnProject    ]);
    ?>
    <div class="row">
        <h4>Beneficiary<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnBeneficiary = [
        ['attribute' => 'id', 'visible' => false],
        'name',
    ];
    echo DetailView::widget([
        'model' => $model->beneficiary,
        'attributes' => $gridColumnBeneficiary    ]);
    ?>
</div>
