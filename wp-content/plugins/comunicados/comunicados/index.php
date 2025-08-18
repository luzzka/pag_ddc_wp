<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

if ($conexion_i->verifica_loggeo()) {

// Filtros
// $f_tipo = '';
$txt_b = '';
//
if ( isset($_GET["txt-busqueda"]) ) {
    $txt_b = $_GET["txt-busqueda"];
}

// $criterio = '';
// switch ($f_tipo) {
//     case '0':
//         $criterio = '0';
//         break;
//     case '1':
//         $criterio = '1';
//         break;
//     case '2':
//         $criterio = '2';
//         break;
//     case '3':
//         $criterio = '3';
//         break;
//     case '4':
//         $criterio = '4';
//         break;
//     default:
//         $criterio = '';
//         break;
// }

$tb = '';

if ($txt_b != '' && !is_null($txt_b)){
    $tb = $txt_b;
}

if ($conexion_i->conectar()) {
    // $result = $conexion_i->lista_comunicados($criterio, $txt_b);
    $result = $conexion_i->lista_comunicados($txt_b);
    $conexion_i->desconectar();
    ?>

    <!DOCTYPE html>
    <html lang="es-ES">
    <head>
        <title>Administracion de Comunicados</title>

        <meta charset="UTF-8">

        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css" />

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

                        <select name="select-filtro" id="select-filtro">
                            <option value="-1" >Todos</option>
                        </select>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" id="txt-busqueda" type="text" name="txt-busqueda" value="">
                            <label class="mdl-textfield__label" for="txt-busqueda">Comunicado</label>
                        </div>

                        <button type="submit" class="boton-buscar buscar-comunicado mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                            <i class="material-icons">find_in_page</i> Buscar
                        </button>

<!--                        <button id="ordenar-comunicados" class="ordenar-comunicados mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">-->
<!--                            <i class="material-icons">import_export</i> Ordenar-->
<!--                        </button>-->

                        <button id="add-comunicado" class="add-comunicado mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                            <i class="material-icons">note_add</i> Agregar
                        </button>

                    </form>

                    <div class="h-scroll" style="width: 100%;margin-top: 10px; overflow-x: scroll;">
                        <table class="tablaComunicados mdl-data-table mdl-js-data-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 100%;">Comunicado</th>
                                    <th style="text-align: center">Detalle</th>
                                    <th style="text-align: center">Anexos</th>
                                    <th style="text-align: center">Estado</th>
                                    <th colspan="2" style="text-align: center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php

                            if ($result->num_rows > 0) {
                                while ($row = mysqli_fetch_row($result)) { ?>

                                    <tr data-id="<?php echo $row[0]; ?>">
                                        <td style="text-align: center"><strong><?php echo $row[2] ?></strong></td>
                                        <td style="text-align: center">
                                            <?php
                                                if (strlen($row[3]) > 20) {
                                                    echo substr($row[3], 0, 20) . '[...]';
                                                }
                                                else
                                                {
                                                    echo $row[3];
                                                }
                                            ?>
                                        </td>
                                        <td style="text-align: left">
                                            <table style="margin: auto;">
                                            <?php
                                            // ITERAR ANEXOS
                                            if ($conexion_i->conectar()) {
                                                $res_publicaciones = $conexion_i->lista_anexos($row[0]);
                                                $conexion_i->desconectar();

                                                while ($sub_row = mysqli_fetch_row($res_publicaciones)) { ?>
                                                    <tr>
                                                        <td style="text-align: left">
                                                            <?php
                                                            $icon = '';
                                                            switch ($sub_row[1])
                                                            {
                                                                case 'pdf':
                                                                    $icon = 'pdf-file.png';
                                                                    break;
                                                                case 'xls':
                                                                case 'xlxs':
                                                                    $icon = 'excel-file.png';
                                                                    break;
                                                                case 'doc':
                                                                case 'docx':
                                                                    $icon = 'word-file.png';
                                                                    break;
                                                                default:
                                                                    $icon = 'info-icon.png';
                                                                    break;
                                                            }
                                                            // echo '<img src="../../../../documentos/images/'.$icon.'"> <a target="blank" href="../../../../documentos/comunicados/'.$sub_row[2].'">'.$sub_row[2].'</a>';
                                                            echo '<img src="../../../../documentos/images/'.$icon.'"> <a target="blank" href="../../../../documentos/comunicados/'.$sub_row[2].'">'.substr(str_replace('_',' ', $sub_row[2]),0, (strlen($sub_row[1]) + 1)*-1).'</a>';
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </table>

                                        </td>
                                        <?php
                                        if ($row[5] == 1)
                                            echo '<td style="text-align: center">
                                                <button class="publicado inferior" data-tooltip="Publicado">
                                                    <i class="material-icons">check_circle</i>
                                                </button>
                                            </td>';
                                        else
                                            echo '<td style="text-align: center">
                                                <button class="nopublicado inferior" data-tooltip="No Publicado">
                                                    <i class="material-icons">block</i>
                                                </button>
                                            </td>';
                                        ?>

                                        <td style="text-align: center">
                                            <button class="editar inferior" data-tooltip="Editar">
                                                <i class="material-icons">edit</i>
                                            </button>
                                        </td>
                                        <td style="text-align: center">
                                            <form action="eliminar_comunicado.php" method="post">
                                                <input type="hidden" name="id_comunicado" value="<?php echo $row[0]; ?>">
                                                <button class="eliminar inferior" type="submit" data-tooltip="Eliminar">
                                                    <i id="icon-delete" class="material-icons hover">delete_forever</i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            else {
                                echo '<td colspan="6" style="text-align: center">SIN RESULTADOS</td>';
                            }

                            ?>

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
<script defer src="js/comunicados.js"></script>
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

<?php } else echo 'Error al conectar con la Base de Datos';
}