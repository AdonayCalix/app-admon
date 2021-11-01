<?php


/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Beneficiary */

$this->title = 'Crear Beneficiario';
$this->params['breadcrumbs'][] = ['label' => 'Beneficiary', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beneficiary-create">

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
