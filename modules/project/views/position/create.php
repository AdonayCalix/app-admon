<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Position */

$this->title = 'Crear Posición';
$this->params['breadcrumbs'][] = ['label' => 'Position', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-create">
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
