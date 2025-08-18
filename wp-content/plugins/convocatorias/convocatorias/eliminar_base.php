<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

// -- FUNCIONES --
function redirigir_con_mensaje ($page, $type, $message) {
    $_SESSION['message'] = [$type, $message];
    header('Location: ' . $page);
    exit;
}

$id = $_POST["id_base"];

if (isset($_POST["id_base"])) {

    $id = $_POST["id_base"];

    if ($conexion_i->conectar()) {

        $result = $conexion_i->get_base($id);
        $result2 = $conexion_i->eliminar_base($id);

        $conexion_i->desconectar();

        if ($result) {
            $row = mysqli_fetch_row($result);

            // si el tipo(0) de base tiene documento adjunto, eliminar documento
            if ($row[0] == 0) {
                // eliminar
                if (!is_null($row[1]) && $row[1] != '') {
                    // $ruta = dirname('..\\..\\..\\..\\documentos\\convocatorias\\'. $row[1]);
                    $ruta = realpath(__DIR__ . '/../../../../documentos/convocatorias/' . $row[1]);

                    if (file_exists($ruta)) {
                        unlink($ruta);
                    }
                }
            }
            if (!$result2) {
                // error al eliminar la fila de la convocatoria
                redirigir_con_mensaje('bases.php', 2, 'Advertencia, no se pudo eliminar el archivo');
            }

            // redirigir
            redirigir_con_mensaje('bases.php', 0, 'Elemento eliminado correctamente');

        }
        else {
            redirigir_con_mensaje('bases.php', 1, 'Ocurrió un error al recibir la ruta anterior');
        }

    }
}