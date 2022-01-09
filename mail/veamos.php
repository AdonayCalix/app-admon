<style>
    font-family:

    'Roboto'
    ,
    sans-serif

    ;
</style>

<p>Buenos noches estimada(o) <?= $name ?>.</p>

<p><strong>Recordatorio de evaluaciones pendientes de realizar.</strong></p>

<strong>Credenciales de acceso</strong>.<br>
<i>Direccion: <?= \yii\helpers\Html::a('ED360', 'https://ceprosaf.org/Evaluacion360') ?> </i><br>
<i>Usuario: <?= $email ?></i><br>
<i>Contraseña: <?= $password ?></i>

<p><strong>Indicaciones</strong></p>
<ol>
    <li value="1">Ingrese al enlace de la direccion del sitio.</li>
    <li>Use las credenciales que se indican en este correo.</li>
    <li>Una vez se ha ingresado, visualizara las evaluaciones asignadas.</li>
    <li>Debera de dar clic en el boton que dice evaluar.</li>
    <li>Se le mostrara la ficha de evaluacion, debera de responder cada pregunta de forma objetiva.</li>
    <li>Cuando conteste todas las preguntas debe de dar clic en el boton de guardar.</li>
    <li>Repetir los pasos del <strong>4 al 6</strong> con las evaluaciones restantes.</li>
</ol>

<p>Este es un correo generado de forma automatica, favor no responderlo. En caso de tener alguna duda remitirse con
    la Unidad de M&E.</p>


