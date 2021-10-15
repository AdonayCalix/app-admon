<div class="form-group" id="add-project-budget">
<?php

use kartik\builder\BaseForm;
use kartik\grid\GridView;
use kartik\builder\TabularForm;
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
        "id" => ['type' => BaseForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'name' => ['type' => BaseForm::INPUT_TEXT, 'label' => 'Nombre'],
        'amount' => ['type' => BaseForm::INPUT_TEXT, 'label' => 'Monto'],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="align-middle" data-feather="trash"></i>&nbsp; ', '#', ['title' =>  'Delete', 'onClick' => 'delRowProjectBudget(' . $key . '); return false;', 'id' => 'project-budget-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="align-middle" data-feather="plus-circle"></i>&nbsp; ' . 'Agregar', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowProjectBudget()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

