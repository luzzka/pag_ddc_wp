<?php

session_start();
include("conectar_i.php");

$conexion_i = new ConnectDB();

if (isset($_POST["id_disposicion"]) &&
    isset( $_POST["nombre_archivo"]) )
{
    // Obtener Data Anterior
    if ($conexion_i->conectar()) {
        $result_d = $conexion_i->get_nombre_documento( $_POST["id_disposicion"] );
        $conexion_i->desconectar();

        if ($result_d)
        {
            while ($row = mysqli_fetch_row($result_d)) {
                $data["tipo_documento"] = $row[0];
                $data["documento"] = $row[1];
            }

            echo json_encode($data);
        }
    }
}