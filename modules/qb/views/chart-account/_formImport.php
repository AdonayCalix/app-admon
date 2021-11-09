
<?php use kartik\form\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'excelFile')->fileInput() ?>

<div class="form-group">
    <?= Html::submitButton('Importar', ['class' => 'btn btn-success']); ?>
</div>

<?php ActiveForm::end() ?>