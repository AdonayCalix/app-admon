<?php

use app\assets\DatePickerAsset;
use app\assets\MoneyAsset;
use app\assets\SweetAlertAsset;
use app\assets\VueSelectAsset;
use kartik\base\BootstrapInterface;
use kartik\widgets\DatePicker;
use mootensai\components\JsBlock;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\modules\expense\models\ExpenseRequest */
/* @var $form yii\widgets\ActiveForm */

VueSelectAsset::register($this);
DatePickerAsset::register($this);
SweetAlertAsset::register($this);
MoneyAsset::register($this);

JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END]);
?>


<div class="expense-request-form" id="expense_details">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL],
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <div>
        <div v:if="errors" class="text-danger">
            <ul v-for="(error, index) in errors">
                <li v-for="(message, messageIndex) in error">
                    <strong>
                        {{ message }}
                    </strong>
                </li>
            </ul>
        </div>
    </div>

    <p class="form-control bg-light" style="margin-bottom: 0px">
        <i><strong>Datos Generales</strong></i>
    </p>
    <div class="container-fluid border">

        <input type="hidden" id="expanse_request_id" value="<?= !$model->isNewRecord ? $model->id : -1 ?>">
        <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

        <?= $form->field($model, 'elaborated_at',
            [
                'inputOptions' =>
                    [
                        'autocomplete' => 'off',
                        'placeholder' => 'Fecha Elaboracion',
                    ]
            ]
        )->widget(DatePicker::class,
            [
                'language' => 'es',
                'pluginOptions' => ['autoclose' => true]
            ]
        ); ?>

        <?= $form->field($model, 'number_transfer')->textInput(['maxlength' => true, 'placeholder' => 'TB/Cheque']) ?>

        <?= $form->field($model, 'beneficiary_id')->widget(\kartik\widgets\Select2::class, [
            'data' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Beneficiary::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => '[SELECCIONE]'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'position')->textInput(['maxlength' => true, 'placeholder' => 'Posicion']) ?>

        <?= $form->field($model, 'project_id')->widget(\kartik\widgets\Select2::class, [
            'data' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Project::find()->orderBy('id')->asArray()->all(), 'id', 'alias'),
            'options' => ['placeholder' => '[SELECCIONE]'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'place')->textInput(['maxlength' => true, 'placeholder' => 'Lugares de Destino']) ?>

        <?= $form->field($model, 'goal')->textInput(['maxlength' => true, 'placeholder' => 'Objetivo']) ?>

        <?= $form->field($model, 'start_date')->widget(\kartik\widgets\DateTimePicker::class, [
            'options' => ['placeholder' => 'Fecha de Entrada'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy h:i'
            ]
        ]); ?>

        <?= $form->field($model, 'end_date')->widget(\kartik\widgets\DateTimePicker::class, [
            'options' => ['placeholder' => 'Fecha de Salida'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd/mm/yyyy hh:ii',
                'showMeridian' => true,
            ]
        ]); ?>

        <?= $form->field($model, 'requested_day')->textInput(['maxlength' => true, 'placeholder' => 'Dias Solicitados']) ?>
    </div>
    <br>
    <?= Yii::$app->controller->renderPartial('_expenseDetails'); ?>

    <button type="submit" class="btn btn-success" v-on:click.prevent="store">
        Guardar
    </button>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>
