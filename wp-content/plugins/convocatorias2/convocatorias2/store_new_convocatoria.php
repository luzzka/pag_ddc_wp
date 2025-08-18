<?php

session_start();
require( "conectar_i.php" );

$conexion_i = new ConnectDB();

function redirigir_con_mensaje( $page, $type, $message ) {
	$_SESSION['message'] = [ $type, $message ];
	header( 'Location: ' . $page );
	exit;
}

if ( isset( $_POST["nombre"] ) &&
     isset( $_POST['date'] ) &&
     isset( $_POST['estado'] ) &&
     isset( $_POST['publicado'] ) ) {

	$nombre    = $_POST["nombre"];
	$fecha     = $_POST["date"];
	$estado    = $_POST["estado"];
	$publicado = $_POST["publicado"];

	if ( $conexion_i->conectar() ) {

		$result = $conexion_i->inserta_convocatoria( $nombre, $fecha, $estado, $publicado );
		$conexion_i->desconectar();

		$date_y = DateTime::createFromFormat( "Y-m-d", $fecha );

		// Crear Directorio -> Anio -> NombreConvocatoria
		$base_path = realpath( __DIR__ . '/../../../../documentos/convocatorias_cas/' );

		$ruta = $base_path . '/' . $date_y->format( "Y" ) . '/' . strtoupper( str_replace(' ','_', $nombre ) );

		if ( ! file_exists( $ruta ) ) {
			mkdir( $ruta, 0777, true );
		}

		if ( $result ) { // succesfull
			redirigir_con_mensaje( 'index.php', 0, 'Convocatoria creada correctamente.' );
		} else { // fail
			redirigir_con_mensaje( 'index/php', 1, 'Ocurrió un error al crear la convocatoria, por favor intente nuevamente.' );
		}

	} else { // no connection
		redirigir_con_mensaje( 'index/php', 1, 'Ocurrió un error al intentar conectarse con la Base de Datos.' );
	}
}