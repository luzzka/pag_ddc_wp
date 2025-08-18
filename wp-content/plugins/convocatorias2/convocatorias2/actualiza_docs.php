<?php

session_start();
require( "conectar_i.php" );

$conexion_i = new ConnectDB();

$enlaces = false;

if ( isset( $_FILES["enlace"] ) ) {
	$ids     = $_POST["ids"];
	$enlaces = true;
}

#region -- FUNCIONES --

function redirigir_con_mensaje( $page, $type, $message ) {
	$_SESSION['message'] = [ $type, $message ];
	header( 'Location: ' . $page );
	exit;
}

// valida el tamaño del archivo a subir
function validar_tamano( $up_file, $maxsize ) {
	// 2MB == 2097152
	if ( $up_file >= $maxsize ) {
		return false;
	}

	return true;
}

// valida el pdf
function valida_pdf( $up_file ) {

	// verificar si cumple el formato correcto
	if ( $up_file['type'] != "application/pdf" ) {
		redirigir_con_mensaje( 'index.php', 1, 'El archivo a subir no es de tipo PDF' );
	}

	// valida tamaño, 2MB == 2097152
	if ( ! validar_tamano( $up_file['size'], 2097152 ) ) {
		redirigir_con_mensaje( 'index.php', 1, 'Tamaño de archivo muy grande. El archivo debe ser menor a _ megabytes' );
	}

	return true;
}

// insertar anexos de comunicado
function store_docs( $ruta, $enlace, $ids, $conexion_i, $tipo, $id_proceso, $id_convocatoria ) {

	$ii = 0;

	foreach ( $enlace['tmp_name'] as $key => $tmp_name ) {
		if ( $ids[ $ii ] == - 1 ) {
			// CREAR

			$ruta_enlace = null;

			if ( $enlace['size'][ $key ] > 0 ) {

				$file_tmp  = $enlace['tmp_name'][ $key ];
				$file_name = str_replace( ' ', '_', strtoupper( $enlace['name'][ $key ] ) );

				// Validar si existe el directorio, si no => crearlo
				if ( ! is_dir( $ruta ) ) {
					mkdir( $ruta, 0777, true );
				}

				if ( ! file_exists( $ruta . '/' . $file_name ) ) {
					move_uploaded_file( $file_tmp, $ruta . '/' . $file_name )
					or redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria, 1, 'Error al subir los documentos adjuntos' );
				} else {
					redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria, 1, 'Ya existe un documento con el mismo nombre' );
				}

				if ( $conexion_i->conectar() ) {

//					$ext = pathinfo( $enlace['name'][ $key ], PATHINFO_EXTENSION );

					// Guardar
//					$guardar2 = $conexion_i->insertar_documentos($ext, $file_name, $id);
					$orden = mysqli_fetch_row( $conexion_i->get_max_orden_x_tipo( $tipo, $id_proceso ) );
					if ( is_null( $orden[0] ) || $orden[0] == '' ) {
						$orden = 1;
					} else {
						$orden = $orden[0] + 1;
					}

//					$guardar2 = $conexion_i->insertar_documentos( $tipo, $file_name . '.' . $ext, $orden, $id_proceso );
					$guardar2 = $conexion_i->insertar_documentos( $tipo, $file_name, $orden, $id_proceso );
					$conexion_i->desconectar();

					if ( ! $guardar2 ) {
						redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria, 1, 'Error al guardar los datos' );
					}
				} else {
					redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria, 1, 'Error al conectar con la BD' );
				}
			}
		}
		$ii ++;
	}
}

// elimina anexos
function elimina_anexos( $path, $tipo, $id_proceso, $conexion_i, $deleted, $id_convocatoria ) {

	if ( $deleted != null && $deleted != '' ) {
		if ( $conexion_i->conectar() ) {
			$gr = $conexion_i->get_docs_x_nombre( $tipo, $deleted );
			$gg = $conexion_i->elimina_docs( $deleted, $id_proceso );
			$conexion_i->desconectar();

			// eliminar los documentos alojados
			if ( $gr->num_rows > 0 && $gg ) {
				while ( $row = mysqli_fetch_row( $gr ) ) {
					if ( file_exists( $path . '/' . $row[0] ) ) {
						unlink( $path . '/' . $row[0] );
					}
				}
			}
		} else {
			redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria, 1, 'Ocurrio un error al conectar con la BD' );
		};
	}
}

#endregion

if ( isset( $_POST["id_proceso"] ) &&
     isset( $_POST["tipo"] ) &&
     isset( $_POST["deleted"] ) ) {

	// -- GET DATA --
	$id_proceso      = $_POST["id_proceso"];
	$deleted         = $_POST['deleted'];
	$tipo            = $_POST['tipo'];
	$id_convocatoria = '';

	if ( $conexion_i->conectar() ) {
		$id_convocatoria = $conexion_i->get_id_convocatoria( $id_proceso );
		$conexion_i->desconectar();
	}

	$id_convocatoria = mysqli_fetch_row( $id_convocatoria );

	// Ruta donde se guardarán los documentos
	$ruta = realpath( __DIR__ . '/../../../../documentos/convocatorias_cas/' );

	if ( $conexion_i->conectar() ) {
		$datos_ruta = $conexion_i->getdata_ruta( $id_proceso );
		$conexion_i->desconectar();

		$row = mysqli_fetch_row( $datos_ruta );

		$nro_proc = preg_replace( '/[^A-Za-z0-9\-]/', '', $row[2] );

		$ruta = $ruta .
		        '/' .
		        $row[0] . // Año
		        '/' .
		        str_replace( ' ', '_', $row[1] ) . // Nombre Convocatoria
		        '/' .
		        $nro_proc . // Numero Proceso
		        '/';
	} else {
		redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria[0], 1, 'Ocurrio un error al conectar con la BD' );
	}

	// Actualizar (SI HUBIERE documentos a subir)
	if ( $enlaces ) {
		store_docs( $ruta, $_FILES['enlace'], $ids, $conexion_i, $tipo, $id_proceso, $id_convocatoria[0] );
	}
	elimina_anexos( $ruta, $tipo, $id_proceso, $conexion_i, $deleted, $id_convocatoria[0] );

	// CORRECTO
	redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria[0], 0, 'Documentos actualizados correctamente' );

} else {
	redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria[0], 1, 'Ocurrio un error al guardar el comunicado' );
}