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

function get_nombre($file){
    // todo escape de caracteres especiales
    return strtoupper( str_replace(" ","_", $file['name']) );
}

function subir_file($file) {
    $source_file = $file['tmp_name'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

    // todo validar tipo de extension correcta

    // $nombre_archivo = strtoupper( str_replace(" ","_", $file['name']) );
    $nombre_archivo = get_nombre($file);

    // $dir_dest_file = "documentos/convocatorias/";
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
        or redirigir_con_mensaje('bases.php',1,'Error al subir el archivo adjunto. Intente Nuevamente');

        if ( $file['error'] == 0 ) return true;
        return false;
    }
}

function selecciona_icon($ext){
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
    return $ext;
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

if ( isset($_POST["titulo"]) &&
    isset($_POST["tipo"]) &&
    isset($_POST["enlace"]) &&
    isset($_POST["estado"]) &&
    isset($_POST["id_base"]) ) {

    // -- OBTENER DATA --
    $titulo = $_POST["titulo"];
    $tipo = $_POST["tipo"];
    $enlace = $_POST["enlace"];
    $estado = $_POST["estado"];
    $id_base = $_POST["id_base"];

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

    $row_old = '';

    // Obtener Data Anterior
    if ($conexion_i->conectar()) {
        $result_base = $conexion_i->lista_base($id_base);
        $conexion_i->desconectar();

        // asignar datos de la base antigua a $row_old
        if ($result_base) {
            if ($result_base->num_rows > 0) $row_old = mysqli_fetch_row($result_base);
            else redirigir_con_mensaje('bases.php', 1,'Error: Sin datos para ese elemento');
        } else redirigir_con_mensaje('bases.php', 1,'Ocurrio un error al traer la data');
    } else redirigir_con_mensaje('bases.php', 1,'Ocurrio un error al conectar con la BD');

    if ($row_old[6] == 0)
    {
        if ($tipo == 0) {
            if ($_FILES['documento']['size'] > 0) {
                $ruta_base = realpath(__DIR__ . '/../../../../documentos/convocatorias/');
                $dir_dest = $ruta_base . '\\' . $row_old[7];
                // borrar enlace antiguo
                if ( file_exists($dir_dest) ) unlink($dir_dest);

                // subir nuevo elemento
                if (subir_file($_FILES['documento'])) {
                    $icon = selecciona_icon(pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION));
                    $nombre_archivo = get_nombre($_FILES['documento']);

                    if ($conexion_i->conectar()) {
                        $guardar = $conexion_i->actualiza_base($id_base, $icon, $titulo, $estado, $tipo, $nombre_archivo);
                        $conexion_i->desconectar();

                        if ($guardar) redirigir_con_mensaje('bases.php',0,'Elemento actualizado correctamente');
                        else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al guardar los datos');
                    } else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al conectar con la BD');
                } else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al subir el archivo al servidor');
            }
            else {
                if ($conexion_i->conectar()) {
                    $guardar = $conexion_i->actualiza_base2($id_base, $titulo, $estado);
                    $conexion_i->desconectar();
                    if ($guardar) redirigir_con_mensaje('bases.php',0,'Elemento actualizado correctamente');
                    else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al guardar los datos');
                } else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al conectar con la BD');
            }
        }
        else {
            $ruta_base = realpath(__DIR__ . '/../../../../documentos/convocatorias/');
            $dir_dest = $ruta_base . '\\' . $row_old[7];
            // borrar enlace antiguo
            if ( file_exists($dir_dest) ) unlink($dir_dest);

            // actualizar enlace
            if($conexion_i->conectar()) {
                $result = $conexion_i->actualiza_base($id_base, 'info-icon.png', $titulo, $estado, $tipo, $enlace);
                $conexion_i->desconectar();

                if ($result) redirigir_con_mensaje('bases.php',0,'Elemento actualizado correctamente');
                else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al agregar el nuevo elemento');
            }
            else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al momento de conectar con la BD');
        }
    }
    else
    {
        if ($tipo == 0) {
            // subir nuevo
            if (subir_file($_FILES['documento'])) {
                $icon = selecciona_icon(pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION));
                $nombre_archivo = get_nombre($_FILES['documento']);

                // actualizar file
                if ($conexion_i->conectar()) {
                    $guardar = $conexion_i->actualiza_base($id_base, $icon, $titulo, $estado, $tipo, $nombre_archivo);
                    $conexion_i->desconectar();

                    if ($guardar) redirigir_con_mensaje('bases.php',0,'Elemento actualizado correctamente');
                    else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al guardar los datos');
                } else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al conectar con la BD');

            } else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al subir el archivo al servidor');
        }
        else {
            // actualizar enlace
            $ruta = null;

            if ($enlace != '' && !is_null($enlace)) $ruta = $enlace;

            if($conexion_i->conectar()) {
                $result = $conexion_i->actualiza_base($id_base,'info-icon.png', $titulo, $estado, $tipo, $ruta);
                $conexion_i->desconectar();

                if ($result) redirigir_con_mensaje('bases.php',0,'Elemento actualizado correctamente');
                else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al agregar el nuevo elemento');
            } else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al momento de conectar con la BD');
        }
    }
}
else redirigir_con_mensaje('bases.php',1,'Ocurrió un error al momento de enviar los datos');