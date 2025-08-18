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
function store_docs( $ruta, $enlace, $ids, $conexion_i, $tipo, $id_convocatoria ) {

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
					$orden = mysqli_fetch_row( $conexion_i->get_max_orden_x_tipo_global( $tipo, $id_convocatoria ) );
					if ( is_null( $orden[0] ) || $orden[0] == '' ) {
						$orden = 1;
					} else {
						$orden = $orden[0] + 1;
					}

					$guardar2 = $conexion_i->insertar_documentos_global( $tipo, $file_name, $orden, $id_convocatoria );
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
function elimina_anexos( $path, $conexion_i, $deleted, $id_convocatoria ) {

	if ( $deleted != null && $deleted != '' ) {
		if ( $conexion_i->conectar() ) {
			$gr = $conexion_i->get_docs_global_x_nombre( $deleted );
			$gg = $conexion_i->elimina_docs_global( $deleted, $id_convocatoria );
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

if ( isset( $_POST["id_convocatoria"] ) &&
     isset( $_POST["tipo"] ) &&
     isset( $_POST["deleted"] ) ) {

	// -- GET DATA --
	$deleted         = $_POST['deleted'];
	$tipo            = $_POST['tipo'];
	$id_convocatoria = $_POST["id_convocatoria"];
//	$id_proceso = $_POST["id_proceso"];

//	if ( $conexion_i->conectar() ) {
//		$convocatoria = $conexion_i->getdata_convocatoria_x_id( $id_convocatoria );
//		$conexion_i->desconectar();
//	}

//	$convocatoria = mysqli_fetch_row( $convocatoria );

	// Ruta donde se guardarán los documentos
	$ruta = realpath( __DIR__ . '/../../../../documentos/convocatorias_cas/' );

	if ( $conexion_i->conectar() ) {
		$datos_ruta = $conexion_i->getdata_ruta_x_idconv( $id_convocatoria );
		$conexion_i->desconectar();

		$row = mysqli_fetch_row( $datos_ruta );

		$ruta = $ruta .
		        '/' .
		        $row[0] . // Año
		        '/' .
		        str_replace( ' ', '_', $row[1] ) . // Nombre Convocatoria
		        '/';
	} else {
		redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria, 1, 'Ocurrio un error al conectar con la BD' );
	}

	// Actualizar (SI HUBIERE documentos a subir)
	if ( $enlaces ) {
		store_docs( $ruta, $_FILES['enlace'], $ids, $conexion_i, $tipo, $id_convocatoria );
	}
	elimina_anexos( $ruta, $conexion_i, $deleted, $id_convocatoria );

	// CORRECTO
	redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria, 0, 'Documentos actualizados correctamente' );

} else {
	redirigir_con_mensaje( 'frm_editar_proceso.php?id=' . $id_convocatoria, 1, 'Ocurrio un error al guardar el contenido' );
}