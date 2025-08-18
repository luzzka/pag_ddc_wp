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

$id_proceso = $_GET["id_proceso"];
$tipo = $_GET["tipo"];

$row = '';
$result2 = '';
$id_convocatoria = '';

if ($conexion_i->conectar()) {
	$proceso = $conexion_i->getdata_proceso($id_proceso);
	$result2 = $conexion_i->getdata_docs_proceso($id_proceso, $tipo);
	$id_convocatoria = $conexion_i->get_id_convocatoria($id_proceso);
	$conexion_i->desconectar();

	$row = mysqli_fetch_row($proceso);
	$id_convocatoria = mysqli_fetch_row($id_convocatoria);

} else redirigir_con_mensaje('frm_editar_proceso.php', 1, 'Ocurrio un error al conectar con la BD');

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<title>Editar Documentos</title>

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

	<form id="formulario" action="actualiza_docs.php" class="mdl-cell mdl-cell--8-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" enctype="multipart/form-data" method="post">

		<input type="hidden" name="id_proceso" value="<?php echo $id_proceso ?>">
		<input type="hidden" name="tipo" value="<?php echo $tipo ?>">

		<h4><?php echo $row[1] ?></h4>

        <hr>

		<?php

		if ($tipo == 0) echo '<h5>PERFIL</h5>';
		else if ($tipo == 1) echo '<h5>COMUNICADOS</h5>';
		else if ($tipo == 2) echo '<h5>EVALUACIÓN CURRICULAR</h5>';
		else if ($tipo == 3) echo '<h5>EVALUACIÓN TÉCNICA</h5>';
		else if ($tipo == 4) echo '<h5>FINALES</h5>';

		echo '<div class="nuevo-field">
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

				echo '<label for="enlace_'.$i.'">
                        <img src="../../../../documentos/images/pdf-file.png" >
                        <span>'.$row1[1].'</span>
                       </label>';


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

        let i = 0;

        let adjuntosDIV = $('.adjuntos');

        let eliminados = [];

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

            let el = $(plantilla2);

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

            i++;

            inp();

            componentHandler.upgradeDom();

        })<?php echo !mysqli_num_rows($result2) > 0 ? '.click()' : '' ?>;

        $('#cancelar').click(function(e) {
            e.preventDefault();

            alertify.confirm(
                'Web - DDC Cusco',
                '&iquest;Est&aacute; seguro de descartar este formulario?',
                function() {
                    window.location.replace("frm_editar_proceso.php?id="+<?php echo $id_convocatoria[0] ?>);
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