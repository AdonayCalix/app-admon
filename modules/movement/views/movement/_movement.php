<div>

    <div class="" id="accordionDetail">
        <div v-for="(detail, index) in details">
            <div class="card">
                <div class="card-body">

                    <p class="form-control bg-light" style="margin-bottom: 0px">
                        <i><strong>Movimiento #{{index +1 }} : {{ detail.kind }}</strong></i>
                    </p>

                    <div class="container-fluid border">

                        <div class="row">
                            <div class="col-md-6">
                                <label for=""><strong>Tipo Movimiento</strong></label>
                                <treeselect v-model="detail.kind" :multiple="false" placeholder="[SELECCIONE]" :name="'Movement[MovementDetails]' + '[' + index + '][kind]'" :options="kindOptions" />
                            </div>
                            <div class="col-md-6">
                                <label for=""><strong>Monto</strong></label>
                                <input class="form-control" type="number" :name="'Movement[MovementDetails]' + '[' + index + '][amount]'">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for=""><strong>Fecha</strong></label>
                                <input class="form-control" lang="en-us" type="date" @change="checkIfDateIsValid(detail.date, index)" v-model="detail.date" :name="'Movement[MovementDetails]' + '[' + index + '][date]'" />
                            </div>
                            <div class="col-md-6">
                                <label for=""><strong>Beneficiario</strong></label>
                                <treeselect v-model="detail.beneficiary" :multiple="false" placeholder="[SELECCIONE]" :name="'Movement[MovementDetails]' + '[' + index + '][beneficiary]'" :options="options" />
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for=""><strong>Concepto</strong></label>
                            <div class="col-md-12">
                                <textarea class="form-control" v-model="detail.concept" :name="'Movement[MovementDetails]' + '[' + index + '][concept]'" placeholder="Ingresa el concepto" id="floatingTextarea"></textarea>
                            </div>
                        </div>
                        <br>
                    </div>
                    <br>

                    <p class="form-control bg-light" style="margin-bottom: 0px">
                        <i><strong>Detalles</strong></i>
                    </p>

                    <div class="container-fluid border">
                        <table class="table table-borderless table-striped table-sm">
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
                                <td><treeselect v-model="sub_detail.activity" :name="'Movement[MovementDetails]' + '[' + index + '][MovementSubDetails][' + indexSubDetail + '][sub_category_id]'" :multiple="false" placeholder="[SELECCIONE]" :options="activity_options"></treeselect></td>
                                <td><treeselect v-model="sub_detail.class" :name="'Movement[MovementDetails]' + '[' + index + '][MovementSubDetails][' + indexSubDetail + '][class_id]'" :multiple="false" placeholder="[SELECCIONE]" :options="class_options" /></td>
                                <td><treeselect v-model="sub_detail.account" :name="'Movement[MovementDetails]' + '[' + index + '][MovementSubDetails][' + indexSubDetail + '][chart_account_id]'" :multiple="false" placeholder="[SELECCIONE]" :options="account_options" /></td>
                                <td><input type="number" class="form-control" :name="'Movement[MovementDetails]' + '[' + index + '][MovementSubDetails][' + indexSubDetail + '][amount]'"  v-model="sub_detail.amount"></td>
                                <td> <a v-on:click="deleteSubItem(indexSubDetail, index)"><i class="btn btn-sm btn-danger">Eliminar</a></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <th scope="row">Total: {{ sumAmount(detail.sub_details) }}</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <p>
                        <br>
                        <button @click="addNewSubCategory(index)" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp;Agregar Detalle</button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <p>
        <button class="btn btn-sm btn-primary" href="#" v-on:click="addDetail">
            <i class="fa fa-plus"></i>&nbsp; Agregar Movimiento
        </button>
    </p>

</div>

