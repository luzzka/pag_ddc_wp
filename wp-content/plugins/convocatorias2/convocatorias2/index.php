<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

if (!$conexion_i->verifica_loggeo()) {
	echo 'ACCESO RESTRINGIDO';
	exit;
}

$f_ano = '';

if ( isset( $_GET["select-anio"] ) ) {
	$f_ano = $_GET["select-anio"];
}

if ($f_ano == '' || is_null($f_ano)) {
	$f_ano = date('Y');
}

if ($conexion_i->conectar()) {
    $result = $conexion_i->getdata_convocatorias2($f_ano);
    $conexion_i->desconectar(); ?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <title>Convocatorias2</title>

    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/principal.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-deep_orange.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="css/alertify.min.css"/>
    <!-- Default theme -->
     <link rel="stylesheet" href="css/alertify.default.min.css"/>

    <!--getmdl-select-->
    <link rel="stylesheet" href="css/getmdl-select.min.css">
</head>
<body>

<div class="mdl-grid">

    <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-tablet"></div>

    <div class="mdl-cell mdl-cell--8-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" style="text-align: center;">

        <div class="cabecera">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label getmdl-select" style="width: 124px;">
            <input type="text" value="" class="mdl-textfield__input" id="select-anio" readonly>
            <input type="hidden" value="" name="select-anio">
            <i class="mdl-icon-toggle__label material-icons">keyboard_arrow_down</i>
            <label for="estado" class="mdl-textfield__label">Año</label>
            <ul for="estado" class="mdl-menu mdl-menu--bottom-left mdl-js-menu">

	            <?php

	            $years = range('2018', date("Y"));

	            if (isset($_GET["select-anio"])) {

                    for ( $i = count($years)-1 ; $i >= 0 ; $i-- ) { ?>

                      <li class="mdl-menu__item" data-val="<?php echo $years[$i] ?>" <?php if ($_GET["select-anio"]==$years[$i]) printf('data-selected="true"'); else printf(''); ?> ><?php echo $years[$i] ?></li>

                    <?php }

                }
                else {

	                for ( $i = count($years)-1 ; $i >= 0 ; $i-- ) {

	                    if ($i == count($years)-1) { ?>

                            <li class="mdl-menu__item" data-val="<?php echo $years[$i] ?>" data-selected="true" ><?php echo $years[$i] ?></li>

                        <?php }
                        else { ?>
                            <li class="mdl-menu__item" data-val="<?php echo $years[$i] ?>" ><?php echo $years[$i] ?></li>
                        <?php }
	                }

                } ?>

            </ul>
        </div>

        <button id="add-convocatoria" class="add-convocatoria mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
            <i class="material-icons">note_add</i> Agregar
        </button>

        </div>

        <hr style="margin-left: 12px; margin-right: 12px;">

        <div class="contenedor-tabla">
            <table class="tabla-convocatorias mdl-data-table mdl-js-data-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                <tr>
                    <th style="text-align: center">N°</th>
                    <th style="text-align: center">Nombre</th>
                    <th style="text-align: center">Fecha de creación</th>
                    <th style="text-align: center">Estado</th>
                    <th style="text-align: center">Publicado</th>
                    <th colspan="4" style="text-align: center">Acciones</th>
                </tr>
                </thead>
                <tbody>
				        <?php

				        if ($result->num_rows > 0) {
				            $i = 1;
					        while ($row = mysqli_fetch_row($result)) { ?>

                      <tr data-id="<?php echo $row[0]; ?>">
                          <td style="text-align: center"><?php echo $i ?></td>
                          <td style="text-align: center"><?php echo $row[1] ?></td>
                          <td style="text-align: center"><?php echo $row[2] ?></td>
                          <td style="text-align: center">
                            <?php
                            if ($row[3] == 0) {
                                echo 'VIGENTE';
                            }
                            else if ($row[3] == 1) {
	                            echo 'FINALIZADA';
                            }
                            ?>
                          </td>
                          <td style="text-align: center">
	                          <?php
	                          if ($row[4] == 1)
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
                              <button class="add-fde inferior" data-tooltip="Fe De Erratas">
                                  <i class="material-icons">note_add</i>
                              </button>
                          </td>
                          <td style="text-align: center">
                              <button class="editar-procesos inferior" data-tooltip="Editar Procesos">
                                  <i class="material-icons">border_color</i>
                              </button>
                          </td>
                          <td style="text-align: center">
                              <form action="elimina_convocatoria.php" method="post">
                                  <input type="hidden" name="id_convocatoria" value="<?php echo $row[0]; ?>">
                                  <button class="eliminar inferior" type="submit" data-tooltip="Eliminar">
                                      <i id="icon-delete" class="material-icons hover">delete_forever</i>
                                  </button>
                              </form>
                          </td>
                      </tr>
                        <?php $i++; }
				        } else echo '<td colspan="8" style="text-align: center">SIN RESULTADOS</td>' ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-tablet"></div>
</div>

<!-- SCRIPTS -->
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<!-- JavaScript -->
<script src="js/alertify.min.js"></script>
<script defer src="js/getmdl-select.min.js"></script>
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
<script>

    $( document ).ready(function() {

        let cc = 0;

        $('#select-anio').on('change', function() {

            if (cc !== 0) {
                window.location = "index.php?select-anio="+$(this).val();
            }
            cc++;
        });

        // Crear
        $('#add-convocatoria').click(function (e) {
            e.preventDefault();

            window.location = "frm_crear_convocatoria.php";
            // console.log(id);
        });

        let tabla = jQuery('.tabla-convocatorias');

        // Eliminar Convocatoria
        tabla.find('button.eliminar[type=submit]').click(function (e) {
            e.preventDefault();
            let boton = $(this);
            let formulario = boton.parent();

            alertify.confirm(
                'Web - DDC Cusco',
                '&iquest;Est&aacute; seguro de eliminar la convocatoria?',
                function() {
                    formulario.submit();
                },
                function(){
                    // NO
                }).set('maximizable', false)
                .set('labels', {ok:'Si', cancel:'No'});
        });

        // Publicar
        tabla.find('button.publicado').click(function () {
            let id = $(this).parent().parent().attr('data-id');

            window.location = "cambia_estado.php?id="+id;
        });

        // No Publicar
        tabla.find('button.nopublicado').click(function () {
            let id = $(this).parent().parent().attr('data-id');

            window.location = "cambia_estado.php?id="+id;
        });

        // Editar
        tabla.find('button.editar').click(function () {
            let id = $(this).parent().parent().attr('data-id');

            window.location = "frm_editar1.php?id="+id;
            // console.log(id);
        });

        // Fe De Erratas
        tabla.find('button.add-fde').click(function () {
            let id = $(this).parent().parent().attr('data-id');

            window.location = "frm_editar_fderratas.php?id="+id;
            // console.log(id);
        });

        // Editar Procesos
        tabla.find('button.editar-procesos').click(function () {
            let id = $(this).parent().parent().attr('data-id');

            window.location = "frm_editar_proceso.php?id="+id;
            // console.log(id);
        });

        // asignar tooltips a todos los elementos que contengan el atributo 'data-tooltip'
        let templateHtml = "<span class=\"mdl-tooltip\" for=\"\"></span>"; // texto html del elemento span que contendra el tooltip
        tabla.find('[data-tooltip]') // encontrar elementos con el atributo 'data-tooltip'
            .each(function (i, e) {
                let id = 'require-tooltip-' + i; // generar id dinamicamente de acuerdo al indice (el cual es unico en este grupo de elementos)
                let element = $(e); // crear referencia jQuery al elemento actual
                if (element.attr('id'))
                    id = element.attr('id'); // si el elemento ya tiene un atributo id, asignar este id a la variable 'id'
                else
                    element.attr('id', id); // caso contrario asignar el id generado como atributo id del elemento
                let template = $(templateHtml); // crear elemento jQuery a partir del texto html
                template.attr('for', id); // asignar atributo 'for'
                template.text($(e).attr('data-tooltip')); // insertar como texto del span (el cual sera el texto del tooltip) el valor del atributo 'data-tooltip' del elemento actual
                element.after(template); // insertar el elemento 'template' despues del elemento actual
            });
    });

</script>
</body>
</html>

<?php } else echo 'Error al conectar con la Base de Datos';