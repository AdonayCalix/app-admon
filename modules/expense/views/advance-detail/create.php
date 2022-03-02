<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\expense\models\AdvanceDetail */

$this->title = 'Crear Detalle de Gasto';
$this->params['breadcrumbs'][] = ['label' => 'Detalle de Gasto', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advance-detail-create">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

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
