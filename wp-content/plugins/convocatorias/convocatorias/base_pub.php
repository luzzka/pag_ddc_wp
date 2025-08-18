<?php
session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

$id_base = $_GET['id_base'];

// -- METODOS --
function redirigir_con_mensaje ($page, $type, $message) {
    $_SESSION['message'] = [$type, $message];
    header('Location: ' . $page);
    exit;
}

if (isset($id_base)){
    if ($conexion_i->conectar()) {
        $result = $conexion_i->pub_nopub_base($id_base);
        $conexion_i->desconectar();
        if ($result) redirigir_con_mensaje('bases.php', 0, 'Cambio de estado correcto');
        else redirigir_con_mensaje('bases.php', 1, 'No se pudo realizar la accion');
    } else redirigir_con_mensaje('bases.php', 1, 'Error al establecer una conexion con la BD');
} else redirigir_con_mensaje('bases.php', 1, 'No se pudo realizar la accion');