<?php

session_start();
include("conectar_i.php");

date_default_timezone_set('America/Lima');

$conexion_i = new ConnectDB();

if ($conexion_i->verifica_loggeo()) {

// Filtros
$f_ano = '';
$txt_b = '';

$histo = false;

if ( isset($_GET["select-ano"]) &&
     isset($_GET["txt-busqueda"]) ) {

    $f_ano = $_GET["select-ano"];
    $txt_b = $_GET["txt-busqueda"];

    $histo = true;
}


if ($conexion_i->conectar()) {
    $result = $conexion_i->lista_publicaciones($f_ano, $txt_b);
    $conexion_i->desconectar();
    ?>

    <!DOCTYPE html>
    <html lang="es-ES">
    <head>
        <title>Administración de Publicaciones</title>

        <meta charset="UTF-8">

        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css">

        <link rel="stylesheet" href="css/principal.css">

        <link rel="stylesheet" href="css/alertify.min.css">
        <link rel="stylesheet" href="css/alertify.default.min.css">
    </head>
    <body>

    <br>

    <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">

        <div class="mdl-grid">

            <div class="mdl-cell mdl-cell--12-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp descripcion">

                <div class="mdl-grid">

                    <form id="barra-de-busqueda" method="get">

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select">
                            <input class="mdl-textfield__input" type="text" id="select-ano" name="select-ano" value="<?php echo $histo ? $f_ano:date("Y") ?>" data-val="<?php echo date("Y") ? $f_ano:date("Y") ?>" readonly tabIndex="-1">
                            <label for="select-ano" class="mdl-textfield__label">Año</label>
                            <ul for="select-ano" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">

                                <?php

                                    $years = range('2013', date("Y"));

                                    for ( $i = count($years)-1 ; $i >= 0 ; $i-- ) { ?>
                                        <li class="mdl-menu__item" data-val="<?php echo $years[$i] ?>"><?php echo $years[$i] ?></li>
                                <?php 
                                    }
                                ?>

                            </ul>
                        </div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" id="txt-busqueda" type="text" name="txt-busqueda" value="">
                            <label class="mdl-textfield__label" for="txt-busqueda">Nombre</label>
                        </div>

                        <button type="submit" class="boton-buscar buscar-disposicion mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                            <i class="material-icons">find_in_page</i> Buscar
                        </button>

                        <button id="add-publicacion" class="add-directiva mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                            <i class="material-icons">note_add</i> Agregar
                        </button>

                    </form>

                    <div class="h-scroll" style="width: 100%;margin-top: 10px; overflow-x: scroll;">
                        <table class="tabla_publicaciones mdl-data-table mdl-js-data-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                            <tr>
                                <th style="text-align: center">Fecha</th>
                                <th style="text-align: center">Imagen</th>
                                <th style="text-align: center">Nombre</th>
                                <th style="text-align: center">Enlace Externo</th>
                                <th style="text-align: center">PDF</th>
                                <th colspan="2" style="text-align: center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>

    <?php
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_row($result)) { ?>

            <tr data-id="<?php echo $row[0] ?>">
                <td style="text-align: center">
                    <?php echo $row[5] ?>
                </td>
                <td style="text-align: center">
                    <?php
                        $img = $row[1];
                        if ( $img == '' || is_null( $img ) ) $img = 'sin_imagen.jpg';
                    ?>
                    <img style="width: 14%;" src="/dmdocuments/ddc-publicaciones/img/<?php echo $img; ?>">
                </td>
                <td style="text-align: center">
                    <?php echo $row[2] ?>
                </td>
                <td style="text-align: center">
                    <?php
                        if ( $row[3] == '' || is_null( $row[3] ) ) { ?>
                            <i data-tooltip="Sin Enlace" class="material-icons">not_interested</i>
                        <?php }
                        else { ?>
                            <a class="enlace" target="_blank" href="<?php echo $row[3] ?>" data-tooltip="Ver Enlace">
                                <i class="material-icons">link</i>
                            </a>
                        <?php }
                    ?>

                </td>
                <td style="text-align: center">
                    <?php
                    if ( $row[4] == '' || is_null( $row[4] ) ) { ?>
                        <i data-tooltip="Sin PDF" class="material-icons">not_interested</i>
                    <?php }
                    else { ?>
                        <a class="pdf" href="/dmdocuments/ddc-publicaciones/<?php echo $row[4] ?>" data-tooltip="Ver PDF">
                            <i class="material-icons">attach_file</i>
                        </a>
                    <?php }
                    ?>

                </td>
                <td style="text-align: center">
                    <button class="editar inferior" data-tooltip="Editar">
                        <i class="material-icons">edit</i>
                    </button>
                </td>
                <td style="text-align: center">
                    <form action="eliminar_publicacion.php" method="post">
                        <input type="hidden" name="id_publicacion" value="<?php echo $row[0] ?>">
                        <button class="eliminar inferior" type="submit" data-tooltip="Eliminar">
                            <i id="icon-delete" class="material-icons hover">delete_forever</i>
                        </button>
                    </form>
                </td>
            </tr>


            <?php } } else {
            echo '<td colspan="7" style="text-align: center">SIN RESULTADOS</td>';
            } ?>

                            </tbody>
                        </table>
                    </div>
                    <br>
                </div>

            </div>

        </div>

    </div>

    <!-- SCRIPTS -->
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/alertify.min.js"></script>
    <script defer src="js/publicaciones.js"></script>
    <script src="js/getmdl-select.min.js"></script>
    <script>
        $(document).ready(function(){
            alertify.set('notifier','position', 'top-right');
            // Show message when this page is called from other
            <?php
            if (isset($_SESSION['message'])) {
                switch ($_SESSION['message'][0]) {
                    case 0:
                        echo 'alertify.success(\''.$_SESSION['message'][1].'\');';
                        break;
                    case 1:
                        echo 'alertify.error(\''.$_SESSION['message'][1].'\');';
                        break;
                    case 2:
                        echo 'alertify.warning(\''.$_SESSION['message'][1].'\');';
                        break;
                    case 3:
                        echo 'alertify.message(\''.$_SESSION['message'][1].'\');';
                        break;
                }
                // clear the value so that it doesn't display again
                unset($_SESSION['message']);
            }
            ?>

        });
    </script>
    </body>
    </html>

<?php } else echo 'Error al conectar con la Base de Datos'; }