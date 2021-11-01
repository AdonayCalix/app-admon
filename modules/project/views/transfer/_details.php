<?php

use webvimark\modules\UserManagement\components\GhostHtml;

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos' => \yii\web\View::POS_END]);

?>

<div class="accordion" id="accordionDetail">
    <div v-for="(item, index) in items" class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                <strong>Detalle No. {{ index + 1}}</strong>
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
             data-bs-parent="#accordionDetail">
            <div class="accordion-body">
                <input type="text" name="concept[]" class="form-control" placeholder="Concepto">
                <input type="text" name="benefiaciary[]" class="form-control" placeholder="Beneficiario">
                <input type="text" name="type[]" class="form-control" placeholder="Tipo Moviemiento">
                <input type="number" name="amount[]" class="form-control" placeholder="Monto">
            </div>
        </div>
    </div>

    <br>

    <button id="btnDetail" class="btn btn-info" href="#" v-on:click="addDetail">
        <i class="align-middle" data-feather="check-plus"></i>
        Agregar Detalle
    </button>

</div>
