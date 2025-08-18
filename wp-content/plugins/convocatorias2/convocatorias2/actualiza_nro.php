<?php

require( "conectar_i.php" );

if ( isset( $_POST["numero"] ) &&
     isset( $_POST["id_proceso"] ) ) {

	$conexion_i = new ConnectDB();

	$numero     = $_POST["numero"];
	$id_proceso = $_POST["id_proceso"];

	if ( $conexion_i->conectar() ) {

		$result2 = $conexion_i->getdata_ruta( $id_proceso );
		$ruta_doc  = mysqli_fetch_row( $result2 );

		$base_path = realpath( __DIR__ . '/../../../../documentos/convocatorias_cas/' );

		$ruta_old = $base_path .
		            '/' .
		            $ruta_doc[0] .
		            '/' .
		            str_replace( ' ', '_', $ruta_doc[1] ) .
		            '/' .
		            strtoupper( preg_replace( '/[^A-Za-z0-9\-]/', '', $ruta_doc[2] ) );

		$ruta_new = $base_path .
		            '/' .
		            $ruta_doc[0] .
		            '/' .
		            str_replace( ' ', '_', $ruta_doc[1] ) .
		            '/' .
		            strtoupper( preg_replace( '/[^A-Za-z0-9\-]/', '', $numero ) );

		$result  = $conexion_i->actualiza_nro( $numero, $id_proceso );

		$conexion_i->desconectar();

		if ( $result && $result2 ) {

			// renombrar carpeta con el nro de convocatoria
			if ( ! rename( $ruta_old, $ruta_new ) ) {
				$arr = array(
					'estado' => false,
					'valor'  => 'Ocurrió un error al momento de renombrar el directorio'
				);

				echo json_encode( $arr );
			} else {

				$arr = array( 'estado' => true );

				echo json_encode( $arr );
			}
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