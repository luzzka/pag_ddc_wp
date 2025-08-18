<?php
session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

if (isset($_GET['id'])){

    $id = $_GET['id'];

    if ($conexion_i->conectar()) {

        $result = $conexion_i->cambia_estado($id);
        $conexion_i->desconectar();

        if ($result)
        {
            // CORRECTO

            // redirigir estableciendo sessiones (  )
            // $_SESSION['tipo-res'] = '';
            // $_SESSION['ano'] = '';

            // $conexion_i->redirigir_con_mensaje('index.php', 0, 'Cambio de estado correcto');
            $_SESSION['message'] = [0, 'Cambio de estado correcto'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else $conexion_i->redirigir_con_mensaje('index.php', 1, 'No se pudo realizar la accion');

    } else $conexion_i->redirigir_con_mensaje('index.php', 1, 'Error al establecer una conexion con la BD');
} else $conexion_i->redirigir_con_mensaje('index.php', 1, 'No se pudo realizar la accion');