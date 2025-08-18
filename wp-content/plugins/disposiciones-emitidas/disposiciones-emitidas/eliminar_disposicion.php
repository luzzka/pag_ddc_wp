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

if (isset($_POST["id_disposicion"])) {

    $id = $_POST["id_disposicion"];

    if ($conexion_i->conectar()) {

        $result = $conexion_i->get_documentos($id);
        $result2 = $conexion_i->elimina_disposicion($id);

        $conexion_i->desconectar();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if (!is_null($row["documento"]) && $row["documento"] != '') {
                    $tipo = '';
                    switch ($row["tipo_resolucion"]) {
                        case 0:
                            $tipo = 'resoluciones';
                            break;
                        case 1:
                            $tipo = 'ministerial';
                            break;
                        case 2:
                            $tipo = 'directivas';
                            break;
                        case 3:
                            $tipo = 'ciras';
                            break;
                        default:
                            $tipo = 'resoluciones';
                            break;
                    }

                    $ruta = realpath(__DIR__ . '/../../../../dmdocuments/'.$tipo.'/'.$row["ano"].'/' . $row["documento"]);

                    if (file_exists($ruta)) {
                        unlink($ruta);
                    }
                }
            }

            if (!$result2) {
                // error al eliminar la fila de la convocatoria
                redirigir_con_mensaje('index.php', 2, 'Advertencia, no se pudo eliminar el elemento');
            }
            // CORRECTO
            redirigir_con_mensaje('index.php', 0, 'Elemento eliminado correctamente');
        } else  redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al recibir la ruta anterior');
    } else  redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al establecer una conexión con la BD');
} else  redirigir_con_mensaje('index.php', 1, 'Ocurrió un error al momento de recibir los datos');