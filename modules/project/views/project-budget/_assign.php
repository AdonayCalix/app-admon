<?php

use app\assets\MoneyAsset;
use app\assets\VueSelectAsset;
use app\modules\project\models\ProjectBudget;
use kartik\widgets\ActiveForm;
use mootensai\components\JsBlock;
use yii\web\View;

VueSelectAsset::register($this);
MoneyAsset::register($this);
JsBlock::widget(['viewFile' => '_scriptBudget', 'pos' => View::POS_END]);

?>
<div id="assign">

    <input type="hidden" id="budget_id" value="<?= /** @var int $budget_id */
    $budget_id ?>">
    <input type="hidden" id="budget_name" value="<?= ProjectBudget::findOne($budget_id)->name ?>">
    <input type="hidden" id="project_id" value="<?= $project_id ?>">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for=""><strong>Periodo de Ejecución</strong></label>
                    <treeselect v-model="period" @input="getData" :multiple="false" placeholder="[SELECCIONE]"
                                :options="period_options"/>
                </div>

                <div class="col-md-4">
                    <label for=""><strong>Presupuesto/POA</strong></label>
                    <treeselect v-model="budget_options[0].id" readonly="true" :multiple="false"
                                placeholder="[SELECCIONE]" :options="budget_options"/>
                </div>
            </div>
        </div>
    </div>
    <div v-if="period">
        <div class="card">
            <div class="card-body">
                <div v-for="(category, index) in categories">
                    <p class="form-control bg-light" style="border-bottom: -5px">
                        <strong>{{ index + 1 }} . {{ category.name }}</strong>
                    </p>
                    <table class="table table-sm table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th width="45%">Actividad</th>
                            <th>Presupueso</th>
                            <th>Ejecutado</th>
                            <th>% Ejecución</th>
                            <th>Disponible</th>
                        </tr>
                        </thead>
                    </table>

                    <div class="table-responsive">
                        <table class="table table-sm table-condesed table-hover table-bordered align-middle">
                            <tbody>
                            <tr v-for="(activity, indexActivity) in category.activities">
                                <th scope="col">{{ activity.account_number }}</th>
                                <td width="45%">{{ activity.name }}</td>
                                <td style="display:none;"><input type="hidden" class="form-control"
                                                                 v-bind:value="activity.id"
                                                                 v-bind:name="'BudgetPeriod' + '[' + activity.activity_id + '][id]'">
                                </td>
                                <td style="display:none;"><input type="hidden" class="form-control"
                                                                 v-bind:value="period"
                                                                 v-bind:name="'BudgetPeriod' + '[' + activity.activity_id + '][period_id]'">
                                </td>
                                <td style="display:none;"><input type="hidden" class="form-control"
                                                                 v-bind:value="category.id"
                                                                 v-bind:name="'BudgetPeriod' + '[' + activity.activity_id + '][category_id]'">
                                </td>
                                <td style="display:none;"><input type="hidden" class="form-control"
                                                                 v-bind:value="activity.activity_id"
                                                                 v-bind:name="'BudgetPeriod' + '[' + activity.activity_id +'][sub_category_id]'">
                                </td>
                                <td>
                                    <input v-model="activity.amount" type="number" class="form-control"
                                           v-bind:name="'BudgetPeriod' + '[' + activity.activity_id + '][amount]'"></td>
                                <td><input v-model="activity.used" type="text" class="form-control" disabled></td>
                                <td><input v-model="activity.percentage" type="text" class="form-control" disabled></td>
                                <td><input v-model="activity.aviable" type="text" class="form-control" disabled></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center"><strong>Sub Total</strong></td>
                                <td class=""><strong>{{ sumAmount(category.activities) }}</strong></td>
                                <td class=""><strong>{{ sumExecute(category.activities) }}</strong></td>
                                <td class=""><strong>0%</strong></td>
                                <td class=""><strong>{{ sumAviable(category.activities) }}</strong></td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <?php $form = ActiveForm::end(); ?>
</div>
