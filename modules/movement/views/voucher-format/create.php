<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\VoucherFormat */

$this->title = 'Crear Formato de Voucher';
$this->params['breadcrumbs'][] = ['label' => 'Voucher Format', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voucher-format-create">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('_form', compact('model', 'voucherFormatForm')) ?>
                </div>
            </div>
        </div>
    </div>

</div>
