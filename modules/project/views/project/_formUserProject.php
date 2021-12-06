<div class="form-group" id="add-user-project">
    <?php

    use kartik\builder\BaseForm;
    use kartik\grid\GridView;
    use kartik\builder\TabularForm;
    use kartik\select2\Select2;
    use kartik\widgets\DatePicker;
    use yii\data\ArrayDataProvider;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $row,
        'pagination' => [
            'pageSize' => -1
        ]
    ]);
    echo TabularForm::widget([
        'dataProvider' => $dataProvider,
        'formName' => 'UserProject',
        'checkboxColumn' => false,
        'actionColumn' => false,
        'attributeDefaults' => [
            'type' => BaseForm::INPUT_TEXT,
        ],
        'attributes' => [
            "id" => ['type' => BaseForm::INPUT_HIDDEN, 'columnOptions' => ['hidden' => true]],
            'user_id' => [
                'label' => 'Usuario',
                'type' => BaseForm::INPUT_WIDGET,
                'widgetClass' => Select2::class,
                'options' => [
                    'data' => ArrayHelper::map(\webvimark\modules\UserManagement\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
                    'options' => ['placeholder' => '[SELECCIONE]'],
                ],
                'columnOptions' => ['width' => '40%']
            ],
            'position' => [
                'type' => BaseForm::INPUT_TEXT,
                'options' => [
                    'placeholder' => 'Cargo del usuario',
                    'autocomplete' => 'off',
                ],
            ],
            'del' => [
                'type' => 'raw',
                'label' => '',
                'value' => function ($model, $key) {
                    return
                        Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                        Html::a('<i class="fa fa-trash"></i> ', '#', ['title' => 'Delete', 'onClick' => 'delRowUserProject(' . $key . '); return false;', 'id' => 'user-project-del-btn']);
                },
            ],
        ],
        'gridSettings' => [
            'panel' => [
                'heading' => false,
                'type' => GridView::TYPE_DEFAULT,
                'before' => false,
                'footer' => false,
                'after' => Html::button('<i class="fa fa-plus"></i>&nbsp; ' . 'Agregar', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowUserProject()']),
            ]
        ]
    ]);
    echo "    </div>\n\n";

    $script = <<< JS
        $(':input').attr("autocomplete", "off");
    JS;
    $this->registerJs($script);
    ?>

