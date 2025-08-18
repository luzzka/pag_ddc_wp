<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

// -- METODOS --
function redirigir_con_mensaje ($page, $type, $message) {
    $_SESSION['message'] = [$type, $message];
    header('Location: ' . $page);
    exit;
}

$id_base = $_GET["id_base"];

$row = "";

if ($conexion_i->conectar()) {

    $result = $conexion_i->lista_base($id_base);
    $conexion_i->desconectar();

    if ($result) {
        if ($result->num_rows > 0) {
            // asignar data a row
            $row = mysqli_fetch_row($result);
        }
        else redirigir_con_mensaje('bases.php',1,'Error: No existe elemento');
    }
    else redirigir_con_mensaje('bases.php',1,'Ocurrio un error al obtener la data');
}
else redirigir_con_mensaje('bases.php', 1, 'Ocurrio un error al conectar con la BD');

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <title>Editar Base</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css" />

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/principal.css">

    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/alertify.default.min.css">
</head>
<body>

<div class="mdl-grid">

    <div class="mdl-cell mdl-cell--3-col mdl-cell--1-col-tablet"></div>
    <form action="actualizar_base.php" class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" enctype="multipart/form-data" method="post">
        <input type="hidden" name="id_base" value="<?php echo $row[0];?>">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="titulo" name="titulo" value="<?php echo $row[4]; ?>">
            <label class="mdl-textfield__label" for="titulo">Nombre de la Base</label>
        </div>

        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar">
                <input type="hidden" id="tipo" name="tipo" value="Enlace">
                <a href="#enlace-panel" class="mdl-tabs__tab <?php if ($row[6] == 1) {echo 'is-active';} ?>">Enlace</a>
                <a href="#adjuntar-panel" class="mdl-tabs__tab <?php if ($row[6] == 0) {echo 'is-active';} ?>">Adjuntar Documento</a>
            </div>

            <?php

            if ($row[6] == 1) {
                echo '<div class="mdl-tabs__panel is-active" id="enlace-panel">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="enlace" name="enlace" value="'.$row[7].'">
                            <label class="mdl-textfield__label" for="enlace">Dirección del Enlace</label>
                        </div>
                    </div>
                    <div class="mdl-tabs__panel" id="adjuntar-panel">
                        <div class="direnlace">
                            <input id="documento" type="file" name="documento" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" />
                            <label for="documento">
                                <i class="material-icons">file_upload</i>
                                <span>Elije el Documento</span>
                            </label>
                        </div>
                    </div>';
            }
            else {
                echo '<div class="mdl-tabs__panel" id="enlace-panel">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="enlace" name="enlace"">
                            <label class="mdl-textfield__label" for="enlace">Dirección del Enlace</label>
                        </div>
                    </div>
                    <div class="mdl-tabs__panel is-active" id="adjuntar-panel">
                        <div class="direnlace">
                            <input id="documento" type="file" name="documento" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" />
                            <label for="documento">
                                <i class="material-icons">file_upload</i>';

                if (is_null($row[7]) || $row[7] == '') echo '<span>Sin Documento</span>';
                else echo '<span>'.$row[7].'</span>';

                echo '</label>
                        </div>
                    </div>';
            }
            ?>

        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <label >Estado de Publicación</label>
            <select name="estado" id="estado">
                <option value="1" <?php if ($row[5] == "1") echo 'selected'; ?>>PUBLICADO</option>
                <option value="0" <?php if ($row[5] == "0") echo 'selected'; ?>>NO PUBLICADO</option>
            </select>
        </div>

        <button id="guardar" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" type="submit">
            Actualizar
        </button>
        &nbsp;
        <button id="cancelar" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
            Cancelar
        </button>
    </form>
    <div class="mdl-cell mdl-cell--3-col mdl-cell--1-col-tablet"></div>
</div>

<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){

        $('#guardar').click(function (e) {
            e.preventDefault();

            var boton = $(this);
            var formulario = boton.parent();

            var seleccion = $('.mdl-tabs__tab.is-active').text();
            $('#tipo').attr("value", seleccion);

            formulario.submit();
        });

        // Cancelar
        $('#cancelar').click(function(e) {
            e.preventDefault();

//            alertify.confirm(
//                'Web - DDC Cusco',
//                '&iquest;Est&aacute; seguro de salir sin guardar?',
//                function() {
            window.location.replace("bases.php");
//                },
//                function(){
//                     NO
//                }).set('maximizable', false)
//                .set('labels', {ok:'Si', cancel:'No'});

        });

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

        inp();
    });
</script>
</body>
</html>