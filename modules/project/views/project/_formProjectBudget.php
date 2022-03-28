<div class="form-group" id="add-project-budget">
    <?php

    use kartik\builder\BaseForm;
    use kartik\grid\GridView;
    use kartik\builder\TabularForm;
    use kartik\number\NumberControl;
    use yii\data\ArrayDataProvider;
    use yii\helpers\Html;

    \app\assets\AppAsset::register($this);

    $dataProvider = new ArrayDataProvider([
        'allModels' => $row,
        'pagination' => [
            'pageSize' => -1
        ]
    ]);
    echo TabularForm::widget([
        'dataProvider' => $dataProvider,
        'formName' => 'ProjectBudget',
        'checkboxColumn' => false,
        'actionColumn' => false,
        'attributeDefaults' => [
            'type' => BaseForm::INPUT_TEXT,
        ],
        'attributes' => [
            "id" => ['type' => BaseForm::INPUT_HIDDEN, 'columnOptions' => ['hidden' => true]],
            'name' => ['type' => BaseForm::INPUT_TEXT, 'label' => 'Nombre',  'columnOptions' => ['width' => '40%']],
            'amount' => [
                'label' => 'Programado',
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => NumberControl::class,
                'options' => [
                    'maskedInputOptions' => [
                        'prefix' => 'Lps ',
                        'allowMinus' => true,
                        'rightAlign' => false
                    ],
                    'options' => [
                        'class' => 'kv-saved',
                        'readonly' => true,
                        'tabindex' => 1000
                    ],
                ],
                'columnOptions' => ['width' => '20%']],
            'del' => [
                'type' => 'raw',
                'label' => '',
                'value' => function ($model, $key) {
                    return
                        Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                        Html::a('<i class="fa fa-trash"></i>&nbsp; ', '#', ['title' => 'Delete', 'onClick' => 'delRowProjectBudget(' . $key . '); return false;', 'id' => 'project-budget-del-btn']);
                },
            ],
        ],
        'gridSettings' => [
            'panel' => [
                'heading' => false,
                'type' => GridView::TYPE_DEFAULT,
                'before' => false,
                'footer' => false,
                'after' => Html::button('<i class="fa fa-plus"></i>&nbsp; ' . 'Agregar', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowProjectBudget()']),
            ],
            'headerContainer' => ['class' => '']
        ]
    ]);
    echo "    </div>\n\n";

    $script = <<< JS
    $(':input').attr("autocomplete", "off");
    JS;
    $this->registerJs($script);
    ?>

