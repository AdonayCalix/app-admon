<div id="detail">
    <p class="form-control bg-light" style="margin-bottom: 0px">
        <i><strong>Detalle del Lote</strong></i>
    </p>

    <div class="container-fluid border">
        <table class="table table-borderless table-striped table-sm">
            <thead>
            <tr>
                <th scope="col" width="2%">#</th>
                <th scope="col" width="35%">Recibido Por</th>
                <th scope="col" width="35%">Memo</th>
                <th scope="col" width="20%">Monto</th>
                <th scope="col" width="20%"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(detail, index) in details">
                <th scope="row">{{ index + 1 }}</th>
                <td style="display:none;"><input type="hidden" v-model="detail.id" :name="'VoluntaryContributionDetails' + '[' + index + '][id]'"></td>
                <td><treeselect v-model="detail.beneficiary" :name="'VoluntaryContributionDetails' + '[' + index + '][beneficiary_id]'" :multiple="false" placeholder="[SELECCIONE]" :options="beneficiaries_options" /></td>
                <td><input type="text" :name="'VoluntaryContributionDetails' + '[' + index + '][memo]'" v-model="detail.memo" class="form-control"></td>
                <td><money  v-bind="money" class="form-control" :name="'VoluntaryContributionDetails' + '[' + index + '][amount]'"  v-model="detail.amount"></money></td>
                <td> <a v-on:click="deleteDetail(index)"><i class="btn btn-danger btn-sm"><i class="fa fa-trash small"></i> Eliminar</a></td>
            </tr>
            </tbody>
        </table>
    </div>

    <br>
    <p>
        <button @click="addDetail" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp;Agregar</button>
    </p>
</div>