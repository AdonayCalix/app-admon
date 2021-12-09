<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\TransferAssignment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Transfer Assignment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-assignment-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Transfer Assignment'.' '. Html::encode($this->title) ?></h2>
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
        [
            'attribute' => 'transfer.id',
            'label' => 'Transfer',
        ],
        [
            'attribute' => 'beneficiary.name',
            'label' => 'Beneficiary',
        ],
        'amount',
        'position',
        'reason',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>Movement<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnMovement = [
        ['attribute' => 'id', 'visible' => false],
        'number',
        'amount',
        'bank_id',
        'bank_account',
        'project_id',
    ];
    echo DetailView::widget([
        'model' => $model->transfer,
        'attributes' => $gridColumnMovement    ]);
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
