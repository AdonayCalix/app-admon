<?php

use app\assets\DatePickerAsset;
use app\assets\MoneyAsset;
use app\assets\SweetAlertAsset;
use app\assets\VueAsset;
use app\assets\VueSelectAsset;
use app\modules\project\models\base\Project;
use kartik\number\NumberControl;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use mootensai\components\JsBlock;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\MaskedInputAsset;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Transfer */
/* @var $form yii\widgets\ActiveForm */

VueSelectAsset::register($this);
DatePickerAsset::register($this);
SweetAlertAsset::register($this);
MoneyAsset::register($this);

JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END]);
?>

<div class="transfer-form" id="details">

    <?php $form = ActiveForm::begin([
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <input type="hidden" id="movement_id" name="Movement[id]" value="<?= $model->isNewRecord ? -1 : $model->id ?>">
    <input type="hidden" id="project_id" value="<?= $model->isNewRecord ? null : $model->project_id ?>">

    <div id="flash"></div>

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
                            'allowMinus' => false,
                            'rightAlign' => false
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-3">
                    <label for="">Proyecto</label>
                    <treeselect v-model="project_id" :multiple="false" placeholder="[SELECCIONE]"
                                :name="'Movement[project_id]'" :options="project_options"/>
                </div>
            </div>
        </div>
    </div>

    <?= Yii::$app->controller->renderPartial('_movement'); ?>

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
