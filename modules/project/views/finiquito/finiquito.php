<br>
<br>
<br>
<br>

<div class="row">
    <div class="col-md-12">
        <h4 class="text-center"><strong><u>FINIQUITO</u></strong></h4>
    </div>

    <br>
    <br>
    <div class="col-md-12">
        <p class="text-justify">
            Por este acto dejo constancia de haber recibido a entera conformidad la cantidad de
            L<?= number_format($resumen['total'], '2', '.', ',') ?>(
            <?= (new \Luecano\NumeroALetras\NumeroALetras())->toString($resumen['total']) ?>
            ) por la cancelación de todos mis beneficios
            laborales ( Auxilio de Cesantía, Vacaciones, Décimo Tercer Mes y Décimo Cuarto mes de Salario todos
            proporcionales.
        </p>
    </div>

    <br>

    &nbsp;&nbsp;
    <div class="col-md-12">
        <table  class="table" style="border: 1px solid black;border-collapse: collapse">
            <tr style="border: 1px solid black;border-collapse: collapse">
                <th width="5%" style="border: 1px solid black;border-collapse: collapse">No</th>
                <th width="45%" style="border: 1px solid black;border-collapse: collapse">CONCEPTO</th>
                <th width="35%" style="border: 1px solid black;border-collapse: collapse">LEMPIRAS</th>
            </tr>
            <tr style="border: 1px solid black;border-collapse: collapse">
                <th style="border: 1px solid black;border-collapse: collapse">1</th>
                <th style="border: 1px solid black;border-collapse: collapse">Auxilio de Cesantía</th>
                <th style="border: 1px solid black;border-collapse: collapse"><?= number_format($resumen['cesantia'], 2, '.', ',') ?></th>
            </tr>
            <tr style="border: 1px solid black;border-collapse: collapse">
                <th style="border: 1px solid black;border-collapse: collapse">2</th>
                <th style="border: 1px solid black;border-collapse: collapse">Décimo Tercer mes Proporcional</th>
                <th style="border: 1px solid black;border-collapse: collapse"><?= number_format($resumen['treaceavo'], 2, '.', ',') ?></th>
            </tr>
            <tr style="border: 1px solid black;border-collapse: collapse">
                <th style="border: 1px solid black;border-collapse: collapse">3</th>
                <th style="border: 1px solid black;border-collapse: collapse">Décimo Cuarto mes Proporcional</th>
                <th style="border: 1px solid black;border-collapse: collapse"><?= number_format($resumen['catorceavo'], 2, '.', ',') ?></th>
            </tr>
            <tr style="border: 1px solid black;border-collapse: collapse">
                <th style="border: 1px solid black;border-collapse: collapse"></th>
                <th style="border: 1px solid black;border-collapse: collapse"><strong>TOTAL</strong></th>
                <th style="border: 1px solid black;border-collapse: collapse"><strong><?= number_format($resumen['total'], 2, '.', ',') ?></strong></th>
            </tr>
        </table>
    </div>
    <br>
    <br>

    <div class="col-md-12">
        <p class="text-justify">
            Y demás otorgamientos suscritos y de la Ley Laboral, tanto completos como proporcionales. De esta manera
            libero y exonero de toda responsabilidad laboral y legal presente, pasada y futura de la Empresa.
        </p>
        <p class="text-justify">
            Razón por la cual doy fe, en la ciudad de La Ceiba, Atlántida, Honduras C.A. a los treinta y un días del mes
            de julio del año Dos Mil veinte y dos.
        </p>
    </div>

    <br>
    <br>
    <div class="col-md-12">
        <p class="text-center"><strong>______________________________</strong></p>
        <p class="text-center"><strong><?= $nombre['colaborador'] ?></strong></p>
        <p class="text-center"><strong>I.D. <?= $identidad ?></strong></p>
    </div>

</div>