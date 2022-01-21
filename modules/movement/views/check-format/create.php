<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\CheckFormat */

$this->title = 'Creando Formato de Solicitud de Cheques';
$this->params['breadcrumbs'][] = ['label' => 'Solicitud de Cheques', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-format-create">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('_form', compact('model', 'checkLogo')) ?>
                </div>
            </div>
        </div>
    </div>
</div>
