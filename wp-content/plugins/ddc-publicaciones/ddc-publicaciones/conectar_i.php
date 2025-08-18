<?php

require_once(explode("wp-content", __FILE__)[0] . "wp-load.php");

// Conexion MySQLi

class ConnectDB
{
    private $host = '127.0.0.1';
    private $database = 'wp_mdc';
    private $username = 'root';
    private $password = 'DDC1821$p%%AFIT';

    private $conn = null;
    private $conectado = false;

    public function conectar()
    {
        try {
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);

            if ($this->conn) {
                $this->conectado = true;

                $pre_sql = "SET NAMES utf8";
                mysqli_query($this->conn, $pre_sql);

                return true;
            }

            // if (mysqli_connect_errno())
            // {
            //     echo "Failed to connect to MySQL: " . mysqli_connect_error();
            // }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function desconectar()
    {
        if ($this->conectado) {
            return mysqli_close($this->conn);
        }
        return false;
    }

    // METODOS - Disposiciones Emitidas

    // is_user_logged_in
    public function verifica_loggeo()
    {
        // si el usuario esta loggeado mostrar, si no, redirigir a pantalla de loggeo
        if (is_user_logged_in()) return true;
        else echo 'ACCESO RESTRINGIDO';

        exit(0);
    }

//    public function lista_publicaciones($tipo_resolucion, $ano, $tb) {
    public function lista_publicaciones($ano, $nombre)
    {
        try {
            $sql = "SELECT * FROM ddc_publicaciones";

            if ( $ano != '' && !is_null($ano) ) $sql .= " WHERE YEAR(fecha) = '$ano'";
            else $sql .= " WHERE YEAR(fecha) = YEAR(CURDATE())";

            if ( $nombre != '' && !is_null($nombre) ) $sql = $sql . " AND nombre LIKE '%".$nombre."%'";

            $sql .= " ORDER BY fecha DESC";

            $result = mysqli_query($this->conn, $sql);

            return $result;
        } catch (Exception $e) {
            return -1;
        }
    }

    public function cambia_estado($id)
    {
        try {
            $sql = "UPDATE ddc_disposiciones_emitidas
                      SET estado = !estado
                    WHERE id = $id";
            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        } catch (Exception $e) {
            return -1;
        }
    }

    public function inserta_publicacion($imagen, $nombre, $enlace, $pdf, $fecha, $estado)
    {
        try {

            $sql = "INSERT INTO ddc_publicaciones (imagen, nombre, enlace, pdf, fecha, estado)
                  VALUES ('$imagen',
                  '$nombre',
                  '$enlace',
                  '$pdf',
                  '$fecha',
                  $estado)";

            $result = mysqli_query($this->conn, $sql);

//             if (!$result) {
//                trigger_error('Invalid query: ' . $this->conn->error);
//                echo 'Invalid query: ' . $this->conn->error;
//                exit;
//             }

            return $result;

        } catch (Exception $e) {
            return false;
        }
    }

    public function get_filenames($id)
    {
        try {
            $sql = "SELECT imagen, pdf FROM ddc_publicaciones where id = $id";

            return mysqli_query($this->conn, $sql);
        } catch (Exception $e) {
            return -1;
        }
    }

    public function elimina_publicacion($id)
    {
        try {
            $resultado = mysqli_query($this->conn, "DELETE FROM ddc_publicaciones WHERE id = $id");
            return $resultado;
        } catch (Exception $e) {
            return -1;
        }
    }

    public function lista_publicacion($id)
    {
        try {
            $sql = "SELECT * FROM ddc_publicaciones WHERE id = $id";

            $result = mysqli_query($this->conn, $sql);

            return $result;
        } catch (Exception $e) {
            return -1;
        }
    }

    public function actualiza_publicacion($id, $imagen, $nombre, $enlace, $pdf, $fecha)
    {
        try {
            $sql = "UPDATE ddc_publicaciones
                    SET nombre = '$nombre',
                        enlace = '$enlace',
                        fecha = '$fecha'";

            if ($imagen != '') {
                $sql .= ",imagen = '$imagen'";
            }
            if ($pdf != '') {
                $sql .= ",pdf = '$pdf'";
            }

            $sql .= " WHERE id = $id";

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            //$tran = $this->conn->rollback();
            return false;
        }

    }

    // -- --

    public function redirigir_con_mensaje($page, $type, $message)
    {
        $_SESSION['message'] = [$type, $message];
        header('Location: ' . $page);
        exit;
    }

}