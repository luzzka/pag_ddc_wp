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
function store_docs( $ruta, $enlace, $ids, $conexion_i, $id_convocatoria ) {

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
					or redirigir_con_mensaje( 'index.php', 1, 'Error al subir los documentos adjuntos' );
				} else {
					redirigir_con_mensaje( 'index.php', 1, 'Ya existe un documento con el mismo nombre' );
				}

				if ( $conexion_i->conectar() ) {

					// $ext = pathinfo( $enlace['name'][ $key ], PATHINFO_EXTENSION );

					// Guardar
					$orden = mysqli_fetch_row( $conexion_i->get_max_orden_fde( $id_convocatoria ) );
					if ( is_null( $orden[0] ) || $orden[0] == '' ) {
						$orden = 1;
					} else {
						$orden = $orden[0] + 1;
					}

					$titulo =  str_replace( '_', ' ', $file_name );
					$titulo =  str_replace( '.PDF', '', $titulo );

					$guardar2 = $conexion_i->insertar_fde( $titulo, $file_name, $orden, $id_convocatoria );
					$conexion_i->desconectar();

					if ( ! $guardar2 ) {
						redirigir_con_mensaje( 'index.php', 1, 'Error al guardar los datos' );
					}
				} else {
					redirigir_con_mensaje( 'index.php', 1, 'Error al conectar con la BD' );
				}
			}
		}
		$ii ++;
	}
}

// elimina otros documentos
function elimina_anexos( $path, $conexion_i, $deleted ) {

	if ( $deleted != null && $deleted != '' ) {
		if ( $conexion_i->conectar() ) {
			$gr = $conexion_i->get_docs_fde_x_nombre( $deleted );
			$gg = $conexion_i->elimina_docs_fde( $deleted );
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
			redirigir_con_mensaje( 'index.php', 1, 'Ocurrio un error al conectar con la BD' );
		};
	}
}

#endregion

if ( isset( $_POST["id_convocatoria"] ) &&
     isset( $_POST["deleted"] ) ) {

	// -- GET DATA --
	$id_convocatoria = $_POST["id_convocatoria"];
	$deleted         = $_POST['deleted'];

	// Ruta donde se guardarán los documentos
	$ruta = realpath( __DIR__ . '/../../../../documentos/convocatorias_cas/' );

	if ( $conexion_i->conectar() ) {
		$datos_ruta = $conexion_i->getdata_ruta_x_idconv( $id_convocatoria );
		$conexion_i->desconectar();

		$row = mysqli_fetch_row( $datos_ruta );

		$ruta = $ruta .
		        '/' .
		        $row[0] . // Anio de la Convocatoria
		        '/' .
		        str_replace( ' ', '_', $row[1] ) . // Nombre Convocatoria
		        '/FE_DE_ERRATAS/';
	} else {
		redirigir_con_mensaje( 'index.php', 1, 'Ocurrio un error al conectar con la BD' );
	}

	// Actualizar (SI HUBIERE documentos a subir)
	if ( $enlaces ) {
		store_docs( $ruta, $_FILES['enlace'], $ids, $conexion_i, $id_convocatoria );
	}
	elimina_anexos( $ruta, $conexion_i, $deleted );

	// CORRECTO
	redirigir_con_mensaje( 'index.php', 0, 'Documentos actualizados correctamente' );

} else {
	redirigir_con_mensaje( 'index.php', 1, 'Ocurrio un error al guardar' );
}