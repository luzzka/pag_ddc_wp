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

// traer nombres de pdf de los procesos a eliminar, segun sus IDS
if ( isset( $_POST["id_procesos"] ) &&
     isset( $_POST["id_convocatoria"] ) ) {

	$ids_procesos = json_decode( $_POST["id_procesos"] );
	$id_convocatoria = json_decode( $_POST["id_convocatoria"] );

	if ( $conexion_i->conectar() ) {

		$base_path = realpath( __DIR__ . '/../../../../documentos/convocatorias_cas/' );

		for ( $i = 0; $i < count( $ids_procesos ); $i ++ ) {
			$docs = $conexion_i->get_nombres_pdf( $ids_procesos[ $i ] );
			$path = $conexion_i->getdata_ruta( $ids_procesos[ $i ] );

			$path = mysqli_fetch_row( $path );

			// genera arreglo de documentos
			$a = array();

			$path_nombre = str_replace( ' ', '_', $path[1] );
			$path_numero = preg_replace( '/[^A-Za-z0-9\-]/', '', $path[2] );

			// itera en el objeto
			foreach ( $docs as $doc ) {
				array_push( $a, $doc['id'] );

				$relative_path = $base_path . '/' . $path[0] . '/' . $path_nombre . '/' . $path_numero . '/' . $doc['nombre_pdf'];

				// elimina el documento x ruta
				if ( file_exists( $relative_path ) ) {
					unlink( $relative_path );
				}
			}
			// eliminar carpeta
			if ( !rmdir( $base_path . '/' . $path[0] . '/' . $path_nombre . '/' . $path_numero ) ) {
				redirigir_con_mensaje( 'frm_editar_proceso.php?id='.$id_convocatoria, 1, 'Error al intentar eliminar el directorio.' );
			}

			// eliminar de la BD, docs y fila de proceso
			$ed = $conexion_i->elimina_docs_x_proceso( $ids_procesos[ $i ] );
			$ep = $conexion_i->elimina_proceso( $ids_procesos[ $i ] );

			if ( !($ed && $ep) ) {
				redirigir_con_mensaje( 'frm_editar_proceso.php?id='.$id_convocatoria, 1, 'Error al intentar eliminar el proceso seleccionado.' );
			}
		}

		redirigir_con_mensaje( 'frm_editar_proceso.php?id='.$id_convocatoria, 0, 'Se retiró el elemento correctamente.' );

	} else {
		redirigir_con_mensaje( 'frm_editar_proceso.php?id='.$id_convocatoria, 1, 'Error al intentar conectar con la base de datos.' );
	}
}