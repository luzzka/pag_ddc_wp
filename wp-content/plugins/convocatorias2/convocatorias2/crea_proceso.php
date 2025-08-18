<?php

require( "conectar_i.php" );

if ( isset( $_POST["numero"] ) &&
     isset( $_POST["puesto"] ) &&
     isset( $_POST["id_convocatoria"] ) ) {

	$conexion_i = new ConnectDB();

	$numero          = $_POST["numero"];
	$puesto          = $_POST["puesto"];
	$id_convocatoria = $_POST["id_convocatoria"];

	if ( $conexion_i->conectar() ) {

		$result = $conexion_i->crea_proceso( $numero, $puesto, $id_convocatoria );
		$data_c = $conexion_i->get_data_convocatoria( $id_convocatoria );
		$conexion_i->desconectar();

		if ( $result && $data_c ) {

			$last_id = mysqli_fetch_row( $result );
			$data_c  = mysqli_fetch_row( $data_c );

			$path_nombre = str_replace( ' ', '_', $data_c[0] );
			$path_numero = strtoupper( preg_replace( '/[^A-Za-z0-9\-]/', '', $numero ) );

			// Crear Carpeta
			$base_path = realpath( __DIR__ . '/../../../../documentos/convocatorias_cas/' );

			$ruta = $base_path . '/' . $data_c[1] . '/' . $path_nombre . '/' . $path_numero;

			if ( ! file_exists( $ruta ) ) {
				mkdir( $ruta, 0777, true );
			}

			$arr = array(
				'estado' => true,
				'valor'  => $last_id
			);

			echo json_encode( $arr );

		} else {

			$arr = array(
				'estado' => false,
				'valor'  => 'Ocurrió un error al momento de insertar los datos'
			);

			echo json_encode( $arr );

		}
	} else {

		$arr = array(
			'estado' => false,
			'valor'  => 'No se pudo conectar con la BD'
		);

		echo json_encode( $arr );

	}
} else {

	$arr = array(
		'estado' => false,
		'valor'  => 'No se recibieron correctamente los parámetros'
	);

	echo json_encode( $arr );
}