<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

// is_user_logged_in
if ($conexion_i->verifica_loggeo()) {

// Filtros
    $f_tipo = '';
    $f_ano = '';
    $txt_b = '';

    $histo = false;

    if (isset($_GET["select-tipo"]) &&
        isset($_GET["select-ano"]) &&
        isset($_GET["txt-busqueda"])) {

        $f_tipo = $_GET["select-tipo"];
        $f_ano = $_GET["select-ano"];
        $txt_b = $_GET["txt-busqueda"];

        $histo = true;
    }

    $criterio_tipo = '';
    switch ($f_tipo) {
        case 'Resol. Directorales':
            $criterio_tipo = '0';
            break;
        case 'Resol. Ministeriales':
            $criterio_tipo = '1';
            break;
        case 'Directivas':
            $criterio_tipo = '2';
            break;
        case 'Ciras':
            $criterio_tipo = '3';
            break;
        default:
            $criterio_tipo = '';
            break;
    }

    $criterio_ano = $f_ano;

    if ($criterio_ano == '') {
        $criterio_ano = date("Y");
    }

//switch ($f_ano){
//case '2017':
//        $criterio_ano = '2017';
//        break;
//    case '2016':
//        $criterio_ano = '2016';
//        break;
//    case '2015':
//        $criterio_ano = '2015';
//        break;
//    case '2014':
//        $criterio_ano = '2014';
//        break;
//    default:
//        $criterio_ano = '2017';
//        break;
//}

    $tb = '';
    if ($txt_b != '' && !is_null($txt_b)) {
        $tb = $txt_b;
    }

    if ($conexion_i->conectar()) {
        $result = $conexion_i->lista_disposiciones_emitidas($criterio_tipo, $criterio_ano, $tb);
        $conexion_i->desconectar();
        ?>

        <!DOCTYPE html>
        <html lang="es-ES">
        <head>
            <title>Administracion de Disposiciones Emitidas</title>

            <meta charset="UTF-8">

            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
            <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css">

            <link rel="stylesheet" href="css/principal.css">
            <!--<link rel="stylesheet" href="css/style.css">-->

            <!--<link rel="stylesheet" href="css/getmdl-select.min.css">-->
            <!--<link rel="stylesheet" href="css/getmdl-select.css">-->

            <link rel="stylesheet" href="css/alertify.min.css">
            <link rel="stylesheet" href="css/alertify.default.min.css">
        </head>
        <body>

        <br>

        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">

            <div class="mdl-grid">
                <!--<div class="mdl-cell mdl-cell--1-col mdl-cell--1-col-tablet"></div>-->

                <div class="mdl-cell mdl-cell--12-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp descripcion">

                    <div class="mdl-grid">

                        <form id="barra-de-busqueda" method="get">

                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select getmdl-select__fullwidth">
                                <input style="width: 176px" class="mdl-textfield__input" type="text" id="select-tipo"
                                       name="select-tipo" value="<?php echo $histo ? $f_tipo : 'Resol. Directorales' ?>"
                                       data-val="<?php echo $histo ? $f_tipo : 'Resol. Directorales' ?>" readonly
                                       tabIndex="-1">
                                <label for="select-tipo" class="mdl-textfield__label">Tipo</label>
                                <ul style="width: 176px" for="select-tipo"
                                    class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                    <li class="mdl-menu__item" data-val="Resol. Directorales">Resol. Directorales</li>
                                    <li class="mdl-menu__item" data-val="Resol. Ministeriales">Resol. Ministeriales</li>
                                    <li class="mdl-menu__item" data-val="Directivas">Directivas</li>
                                    <li class="mdl-menu__item" data-val="Ciras">Ciras</li>
                                </ul>
                            </div>

                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select">
                            <input class="mdl-textfield__input" type="text" id="select-ano" name="select-ano" value="<?php echo $histo ? $f_ano:date("Y") ?>" data-val="<?php echo date("Y") ? $f_ano:date("Y") ?>" readonly tabIndex="-1">
                                <label for="select-ano" class="mdl-textfield__label">Año</label>
                                <ul for="select-ano" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                                    <?php

                                    $years = range('2014', date("Y"));

                                    for ( $i = count($years)-1 ; $i >= 0 ; $i-- ) { ?>
                                        <li class="mdl-menu__item" data-val="<?php echo $years[$i] ?>"><?php echo $years[$i] ?></li>
                                    <?php 
                                    }
                                    ?>
                                </ul>
                            </div>

                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" id="txt-busqueda" type="text" name="txt-busqueda"
                                       value="">
                                <label class="mdl-textfield__label" for="txt-busqueda">Nombre</label>
                            </div>

                            <button type="submit"
                                    class="boton-buscar buscar-disposicion mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                                <i class="material-icons">find_in_page</i> Buscar
                            </button>

                            <button id="ordenar-disposiciones"
                                    class="ordenar-disposiciones mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                                <i class="material-icons">import_export</i> Ordenar
                            </button>

                            <button id="add-disposicion" class="add-directiva mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" disabled>
                                <i class="material-icons">note_add</i> Agregar
                            </button>

                        </form>

                        <div class="h-scroll" style="width: 100%;margin-top: 10px; overflow-x: scroll;">
                            <table class="tablaDisposiciones mdl-data-table mdl-js-data-table"
                                   style="width: 100%; border-collapse: collapse;">
                                <thead>
                                <tr>
                                    <th style="text-align: center">Tipo</th>
                                    <th style="text-align: center">Año</th>
                                    <th style="text-align: center">Nombre</th>
                                    <th style="text-align: center">Documento</th>
                                    <th style="text-align: center">Estado</th>
                                    <th colspan="2" style="text-align: center">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_row($result)) { ?>

                                        <tr data-id="<?php echo $row[0] ?>">
                                            <td style="text-align: center">
                                                <?php
                                                $tipo = '';
                                                switch ($row[3]) {
                                                    case 0:
                                                        // Res. Directoral
                                                        $tipo = 'R. Directoral';
                                                        break;
                                                    case 1:
                                                        // Res. Ministerial
                                                        $tipo = 'R. Ministerial';
                                                        break;
                                                    case 2:
                                                        // Directivas
                                                        $tipo = 'Directivas';
                                                        break;
                                                    case 3:
                                                        // Ciras
                                                        $tipo = 'Ciras';
                                                        break;
                                                    default:
                                                        $tipo = 'N/A';
                                                        break;
                                                }
                                                echo $tipo;
                                                ?>
                                            </td>
                                            <td style="text-align: center">
                                                <?php echo $row[4] ?>
                                            </td>
                                            <td style="text-align: center">
                                                <?php echo nl2br($row[1]) ?>
                                            </td>
                                            <td style="text-align: center">
                                                <?php

                                                if (!is_null($row[8]) && $row[8] != '') {
                                                    if ($row[7] == 'url') {
                                                        echo '<a href="' . $row[8] . '" target="_blank">
                                                        <img style="border: 0; vertical-align: middle;" src="../../../../images/url.png" alt="" width="20" height="20" border="0">
                                                    </a>';
                                                    } else {
                                                        $ext = '';
                                                        $sub = '';

                                                        switch ($row[7]) {
                                                            case 'pdf';
                                                                $ext = 'pdf.jpg';
                                                                break;
                                                            case 'xls';
                                                            case 'xlsx';
                                                                $ext = 'xlsx.jpg';
                                                                break;
                                                            case 'doc';
                                                            case 'docx';
                                                                $ext = 'docx.jpg';
                                                                break;
                                                            case 'rar';
                                                                $ext = 'rar.png';
                                                                break;
                                                            default:
                                                                $ext = 'info.jpg';
                                                                break;
                                                        }

                                                        switch ($row[3]) {
                                                            case 0;
                                                                $sub = 'resoluciones';
                                                                break;
                                                            case 1;
                                                                $sub = 'ministerial';
                                                                break;
                                                            case 2;
                                                                $sub = 'directivas';
                                                                break;
                                                            case 3;
                                                                $sub = 'ciras';
                                                                break;
                                                        }


                                                        echo '<a href="../../../../dmdocuments/' . $sub . '/' . $row[4] . '/' . $row[8] . '" target="_blank">
                                                        <img style="border: 0; vertical-align: middle;" src="../../../../images/' . $ext . '" alt="" width="20" height="20" border="0">
                                                    </a>';

                                                    }
                                                } else echo 'Sin Documento' ?>
                                            </td>
                                            <td style="text-align: center">
                                                <?php

                                                if ($row[6] == 1)
                                                    echo '<button class="publicado inferior" data-tooltip="Publicado">
                                                        <i class="material-icons">check_circle</i>
                                                    </button>';
                                                else
                                                    echo '<button class="nopublicado inferior" data-tooltip="No Publicado">
                                                        <i class="material-icons">block</i>
                                                    </button>';
                                                ?>
                                            </td>
                                            <td style="text-align: center">
                                                <button class="editar inferior" data-tooltip="Editar">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                            </td>
                                            <td style="text-align: center">
                                                <form action="eliminar_disposicion.php" method="post">
                                                    <input type="hidden" name="id_disposicion"
                                                           value="<?php echo $row[0]; ?>">
                                                    <button class="eliminar inferior" type="submit"
                                                            data-tooltip="Eliminar">
                                                        <i id="icon-delete"
                                                           class="material-icons hover">delete_forever</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>


                                        <?php
                                    }
                                } else {
                                    echo '<td colspan="7" style="text-align: center">SIN RESULTADOS</td>';
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>

                </div>

                <!--<div class="mdl-cell mdl-cell--1-col mdl-cell--1-col-tablet"></div>-->
            </div>

        </div>

        <!-- SCRIPTS -->
        <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/alertify.min.js"></script>
        <script defer src="js/disposiciones.js"></script>
        <script src="js/getmdl-select.min.js"></script>
        <script>
            $(document).ready(function () {
                alertify.set('notifier', 'position', 'top-right');
                // Show message when this page is called from other
                <?php
                if (isset($_SESSION['message'])) {
                    switch ($_SESSION['message'][0]) {
                        case 0:
                            echo 'alertify.success(\'' . $_SESSION['message'][1] . '\');';
                            break;
                        case 1:
                            echo 'alertify.error(\'' . $_SESSION['message'][1] . '\');';
                            break;
                        case 2:
                            echo 'alertify.warning(\'' . $_SESSION['message'][1] . '\');';
                            break;
                        case 3:
                            echo 'alertify.message(\'' . $_SESSION['message'][1] . '\');';
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

    <?php } else echo 'Error al conectar con la Base de Datos';
}