<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

$tipo = $_GET["tipo"];
$id_proceso = $_GET["id_proceso"];
$id_convocatoria = '';

if ($conexion_i->conectar()) {
	$result = $conexion_i->lista_docs_x_tipo($tipo, $id_proceso);
	$id_convocatoria = $conexion_i->get_id_convocatoria( $id_proceso );
	$conexion_i->desconectar();

	$id_convocatoria = mysqli_fetch_row( $id_convocatoria );
	?>

	<!DOCTYPE html>
	<html lang="es-ES">
	<head>
		<title>Reordenamiento de Documentos</title>

		<meta charset="UTF-8">

		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.brown-orange.min.css" />

		<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

		<link rel="stylesheet" href="css/principal.css">
		<link rel="stylesheet" href="css/style.css">

		<link rel="stylesheet" href="css/alertify.min.css">
		<link rel="stylesheet" href="css/alertify.default.min.css">

		<style>
			tbody>tr {cursor: move;}
			img {
				width: auto !important;
				height: auto !important;
			}
		</style>
	</head>
	<body>

	<br>

	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">

		<div class="mdl-grid">

			<div class="mdl-cell mdl-cell--3-col mdl-cell--1-col-tablet"></div>

			<form action="store_orden_docs.php" class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-color--white mdl-shadow--2dp" method="post">

					<div class="mdl-grid">

						<div class="h-scroll" style="width: 100%;margin-top: 10px; overflow-x: scroll;">
							<table class="tablaBases mdl-data-table mdl-js-data-table" style="width: 100%; border-collapse: collapse;">
								<thead>
								<tr>
									<th style="text-align: center">Documentos</th>
								</tr>
								</thead>
								<tbody id="selections">

								<?php

								if ($result->num_rows > 0) {
									while ($row = mysqli_fetch_row($result)) { ?>
										<tr class="selection">
											<input name="ids[]" type="hidden" value="<?php echo $row[0] ?>">
											<input name="id_convocatoria" type="hidden" value="<?php echo $id_convocatoria[0] ?>">
											<td style="text-align: center">
												<strong>
													<?php echo $row[1] ?>
												</strong>
											</td>
										</tr>
										<?php
									}
								}
								else echo '<td style="text-align: center">SIN RESULTADOS</td>';
								?>

								</tbody>
							</table>


						</div>
						<br>
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


	</div>

	</div>

	<!-- SCRIPTS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script src="js/Sortable.min.js"></script>
	<script src="js/alertify.min.js"></script>

	<script>
      $(document).ready(function() {

          $('#cancelar').click(function (e) {
              e.preventDefault();

              // let boton = $(this);
              // let formulario = boton.parent();

              alertify.confirm(
                  'Web - DDC Cusco',
                  '¿Está seguro de salir sin guardar los cambios?',
                  function() {
                      window.location = "frm_editar_proceso.php?id=<?php echo $id_convocatoria[0] ?>";
                  },
                  function(){
                      // NO
                  }).set('maximizable', false)
                  .set('labels', {ok:'Si', cancel:'No'});
          });

          Sortable.create(selections, {
              animation: 150
          });

      });
	</script>
	</body>
	</html>

<?php } else echo 'Error al conectar con la Base de Datos';