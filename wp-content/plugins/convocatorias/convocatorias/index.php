<?php

session_start();
include("conectar_i.php");

//require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );

// si el usuario esta loggeado mostrar, si no, redirigir a pantalla de loggeo
//if ( is_user_logged_in() )
//{
//    // code
//    echo 'loggeado';
//}
//else
//{
//    echo 'deslogueado';
//}
//
//exit(0);

$conexion_i = new ConnectDB();

$f_ano = '';
$txt_b = '';

if (isset($_GET["select-filtro"]) && isset($_GET["txt-busqueda"])){
    $f_ano = $_GET["select-filtro"];
    $txt_b = $_GET["txt-busqueda"];
}

$criterio = '';

$criterio = $f_ano;

if ($f_ano == '' || is_null($f_ano)) {
    $criterio = date('Y');
}

$tb = '';

if ($txt_b != '' && !is_null($txt_b)){
    $tb = $txt_b;
}

if ($conexion_i->conectar()){

    $result = $conexion_i->listar_convocatorias($criterio, $tb);

    $conexion_i->desconectar();

    $i = 1;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Administracion Convocatorias</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css"> -->
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-deep_purple.min.css" />

    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

    <link rel="stylesheet" href="css/principal.css">

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
                    <select name="select-filtro" id="select-filtro">

                        <?php

                            $years = range('2017', date("Y"));

                            for ( $i = count($years)-1 ; $i >= 0 ; $i-- )
                            {?>
                                <option value="<?php echo $years[$i] ?>" <?php if (isset($_GET["select-filtro"])) { if ($_GET["select-filtro"]==$years[$i]) printf('selected'); else printf(''); } ?>><?php echo $years[$i] ?></option>
                             <?php
                            }

                        ?>

                    </select>

                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" id="txt-busqueda" type="text" name="txt-busqueda" value="">
                        <label class="mdl-textfield__label" for="txt-busqueda">C&oacute;digo de Convocatoria</label>
                    </div>

                    <button type="submit" class="boton-buscar buscar-convocatoria mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                        <i class="material-icons">find_in_page</i> Buscar
                    </button>

                    <button id="add-convocatoria" class="add-convocatoria mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                        <i class="material-icons">note_add</i> Agregar
                    </button>
                </form>

                <div class="h-scroll" style="width: 100%;margin-top: 10px; overflow-x: scroll;">
                    <table class="tablaConvocatorias mdl-data-table mdl-js-data-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                        <tr>
                            <th style="text-align: center">Nro. Conv.</th>
                            <th style="text-align: center">Fecha</th>
                            <th style="text-align: center">Tipo</th>
                            <th style="text-align: center">Convocatoria</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Publicaci&oacute;n de Resultados</th>
                            <th colspan="2" style="text-align: center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_row($result)) {
                        ?>

                            <tr data-id="<?php echo $row[0] ?>">
                                <td style="text-align: center"><?php echo $row[4] ?></td>
                                <td style="text-align: center"><?php echo $row[1] ?></td>
                                <td style="text-align: center"><?php echo $row[2] ?></td>
                                <td style="text-align: center">
                                    <?php
                                        echo $row[5];
                                        if (isset($row[6]) && $row[6] != '' && !is_null($row[6])) {
                                            // echo ' <a href="documentos/convocatorias/'.$row[2].'/'.$row[3].'/'.$row[4].'/'.$row[6].'" target="_blank"><img style="border: 0px; vertical-align: top;" src="../convocatorias/documentos/images/list.png" alt="" width="20" height="20" border="0"></a>';
                                            echo ' <a href="/documentos/convocatorias/'.$row[2].'/'.$row[3].'/'.$row[4].'/'.$row[6].'" target="_blank"><img style="border: 0px; vertical-align: top;" src="../convocatorias/documentos/images/list.png" alt="" width="20" height="20" border="0"></a>';
                                        }
                                    ?>
                                </td>
                                <td style="text-align: center">
                                    <?php
                                        if ($row[7] == 0)
                                            echo 'ABIERTO';
                                        if ($row[7] == 1)
                                            echo 'CERRADO'
                                    ?>
                                </td>
                                <td>
                                    <table style="margin: auto;">
                                        <?php
                                        // ITERAR PUBLICACIONES
                                        if ($conexion_i->conectar()) {
                                            $res_publicaciones = $conexion_i->listar_conv_publicaciones($row[0]);
                                            $conexion_i->desconectar();

                                            while ($sub_row = mysqli_fetch_row($res_publicaciones)){ ?>
                                                <tr>
                                                    <td style="text-align: left">
                                                        <?php
                                                            echo $sub_row[3] . ' ' . $sub_row[2];

                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            if (!isset($sub_row[4]) || $sub_row[4] == '') {
                                                                // sin enlace
                                                            }
                                                            else {
                                                                //echo ' <a href="'.$sub_row[4].'" target="_blank">VER</a>';
                                                                echo ' <a href="/documentos/convocatorias/'.$row[2].'/'.$row[3].'/'.$row[4].'/'.$sub_row[4].'" target="_blank">VER</a>';
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }

                                        ?>
                                    </table>
                                </td>
                                <td style="text-align: center">
                                    <button class="editar inferior" data-tooltip="Editar">
                                        <i class="material-icons">edit</i>
                                    </button>
                                </td>
                                <td style="text-align: center">
                                    <form action="eliminar.php" method="post">
                                        <input type="hidden" name="id_conv" value="<?php echo $row[0] ?>">
                                        <button class="eliminar inferior" type="submit" data-tooltip="Eliminar">
                                            <i id="icon-delete" class="material-icons hover">delete_forever</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <?php $i++; } } else {
                                echo '<td colspan="7" style="text-align: center">SIN RESULTADOS</td>';
                            } ?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="js/alertify.min.js"></script>
<script defer src="js/index.js"></script>

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

<?php

}
else
    echo "Ocurrio un error al conectar con la Base de Datos, por favor recargue la pagina.";

?>