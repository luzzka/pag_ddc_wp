<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

#region -- FUNCIONES --
function redirigir_con_mensaje ($page, $type, $message) {
    $_SESSION['message'] = [$type, $message];
    header('Location: ' . $page);
    exit;
}

function recursiveRemoveDirectory($directory)
{
    // https://stackoverflow.com/questions/11267086/php-unlink-all-files-within-a-directory-and-then-deleting-that-directory
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) {
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}

#endregion

// obtener id de la convocatoria
$id = $_POST["id_conv"];

if (isset($id)) {
    if ($conexion_i->conectar()) {

        //$result = $conexion_i->get_rutapdf_convocatoria($id);
        $result = $conexion_i->get_convocatoria($id);
        $result2 = $conexion_i->eliminar_convocatoria($id);

        $conexion_i->desconectar();

        // asignar data(ruta del pdf) a row
        $row = mysqli_fetch_row($result);

        if ($result->num_rows > 0)
        {
            // eliminar los archivos asociados a esa convocatoria
            $ruta_base = '/var/www/html/documentos/convocatorias/';
            $ruta = $ruta_base . $row[0] ."/". $row[1] ."/". $row[2];

            recursiveRemoveDirectory($ruta);
        }

        if (!$result2) {
            // error al eliminar la fila de la convocatoria
            redirigir_con_mensaje('index.php', 1, 'Error, no se pudo eliminar la convocatoria');
        }

        // redirigir
        redirigir_con_mensaje('index.php', 0, 'La convocatoria se elimino correctamente');
    }
}