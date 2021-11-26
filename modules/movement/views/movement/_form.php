<?php

use app\assets\DatePickerAsset;
use app\assets\SweetAlertAsset;
use app\assets\VueSelectAsset;
use kartik\number\NumberControl;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Transfer */
/* @var $form yii\widgets\ActiveForm */

VueSelectAsset::register($this);
DatePickerAsset::register($this);
SweetAlertAsset::register($this);

?>

<div class="transfer-form">

    <?php $form = ActiveForm::begin([
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <div class="card">
        <div class="card-body" style="margin-bottom: -15px">
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'number')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'amount')->widget(NumberControl::class, [
                        'maskedInputOptions' => [
                            'prefix' => 'Lps ',
                            'allowMinus' => false,
                            'rightAlign' => false
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

    <?= Yii::$app->controller->renderPartial('_movement'); ?>

    <button type="submit" class="btn btn-success">
        Enviar
    </button>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>
