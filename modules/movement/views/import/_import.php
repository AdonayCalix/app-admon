<?php
/* @var $this yii\web\View */

use app\assets\VueSelectAsset;
use kartik\form\ActiveForm;
use mootensai\components\JsBlock;
use yii\base\View;

$this->title = 'Importar Movimientos al QuickBook';
$this->params['breadcrumbs'][] = $this->title;

VueSelectAsset::register($this);
JsBlock::widget(['viewFile' => 'script', 'pos' => \yii\web\View::POS_END]);

?>

<div id="import-qb">
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <?php $form = ActiveForm::begin([
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <div class="card">
        <div class="card-body">
            <div id="import">
                <div class="row">
                    <div class="col-md-3">
                        <label for=""><strong>Proyecto</strong></label>
                        <treeselect v-model="project_id" :multiple="false" placeholder="[SELECCIONE]"
                                    :options="project_list"/>
                    </div>
                    <div class="col-md-3">
                        <label for=""><strong>Tipo de Moviemiento</strong></label>
                        <treeselect v-model="kind_of_movement_id" :multiple="false" placeholder="[SELECCIONE]"
                                    :options="kind_of_movement_list"/>
                    </div>

                    <div class="col align-content-center" style="margin-top: 10px">
                        <br>
                        <a v-on:click="getMovements" class="btn btn-primary btn-sm">
                            Vista Previa
                        </a>
                        <a v-on:click="store" class="btn btn-success btn-sm">
                            Importar
                        </a>
                    </div>
                </div>

                <div class="row" v-if="movements">
                    <div class="col-md-10">
                        <br>
                        <table class="table table-sm table-condesed table-striped table-hover table-bordered align-middle">
                            <tbody>
                            <tr class="kv-table-header">
                                <td width="5%"><strong>#</strong></td>
                                <td width="25%"><strong>No TB/Cheque</strong></td>
                                <td width="25%"><strong>Monto</strong></td>
                                <td width="25%"><strong>Fecha</strong></td>
                                <td width="10%"><strong>Accion</strong></td>
                            </tr>

                            <tr v-for="(movement, index) in movements" v-on:click="diClick(index)">
                                <td><strong>{{index + 1}}</strong></td>
                                <td hidden><strong><input type="hidden" :value="movement.id" :name="'Movements[' + index + '][id]'"></strong></td>
                                <td>{{movement.number}}</td>
                                <td>{{movement.amount}}</td>
                                <td>{{movement.date}}</td>
                                <td><input type="checkbox" checked :name="'Movements[' + index + '][isChecked]'" :id="index"></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>