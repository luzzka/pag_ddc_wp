<?php
session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

// -- METODOS --
function redirigir_con_mensaje ($page, $type, $message) {
    $_SESSION['message'] = [$type, $message];
    header('Location: ' . $page);
    exit;
}
// -- -- -- --

if (isset($_GET['id'])){

    $id_comunicado = $_GET['id'];

    if ($conexion_i->conectar()) {

        $result = $conexion_i->cambia_estado($id_comunicado);
        $conexion_i->desconectar();

        if ($result) redirigir_con_mensaje('index.php', 0, 'Cambio de estado correcto');
        else redirigir_con_mensaje('index.php', 1, 'No se pudo realizar la accion');

    } else redirigir_con_mensaje('index.php', 1, 'Error al establecer una conexion con la BD');
} else redirigir_con_mensaje('index.php', 1, 'No se pudo realizar la accion');