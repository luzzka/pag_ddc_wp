<?php

error_reporting(E_ALL);

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

// -- MÉTODOS --

function redirigir_con_mensaje($page, $type, $message)
{
    $_SESSION['message'] = [$type, $message];
    header('Location: ' . $page);
    exit;
}

function validar_tamano($up_file, $maxsize)
{
    if ($up_file >= $maxsize) {
        return false;
    }
    return true;
}

function valida_pdf($up_file)
{

    // verificar si esta seteada
    if (!isset($up_file)) {
        redirigir_con_mensaje('index.php', 1, 'No se encontro el archivo a subir');
    }

    // verificar si cumple el formato correcto
    if ($up_file['type'] != "application/pdf") {
        redirigir_con_mensaje('index.php', 1, 'El archivo a subir no es de tipo PDF');
    }

    // todo especificar tamano de subida 2MB == 2097152
    if (!validar_tamano($up_file['size'], 2097152)) {
        redirigir_con_mensaje('index.php', 1, 'Tamaño de archivo muy grande. El archivo debe ser menor a _ megabytes');
    }

    return true;
}

function sube_file($up_file, $ruta) {

    $source_file = $up_file['tmp_name'];

    // Obtener el nombre generico del archivo

    $ext = pathinfo($up_file['name'], PATHINFO_EXTENSION);
    $nombre_archivo = time().'_'.mt_rand().'.'.strtolower($ext);
    // $nombre_archivo = strtoupper(str_replace(" ", "_", $up_file['name']));

    $dest_file = $ruta . '/' . $nombre_archivo;

    // verificar si ya existe un archivo con el mismo nombre en la ruta
    if (file_exists($dest_file)) {
        redirigir_con_mensaje('index.php', 1, 'Ya existe un archivo con el mismo nombre');
    } else {
        // Subir archivo
        if ( !is_dir($ruta) ) redirigir_con_mensaje('index.php', 1, 'Directorio inexistente.');
        if ( !is_writable($ruta) ) redirigir_con_mensaje('index.php', 1, 'Directorio sin permisos de escritura.');
        else {
            move_uploaded_file($source_file, $dest_file)
            or redirigir_con_mensaje('index.php', 1, 'Error al subir el elemento. Por favor intente nuevamente');
        }

        if ($up_file['error'] == 0) {
//            $ext = pathinfo($up_file['name'], PATHINFO_EXTENSION);
//            return $nombre_archivo . '.' . $ext;
            return $nombre_archivo;
        } else redirigir_con_mensaje('index.php', 1, 'Ocurrió un error de validación');
    }
    return false;
}

// -- -- --

if (isset($_POST["nombre"]) &&
    isset($_POST["enlace"]) &&
    isset($_POST["date"])) {

    // -- OBTENER DATA --
    $nombre = $_POST["nombre"];
    $enlace = $_POST["enlace"];

    $date = $_POST["date"];

    // Ruta Base
    $ruta_dmdocuments = realpath(__DIR__ . '/../../../../dmdocuments/');

    $nombre_imagen = '';
    $nombre_archivo = '';

    if ($_FILES['imagen']['size'] > 0) {
        // Subir y Obtener Nombre de la imagen
        $nombre_imagen = sube_file( $_FILES['imagen'], $ruta_dmdocuments . '/ddc-publicaciones/img/' );
    }
    if ($_FILES['documento']['size'] > 0) {
        // Subir y Obtener Nombre del PDF
        $nombre_archivo = sube_file($_FILES['documento'], $ruta_dmdocuments . '/ddc-publicaciones/');
    }

    if ($conexion_i->conectar()) {

//        echo 'nombre_imagen: '.$nombre_imagen;
//        echo '<br>';
//        echo 'nombre: '.$nombre;
//        echo '<br>';
//        echo 'enlace: '.$enlace;
//        echo '<br>';
//        echo 'nombre_archivo: '.$nombre_archivo;
//        echo '<br>';
//        echo 'date: '.$date;
//        exit;

        // guardar
        $guardar = $conexion_i->inserta_publicacion($nombre_imagen, $nombre, $enlace, $nombre_archivo, $date,1);
        $conexion_i->desconectar();

        if ($guardar) {
            // Correcto, redirigir a index.php
            redirigir_con_mensaje('index.php', 0, 'Publicación creada correctamente');
        } else redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al guardar los datos');
    } else redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al conectar con la BD');
} else redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al momento de enviar los datos');