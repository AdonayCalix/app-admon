<?php

use app\assets\MoneyAsset;
use app\assets\VueSelectAsset;
use kartik\base\BootstrapInterface;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\VoluntaryContribution */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos' => \yii\web\View::POS_END]);

VueSelectAsset::register($this);
MoneyAsset::register($this);
?>

<div class="voluntary-contribution-form" id="voluntary-contribution-detail">

    <?php $form = ActiveForm::begin([
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <input type="hidden" id="voluntary_contribution_id" value="<?= $model->isNewRecord ? -1 : $model->id ?>">

    <div v:if="errors" class="text-danger">
        <ul>
            <li v-for="(error, index) in errors"><strong>{{ error[0] }}</strong></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Memo'])->label('Memo') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'date')->widget(\kartik\datecontrol\DateControl::class, [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => '',
                        'autoclose' => true
                    ]
                ],
            ]); ?>
        </div>
    </div>

    <?= Yii::$app->controller->renderPartial('_formVoluntaryContributionDetail') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear Lote' : 'Actualizar Lote', ['v-on:click.prevent' => 'store', 'class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Cancelar'), Yii::$app->request->referrer, ['class' => 'btn btn-danger btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>