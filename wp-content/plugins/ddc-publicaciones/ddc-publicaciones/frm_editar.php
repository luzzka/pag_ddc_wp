<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

if ( $conexion_i->verifica_loggeo() ) {

// -- METODOS --
function redirigir_con_mensaje ($page, $type, $message) {
    $_SESSION['message'] = [$type, $message];
    header('Location: ' . $page);
    exit;
}

$id_publicacion = $_GET["id"];

$row = '';

if ($conexion_i->conectar()) {

    $result = $conexion_i->lista_publicacion($id_publicacion);
    $conexion_i->desconectar();

    if ($result) {
        if ($result->num_rows > 0) {
            // asignar data a row
            $row = mysqli_fetch_row($result);
        } else redirigir_con_mensaje('index.php',1,'Error: No existe elemento');
    } else redirigir_con_mensaje('index.php',1,'Ocurrio un error al obtener la data');
} else redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al conectar con la BD');

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="UTF-8">
    <title>Edita Publicación</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/alertify.default.min.css">

    <link rel="stylesheet" href="css/bootstrap-material-datetimepicker.css" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css" />
</head>
<body>

<div class="mdl-grid">

    <div class="mdl-cell mdl-cell--3-col mdl-cell--1-col-tablet"></div>
    <form id="formulario" action="actualiza_publicacion.php" class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" enctype="multipart/form-data" method="post">

        <input type="hidden" name="id_publicacion" value="<?php echo $row[0]; ?>">

        <div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-control-wrapper">
                        <input type="text" id="date" name="date" class="form-control floating-label" placeholder="Fecha de Publicación" value="<?php echo $row[5] ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="nombre" name="nombre" value="<?php echo $row[2] ?>">
            <label class="mdl-textfield__label" for="nombre">Nombre de la Publicación</label>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="enlace" name="enlace" value="<?php echo $row[3] ?>">
            <label class="mdl-textfield__label" for="enlace">Enlace Externo (URL)</label>
        </div>

        <div>
            <div class="row">
                <div class="col-md-6">
                    <img id="img" src="<?php if (is_null($row[1]) || $row[1] == '') echo '/dmdocuments/ddc-publicaciones/img/sin_imagen.jpg'; else echo "/dmdocuments/ddc-publicaciones/img/$row[1]"; ?>" alt="" style="max-height: 180px">
                </div>
            </div>
        </div>

        <br>

        <div>
            <div class="row">
                <div class="col-md-6">
                    <input id="imagen" type="file" name="imagen" accept="image/x-png,image/jpeg" />
                </div>
            </div>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input id="documento" type="file" name="documento" accept="application/pdf" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" />
            <label for="documento">
                <i class="material-icons">file_upload</i>
                <?php
                    $enlace = $row[4];
                    if ( $enlace == '' || is_null($enlace) ){
                        $enlace = 'Seleccionar PDF';
                    }
                ?>
                <span><?php echo $enlace ?></span>
            </label>
        </div>

        <button id="guardar" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" type="submit">
            Guardar
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

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
<!--<script type="text/javascript" src="https://rawgit.com/FezVrasta/bootstrap-material-design/master/dist/js/material.min.js"></script>-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/bootstrap-material-design.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/ripples.min.css"/>

<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="js/bootstrap-material-datetimepicker.js"></script>

<script src="js/alertify.min.js"></script>

<script src="js/getmdl-select.min.js"></script>

<script>
    $(document).ready(function(){

        $('#date').bootstrapMaterialDatePicker({
            time: false,
            clearButton: true
        });

        $('#guardar').click(function (e) {
            e.preventDefault();

            let boton = $(this);
            let formulario = boton.parent();

            let seleccion = $('.mdl-tabs__tab.is-active').text();
            $('#tipo').attr("value", seleccion);

            if ( seleccion === 'Enlace' ) {
                // eliminar
                document.getElementById("documento").value = "";

                formulario.submit();
            }
            else {

                if(document.getElementById("documento").value !== "") {
                    if ( $('#documento')[0].files[0].size > 15728640 ) {
                        // documento excede el límite de 15 mb

                        alertify.alert('Web - DDC Cusco',
                            'El tamaño del archivo que intenta adjuntar supera el límite de 15 MB, por favor seleccione un archivo de menor tamaño y vuelva a intentarlo.');

                    }
                    else {
                        formulario.submit();
                    }
                }
                else {
                    formulario.submit();
                }

            }

        });

        // Cancelar
        $('#cancelar').click(function(e) {
            e.preventDefault();

            // comprobar iterando en los input text
            var elements = document.getElementById("formulario").elements;

            var comprueba = false;

            for (var i = 0, element; element = elements[i++];) {
                if ( element.name === "titulo" ||
                    element.name === "enlace" ||
                    element.name === "documento" ) {

                    console.log(element.name);

                    if (element.value !== '')
                    {
                        comprueba = true;
                        break;
                    }
                }
            }

            if (comprueba) {

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

            }
            else {
                window.location = 'index.php';
            }

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

        // Cambiar imagen de miniatura al seleccionarla
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imagen").change(function(){
            readURL(this);
        });

    });
</script>
</body>
</html>

<?php } ?>