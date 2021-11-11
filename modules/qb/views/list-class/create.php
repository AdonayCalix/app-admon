<?php


/* @var $this yii\web\View */
/* @var $model app\modules\qb\models\ListClass */

$this->title = 'Crear clase';
$this->params['breadcrumbs'][] = ['label' => 'List Class', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-class-create">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('_form', [
                        'model' => $model
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
