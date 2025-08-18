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

function validar_tamano ($up_file, $maxsize) {
    if( $up_file >= $maxsize) {
        return false;
    }
    return true;
}

function valida_pdf ($up_file) {

    // verificar si esta seteada
    if (!isset($up_file)) {
        redirigir_con_mensaje('bases.php', 1, 'No se encontro el archivo a subir');
    }

    // verificar si cumple el formato correcto
    if ($up_file['type'] != "application/pdf"){
        redirigir_con_mensaje('bases.php',1, 'El archivo a subir no es de tipo PDF');
    }

    // todo especificar tamano de subida 2MB == 2097152
    if (!validar_tamano($up_file['size'], 2097152)) {
        redirigir_con_mensaje('bases.php',1, 'Tamaño de archivo muy grande. El archivo debe ser menor a _ megabytes');
    }

    return true;
}
// -- -- --

if ( isset($_POST["titulo"]) &&
    isset($_POST["tipo-disposicion"]) &&
    isset($_POST["ano"]) &&
    isset($_POST["estado"]) ) {

    // -- OBTENER DATA --
    $titulo = $_POST["titulo"];
    $tipo_disposicion = $_POST["tipo-disposicion"];
    $ano = $_POST["ano"];
    $estado = $_POST["estado"];
    $tipo = $_POST["tipo"]; // [1:URL, 0:Documento]
    $enlace = $_POST["enlace"];

    $ruta_tipo_disposicion = '';

    switch ($tipo_disposicion) {
        case 'Resolución Directoral':
            $tipo_disposicion = 0;
            $ruta_tipo_disposicion = 'resoluciones';
            break;
        case 'Resolución Ministerial':
            $tipo_disposicion = 1;
            $ruta_tipo_disposicion = 'ministerial';
            break;
        case 'Directiva':
            $tipo_disposicion = 2;
            $ruta_tipo_disposicion = 'directivas';
            break;
        case 'Cira':
            $tipo_disposicion = 3;
            $ruta_tipo_disposicion = 'ciras';
            break;
        default:
            $tipo_disposicion = 0;
            $ruta_tipo_disposicion = 'resoluciones';
            break;
    }

    switch ($tipo) {
        case 'Adjuntar Documento':
            $tipo = 0;
            break;
        case 'Enlace':
            $tipo = 1;
            break;
        default:
            $tipo = 1;
            break;
    }

    switch ($estado) {
        case 'PUBLICADO':
            $estado = 1;
            break;
        case 'NO PUBLICADO':
            $estado = 0;
            break;
        default:
            $estado = 0;
            break;
    }

    if ( $tipo == 1 )
    {
        $ruta = null;
        // si la URL está vacía
        if ($enlace != '' && !is_null($enlace)) {
            $ruta = $enlace;
        }

        // Subir con URL
        if($conexion_i->conectar()) {
            $result = $conexion_i->inserta_disposicion($titulo, $tipo_disposicion, $ano, $estado, 'url', $ruta);
            $conexion_i->desconectar();

            if ($result) redirigir_con_mensaje('index.php',0,'Elemento agregado correctamente');
            else redirigir_con_mensaje('index.php',1,'Ocurrió un error al agregar el nuevo elemento');
        } else redirigir_con_mensaje('index.php',1,'Ocurrió un error al momento de conectar con la Base de Datos');
    }
    else
    {
        // todo validar tipo de archivo
        // subir documento
        //if ( valida_pdf($_FILES['documento']) ) {

        $source_file = $_FILES['documento']['tmp_name'];
        $ext = pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);

        $nombre_archivo = strtoupper( str_replace(" ","_", $_FILES['documento']['name']) );

        $dir_dest_file = "/var/www/html/dmdocuments/".$ruta_tipo_disposicion."/".$ano."/";
//        $dir_dest_file = realpath(__DIR__ . '/../../../../dmdocuments/'.$ruta_tipo_disposicion.'/'.$ano.'/');
        $dest_file = $dir_dest_file . $nombre_archivo;

        // verificar si ya existe un archivo con el mismo nombre en la ruta
        if (file_exists($dest_file)) {
            redirigir_con_mensaje('index.php',1, 'Ya existe un archivo con el mismo nombre');
        }
        else {
            // Validar si existe el directorio, si no -> crearlo
            if ( ! is_dir($dir_dest_file)) {
                mkdir($dir_dest_file, 0777, true);
            }



            // Subir archivo
            move_uploaded_file($source_file, $dest_file)
            or redirigir_con_mensaje('index.php', 1, 'Error al subir el documento. Intente Nuevamente');

            if ($_FILES['documento']['error'] == 0) {
                if ($conexion_i->conectar()) {

                    // guardar
                    $guardar = $conexion_i->inserta_disposicion($titulo, $tipo_disposicion, $ano, $estado, $ext, $nombre_archivo);
                    $conexion_i->desconectar();

                    if ($guardar)
                    {
                        // Correcto, redirigir a index.php
                        redirigir_con_mensaje('index.php',0,'Elemento creado correctamente');
                    }
                    else redirigir_con_mensaje('index.php',1,'Ocurrió un error al guardar los datos');
                } else redirigir_con_mensaje('index.php',1,'Ocurrió un error al conectar con la BD');
            } else redirigir_con_mensaje('index.php',1,'Ocurrió un error al validar el documento');
        }
    }
}
else redirigir_con_mensaje('index.php',1,'Ocurrió un error al momento de enviar los datos');