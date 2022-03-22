<?php /** @noinspection ALL */

use app\assets\VueSelectAsset;
use app\modules\project\models\ProjectBudget as ProjectBudgetAlias;
use mootensai\components\JsBlock;
use kartik\form\ActiveForm;
use yii\web\View;

VueSelectAsset::register($this);
JsBlock::widget(['viewFile' => '_scriptAssignqb', 'pos' => View::POS_END]);
?>

<div id="assign-qb">

    <input type="hidden" id="budget_id" value="<?= $budget_id ?>">
    <input type="hidden" id="budget_name" value="<?= ProjectBudgetAlias::findOne($budget_id)->name ?>">
    <input type="hidden" id="project_id" value="<?= $project_id ?>">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card">
        <div class="card-body">
            <div class="col-md-4">
                <label for=""><strong>Presupuesto/POA</strong></label>
                <treeselect v-model="budget_options[0].id" readonly="true" :multiple="false"
                            placeholder="[SELECCIONE]" :options="budget_options"/>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div v-for="(category, index) in categories">
                <p class="form-control bg-light" style="border-bottom: -5px">
                    <strong>{{ index + 1 }} . {{ category.name }}</strong>
                </p>

                <div class="table-responsive">
                    <table class="table table-sm table-condesed table-hover table-bordered align-middle">
                        <tbody>
                        <tr v-for="(activity, indexActivity) in category.activities">
                            <th hidden width="2%"><input type="hidden" v-bind:value="activity.id"
                                                         v-bind:name="'AssignQb' + '[' + activity.id + '][id]'"></th>
                            <th scope="col" width="2%">{{ activity.account_number }}</th>
                            <td width="40%">{{ activity.name }}</td>
                            <td width="25%"> <treeselect :multiple="true" v-model="activity.class_id" readonly="true"
                                                         v-bind:name="'AssignQb' + '[' + activity.id + '][classes][]'" placeholder="[SELECCIONE]" :options="class_options"/></td>
                            <td width="25%"> <treeselect :multiple="true" v-model="activity.chart_account_id" readonly="true"
                                                         v-bind:name="'AssignQb' + '[' + activity.id + '][chart_accounts][]'" placeholder="[SELECCIONE]" :options="chart_account_options"/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <?php $form = ActiveForm::end(); ?>
</div>