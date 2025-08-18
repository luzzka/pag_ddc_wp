<?php

session_start();
//include("conectar_i.php");
require("conectar_i.php");

$conexion_i = new ConnectDB();

// get data
$id = $_POST["id"];
$tipo = $_POST["tipo"];
$ano = $_POST["ano"];
$nro = $_POST["nro_conv"];
$codigo = $_POST["codigo-convocatoria"];
$estado = $_POST["estado"];

$date = $_POST["date"];

$estado_documento = $_POST['estado_documento'];

$deleted = $_POST['deleted'];

$enlaces = false;

if ( isset($_POST['titulo']) ) {
    $titulos = $_POST['titulo'];
    $detalles = $_POST['detalle'];
    $ids = $_POST['ids'];

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

// insertar enlaces
function store_enlace ($tipo, $ano, $nro, $enlace, $ids, $titulos, $detalles, $conexion_i, $id) {

    $ii = 0;

    $dir_dest_file = "/var/www/html/documentos/convocatorias/". $tipo ."/". $ano ."/". $nro ."/";

    foreach($enlace['tmp_name'] as $key => $tmp_name)
    {
        if ($ids[$ii] == -1) {
            // CREAR

            $ruta_enlace = null;

            if ( $enlace['size'][$key] > 0 ){
                // existe file enlace

                $file_tmp = $enlace['tmp_name'][$key];

                $ruta_enlace = strtoupper($titulos[$ii].'_'.$tipo.'_'.$nro.'_'.$ano).'.pdf';

                move_uploaded_file($file_tmp, $dir_dest_file . $ruta_enlace)
                or redirigir_con_mensaje('index.php',1,'Error al subir los enlaces');
            }

            if ( $conexion_i->conectar() ) {

                // crear la ruta del pdf anexo
                //$ruta_e = $dir_dest_file . $file_name;

                // comprobar si la ruta es valida dependiendo de la existencia del pdf
                //if (is_null($file_tmp) or $file_tmp == '') $ruta_e = null;

                // guardar
                $guardar2 = $conexion_i->insertar_publicacion($titulos[$ii], $detalles[$ii], $ruta_enlace, $id);
                $conexion_i->desconectar();

                if ($guardar2){
                    // enlace subido correctamente
                } else {
                    redirigir_con_mensaje('index.php',1,'Error al guardar los datos');
                }
            } else {
                redirigir_con_mensaje('index.php',1,'Error al conectar con la BD');
            }
        }
        else {

            // Editar: Eliminar Enlace Anterior si hubiere

            $ruta_enlace_old = null;

            // obtener  anterior  ruta_pdf_old
            if ( $conexion_i->conectar() ) {

                $rr = $conexion_i->get_rutaenlace_convocatoria($ids[$ii]);
                $conexion_i->desconectar();

                $row = mysqli_fetch_row($rr);

                $ruta_enlace_old = $row[0];
            }

            if ( $enlace['size'][$key] > 0 ){

                // obtener nombre correcto
                $ruta_enlace = $titulos[$ii].'_'.$tipo.'_'.$nro.'_'.$ano.'.pdf';
                $file_tmp = $enlace['tmp_name'][$key];

                // eliminar enlace anterior
                if (!is_null($ruta_enlace_old) && $ruta_enlace_old != "") {
                    // verificar si ya existe un enlace con el mismo nombre, y eliminarlo
                    if ( file_exists($dir_dest_file . $ruta_enlace_old) ) unlink($dir_dest_file . $ruta_enlace_old);
                }

                // subir pdf a la ruta
                move_uploaded_file($file_tmp, $dir_dest_file . $ruta_enlace)
                or redirigir_con_mensaje('index.php',1,'Error al subir el enlace');

                if ($conexion_i->conectar()){
                    $conexion_i->actualizar_publicacion($ids[$ii],$titulos[$ii], $detalles[$ii], $ruta_enlace);
                    $conexion_i->desconectar();
                }
            }
            else {
                if ($conexion_i->conectar()){
                    $conexion_i->actualizar_publicacion_no_ruta($ids[$ii],$titulos[$ii], $detalles[$ii]);
                    $conexion_i->desconectar();
                }
            }
        }
        $ii++;
    }
}

// elimina enlaces
function elimina_enlaces($path, $id, $conexion_i, $deleted) {
    if ($deleted != null && $deleted != '') {
        if ($conexion_i->conectar()){
            $gr = $conexion_i->get_rutasenlaces_convocatoria($deleted);
            $gg = $conexion_i->elimina_conv_publicaciones($deleted, $id);
            $conexion_i->desconectar();

            // eliminar todas las tuplas
            if ($gr->num_rows > 0 && $gg) {
                while($row = $gr->fetch_assoc()) {
                    if ( file_exists($path . $row["ruta_enlace"]) ) {
                        unlink($path . $row["ruta_enlace"]);
                    }
                }
            }

        }
        else { redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al conectar con la BD'); };
    }
}

#endregion

if ( isset( $_FILES['documento'] ) &&
    isset( $codigo ) &&
    isset( $tipo ) &&
    isset( $ano ) &&
    isset( $nro ) &&
    isset( $estado ) ) {

    // quitar espacios a las variables
    $codigo = trim($codigo);
    $nro = trim($nro);

    switch ($tipo) {
        case 0:
            $tipo = 'CAS';
            break;
    }

    $dir_dest_file = "/var/www/html/documentos/convocatorias/". $tipo ."/". $ano ."/". $nro ."/";

    // obtener estado anterior
    $estado_documento_old = 0;
    $ruta_pdf_old = '';

    if ( $conexion_i->conectar() ) {

        $rr = $conexion_i->get_rutapdf_convocatoria($id);
        $conexion_i->desconectar();

        $row = mysqli_fetch_row($rr);

        $ruta_pdf_old = $row[0];
        if (!is_null($ruta_pdf_old) && $ruta_pdf_old != ''){
            $estado_documento_old = 1;
        }
    }

    // [$estado_documento_old == 0] => Sin Documento Anterior
    // [$estado_documento_old == 1] => Con Documento Anterior

    if ( $estado_documento_old == 0 ) // no cuenta con documento anterior
    {
        $ruta_pdf = null;

        if ( $_FILES['documento']['size'] > 0 ) // hay documento nuevo
        {
            // crear y establecer ruta; subir el nuevo pdf
            if ( valida_pdf($_FILES['documento']) ) {

                // rutas
                $source_file = $_FILES['documento']['tmp_name'];
                $nombre_archivo = strtoupper("CONVOCATORIA_".$tipo."_".$nro."_".$ano);
                $dir_dest_file = "/var/www/html/documentos/convocatorias/". $tipo ."/". $ano ."/". $nro ."/";
                $dest_file = $dir_dest_file . $nombre_archivo . '.pdf';

                // verificar si ya existe un archivo con el mismo nombre, y eliminarlo
                if ( file_exists($dest_file) ) unlink($dest_file);

                // Validar si existe el directorio, si no => crearlo
                if ( ! is_dir($dir_dest_file)) {
                    mkdir($dir_dest_file, 0777, true);
                }

                // subir documento
                move_uploaded_file($source_file, $dest_file)
                or redirigir_con_mensaje('index.php',1, 'Ocurrio un error al subir el PDF');

                // establecer ruta
                if ($_FILES['documento']['error'] == 0) {
                    $ruta_pdf = $nombre_archivo . '.pdf';
                }
            }
            else { redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al validar el documento'); };
        }

        if ($conexion_i->conectar()) {

            $guardar = $conexion_i->actualizar_convocatoria($id, $date, $tipo, $ano, $nro, $codigo, $ruta_pdf, $estado);
            $conexion_i->desconectar();

            if ($guardar)
            {
                // -- CONVOCATORIA ACTUALIZADA --

                // Actualizar Documentos Anexos SI HUBIERE
                if ($enlaces) {
                    store_enlace($tipo, $ano, $nro, $_FILES['enlace'], $ids, $titulos, $detalles, $conexion_i, $id);
                }
                elimina_enlaces($dir_dest_file, $id, $conexion_i, $deleted);

                // CORRECTO
                redirigir_con_mensaje('index.php',0, 'Convocatoria actualizada correctamente');
            }
            else {
                // ERROR AL ACTUALIZAR
                redirigir_con_mensaje('index.php',1, 'Ocurrio un error al editar la convocatoria');
            }
        }
        else { redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al conectar a la Base De Datos'); }

    }
    else // cuenta con un documento anterior
    {
        $ruta_pdf = null;

        if ( $_FILES['documento']['size'] == 0 ) // no hay documento nuevo
        {
            if ($estado_documento == 0) // actualizar con ruta null
            {
                // eliminar documento de convocatoria
                if ( !is_null($ruta_pdf_old) && $ruta_pdf_old != '') {
                    if ( file_exists($dir_dest_file . $ruta_pdf_old) ) unlink($dir_dest_file . $ruta_pdf_old);
                }

                if ($conexion_i->conectar()) {

                    $guar = $conexion_i->actualizar_convocatoria($id, $date, $tipo, $ano, $nro, $codigo, $ruta_pdf, $estado);
                    //$guar = $conexion_i->actualizar_convocatoria_no_ruta($id, $tipo, $ano, $nro, $codigo, $estado);
                    $conexion_i->desconectar();

                    if ($guar) {
                        // convocatoria actualizada

                        // Actualizar Documentos Anexos SI HUBIERE
                        if ($enlaces) {
                            // todo si existe enlace de RESULTADO FINAL, preguntar si desea actualizar estado a CERRADO
                            store_enlace($tipo, $ano, $nro, $_FILES['enlace'], $ids, $titulos, $detalles, $conexion_i, $id);
                        }
                        elimina_enlaces($dir_dest_file, $id, $conexion_i, $deleted);

                        // CORRECTO
                        redirigir_con_mensaje('index.php',0, 'Convocatoria actualizada correctamente');
                    }
                    else { redirigir_con_mensaje('index.php',1, 'Error al guardar la convocatoria'); }

                }
                else {
                    redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al guardar los datos en la BD');
                }
            }
            else // guardar sin modificar la ruta
            {
                if ($conexion_i->conectar()) {

                    //$guar = $conexion_i->actualizar_convocatoria($id, $tipo, $ano, $nro, $codigo, $ruta_pdf, $estado);
                    $guar = $conexion_i->actualizar_convocatoria_no_ruta($id, $date, $tipo, $ano, $nro, $codigo, $estado);
                    $conexion_i->desconectar();

                    if ($guar) {
                        // convocatoria actualizada

                        // Actualizar Documentos Anexos SI HUBIERE
                        if ($enlaces) {
                            // todo si existe enlace de RESULTADO FINAL, preguntar si desea actualizar estado a CERRADO
                            store_enlace($tipo, $ano, $nro, $_FILES['enlace'], $ids, $titulos, $detalles, $conexion_i, $id);
                        }
                        // elimina_enlaces($dir_dest_file, $id, $conexion_i, $deleted);

                        // CORRECTO
                        redirigir_con_mensaje('index.php',0, 'Convocatoria actualizada correctamente');
                    } else { redirigir_con_mensaje('index.php',1, 'Error al guardar la convocatoria'); }
                } else { redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al guardar los datos en la BD'); }

            }

        }
        else // hay documento nuevo
        {
            // rutas
            $dir_dest_file = "/var/www/html/documentos/convocatorias/". $tipo ."/". $ano ."/". $nro ."/";

            $ruta_pdf_old = null;

            // obtener  anterior  ruta_pdf_old
            if ( $conexion_i->conectar() ) {

                $rr = $conexion_i->get_rutapdf_convocatoria($id);
                $conexion_i->desconectar();

                $row = mysqli_fetch_row($rr);

                $ruta_pdf_old = $row[0];
            }

            // eliminar documento anterior
            if (!is_null($ruta_pdf_old)) {
                // verificar si ya existe un archivo con el mismo nombre, y eliminarlo
                if ( file_exists($dir_dest_file . $ruta_pdf_old) ) unlink($dir_dest_file . $ruta_pdf_old);
            }

            // Valida PDF
            if ( valida_pdf($_FILES['documento']) ) {

                // rutas
                $source_file = $_FILES['documento']['tmp_name'];
                // $dir_dest_file = "documentos/convocatorias/". $tipo ."/". $ano ."/". $nro ."/";
                $dest_file = $dir_dest_file . $_FILES['documento']['name'];

                // verificar si ya existe un archivo con el mismo nombre
                if ( file_exists($dest_file) ) {
                    unlink($dest_file);
                }
                // Validar si existe el directorio, si no, crearlo
                if ( ! is_dir($dir_dest_file)) {
                    mkdir($dir_dest_file, 0777, true);
                }

                // subir el nuevo pdf
                move_uploaded_file($source_file, $dir_dest_file . $_FILES['documento']['name'])
                or redirigir_con_mensaje('index.php',1, 'Ocurrio un error al subir el documento');

                if ($_FILES['documento']['error'] == 0) {

                    if ($conexion_i->conectar()) {

                        // ruta
                        $ruta_pdf = $_FILES['documento']['name'];

                        // Actualizar
                        $guardar = $conexion_i->actualizar_convocatoria($id, $date, $tipo, $ano, $nro, $codigo, $ruta_pdf, $estado);
                        $conexion_i->desconectar();

                        if ($guardar)
                        {
                            // CONVOCATORIA ACTUALIZADA

                            // Actualizar Documentos Anexos SI HUBIERE
                            if ($enlaces) {
                                store_enlace($tipo, $ano, $nro, $_FILES['enlace'], $ids, $titulos, $detalles, $conexion_i, $id);
                            }
                            elimina_enlaces($dir_dest_file, $id, $conexion_i, $deleted);

                            // CORRECTO
                            redirigir_con_mensaje('index.php',0, 'Convocatoria actualizada correctamente');
                        }
                        else {
                            // ERROR AL ACTUALIZAR
                            redirigir_con_mensaje('index.php',1, 'Ocurrio un error al editar la convocatoria');
                        }
                    }
                    else {
                        redirigir_con_mensaje('index.php',1, 'Ocurrio un error al conectar con la BD');
                    }
                }
                else {
                    redirigir_con_mensaje('index.php', 1, 'El documento presento un problema al momento de guardar');
                }
            }
            else {
                redirigir_con_mensaje('index.php', 1, 'Ocurrio un error al validar el documento');
            }
        }
    }
}
else redirigir_con_mensaje('index.php',1, 'Ocurrio un error al guardar la convocatoria');