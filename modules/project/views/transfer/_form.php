<?php

use kartik\base\BootstrapInterface;
use webvimark\modules\UserManagement\components\GhostHtml;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Transfer */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="transfer-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL],
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true, 'placeholder' => 'No. Cheque/TB']) ?>

    <?= $form->field($model, 'amount')->textInput(['placeholder' => 'Monto']) ?>

    <?= $form->field($model, 'bank_id')->textInput(['placeholder' => 'Banco']) ?>

    <?= $form->field($model, 'bank_account')->textInput(['maxlength' => true, 'placeholder' => 'Cuenta']) ?>

    <?= Yii::$app->controller->renderPartial('_details'); ?>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>
