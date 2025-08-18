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

$id_disposicion = $_GET["id"];

$row = "";

if ($conexion_i->conectar()) {

    $result = $conexion_i->lista_disposicion($id_disposicion);
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
    <title>Editar Disposicion</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css" />

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/principal.css">

    <!--<link rel="stylesheet" href="css/getmdl-select.min.css">-->

    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/alertify.default.min.css">
</head>
<body>

<div class="mdl-grid">

    <div class="mdl-cell mdl-cell--3-col mdl-cell--1-col-tablet"></div>
    <form action="actualiza_disposicion.php" class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" enctype="multipart/form-data" method="post">
        <input type="hidden" id="id_disposicion" name="id_disposicion" value="<?php echo $row[0];?>">

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
            <input class="mdl-textfield__input" type="text" id="tipo-disposicion" name="tipo-disposicion" value="<?php
            $tipo = '';
            switch ($row[3]) {
                case 0:
                    $tipo = 'Resolución Directoral';
                    break;
                case 1:
                    $tipo = 'Resolución Ministerial';
                    break;
                case 2:
                    $tipo = 'Directiva';
                    break;
                case 3:
                    $tipo = 'Cira';
                    break;
                default:
                    $tipo = 'Resolución Directoral';
                    break;
            }
            echo $tipo; ?>" readonly tabIndex="-1">
            <label for="tipo-disposicion" class="mdl-textfield__label">Tipo</label>
            <ul for="tipo-disposicion" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                <li class="mdl-menu__item">Resolución Directoral</li>
                <li class="mdl-menu__item">Resolución Ministerial</li>
                <li class="mdl-menu__item">Directiva</li>
                <li class="mdl-menu__item">Cira</li>
            </ul>
        </div>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select">
            <input class="mdl-textfield__input" type="text" id="ano" name="ano" value="<?php
            // $ano = $row[4];
            // switch ($row[4]) {
            //     case 2017:
            //         $ano = '2017';
            //         break;
            //     case 2016:
            //         $ano = '2016';
            //         break;
            //     case 2015:
            //         $ano = '2015';
            //         break;
            //     case 2014:
            //         $ano = '2014';
            //         break;
            //     default:
            //         $tipo = '2017';
            //         break;
            // }
            echo $row[4]; ?>" readonly tabIndex="-1">
            <label for="ano" class="mdl-textfield__label">Año</label>
            <ul for="ano" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                <li class="mdl-menu__item">2019</li>
                <li class="mdl-menu__item">2018</li>
                <li class="mdl-menu__item">2017</li>
                <li class="mdl-menu__item">2016</li>
                <li class="mdl-menu__item">2015</li>
                <li class="mdl-menu__item">2014</li>
            </ul>
        </div>

        <div class="mdl-textfield mdl-js-textfield">
            <textarea class="mdl-textfield__input" type="text" rows= "3" id="titulo" name="titulo"><?php echo $row[1] ?></textarea>
            <label class="mdl-textfield__label" for="titulo">Título</label>
        </div>

        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar">
                <input type="hidden" id="tipo" name="tipo" value="Enlace">
                <a href="#enlace-panel" class="mdl-tabs__tab <?php if ($row[7] == 'url') {echo 'is-active';} ?>">Enlace</a>
                <a href="#adjuntar-panel" class="mdl-tabs__tab <?php if ($row[7] != 'url') {echo 'is-active';} ?>">Adjuntar Documento</a>
            </div>

            <?php

            if ($row[7] == 'url')
            {
                echo '<div class="mdl-tabs__panel is-active" id="enlace-panel">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="enlace" name="enlace" value="'.$row[8].'">
                    <label class="mdl-textfield__label" for="enlace">Direcci&oacute;n (URL)</label>
                </div>
            </div>
            <div class="mdl-tabs__panel" id="adjuntar-panel">
                <div class="direnlace">
                    <input id="documento" type="file" name="documento" accept="application/pdf" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" />
                    <label for="documento">
                        <i class="material-icons">file_upload</i>
                        <span>Elije el Documento</span>
                    </label>
                </div>
            </div>';
            }
            else
            {
                echo '<div class="mdl-tabs__panel" id="enlace-panel">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="enlace" name="enlace">
                    <label class="mdl-textfield__label" for="enlace">Direcci&oacute;n (URL)</label>
                </div>
            </div>
            <div class="mdl-tabs__panel is-active" id="adjuntar-panel">
                <div class="direnlace">
                    <input id="documento" type="file" name="documento" accept="application/pdf" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" />
                    <label for="documento">
                        <i class="material-icons">file_upload</i>';
                if (is_null($row[8]) || $row[8] == '') echo '<span>Sin Documento</span>';
                else echo '<span>'.$row[8].'</span>';

                echo '</label>
                        </div>
                    </div>';
            }
            ?>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                <input class="mdl-textfield__input" type="text" id="estado" name="estado" value="<?php
                $estado = '';
                switch ($row[6]) {
                    case 1:
                        $estado = 'PUBLICADO';
                        break;
                    case 0:
                        $estado = 'NO PUBLICADO';
                        break;
                    default:
                        $estado = 'NO PUBLICADO';
                        break;
                }
                echo $estado; ?>" readonly tabIndex="-1">
                <label for="estado" class="mdl-textfield__label">Estado</label>
                <ul for="estado" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                    <li class="mdl-menu__item">PUBLICADO</li>
                    <li class="mdl-menu__item">NO PUBLICADO</li>
                </ul>
            </div>
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

<script src="js/alertify.min.js"></script>
<script src="js/getmdl-select.min.js"></script>

<script>
    $(document).ready(function(){

        $('#guardar').click(function (e) {
            e.preventDefault();

            var boton = $(this);
            var formulario = boton.parent();

            var seleccion = $('.mdl-tabs__tab.is-active').text();
            $('#tipo').attr("value", seleccion);

            // si existe un nuevo archivo a subir

            if ( $('#tipo').val() === 'Adjuntar Documento' && $('#documento').val() !== '' ) {

                var id_disposicion = $('#id_disposicion').val();
                var nombre_archivo = $('#documento').next().children().eq(1).text();
                nombre_archivo = nombre_archivo.toUpperCase().replace(' ','_');

                if ( id_disposicion !== '' ) {
                    $.ajax({
                        url:"file_exists.php",
                        method:"POST",
                        data: {
                            "id_disposicion":id_disposicion,
                            "nombre_archivo":nombre_archivo
                        },
                        datatype:"JSON",
                        success:function (data) {

                            var resultados = JSON.parse(data);

                            if (resultados.tipo_documento !== 'url' &&
                                resultados.documento === nombre_archivo) {
                                alertify.confirm(
                                    'Web - DDC Cusco',
                                    '¿Existe un archivo con el mismo nombre, desea reemplazarlo?',
                                    function() {
                                        formulario.submit();
                                    },
                                    function(){
                                        // NO
                                    }).set('maximizable', false)
                                    .set('labels', {ok:'Si', cancel:'No'});
                            }
                            else {
                                formulario.submit();
                            }
                        },
                        error: function (request, status, error) {
                            // console.log(request.responseText);
                        }
                    })
                }

            }
            else {
                formulario.submit();
            }


        });

        // Cancelar
        $('#cancelar').click(function(e) {
            e.preventDefault();

           alertify.confirm(
               'Web - DDC Cusco',
               '&iquest;Est&aacute; seguro de salir sin guardar?',
               function() {
            window.location.replace("index.php");
               },
               function(){
                    // NO
               }).set('maximizable', false)
               .set('labels', {ok:'Si', cancel:'No'});

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