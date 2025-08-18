<?php

session_start();
include( "conectar_i.php" );

$conexion_i = new ConnectDB();

if (!$conexion_i->verifica_loggeo()) {
	echo 'ACCESO RESTRINGIDO';
	exit;
}

function redirigir_con_mensaje( $page, $type, $message ) {
	$_SESSION['message'] = [ $type, $message ];
	header( 'Location: ' . $page );
	exit;
}

function deleteDirectory( $dir ) {
	if ( ! file_exists( $dir ) ) {
		return true;
	}

	if ( ! is_dir( $dir ) ) {
		return unlink( $dir );
	}

	foreach ( scandir( $dir ) as $item ) {
		if ( $item == '.' || $item == '..' ) {
			continue;
		}

		if ( ! deleteDirectory( $dir . DIRECTORY_SEPARATOR . $item ) ) {
			return false;
		}

	}

	return rmdir( $dir );
}

if ( isset( $_POST["id_convocatoria"] ) ) {

//	$ids_procesos = json_decode( $_POST["id_procesos"] );
	$id_convocatoria = $_POST["id_convocatoria"];

	if ( $conexion_i->conectar() ) {

		$result = $conexion_i->get_data_convocatoria( $id_convocatoria );
		$result = mysqli_fetch_row( $result );

		$base_path = realpath( __DIR__ . '/../../../../documentos/convocatorias_cas/' );

		$ruta = $base_path . '/' . $result[1] . '/' . str_replace( ' ', '_', $result[0] );

		// elimina el directorio
		if ( file_exists( $ruta ) ) {
			deleteDirectory( $ruta );
		}

		// eliminar docs
		$ed = $conexion_i->elimina_doc_x_idconv( $id_convocatoria );

		// eliminar procesos
		$ep = $conexion_i->elimina_proc_x_idconv( $id_convocatoria );

		// eliminar convocatoria
		$ec = $conexion_i->elimina_convocatoria( $id_convocatoria );

		$conexion_i->desconectar();

		if ( $ed && $ep && $ec ) {
			redirigir_con_mensaje( 'index.php', 0, 'Se eliminó la convocatoria correctamente.' );
		} else {
			redirigir_con_mensaje( 'index.php', 1, 'Error al eliminar la convocatoria.' );
		}
	} else {
		redirigir_con_mensaje( 'index.php', 1, 'Error al intentar conectar con la base de datos.' );
	}
}