<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

function redirigir_con_mensaje ($page, $type, $message) {
    $_SESSION['message'] = [$type, $message];
    header('Location: ' . $page);
    exit;
}

// valida el tamaño del archivo a subir
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
//    if (!validar_tamano($up_file['size'], 2097152)) {
//        redirigir_con_mensaje('index.php',1, 'Tamaño de archivo muy grande. El archivo debe ser menor a _ megabytes');
//    }

    return true;
}

// get data
$tipo = $_POST["tipo"];
$ano = $_POST["ano"];
$nro = $_POST["nro_conv"];
$codigo = $_POST["codigo-convocatoria"];
$estado = $_POST["estado"];

$date = $_POST["date"];

$titulos = $_POST['titulo'];
$detalles = $_POST['detalle'];

// inicio validaciones
if ( isset( $_FILES['documento'] ) &&
    isset( $codigo ) &&
    isset( $tipo ) &&
    isset( $ano ) &&
    isset( $nro ) &&
    isset( $estado ) ) {

    $codigo = trim($codigo);
    $estado = trim($estado);

    switch ($tipo) {
        case 0:
            $tipo = 'CAS';
            break;
    }

    // valida pdf desde la funcion
    if ( valida_pdf($_FILES['documento']) ) {

        // ruta temporal del documento a subir
        $source_file = $_FILES['documento']['tmp_name'];

        $nombre_archivo = strtoupper("CONVOCATORIA_".$tipo."_".$nro."_".$ano);

        $dir_dest_file = '/var/www/html/documentos/convocatorias/'.$tipo .'/'. $ano .'/'. $nro .'/';

        $dest_file = $dir_dest_file . $nombre_archivo . '.pdf';

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
            or redirigir_con_mensaje('index.php',1,'Error al subir el PDF. Intente Nuevamente');

            // Si no existe error, continuar
            if ($_FILES['documento']['error'] == 0) {

                if ($conexion_i->conectar()) {

                    // ruta del pdf
                    $ruta_pdf = $dest_file;

                    // guardar
                    $guardar = $conexion_i->insert_conv_lid($date, $tipo, $ano, $nro, $codigo, $nombre_archivo.'.pdf', $estado);

                    $conexion_i->desconectar();

                    $row = mysqli_fetch_row($guardar);

                    // obtener el ultimo ID insertado
                    $lid = $row[0];

                    if ($guardar)
                    {
                        // Guardar Documentos Anexos
                        if(isset($_FILES['enlace'])){
                            $ii = 0;
                            foreach($_FILES['enlace']['tmp_name'] as $key => $tmp_name)
                            {
                                //$file_name = $_FILES['enlace']['name'][$key];
                                // EVAL_CURRICULAR_CAS_007_2016
                                $file_name = strtoupper($titulos[$ii].'_'.$tipo.'_'.$nro.'_'.$ano).'.pdf';
                                $file_tmp = $_FILES['enlace']['tmp_name'][$key];

                                //insertar publicaciones
                                if ($conexion_i->conectar()){

                                    // crear la ruta del pdf anexo
                                    //$ruta_e = $dir_dest_file . $file_name;
                                    $ruta_e = $file_name;

                                    // comprobar si la ruta es valida dependiendo de la existencia del pdf
                                    if (is_null($file_tmp) or $file_tmp == '') $ruta_e = null;

                                    // guardar
                                    $guardar2 = $conexion_i->insertar_publicacion($titulos[$ii], $detalles[$ii], $ruta_e, $lid);

                                    $conexion_i->desconectar();

                                    if ($guardar2){
                                        if (!is_null($ruta_e)) {

                                            // subir pdf a la ruta
                                            move_uploaded_file($file_tmp, $dir_dest_file . $file_name)
                                            or redirigir_con_mensaje('index.php',1,'Error al subir los documentos');
                                        }
                                    }
                                    else {
                                        redirigir_con_mensaje('index.php',1,'Error al guardar los datos');
                                    }
                                }

                                $ii++;
                            }
                        }
                        // Correcto, redirigir a index.php
                        redirigir_con_mensaje('index.php',0,'Convocatoria creada correctamente');
                    }
                    else {
                        redirigir_con_mensaje('index.php',1,'Ocurrio un error al guardar los datos, por favor intente nuevamente');
                    }
                }
            }
            else
            {
                redirigir_con_mensaje('index.php',1,'Ocurrio un error con el archivo a subir, por favor intente nuevamente');
            }
        }
    }
    else
    {
        redirigir_con_mensaje('index.php',1,'Ocurrio un error al validar el archivo que se quiere subir, por favor intente nuevamente');
    }
}
else
{
    redirigir_con_mensaje('index.php',1,'Error al guardar los datos, por favor intente nuevamente');
}

?>