<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

// Funciones
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
        redirigir_con_mensaje('index.php', 1, 'No se encontro el archivo a subir');
    }

    // verificar si cumple el formato correcto
    if ($up_file['type'] != "application/pdf"){
        redirigir_con_mensaje('index.php',1, 'El archivo a subir no es de tipo PDF');
    }

    // todo especificar tamano de subida 2MB == 2097152
    if (!validar_tamano($up_file['size'], 2097152)) {
        redirigir_con_mensaje('index.php',1, 'Tamaño de archivo muy grande. El archivo debe ser menor a _ megabytes');
    }

    return true;
}

if ( isset($_POST["titulo-comunicado"]) &&
    isset($_POST["detalle"]) &&
    isset($_POST["estado"]) ) {

    // OBTENER DATA
    $titulo = $_POST["titulo-comunicado"];
    $detalle = $_POST["detalle"];
    $estado = $_POST["estado"];

    $codigo = trim($titulo);
    $detalle = trim($detalle);

    switch ($estado)
    {
        case 0:
            $estado = 0;
            break;
        case 1:
            $estado = 1;
            break;
        default:
            $estado = 0;
            break;
    }

    if ($conexion_i->conectar()) {
        $r = $conexion_i->insertar_comunicado_lid($titulo, $detalle, $estado);
        $conexion_i->desconectar();

        if ($r) {
            // Comunicado Agregado Correctamente
            // obtener el ultimo ID insertado, lid = last id
            $rowlid = mysqli_fetch_row($r);
            $lid = $rowlid[0];

            // Insertar anexos
            if (isset($_FILES["enlace"])) {
                foreach($_FILES['enlace']['tmp_name'] as $key => $tmp_name)
                {
                    if ($_FILES['enlace']['size'][$key] > 0) {
                        $ext = pathinfo($_FILES['enlace']['name'][$key], PATHINFO_EXTENSION);
                        $file_name = str_replace(' ','_', strtoupper($_FILES['enlace']['name'][$key]));
                        $file_tmp = $_FILES['enlace']['tmp_name'][$key];
                        $ruta = realpath(__DIR__ . '/../../../../documentos/comunicados/');

                        // Subir los Documentos
                        if (!file_exists($ruta . '/' . $file_name)) {
                            move_uploaded_file($file_tmp, $ruta . '/' . $file_name)
                            or redirigir_con_mensaje('index.php',1,'Error al subir los documentos anexos');
                        }
                        else redirigir_con_mensaje('index.php',1,'Ya existe un documento con el mismo nombre');

                        // Subir a la BD
                        if ($conexion_i->conectar()) {
                            $guardar = $conexion_i->insertar_anexos($ext, $file_name, $lid);
                            $conexion_i->desconectar();

                            if ($guardar) {
                                // insertado
                            } else redirigir_con_mensaje('index.php',1,'Error al guardar el documento adjunto');
                        }
                    }
                }
                // CORRECTO
                redirigir_con_mensaje('index.php', 0, 'Se agregó el comunicado correctamente');
            }
        } else redirigir_con_mensaje('index.php', 1, 'Error: No se pudo agregar el comunicado, intente nuevamente');
    } else redirigir_con_mensaje('index.php', 1, 'Error: No se pudo establecer una conexion con la Base de Datos');
} else redirigir_con_mensaje('index.php', 1, 'Error: No se enviaron correctamente los datos al servidor');