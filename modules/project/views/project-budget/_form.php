<?php

use app\modules\project\models\Project;
use kartik\base\BootstrapInterface;
use kartik\number\NumberControl;
use kartik\widgets\Select2;
use mootensai\components\JsBlock;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\ProjectBudget */
/* @var $form yii\widgets\ActiveForm */

JsBlock::widget(['viewFile' => '_script', 'pos'=> View::POS_END,
    'viewParams' => [
        'class' => 'BudgetCategory', 
        'relID' => 'budget-category', 
        'value' => Json::encode($model->budgetCategories),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="project-budget-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nombre']) ?>

    <?= $form->field($model, 'amount')->widget(NumberControl::class, [
        'maskedInputOptions' => [
            'prefix' => 'Lps ',
            'allowMinus' => false,
            'rightAlign' => false
        ]
    ]); ?>

    <?= $form->field($model, 'project_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Project::find()->orderBy('id')->asArray()->all(), 'id', 'alias'),
        'options' => ['placeholder' => '[SELECCIONE]'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Categorias'),
            'content' => $this->render('_formBudgetCategory', [
                'row' => ArrayHelper::toArray($model->budgetCategories),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>
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
