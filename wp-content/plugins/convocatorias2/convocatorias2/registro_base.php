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
    isset($_POST["tipo"]) &&
    isset($_POST["enlace"]) &&
    isset($_POST["estado"]) ) {

    // -- OBTENER DATA --
    $titulo = $_POST["titulo"];
    $tipo = $_POST["tipo"];
    $enlace = $_POST["enlace"];
    $estado = $_POST["estado"];

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

    if ( $tipo == 1 )
    {
        $ruta = null;
        // si el enlace esta vacio
        if ($enlace != '' && !is_null($enlace)) {
            $ruta = $enlace;
        }

        // Subir con enlace
        if($conexion_i->conectar()) {
            $result = $conexion_i->insertar_base('info-icon.png', $titulo, $estado, $tipo, $ruta);
            $conexion_i->desconectar();

            if ($result) redirigir_con_mensaje('bases.php',0,'Elemento agregado correctamente');
            else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al agregar el nuevo elemento');
        }
        else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al momento de conectar con la BD');
    }
    else
    {
        // todo validar tipo de archivo
        // subir documento
        //if ( valida_pdf($_FILES['documento']) ) {

        $source_file = $_FILES['documento']['tmp_name'];
        $ext = pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);

        $nombre_archivo = strtoupper( str_replace(" ","_", $_FILES['documento']['name']) );

        $dir_dest_file = "../../../../documentos/convocatorias/";
        $dest_file = $dir_dest_file . $nombre_archivo;

        // verificar si ya existe un archivo con el mismo nombre en la ruta
        if (file_exists($dest_file)) {
            redirigir_con_mensaje('bases.php',1, 'Ya existe un archivo con el mismo nombre');
        }
        else {
            // Validar si existe el directorio, si no -> crearlo
            if ( ! is_dir($dir_dest_file)) {
                mkdir($dir_dest_file, 0777, true);
            }

            // Subir archivo
            move_uploaded_file($source_file, $dest_file)
            or redirigir_con_mensaje('bases.php',1,'Error al subir el PDF. Intente Nuevamente');

            if ($_FILES['documento']['error'] == 0) {

                // seleccionar icono
                switch ($ext) {
                    case 'pdf':
                    case 'PDF':
                        $ext = 'pdf-file.png';
                        break;
                    case 'xls':
                    case 'xlsx':
                    case 'XLS':
                    case 'XLSX':
                        $ext = 'excel-file.png';
                        break;
                    case 'doc':
                    case 'docx':
                    case 'DOC':
                    case 'DOCX':
                        $ext = 'word-file.png';
                        break;
                    default:
                        $ext = 'info-icon.png';
                        break;
                }


                if ($conexion_i->conectar()) {

                    // guardar
                    $guardar = $conexion_i->insertar_base($ext, $titulo, $estado, $tipo, $nombre_archivo);
                    $conexion_i->desconectar();

                    if ($guardar)
                    {
                        // Correcto, redirigir a bases.php
                        redirigir_con_mensaje('bases.php',0,'Elemento creado correctamente');
                    }
                    else {
                        redirigir_con_mensaje('bases.php',1,'Ocurrió un error al guardar los datos');
                    }
                }
            }
        }
    }
}
else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al momento de enviar los datos');