<div class="form-group" id="add-project-period">
    <?php

    use kartik\builder\BaseForm;
    use kartik\grid\GridView;
    use kartik\builder\TabularForm;
    use kartik\widgets\DatePicker;
    use yii\data\ArrayDataProvider;
    use yii\helpers\Html;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $row,
        'pagination' => [
            'pageSize' => -1
        ]
    ]);
    echo TabularForm::widget([
        'dataProvider' => $dataProvider,
        'formName' => 'ProjectPeriod',
        'checkboxColumn' => false,
        'actionColumn' => false,
        'options' => [
            'headerContainer' => ['class' => '']
        ],
        'attributeDefaults' => [
            'type' => BaseForm::INPUT_TEXT,
        ],
        'attributes' => [
            "id" => ['type' => BaseForm::INPUT_HIDDEN, 'columnOptions' => ['hidden' => true]],
            'name' => ['type' => BaseForm::INPUT_TEXT, 'label' => 'Nombre', 'columnOptions' => ['width' => '20%']],
            'start_date' => [
                'label' => 'Fecha Inicio',
                'type' => BaseForm::INPUT_WIDGET,
                'widgetClass' => DatePicker::class,
                'options' => [
                    'options' => [
                        'autocomplete' => 'off'
                    ],
                    'language' => 'es',
                    'pluginOptions' => ['autoclose' => true]
                ],
                'columnOptions' => ['width' => '20%']
            ],
            'end_date' => [
                'label' => 'Fecha Final',
                'type' => BaseForm::INPUT_WIDGET,
                'widgetClass' => DatePicker::class,
                'options' => [
                    'options' => [
                        'autocomplete' => 'off'
                    ],
                    'language' => 'es',
                    'pluginOptions' => ['autoclose' => true]
                ],
                'option' => [
                    'autocomplete' => 'off'
                ],
                'columnOptions' => ['width' => '20%']
            ],
            'del' => [
                'type' => 'raw',
                'label' => '',
                'value' => function ($model, $key) {
                    return
                        Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                        Html::a('<i class="fa fa-trash"></i> ', '#', ['title' => 'Delete', 'onClick' => 'delRowProjectPeriod(' . $key . '); return false;', 'id' => 'project-period-del-btn']);
                },
            ],
        ],
        'gridSettings' => [
            'panel' => [
                'heading' => false,
                'type' => GridView::TYPE_DEFAULT,
                'before' => false,
                'footer' => false,
                'after' => Html::button('<i class="fa fa-plus"></i>&nbsp; ' . 'Agregar', ['type' => 'button', 'class' => 'btn btn-success btn-sm kv-batch-create', 'onClick' => 'addRowProjectPeriod()']),
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

