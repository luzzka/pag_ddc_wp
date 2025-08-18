<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

// traer id
$id_comunicado = $_GET["id"];

$row = '';
$result2 = '';

if ($conexion_i->conectar()) {

    $result = $conexion_i->get_comunicado($id_comunicado);
    $result2 = $conexion_i->get_fanexos($id_comunicado);

    $conexion_i->desconectar();

    if (!$result) $conexion_i->redirigir_con_mensaje('index.php',1,'Error al obtener la data');

    // asignar data a row
    $row = mysqli_fetch_row($result);
}
else
{
    $conexion_i->redirigir_con_mensaje('index.php',1,'Error al obtener la data');
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <title>Editar Comunicado</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/principal.css">

    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/alertify.default.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css" />
</head>
<body>

<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-tablet"></div>

    <form id="formulario" action="actualiza_comunicado.php" class="mdl-cell mdl-cell--8-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" enctype="multipart/form-data" method="post">

        <input type="hidden" name="id" value="<?php echo $row[0] ?>">

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="titulo-comunicado" name="titulo-comunicado" value="<?php echo $row[2]; ?>">
            <label class="mdl-textfield__label" for="titulo-comunicado">Título de Comunicado</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield">
            <textarea class="mdl-textfield__input" type="text" rows= "3" id="detalle" name="detalle" ><?php echo $row[3]; ?></textarea>
            <label class="mdl-textfield__label" for="detalle">Detalle del Comunicado...</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <label >Estado de Publicaci&oacute;n</label>
            <select name="estado" id="estado">
                <option value="1" <?php echo $row[5] == 1 ? 'selected' : '' ?>>PUBLICADO</option>
                <option value="0" <?php echo $row[5] == 0 ? 'selected' : '' ?>>NO PUBLICADO</option>
            </select>
        </div>

        <?php

        echo '<hr>
                <div class="nuevo-field">
                    <button id="add">
                        <i class="material-icons">add_circle_outline</i>
                    </button>
                    <div class="mdl-tooltip" for="add">
                        A&ntilde;adir
                    </div>
                </div>';
        echo '<input id="deleted" name="deleted" type="hidden" value="">';
        echo '<div class="adjuntos">';
        if (mysqli_num_rows($result2) > 0) {

            $i=0;

            while ($row1 = mysqli_fetch_array($result2, MYSQLI_NUM)) {

                echo '<div id="'.$row1[0].'">';

                // echo '<input id="enlace_'.$i.'" type="file" name="enlace[]" accept="application/pdf" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" disabled/>
                //     <label for="enlace_'.$i.'"><i class="material-icons">file_upload</i><span>'.$row1[2].'</span></label>';

                $icon = 'info-icon.png';

                switch ($row1[1]) {
                    case 'pdf':
                        $icon = 'pdf-file.png';
                        break;
                    case 'doc':
                    case 'docx':
                        $icon = 'word-file.png';
                        break;
                    case 'xls':
                    case 'xlsx':
                        $icon = 'excel-file.png';
                        break;
                    default:
                        $icon = 'info-icon.png';
                        break;
                }

                echo '<label for="enlace_'.$i.'"><img src="../../../../documentos/images/'.$icon.'" > <span>'.$row1[2].'</span></label>';


                echo '<button id="'.$i.'" class="eliminar" tabindex="0">
                            <i class="material-icons">cancel</i>
                        </button>
                        <span class="mdl-tooltip" for="'.$i.'" data-upgraded=",MaterialTooltip">Eliminar</span>
                    </div>';

                $i++;
            }
        }
        echo '</div>';
        ?>

        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" type="submit">
            Guardar
        </button>
        &nbsp;
        <button id="cancelar" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
            Cancelar
        </button>
    </form>

    <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-tablet"></div>
</div>

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/alertify.min.js"></script>
<script>
    $(document).ready(function(){

        var i = 0;

        var adjuntosDIV = $('.adjuntos');

        var eliminados = [];

        function inp (){
            // INPUTS TYPE FILE
            var inputs = document.querySelectorAll( '.inputfile' );
            Array.prototype.forEach.call( inputs, function( input )
            {
                var label	 = input.nextElementSibling,
                    labelVal = label.innerHTML;

                input.addEventListener( 'change', function( e )
                {
                    var fileName = '';
                    if( this.files && this.files.length > 1 )
                        fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                    else
                        fileName = e.target.value.split( '\\' ).pop();

                    if( fileName )
                        label.querySelector( 'span' ).innerHTML = fileName;
                    else
                        label.innerHTML = labelVal;
                });
            });
        }

        $('#add').click(function (e) {

            e.preventDefault();

            plantilla2 = '<div><input type="hidden" name="ids[]" value="-1"><input id="enlace'+i+'" type="file" name="enlace[]" accept="application/pdf" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" /><label for="enlace'+i+'"><i class="material-icons">file_upload</i><span>Elije el Enlace</span></label><button id="'+i+'" class="eliminar" ><i class="material-icons">cancel</i></button><span class="mdl-tooltip" for="'+i+'">Eliminar</span></div>';

            var el = $(plantilla2);

            el.find('.eliminar').click(function(e) {

                e.preventDefault();

                alertify.confirm(
                    'Web - DDC Cusco',
                    '&iquest;Est&aacute; seguro de retirar este elemento?',
                    function() {
                        el.remove();
                        alertify.success('Elemento Retirado');
                    },
                    function(){
                        // -- NO
                    }).set('maximizable', false)
                    .set('labels', {ok:'Si', cancel:'No'});

            });

            el.appendTo(adjuntosDIV);

            inp();

            i++;

            componentHandler.upgradeDom();

        })<?php echo !mysqli_num_rows($result2) > 0 ? '.click()' : '' ?>;

        $('#cancelar').click(function(e) {
            e.preventDefault();

            alertify.confirm(
                'Web - DDC Cusco',
                '&iquest;Est&aacute; seguro de descartar este formulario?',
                function() {
                    window.location.replace("index.php");
                },
                function(){
                    // alertify.error('Cancel')
                    // return false;
                }).set('maximizable', false)
                .set('labels', {ok:'Si', cancel:'No'});

        });

        adjuntosDIV.find('button.eliminar').click(function (e) {
            e.preventDefault();

            let boton = $(this);
            let id_fila = boton.parent().attr('id');

            alertify.confirm(
                'Web - DDC Cusco',
                '&iquest;Est&aacute; seguro de retirar este elemento?',
                function() {

                    eliminados = eliminados.concat(id_fila);

                    // asign data for eliminados to input hidden
                    $('#deleted').attr('value', eliminados);

                    $("#"+id_fila).remove();

                    alertify.success('Elemento Retirado');
                },
                function(){
                    // -- NO
                }).set('maximizable', false)
                .set('labels', {ok:'Si', cancel:'No'});

        });

    });
</script>
</body>
</html>
