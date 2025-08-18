<?php

session_start();
require( "conectar_i.php" );

$conexion_i = new ConnectDB();

#region -- FUNCIONES --

function redirigir_con_mensaje( $page, $type, $message ) {
	$_SESSION['message'] = [ $type, $message ];
	header( 'Location: ' . $page );
	exit;
}

#endregion

if ( isset( $_POST["id_convocatoria"] ) &&
     isset( $_POST["nombre"] ) &&
     isset( $_POST['date'] ) &&
     isset( $_POST['estado'] ) &&
     isset( $_POST['publicado'] ) ) {

	$nombre    = strtoupper( $_POST["nombre"] );
	$fecha     = $_POST["date"];
	$estado    = $_POST["estado"];
	$publicado = $_POST["publicado"];

	$id = $_POST["id_convocatoria"];

	if ( $conexion_i->conectar() ) {

		$res = $conexion_i->getdata_ruta_x_idconv( $id );

		$ruta_conv = mysqli_fetch_row( $res );

		$base_path = realpath( __DIR__ . '/../../../../documentos/convocatorias_cas/' );

		$ruta_old = $base_path .
		            '/' .
		            $ruta_conv[0] .
		            '/' .
		            str_replace( ' ', '_', $ruta_conv[1] );

		// $date = DateTime::createFromFormat( "Y-m-d", $fecha );

		$ruta_new = $base_path .
		            '/' .
					// $date->format( "Y" ) .
		            $ruta_conv[0] .
		            '/' .
		            str_replace( ' ', '_', $nombre );

		$result = $conexion_i->edita_convocatoria( $nombre, $fecha, $estado, $publicado, $id );
		$conexion_i->desconectar();

		if ( $res && $result ) {

			if ( file_exists( $ruta_old ) &&
			     ( ( ! file_exists( $ruta_new ) ) || is_writable( $ruta_new ) ) ) {

				// renombrar carpeta con el anio y nombre de convocatoria
				if ( ! rename( $ruta_old, $ruta_new ) ) {

					redirigir_con_mensaje( 'index.php', 1, 'Ocurrió un error al momento de renombrar el directorio' );

				} else {

					redirigir_con_mensaje( 'index.php', 0, 'Cambios guardados correctamente.' );

				}
			}
			redirigir_con_mensaje( 'index.php', 1, 'Ocurrió un error al momento de verificar el directorio' );
		}

	} else { // no connection
		redirigir_con_mensaje( 'index.php', 1, 'Ocurrió un error al intentar conectar con la Base de Datos.' );
	}
} else {
	redirigir_con_mensaje( 'index.php', 1, 'Ocurrió un error al enviar los datos.' );
}