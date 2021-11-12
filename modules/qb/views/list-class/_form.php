<?php

use app\assets\VueSelectAsset;
use kartik\base\BootstrapInterface;
use mootensai\components\JsBlock;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\modules\qb\models\ListClass */
/* @var $form yii\widgets\ActiveForm */

VueSelectAsset::register($this);
JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END]);
?>

<div class="list-class-form" id="list-class">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL],
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <input type="hidden" id="identifier" value="<?= $model->isNewRecord ? -1 : $model->sub_class ?>">
    <input type="hidden" id="kind_class" value="<?= $model->is_parent ?>">

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nombre']) ?>

    <div class="form-group row">

        <label class="col-sm-2 col-form-label" v-on:click="changeDisabled">
            <input type="checkbox" name="ListClass[is_parent]" v-model="checked" value="false"  true-value="yes" false-value="no">
            Sub Clase De?
        </label>
        <div class="col-sm-10">
            <treeselect v-model="subClass" :disabled="disabled" name="ListClass[sub_class]" :multiple="false" placeholder="[SELECCIONE]"  :options="options" />
        </div>
    </div>

    <br>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancelar'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>
