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
// -- -- --

if (isset($_POST["id_publicacion"])) {

    $id = $_POST["id_publicacion"];

    if ($conexion_i->conectar()) {

        $result = $conexion_i->get_filenames($id);
        $result2 = $conexion_i->elimina_publicacion($id);

        $conexion_i->desconectar();

        if ($result) {

            // Ruta Base
            $ruta_dmdocuments = realpath(__DIR__ . '/../../../../dmdocuments/');

            while ($row = $result->fetch_assoc()) {
                if (!is_null($row["pdf"]) && $row["pdf"] != '') {

                    $ruta = $ruta_dmdocuments . '/ddc-publicaciones/' . $row["pdf"];

                    if (file_exists($ruta)) unlink($ruta);
                }
                if (!is_null($row["imagen"]) && $row["imagen"] != '') {

                    $ruta = $ruta_dmdocuments . '/ddc-publicaciones/img/' . $row["imagen"];

                    if (file_exists($ruta)) unlink($ruta);
                }
            }

            if (!$result2) {
                // error al eliminar
                redirigir_con_mensaje('index.php', 2, 'Advertencia, no se pudo eliminar el elemento');
            }
            // CORRECTO
            redirigir_con_mensaje('index.php', 0, 'Elemento eliminado correctamente');
        } else  redirigir_con_mensaje('index.php', 1, 'Error al obtener los filenames !');
    } else  redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al establecer una conexión con la BD');
} else  redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al momento de recibir los datos');