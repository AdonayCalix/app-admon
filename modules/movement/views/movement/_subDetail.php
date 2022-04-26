<?php

use app\modules\qb\models\ChartAccount;
use app\modules\qb\models\ListClass;
use yii\data\ArrayDataProvider;

$providerSubCategorieDetail = new ArrayDataProvider([
    'allModels' => $model->movementSubDetails,
]);

?>


<div class="bg-white">

    <?php if ($providerSubCategorieDetail->totalCount) {
        $gridSubCategorieDetail = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'class_id',
                'value' => function ($model) {
                    return ListClass::findOne(['identifier' => $model->class_id])->name ?? null;
                }
            ],
            [
                'attribute' => 'chart_account_id',
                'value' => function ($model) {
                    return ChartAccount::findOne(['account_number' => $model->chart_account_id])->name ?? null;
                }
            ],
            [
                'attribute' => 'subCategory.name',
            ],
            [
                'attribute' => 'amount',
                'width' => '10%'
            ],
        ];

        echo \kartik\grid\GridView::widget([
            'dataProvider' => $providerSubCategorieDetail,
            'columns' => $gridSubCategorieDetail,
            'summary' => false,
            'condensed' => true,
            'striped' => true,
            'showFooter' => false,
            'headerContainer' => ['class' => '']
        ]);
    }
    ?>
</div>

