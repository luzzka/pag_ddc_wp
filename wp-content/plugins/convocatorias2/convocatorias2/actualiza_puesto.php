<?php

require( "conectar_i.php" );

if ( isset( $_POST["puesto"] ) &&
     isset( $_POST["id_proceso"] ) ) {

	$conexion_i = new ConnectDB();

	$puesto          = $_POST["puesto"];
	$id_proceso = $_POST["id_proceso"];

	if ( $conexion_i->conectar() ) {

		$result = $conexion_i->actualiza_puesto( $puesto, $id_proceso );
		$conexion_i->desconectar();

		if ( $result ) {

			$arr = array( 'estado' => true );

			echo json_encode( $arr );

		} else {

			$arr = array( 'estado' => false,
			              'valor' => 'Ocurrió un error al momento de insertar los datos' );

			echo json_encode( $arr );

		}
	} else {

		$arr = array( 'estado' => false,
		              'valor' => 'No se pudo conectar con la BD' );

		echo json_encode( $arr );

	}
} else {

	$arr = array( 'estado' => false,
	              'valor' => 'No se recibieron correctamente los parámetros' );

	echo json_encode( $arr );
}