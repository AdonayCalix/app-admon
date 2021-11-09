<?php

/* @var $this yii\web\View */
/* @var $model app\modules\qb\models\ChartAccount */


use app\modules\qb\models\ImportForm;

$this->title = 'Importar Cuentas del QuickBook';
$this->params['breadcrumbs'][] = ['label' => 'Chart Account', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chart-account-import">
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('_formImport', [
                        'model' => $model
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
