<?php

use app\modules\qb\repository\AccountType;
use app\modules\qb\repository\Currency;

/* @var $this yii\web\View */
/* @var $model app\modules\qb\models\ChartAccount */

$this->title = 'Actulizando Registro: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Chart Account', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editando';
?>
<div class="chart-account-update">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'currencies' => Currency::get(),
                        'accountTypes' => AccountType::get()
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
