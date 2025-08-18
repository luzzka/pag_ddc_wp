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

    // METODOS - Comunicados

    public function verifica_loggeo()
    {
        // si el usuario esta loggeado mostrar, si no, redirigir a pantalla de loggeo
        if (is_user_logged_in()) return true;
        else echo 'ACCESO RESTRINGIDO';

        exit(0);
    }

    public function lista_comunicados($tb) {
        try {
            $sql = "SELECT * FROM ddc_comunicados";

            if ($tb != '') {
                $sql .= " WHERE titulo LIKE '%".$tb."%'";
            }

            $sql .= " ORDER BY orden";

            $result = mysqli_query($this->conn, $sql);

            return $result;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function lista_anexos($id_ddc_comunicados) {
        try {
            $sql = "SELECT * FROM ddc_comunicados_anexos WHERE id_ddc_comunicados = $id_ddc_comunicados";

            $result = mysqli_query($this->conn, $sql);

            return $result;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function insertar_comunicado_lid($titulo, $detalle, $estado) {
        try {
            $sql_orden = "SELECT IF(max(orden) is null, 1, max(orden)+1) as orden from ddc_comunicados";
            $result_orden = mysqli_query($this->conn, $sql_orden)->fetch_object()->orden;

            $sql = "INSERT INTO ddc_comunicados (orden, titulo, detalle, fecha, estado)
                VALUES ($result_orden,
                        '$titulo',
                        '$detalle',
                        CURRENT_DATE,
                        $estado)";

            $lid = "SELECT LAST_INSERT_ID();";

            if (mysqli_query($this->conn, $sql)) return mysqli_query($this->conn, $lid);
            else return false;

        } catch (Exception $e) {
            return false;
        }
    }

    public function insertar_anexos($tipo, $anexo, $id_ddc_comunicados) {
        try {
            $sql = "INSERT INTO ddc_comunicados_anexos (tipo, anexo, id_ddc_comunicados)
                VALUES ('$tipo',
                        '$anexo',
                        $id_ddc_comunicados)";

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            return false;
        }
    }

    public function get_anexos($id) {
        try {
            $sql = "SELECT anexo FROM ddc_comunicados_anexos WHERE id_ddc_comunicados = $id";
            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function get_anexo($id) {
        try {
            $sql = "SELECT anexo FROM ddc_comunicados_anexos WHERE id = $id";
            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function eliminar_comunicado($id) {
        try {
            $resultado = mysqli_query($this->conn,"DELETE FROM ddc_comunicados WHERE id = $id");
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function cambia_estado($id) {
        try {
            $sql = "UPDATE ddc_comunicados
                      SET estado = !estado
                    WHERE id = $id";
            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function actualiza_comunicado ($id, $titulo, $detalle, $estado) {
        try
        {
            $sql = "UPDATE ddc_comunicados
                SET titulo = '$titulo',
                    detalle = '$detalle',
                    estado = $estado
                WHERE id = $id";

            return mysqli_query($this->conn, $sql);

        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function actualiza_anexo ($id, $tipo, $anexo) {
        try
        {
            $sql = "UPDATE ddc_comunicados_anexos
                SET tipo = $tipo,
                    anexo = '$anexo'
                WHERE id = $id";

            return mysqli_query($this->conn, $sql);

        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function get_comunicado($id) {
        try {
            $sql = "SELECT * FROM ddc_comunicados WHERE id = $id";

            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function get_fanexos($id) {
        try {
            $sql = "SELECT * FROM ddc_comunicados_anexos WHERE id_ddc_comunicados = $id";

            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function get_anexos_2($ids) {
        // Obtiene la lista de ANEXOS segun un arreglo de IDS
        try {
            $sql = 'SELECT anexo FROM ddc_comunicados_anexos WHERE id IN (' . $ids . ')';

            return mysqli_query($this->conn, $sql);
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function elimina_anexos($ids, $idc){
        try {
            // para el caso de eliminar un solo elemento
            $elementos = implode(', ', $ids);
            if ($elementos == '') $elementos = $ids;

            $sql = "DELETE FROM ddc_comunicados_anexos WHERE id IN (". $elementos . ") AND id_ddc_comunicados = ".$idc;

            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function lista_comunicados_publicados() {
        try {
            $sql = "SELECT id, titulo, detalle FROM ddc_comunicados WHERE estado = 1 ORDER BY orden";
            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function store_orden_comunicados($ids) {
        try {
            $result = true;
            $i = 1;

            foreach ($ids as $id) {
                $sql = "UPDATE ddc_comunicados SET orden=$i WHERE id=$id";
                $result = $result && mysqli_query($this->conn, $sql);
                $i++;
            }

            return false || $result;

        } catch (Exception $e) {
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