<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\expense\models\ExpenseRequest */

$this->title = 'Anticipo de Gasto' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Anticipo de Gasto', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editando';
?>
<div class="expense-request-update">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('_form', compact('model')) ?>
                </div>
            </div>
        </div>
    </div>

</div>
