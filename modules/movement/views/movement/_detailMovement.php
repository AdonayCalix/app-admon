<div class="row">
    <div class="col-md-4">
        <label for=""><strong>Fecha</strong></label>
        <input class="form-control" type="text" v-model="detail.date" @input="checkIfDateIsValid" name="date[]" placeholder="Fecha">
    </div>
    <div class="col-md-4">
        <label for=""><strong>Beneficiario</strong></label>
        <treeselect v-model="detail.beneficiary" :multiple="false" placeholder="[SELECCIONE]" name="beneficiary[]" :options="options" />
    </div>
    <div class="col-md-4">
        <label for=""><strong>Tipo Movimiento</strong></label>
        <treeselect v-model="detail.kind" :multiple="false" placeholder="[SELECCIONE]" name="kind[]" :options="kindOptions" />
    </div>
</div>
<br>
<div class="row">
    <label for=""><strong>Concepto</strong></label>
    <div class="col-md-12">
        <textarea class="form-control" v-model="detail.concept" placeholder="Ingresa el concepto" id="floatingTextarea"></textarea>
    </div>
</div>