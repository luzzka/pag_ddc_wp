<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

// -- METODOS --
function redirigir_con_mensaje($page, $type, $message) {
    $_SESSION['message'] = [$type, $message];
    header('Location: ' . $page);
    exit;
}

function elimina_anterior($result, $criterio) {

    // Ruta Base
    $ruta_dmdocuments = realpath(__DIR__ . '/../../../../dmdocuments/');

    if ($criterio == 1) {
        while ($row = $result->fetch_assoc()) {
            if (!is_null($row["imagen"]) && $row["imagen"] != '') {

                $ruta = $ruta_dmdocuments . '/ddc-publicaciones/img/' . $row["imagen"];

                if (file_exists($ruta)) unlink($ruta);
            }
        }
    }
    if ($criterio == 2) {
        while ($row = $result->fetch_assoc()) {
            if (!is_null($row["pdf"]) && $row["pdf"] != '') {

                $ruta = $ruta_dmdocuments . '/ddc-publicaciones/' . $row["pdf"];

                if (file_exists($ruta)) unlink($ruta);
            }
        }
    }
}

function sube_file($up_file, $ruta) {

    $source_file = $up_file['tmp_name'];

    $ext = pathinfo($up_file['name'], PATHINFO_EXTENSION);
    $nombre_archivo = time().'_'.mt_rand().'.'.strtolower($ext);
    // $nombre_archivo = strtoupper(str_replace(" ", "_", $up_file['name']));

    $dest_file = $ruta . '/' . $nombre_archivo;

    // verificar si ya existe un archivo con el mismo nombre en la ruta
    if (file_exists($dest_file)) redirigir_con_mensaje('index.php', 1, 'Ya existe un archivo con el mismo nombre');
    else {
        // Subir archivo
        if (!is_dir($ruta)) redirigir_con_mensaje('index.php', 1, 'Directorio inexistente.');
        if (!is_writable($ruta)) redirigir_con_mensaje('index.php', 1, 'Directorio sin permisos de escritura.');
        else {
            move_uploaded_file($source_file, $dest_file)
            or redirigir_con_mensaje('index.php', 1, 'Error al subir el elemento. Por favor intente nuevamente');
        }

        if ($up_file['error'] == 0) {
            return $nombre_archivo;
        } else redirigir_con_mensaje('index.php', 1, 'Ocurrió un error de validación');
    }
    return false;
}

//function validar_tamano ($up_file, $maxsize) {
//    if( $up_file >= $maxsize) {
//        return false;
//    }
//    return true;
//}

//function valida_pdf ($up_file) {
//
//    // verificar si esta seteada
//    if (!isset($up_file)) {
//        redirigir_con_mensaje('bases.php', 1, 'No se encontro el archivo a subir');
//    }
//
//    // verificar si cumple el formato correcto
//    if ($up_file['type'] != "application/pdf"){
//        redirigir_con_mensaje('bases.php',1, 'El archivo a subir no es de tipo PDF');
//    }
//
//    // todo especificar tamano de subida 2MB == 2097152
//    if (!validar_tamano($up_file['size'], 2097152)) {
//        redirigir_con_mensaje('bases.php',1, 'Tamaño de archivo muy grande. El archivo debe ser menor a _ megabytes');
//    }
//
//    return true;
//}
// -- -- --

if (isset($_POST["nombre"]) &&
    isset($_POST["enlace"]) &&
    isset($_POST["date"]) &&
    isset($_POST["id_publicacion"])) {

    // -- OBTENER DATA --
    $nombre = $_POST["nombre"];
    $enlace = $_POST["enlace"];
    $date = $_POST["date"];

    $id_publicacion = $_POST["id_publicacion"];

    $new_imagen = $_FILES['imagen'];
    $new_pdf = $_FILES['documento'];

    $nombre_img = '';
    $nombre_pdf = '';
    $old_data = null;

    // Ruta Base
    $ruta_dmdocuments = realpath(__DIR__ . '/../../../../dmdocuments/');

    // verificar si hay nueva imagen
    if ($new_imagen['size'] > 0) {
//        echo 'hay nueva img';
//        exit(0);
        // existe nueva IMG
        // -- eliminar anterior IMG
        // obtener ruta anterior de IMG
        if ($conexion_i->conectar()) {
            $old_data = $conexion_i->get_filenames($id_publicacion);
            if ($old_data) {
                // eliminar IMG anterior (IMG => 1)
                elimina_anterior($old_data, 1);

                // subir nueva img
                // todo validacion IMG
                $nombre_img = sube_file($new_imagen, $ruta_dmdocuments . '/ddc-publicaciones/img/');

            } else redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al traer la data');
        } else redirigir_con_mensaje('index.php', 1, 'Ocurrio un error de conexión');
    }

    // verificar si hay nuevo documento
    if ($new_pdf['size'] > 0) {
        // existe nuevo documento -
        // eliminar la anterior y subir el nuevo
        if ($old_data == null) {
            if ($conexion_i->conectar()) $old_data = $conexion_i->get_filenames($id_publicacion);
            else redirigir_con_mensaje('index.php', 1, 'Ocurrio un error de conexión');
        }

        elimina_anterior($old_data, 2);

        // subir nuevo PDF
        // todo validacion PDF
        $nombre_pdf = sube_file($new_pdf, $ruta_dmdocuments . '/ddc-publicaciones/');
    }

    // insertar en la BD

    if ($conexion_i->conectar()) {
        $guardar = $conexion_i->actualiza_publicacion($id_publicacion, $nombre_img, $nombre, $enlace, $nombre_pdf, $date);
        $conexion_i->desconectar();

        if ($guardar) redirigir_con_mensaje('index.php', 0, 'Publicación actualizada correctamente');
        else redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al guardar los datos');
    } else redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al conectar con la BD');
} else redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al enviar los datos');