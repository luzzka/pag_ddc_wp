<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

if (!$conexion_i->verifica_loggeo()) {
	echo 'ACCESO RESTRINGIDO';
	exit;
}

function redirigir_con_mensaje ($page, $type, $message) {
	$_SESSION['message'] = [$type, $message];
	header('Location: ' . $page);
	exit;
}

$id_convocatoria = $_GET["id"];

$row = '';

if ($conexion_i->conectar()) {
	$result = $conexion_i->getdata_convocatoria_x_id($id_convocatoria);
	$conexion_i->desconectar();

	if ($result) {
		if ($result->num_rows > 0) {
			$row = mysqli_fetch_row($result); // asignar data a row
		}
		else {
			// no hay data
			redirigir_con_mensaje('index.php',1,'No se tiene registro');
		}
	} else redirigir_con_mensaje('index.php',1,'Ocurrio un error al obtener la data');
} else redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al conectar con la BD');

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title>Edita Convocatoria</title>

	<link rel="stylesheet" href="css/style.css">

	<link rel="stylesheet" href="css/alertify.min.css">
	<link rel="stylesheet" href="css/alertify.default.min.css">

    <!--getmdl-select-->
    <link rel="stylesheet" href="css/getmdl-select.min.css">

	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css" />

    <!--  Date Picker  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/bootstrap-material-design.min.css"/>
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/ripples.min.css"/>-->

    <link rel="stylesheet" href="css/bootstrap-material-datetimepicker.css" />
</head>
<body>

<div class="mdl-grid">

	<div class="mdl-cell mdl-cell--3-col mdl-cell--1-col-tablet"></div>
	<form id="formulario" action="store_edit_convocatoria.php" class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" enctype="multipart/form-data" method="post">

		<input type="hidden" name="id_convocatoria" value="<?php echo $id_convocatoria ?>">

		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" id="nombre" name="nombre" value="<?php echo $row[0] ?>" >
			<label class="mdl-textfield__label" for="nombre">Nombre</label>
		</div>

        <div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-control-wrapper">
                        <input type="text" id="date" name="date" class="form-control floating-label" placeholder="Fecha" value="<?php echo $row[1] ?>">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select">
            <input type="text" value="" class="mdl-textfield__input" id="estado" readonly>
            <input type="hidden" value="" name="estado">
            <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
            <label for="estado" class="mdl-textfield__label">Estado</label>
            <ul for="estado" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                <li class="mdl-menu__item" data-val="0" <?php echo $row[2]==0 ? 'data-selected="true"' : '' ?>>Vigente</li>
                <li class="mdl-menu__item" data-val="1" <?php echo $row[2]==1 ? 'data-selected="true"' : '' ?>>Finalizada</li>
            </ul>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select">
            <input type="text" value="" class="mdl-textfield__input" id="publicado" readonly>
            <input type="hidden" value="" name="publicado">
            <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
            <label for="publicado" class="mdl-textfield__label">Visibilidad</label>
            <ul for="publicado" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">
                <li class="mdl-menu__item" data-val="0" <?php echo $row[3]==0 ? 'data-selected="true"' : '' ?>>No Publicado</li>
                <li class="mdl-menu__item" data-val="1" <?php echo $row[3]==1 ? 'data-selected="true"' : '' ?>>Publicado</li>
            </ul>
        </div>

		<br>

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
<script defer src="js/getmdl-select.min.js"></script>

<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>-->
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script type="text/javascript" src="js/bootstrap-material-datetimepicker.js"></script>

<script>
    $(document).ready(function() {

        $('#date').bootstrapMaterialDatePicker({
            time: false,
            clearButton: true
        });

        $('#guardar').click(function (e) {
            e.preventDefault();

            let boton = $(this);
            let formulario = boton.parent();

            // Validaciones del Formulario
            if($("#nombre").val() !== "") {

                if($("#date").val() !== "") {
                    formulario.submit();
                }
                else {
                    alertify.alert('Web - DDC Cusco', 'El campo "Fecha" no debe estar vacío !');
                }
            }
            else {
                alertify.alert('Web - DDC Cusco', 'El campo "Nombre" no debe estar vacío !');
            }
        });

        // Cancelar
        $('#cancelar').click(function(e) {
            e.preventDefault();

            // comprobar iterando en los input text
            // let elements = document.getElementById("formulario").elements;
            //
            // let comprueba = false;
            //
            // for (let i = 0, element; element = elements[i++];) {
            //     if ( element.name === "titulo" ||
            //         element.name === "enlace" ||
            //         element.name === "documento" ) {
            //
            //         console.log(element.name);
            //
            //         if (element.value !== '')
            //         {
            //             comprueba = true;
            //             break;
            //         }
            //     }
            // }
            //
            // if (comprueba) {
            //
            //     alertify.confirm(
            //         'Web - DDC Cusco',
            //         '&iquest;Est&aacute; seguro de descartar este formulario?',
            //         function() {
            //             window.location.replace("index.php");
            //         },
            //         function(){
            //             // alertify.error('Cancel')
            //             // return false;
            //         }).set('maximizable', false)
            //         .set('labels', {ok:'Si', cancel:'No'});
            //
            // }
            // else {
            window.location = 'index.php';
            // }

        });
    });
</script>
</body>
</html>