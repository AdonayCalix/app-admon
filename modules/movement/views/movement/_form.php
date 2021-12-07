<?php

use app\assets\DatePickerAsset;
use app\assets\SweetAlertAsset;
use app\assets\VueSelectAsset;
use kartik\number\NumberControl;
use kartik\form\ActiveForm;
use mootensai\components\JsBlock;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Transfer */
/* @var $form yii\widgets\ActiveForm */

VueSelectAsset::register($this);
DatePickerAsset::register($this);
SweetAlertAsset::register($this);

JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END]);
?>

<div class="transfer-form" id="details">

    <?php $form = ActiveForm::begin([
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <input type="hidden" id="movement_id" name="Movement[id]" value="<?= $model->isNewRecord ? -1 : $model->id ?>">

    <div class="card">
        <div class="card-body" style="margin-bottom: -15px">

            <div v:if="errors" class="text-danger">
                <ul>
                    <li v-for="(error, index) in errors"><strong>{{ error }}</strong></li>
                </ul>
            </div>

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
                <div class="col-sm-3">
                    <?= $form->field($model, 'project_id')->textInput(['maxlength' => true, 'placeholder' => '']) ?>
                </div>
            </div>
        </div>
    </div>

    <?= Yii::$app->controller->renderPartial('_movement'); ?>

    <button type="submit" class="btn btn-success" v-on:click.prevent="store">
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
