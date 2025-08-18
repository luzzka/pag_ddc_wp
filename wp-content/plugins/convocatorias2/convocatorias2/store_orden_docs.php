<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

if ( isset($_POST['ids']) &&
     isset($_POST['id_convocatoria']) ) {

	$ids = $_POST['ids'];
	$id_convocatoria = $_POST['id_convocatoria'];

	if ($conexion_i->conectar()) {
		$result = $conexion_i->store_orden_docs($ids);
		$conexion_i->desconectar();

		if ($result) $conexion_i->redirigir_con_mensaje('frm_editar_proceso.php?id='.$id_convocatoria, 0, 'Orden actualizado correctamente');
		else $conexion_i->redirigir_con_mensaje('frm_editar_proceso.php?id='.$id_convocatoria, 1, 'Ocurrio un error al guardar el orden');

	} else $conexion_i->redirigir_con_mensaje('frm_editar_proceso.php?id='.$id_convocatoria, 1, 'Error: No se pudo establecer conexión con la Base de Datos');
} else $conexion_i->redirigir_con_mensaje('index.php', 1, 'Error: Valores no establecidos');