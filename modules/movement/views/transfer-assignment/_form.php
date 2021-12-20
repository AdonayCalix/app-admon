<?php

use app\assets\MoneyAsset;
use app\assets\VueSelectAsset;
use mootensai\components\JsBlock;
use yii\helpers\Html;
use yii\web\View;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\TransferAssignment */
/* @var $form yii\widgets\ActiveForm */

VueSelectAsset::register($this);
MoneyAsset::register($this);
JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END]);

?>

<div id="tansfer_assignment" class="transfer-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <div id="flash"></div>
    <input type="hidden" id="transfer_id" value="<?= $model->transfer_id ?>" name="transferId">
    <input type="hidden" id="isNewRecord" value="<?= $isNewRecord ?>" name="isNewRecord">

    <div v:if="errors" class="text-danger">
        <ul>
            <li v-for="(error, index) in errors"><strong>{{ error }}</strong></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <label for="">No TB/Cheque</label>
                    <treeselect v-model="transfer_id" :name="'DynamicModel[transfer_id]'" :multiple="false" placeholder="[SELECCIONE]" :options="transfer_options"></treeselect>
                </div>
            </div>

            <br>

            <div class="container-fluid border">
                <table class="table table-borderless table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" width="15%">Beneficiario</th>
                        <th scope="col" width="15%">Posicion</th>
                        <th scope="col" width="50%">Motivo</th>
                        <th scope="col" width="15%">Monto</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(detail, index) in assign_detail">
                        <th scope="row">{{ index + 1 }}</th>
                        <td style="display:none;"><input type="hidden" v-model="detail.id"
                                                         :name="'TransferAssignment' + '[' + index + '][id]'"></td>
                        <td style="display:none;"><input type="hidden" v-model="transfer_id"
                                                         :name="'TransferAssignment' + '[' + index + '][transfer_id]'"></td>
                        <td>
                            <treeselect v-model="detail.beneficiary_id"
                                        :name="'TransferAssignment' + '[' + index + '][beneficiary_id]'"
                                        :multiple="false" placeholder="[SELECCIONE]"
                                        :options="beneficiaries_options"></treeselect>
                        </td>
                        <td>
                            <treeselect v-model="detail.position"
                                        :name="'TransferAssignment' + '[' + index + '][position]'" :multiple="false"
                                        placeholder="[SELECCIONE]" :options="position_options"></treeselect>
                        </td>
                        <td><input type="text" class="form-control"
                                   :name="'TransferAssignment' + '[' + index + '][reason]'" v-model="detail.reason">
                        </td>
                        <td>
                            <money v-model="detail.amount" class="form-control" :name="'TransferAssignment' + '[' + index + '][amount]'"></money>

                        </td>
                        <td><a v-on:click="deleteAssignDetail(index)"><i class="btn btn-sm btn-danger">Eliminar</a></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <th scope="row">Total: {{ sumAmount(assign_detail) }}</th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <p>
                <button class="btn btn-sm btn-primary" href="#" v-on:click="addAssignDetail">
                    <i class="fa fa-plus"></i>&nbsp; Agregar Detalle
                </button>
            </p>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Asignar', ['class' => 'btn btn-success', 'v-on:click.prevent' => 'store']) ?>
        <?= Html::a(Yii::t('app', 'Cancelar'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
