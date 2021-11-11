<?php

use mootensai\components\JsBlock;
use yii\web\View;

JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END]);
?>

<div id="details">
    <div class="accordion" id="accordionDetail">
        <div v-for="(detail, index) in details">

            <div class="accordion-item">

                <h2 class="accordion-header" v-bind:id="'heading-' + index">

                    <button class="accordion-button collapsed"
                            type="button" data-bs-toggle="collapse"
                            v-bind:data-bs-target="'#detail-' + index"
                            aria-expanded="false"
                            v-bind:aria-controls="'detail-' + index">

                        <i><strong>Detalle No. {{ index + 1 }}</strong></i>
                    </button>
                </h2>

                <div v-bind:id="'detail-' + index"
                     class="accordion-collapse collapse"
                     v-bind:aria-labelledby="'heading-' + index"
                     data-bs-parent="#accordionDetail">

                    <div class="accordion-body">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="">Fecha</label>
                                <input class="form-control" type="date" v-model="detail.date" name="date[]" placeholder="Fecha">
                            </div>
                            <div class="col-md-4">
                                <label for="">Beneficiario</label>
                                <treeselect v-model="detail.beneficiary" :multiple="false" placeholder="[SELECCIONE]" name="beneficiary[]" :options="options" />
                            </div>
                            <div class="col-md-4">
                                <label for="">Tipo de Moviemiento</label>
                                <treeselect v-model="detail.kind" :multiple="false" placeholder="[SELECCIONE]" name="kind[]" :options="kindOptions" />
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <label for="">Concepto</label>
                            <div class="col-md-12">
                                <textarea class="form-control" v-model="detail.concept" placeholder="Ingresa el concepto" id="floatingTextarea"></textarea>
                            </div>
                        </div>

                        <br>

                        <div class="border">
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" width="25%">Actividad</th>
                                    <th scope="col" width="25%">Clase</th>
                                    <th scope="col" width="25%">Cuenta</th>
                                    <th scope="col" width="25%">Monto</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(sub_detail, indexSubDetail) in detail.sub_details">
                                    <th scope="row">{{ indexSubDetail + 1 }}</th>
                                    <td><treeselect v-model="sub_detail.activity" :multiple="false" placeholder="[SELECCIONE]" :options="options" /></td>
                                    <td><treeselect v-model="sub_detail.class" :multiple="false" placeholder="[SELECCIONE]" :options="options" /></td>
                                    <td><treeselect v-model="sub_detail.account" :multiple="false" placeholder="[SELECCIONE]" :options="options" /></td>
                                    <td><input type="number" class="form-control" v-model="sub_detail.amount"></td>
                                    <td> <a v-on:click="deleteSubItem(indexSubDetail, index)"><i class="btn btn-danger">Eliminar</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <p>
                            <br>
                            <button v-on:click="addNewSubCategory(index)" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Agregar Categoria</button>
                        </p>

                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>

    <p>
        <button class="btn btn-success" href="#" v-on:click="addDetail">
            <i class="fa fa-plus"></i>&nbsp; Agregar Detalle
        </button>
    </p>
</div>

