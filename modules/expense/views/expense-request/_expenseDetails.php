<div >
    <p class="form-control bg-light" style="margin-bottom: 0px">
        <i><strong>Alimentación</strong></i>
    </p>

    <div class="container-fluid border">
        <table class="table table-borderless table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" width="20%">Fecha</th>
                <th scope="col" width="35%">
                    Destino
                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#newPlace">
                        <i class="fa fa-plus"></i> Añadir
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="newPlace" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Destino</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" id="new-place" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="new_place" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button v-on:click="storeNewPlace" type="button" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
                <th scope="col" width="15%">Desayuno</th>
                <th scope="col" width="15%">Almuerzo</th>
                <th scope="col" width="15%">Cena</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(food_expense, index) in food_expenses">
                <th scope="row">{{ index + 1 }}</th>
                <td style="display:none;"><input type="hidden" v-model="food_expense.id" :name="'FoodExpenseRequests' + '[' + index + '][id]'"></td>
                <td><date-picker v-model="food_expense.date" :input-attr="{name: 'FoodExpenseRequests' + '[' + index + '][date]'}" format="DD/MM/YYYY" valuetype="format" lang="es"></td>
                <td><treeselect v-model="food_expense.place_id" :name="'FoodExpenseRequests' + '[' + index + '][place_id]'"  :multiple="false" placeholder="[SELECCIONE]" :options="places_options"></treeselect></td>
                <td><money v-model="food_expense.breakfast" v-bind="money" class="form-control" :name="'FoodExpenseRequests' + '[' + index + '][breakfast]'"></money></td>
                <td><money v-model="food_expense.lunch" v-bind="money" class="form-control" :name="'FoodExpenseRequests' + '[' + index + '][lunch]'"></money></td>
                <td><money v-model="food_expense.dinner" v-bind="money" class="form-control"  :name="'FoodExpenseRequests' + '[' + index + '][dinner]'" ></money></td>
                <td> <a v-on:click="deleteFoodExpense(index)"><i class="btn btn-sm btn-danger">Eliminar</a></td>
            </tr>
            </tbody>
        </table>
        <p>
            <button @click="addNewFoodExpense()" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp;Agregar</button>
        </p>
    </div>

    <br>

    <p class="form-control bg-light" style="margin-bottom: 0px">
        <i><strong>Otros Gastos</strong></i>
    </p>

    <div class="container-fluid border">
        <table class="table table-borderless table-striped table-sm">
            <thead>
            <tr>
                <th scope="col" width="2%">#</th>
                <th scope="col" width="30%">
                    Gasto
                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-plus"></i> Añadir
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Gasto</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" id="new_expense" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="new_beneficiary" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button v-on:click="storeNewExpense" type="button" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
                <th scope="col" width="20%">Monto</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(other_expense, index) in other_expenses">
                <th scope="row">{{ index + 1 }}</th>
                <td style="display:none;"><input type="hidden" v-model="other_expense.id" :name="'ExpenseRequestDetails' + '[' + index + '][id]'"></td>
                <td><treeselect v-model="other_expense.expense_id" :name="'ExpenseRequestDetails' + '[' + index + '][advance_detail_id]'" :multiple="false" placeholder="[SELECCIONE]" :options="advance_details"></treeselect></td>
                <td><money  v-bind="money" class="form-control" :name="'ExpenseRequestDetails' + '[' + index + '][amount]'" v-model="other_expense.amount"></money></td>
                <td> <a v-on:click="deleteOtherExpense(index)"><i class="btn btn-sm btn-danger">Eliminar</a></td>
            </tr>
            </tbody>
        </table>
        <p>
            <button @click="addNewOtherExpense()" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp;Agregar</button>
        </p>
    </div>
    <br>
</div>