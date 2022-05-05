<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\VoluntaryContributionSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\grid\GridViewInterface;
use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Aporte Voluntario';
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="voluntary-contribution-index">

        <div class="card">
            <div class="card-body">

                <p>
                    <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Registrar Aportes Voluntarios', ['create'], ['class' => 'btn btn-sm btn-success']) ?>
                </p>
                <div class="row">
                    <?php
                    $gridColumn = [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'name',
                            'width' => '50%'
                        ],
                        [
                            'attribute' => 'date',
                            'filterType' => GridViewInterface::FILTER_DATE,
                            'filterWidgetOptions' => [
                                'id' => 'fecha',
                                'removeButton' => false,
                                'language' => 'es',
                                'options' => [
                                    'autocomplete' => 'new-text'
                                ],
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                    'todayBtn' => false,
                                    'orientation' => 'bottom left'
                                ],
                            ],
                            'width' => '40%',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                        ],
                    ];
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => $gridColumn,
                        'pjax' => true,
                        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-voluntary-contribution']],
                        'headerContainer' => ['class' => ''],
                        'condensed' => true,
                        'striped' => true
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>