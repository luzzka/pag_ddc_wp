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

    public function conectar ()
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
        }
        catch (Exception $e) {
            return false;
        }
    }

    public function desconectar ()
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

    public function lista_disposiciones_emitidas($tipo_resolucion, $ano, $tb) {
        try {
            $sql = "SELECT * FROM ddc_disposiciones_emitidas";

            if ($tipo_resolucion != '') $sql .= " WHERE tipo_resolucion = $tipo_resolucion";
            else $sql .= " WHERE tipo_resolucion = 0";

            if ($tb != '') $sql = $sql . " AND resolucion LIKE '%".$tb."%'";

            if ($ano != '') $sql .= " AND ano = '$ano'";
            else $sql .= " AND ano = YEAR(CURDATE())";

            $sql .= " ORDER BY ano DESC, orden";

            $result = mysqli_query($this->conn, $sql);

            return $result;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function cambia_estado($id) {
        try {
            $sql = "UPDATE ddc_disposiciones_emitidas
                      SET estado = !estado
                    WHERE id = $id";
            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function inserta_disposicion($resolucion, $tipo_resolucion, $ano, $estado, $tipo_documento, $documento) {
        try {

            $sql_orden = "SELECT IF(max(orden) is null, 1, max(orden)+1) as orden from ddc_disposiciones_emitidas";
            $result_orden = mysqli_query($this->conn, $sql_orden)->fetch_object()->orden;

            if ($documento == null) {
                $sql = "INSERT INTO ddc_disposiciones_emitidas (resolucion, fecha_publicacion, tipo_resolucion, ano, orden, estado, tipo_documento, documento)
                      VALUES ('$resolucion',
                      CURRENT_DATE,
                      $tipo_resolucion,
                      '$ano',
                      $result_orden,
                      $estado,
                      '$tipo_documento',
                      null)";
            }
            else {
                $sql = "INSERT INTO ddc_disposiciones_emitidas (resolucion, fecha_publicacion, tipo_resolucion, ano, orden, estado, tipo_documento, documento)
                      VALUES ('$resolucion',
                      CURRENT_DATE,
                      $tipo_resolucion,
                      '$ano',
                      $result_orden,
                      $estado,
                      '$tipo_documento',
                      '$documento')";
            }

            $result = mysqli_query($this->conn, $sql);

            // if (!$result) {
            //    trigger_error('Invalid query: ' . $this->conn->error);
            //    exit;
            // }

            return $result;

        } catch (Exception $e) {
            return false;
        }
    }

    public function get_documentos ($id) {
        try {
            $sql = "SELECT tipo_resolucion, ano, tipo_documento, documento FROM ddc_disposiciones_emitidas where id = $id";

            return mysqli_query($this->conn, $sql);
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function elimina_disposicion ($id) {
        try {
            $resultado = mysqli_query($this->conn,"DELETE FROM ddc_disposiciones_emitidas WHERE id = $id");
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function lista_disposicion ($id) {
        try {
            $sql = "SELECT * FROM ddc_disposiciones_emitidas WHERE id = $id";

            $result = mysqli_query($this->conn, $sql);

            return $result;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function actualiza_disposicion ($id, $resolucion, $tipo_resolucion, $ano, $estado, $tipo_documento, $documento) {

        try {
            if ($documento == null) {
                $sql = "UPDATE ddc_disposiciones_emitidas
                    SET resolucion = '$resolucion',
                        tipo_resolucion = $tipo_resolucion,
                        ano = $ano,
                        estado = $estado,
                        tipo_documento = '$tipo_documento',
                        documento = NULL
                    WHERE id = $id";
            }
            else {
                $sql = "UPDATE ddc_disposiciones_emitidas
                    SET resolucion = '$resolucion',
                        tipo_resolucion = $tipo_resolucion,
                        ano = $ano,
                        estado = $estado,
                        tipo_documento = '$tipo_documento',
                        documento = '$documento'
                    WHERE id = $id";
            }

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            //$tran = $this->conn->rollback();
            return false;
        }

    }

    public function actualiza_disposicion2 ($id, $resolucion, $tipo_resolucion, $ano, $estado) {

        try {
            $sql = "UPDATE ddc_disposiciones_emitidas
                SET resolucion = '$resolucion',
                    tipo_resolucion = $tipo_resolucion,
                    ano = $ano,
                    estado = $estado
                WHERE id = $id";

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            //$tran = $this->conn->rollback();
            return false;
        }

    }

    public function get_nombre_documento ($id) {
        // obtiene el nombre del archivo anterior
        try {
            $sql = "SELECT tipo_documento, documento FROM ddc_disposiciones_emitidas WHERE id=$id";

            return mysqli_query($this->conn, $sql);
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function lista_disposiones_publicadas ($tipo, $ano) {
        try {
            $sql = "SELECT * FROM ddc_disposiciones_emitidas WHERE tipo_resolucion = $tipo AND ano = '$ano' AND estado = 1 ORDER BY orden";

            $result = mysqli_query($this->conn, $sql);

            return $result;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function actualiza_orden($ids) {

        try {
            $result = true;
            $i = 1;

            foreach ($ids as $id) {
                $sql = "UPDATE ddc_disposiciones_emitidas SET orden=$i WHERE id=$id";
                $result = $result && mysqli_query($this->conn, $sql);
                $i++;
            }

            // foreach ($ids as $key => $ddc_conv_bases) {
            //     $orden = $i;
            //     $id = intval($ddc_conv_bases->id);
            //
            //     $sql = "UPDATE ddc_conv_bases SET orden='$orden' WHERE id=$id";
            //     $result = $result && mysqli_query($this->conn, $sql);
            //     $i++;
            // }
            return false || $result;

        } catch (Exception $e) {
            //$tran = $this->conn->rollback();
            return false;
        }

    }
    // -- --

    public function redirigir_con_mensaje ($page, $type, $message) {
        $_SESSION['message'] = [$type, $message];
        header('Location: ' . $page);
        exit;
    }

}