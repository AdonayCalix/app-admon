<?php

use app\assets\VueSelectAsset;
use kartik\base\BootstrapInterface;
use kartik\select2\Select2;
use mootensai\components\JsBlock;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\modules\qb\models\ChartAccount */
/* @var $form yii\widgets\ActiveForm */

VueSelectAsset::register($this);
JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END]);

?>

<div id="chart-account" class="chart-account-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL],
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <input type="hidden" id="account_number" value="<?= $model->isNewRecord ? -1 : $model->sub_account ?>">
    <input type="hidden" id="kind_account" value="<?= $model->is_parent?>">

    <?= $form->field($model, 'account_number')->textInput(['maxlength' => true, 'placeholder' => 'Numero de Cuenta']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nombre']) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'placeholder' => 'Descripcion']) ?>

    <div class="form-group row">

        <label class="col-sm-2 col-form-label" v-on:click="changeDisabled">
            <input type="checkbox" name="ChartAccount[is_parent]" v-model="checked" true-value="yes" false-value="no">
            Sub Cuenta De?
        </label>
        <div class="col-sm-10">
            <treeselect v-model="subAccount" :disabled="disabled" name="ChartAccount[sub_account]" :multiple="false" placeholder="[SELECCIONE]"  :options="options" />
        </div>
    </div>

    <br>

    <?= $form->field($model, 'type')->widget(Select2::class, [
        'data' => ArrayHelper::map($accountTypes, 'id', 'value'),
        'options' => ['placeholder' => '[SELECCIONE]'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'currency')->widget(Select2::class, [
        'data' => ArrayHelper::map($currencies, 'id', 'value'),
        'options' => ['placeholder' => '[SELECCIONE]'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancelar'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>
