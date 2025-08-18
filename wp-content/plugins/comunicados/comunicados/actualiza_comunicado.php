<?php

session_start();
require("conectar_i.php");

$conexion_i = new ConnectDB();

$enlaces = false;

if ( isset($_FILES["enlace"]) ) {
    $ids = $_POST["ids"];
    $enlaces = true;
}

#region -- FUNCIONES --

function redirigir_con_mensaje ($page, $type, $message) {
    $_SESSION['message'] = [$type, $message];
    header('Location: ' . $page);
    exit;
}

// valida el tamaño del archivo a subir
function validar_tamano ($up_file, $maxsize) {
    // 2MB == 2097152
    if( $up_file >= $maxsize) {
        return false;
    }

    return true;
}

// valida el pdf
function valida_pdf ($up_file) {

    // verificar si cumple el formato correcto
    if ($up_file['type'] != "application/pdf") {
        redirigir_con_mensaje('index.php',1, 'El archivo a subir no es de tipo PDF');
    }

    // valida tamaño, 2MB == 2097152
    if (!validar_tamano($up_file['size'], 2097152)) {
        redirigir_con_mensaje('index.php',1, 'Tamaño de archivo muy grande. El archivo debe ser menor a _ megabytes');
    }

    return true;
}

// insertar anexos de comunicado
function store_anexos ($enlace, $ids, $conexion_i, $id) {

    $ii = 0;

    // Ruta para la publicación de comunicados
    $ruta = realpath(__DIR__ . '/../../../../documentos/comunicados/');

    foreach($enlace['tmp_name'] as $key => $tmp_name)
    {
        if ($ids[$ii] == -1) {
            // CREAR

            $ruta_enlace = null;

            if ( $enlace['size'][$key] > 0 ) {

                $file_tmp = $enlace['tmp_name'][$key];
                $file_name = str_replace(' ','_', strtoupper( $enlace['name'][$key] ));

                if (!file_exists($ruta . '\\' . $file_name)) {
                    move_uploaded_file($file_tmp, $ruta . '\\' . $file_name)
                    or redirigir_con_mensaje('index.php',1,'Error al subir los documentos anexos');
                }
                else redirigir_con_mensaje('index.php',1,'Ya existe un documento con el mismo nombre');

                if ( $conexion_i->conectar() ) {

                    $ext = pathinfo($enlace['name'][$key], PATHINFO_EXTENSION);

                    // Guardar
                    $guardar2 = $conexion_i->insertar_anexos($ext, $file_name, $id);
                    $conexion_i->desconectar();

                    if ($guardar2){
                        // enlace $i subido correctamente
                    } else redirigir_con_mensaje('index.php',1,'Error al guardar los datos');
                } else redirigir_con_mensaje('index.php',1,'Error al conectar con la BD');
            }
        }
        // else {
        //
        //     // Editar: Eliminar Enlace Anterior si hubiere
        //     $enlace_old = null;
        //
        //     // obtener  anterior  ruta_pdf_old
        //     if ( $conexion_i->conectar() ) {
        //
        //         $rr = $conexion_i->get_anexo($ids[$ii]);
        //         $conexion_i->desconectar();
        //
        //         $row = mysqli_fetch_row($rr);
        //         $enlace_old = $row[0];
        //     }
        //
        //     if ( $enlace['size'][$key] > 0 ) {
        //
        //         $file_tmp = $enlace['tmp_name'][$key];
        //         $file_name = str_replace(' ','_', strtoupper( $enlace['name'][$key] ));
        //         $ext = pathinfo($enlace['name'][$key], PATHINFO_EXTENSION);
        //
        //         // eliminar enlace anterior
        //         if (!is_null($enlace_old) && $enlace_old != "") {
        //             // verificar si ya existe un enlace con el mismo nombre y eliminarlo
        //             if ( file_exists($ruta . '\\' . $enlace_old) ) {
        //                 unlink($ruta . '\\' . $enlace_old);
        //             }
        //         }
        //
        //         // subir nuevo pdf a la ruta
        //         move_uploaded_file($file_tmp, $ruta . $file_name)
        //         or redirigir_con_mensaje('index.php',1,'Error al subir el enlace');
        //
        //         if ($conexion_i->conectar()){
        //             $conexion_i->actualiza_anexo($ids[$ii], $ext, $file_name);
        //             $conexion_i->desconectar();
        //         }
        //     }
        // }
        $ii++;
    }
}

// elimina anexos de comunicados
function elimina_anexos($path, $id_comunicado, $conexion_i, $deleted) {
    if ($deleted != null && $deleted != '') {
        if ($conexion_i->conectar()) {
            $gr = $conexion_i->get_anexos_2($deleted);
            $gg = $conexion_i->elimina_anexos($deleted, $id_comunicado);
            $conexion_i->desconectar();

            // eliminar los documentos alojados
            if ($gr->num_rows > 0 && $gg) {
                while ($row = mysqli_fetch_row($gr)) {
                    if ( file_exists($path . '\\' . $row[0]) ) {
                        unlink($path . '\\' . $row[0]);
                    }
                }
            }

        }
        else { redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al conectar con la BD'); };
    }
}

#endregion

if ( isset($_POST["id"]) &&
    isset($_POST["titulo-comunicado"]) &&
    isset($_POST["detalle"]) &&
    isset($_POST["estado"]) &&
    isset($_POST["deleted"])) {

    // -- GET DATA --
    $id = $_POST["id"];
    $titulo = $_POST["titulo-comunicado"];
    $detalle = $_POST["detalle"];
    $estado = $_POST["estado"];
    $deleted = $_POST['deleted'];

    // quitar espacios a las variables
    $titulo = trim($titulo);
    $detalle = trim($detalle);

    switch ($estado) {
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

    // Ruta para la publicación de comunicados
    $ruta = realpath(__DIR__ . '/../../../../documentos/comunicados/');

    // Actualizar el comunicado
    if ($conexion_i->conectar()) {
        $r = $conexion_i->actualiza_comunicado($id, $titulo, $detalle, $estado);
        $conexion_i->desconectar();
        if ($r) {
            // Comunicado Actualizado Correctamente

            // Actualizar Anexos (SI HUBIERE)
            if ($enlaces) {
                store_anexos($_FILES['enlace'], $ids, $conexion_i, $id);
            }
            // elimina_enlaces($dir_dest_file, $id, $conexion_i, $deleted);
            elimina_anexos($ruta, $id, $conexion_i, $deleted);

            // CORRECTO
            redirigir_con_mensaje('index.php',0, 'Comunicado actualizado correctamente');

        } else $conexion_i->redirigir_con_mensaje('index.php',1,'Ocurrió un error al momento de guardar los datos');
    } else $conexion_i->redirigir_con_mensaje('index.php',1,'Ocurrió un error al conectar con la Base de Datos');
}
else redirigir_con_mensaje('index.php',1, 'Ocurrio un error al guardar el comunicado');