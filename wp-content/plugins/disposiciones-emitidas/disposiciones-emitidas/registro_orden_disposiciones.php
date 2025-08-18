<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

if ( isset($_POST['ids']) ) {

    $ids = $_POST['ids'];

    if ($conexion_i->conectar()) {

        $result = $conexion_i->actualiza_orden($ids);
        $conexion_i->desconectar();

        // if ($result) $conexion_i->redirigir_con_mensaje('index.php', 0, 'Orden actualizado correctamente');
        if ($result)
        {
            // CORRECTO
            // $_SESSION['message'] = [0, 'Orden actualizado correctamente'];
            // header('Location: ' . $_SERVER['HTTP_REFERER']);
            $conexion_i->redirigir_con_mensaje('index.php', 0, 'Orden actualizado correctamente');
        }
        else $conexion_i->redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al guardar el orden');

    } else $conexion_i->redirigir_con_mensaje('index.php', 1, 'Error: No se pudo establecer conexión con la Base de Datos');
} else $conexion_i->redirigir_con_mensaje('index.php', 1, 'Error: Valores no establecidos');