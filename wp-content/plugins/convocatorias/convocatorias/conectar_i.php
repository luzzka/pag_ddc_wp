<?php

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

    // METODOS

    // -- convocatorias

    public function insertar_convocatoria ($fecha, $tipo, $ano, $nro, $codigo, $ruta_pdf, $estado) {

        try {

            $sql = "INSERT INTO ddc_convocatorias (fecha, tipo, ano, nro, codigo, ruta_pdf, estado) VALUES ($fecha, '$tipo', '$ano', '$nro', '$codigo', '$ruta_pdf', '$estado')";

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            return false;
        }

    }

    public function insert_conv_lid($fecha, $tipo, $ano, $nro, $codigo, $ruta_pdf, $estado) {
        try {

            $sql = "INSERT INTO ddc_convocatorias (fecha, tipo, ano, nro, codigo, ruta_pdf, estado) VALUES ('$fecha', '$tipo', '$ano', '$nro', '$codigo', '$ruta_pdf', '$estado')";

            $lid = "SELECT LAST_INSERT_ID();";

            if (mysqli_query($this->conn, $sql))
                return mysqli_query($this->conn, $lid);
            else
                return false;

        } catch (Exception $e) {
            return false;
        }
    }

    public function insertar_publicacion ($titulo, $detalle, $ruta_enlace, $id_ddc_conv) {
        try {
            $sql = "INSERT INTO ddc_conv_publicaciones (fecha, titulo, detalle, ruta_enlace, id_ddc_convocatorias)
                      VALUES (CURRENT_TIMESTAMP,
                      '$titulo',
                      '$detalle',
                      '$ruta_enlace',
                      $id_ddc_conv)";

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            return false;
        }

    }

    public function listar_convocatorias($criterio, $tb) {
        try {
            $sql = "SELECT * FROM ddc_convocatorias";

            if ($criterio != '') {
                $sql = $sql . " WHERE ano = '".$criterio."'";
            }
            else {
                $sql = $sql . " WHERE ano = '".date('Y')."'";
            }
            if ($tb != '') {
                $sql = $sql . " AND codigo LIKE '%".$tb."%'";
            }

            $sql = $sql . " ORDER BY nro DESC";

            return mysqli_query($this->conn, $sql);
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function listar_conv_publicaciones($id_convocatoria) {
        try {
            $resultado = mysqli_query($this->conn,"SELECT * FROM ddc_conv_publicaciones WHERE id_ddc_convocatorias = $id_convocatoria");
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function listar_data_convocatoria($id) {
        try {
            $resultado = mysqli_query($this->conn,"SELECT * FROM ddc_convocatorias WHERE id = $id");
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function actualizar_convocatoria($id, $fecha, $tipo, $ano, $nro, $codigo, $ruta_pdf, $estado) {
        try {

            if (is_null($ruta_pdf)) {
                $sql = "UPDATE ddc_convocatorias
                SET fecha = '$fecha',
                    tipo = '$tipo',
                    ano = '$ano',
                    nro = '$nro',
                    codigo = '$codigo',
                    ruta_pdf = null,
                    estado = '$estado'
                WHERE id = $id";
            }
            else {
                $sql = "UPDATE `ddc_convocatorias`
                SET fecha = '$fecha',
                    tipo = '$tipo',
                    nro = '$nro',
                    codigo = '$codigo',
                    ruta_pdf = '$ruta_pdf',
                    estado = '$estado'
                WHERE id = $id";
            }

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            // $tran = $this->conn->rollback();
            // mysqli_error($this->conn);
            return false;
        }
    }

    public function actualizar_convocatoria_no_ruta($id, $fecha, $tipo, $ano, $nro, $codigo, $estado) {
        try {
            $sql = "UPDATE ddc_convocatorias
            SET fecha = '$fecha',
                tipo = '$tipo',
                ano = '$ano',
                nro = '$nro',
                codigo = '$codigo',
                estado = '$estado'
            WHERE id = '$id'";

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            //$tran = $this->conn->rollback();
            return false;
        }
    }

    public function actualizar_publicacion($id, $titulo, $detalle, $ruta_enlace) {

        try {
            $sql = "UPDATE ddc_conv_publicaciones
            SET titulo = '$titulo',
                detalle = '$detalle',
                ruta_enlace = '$ruta_enlace'
            WHERE id = $id";

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            //$tran = $this->conn->rollback();
            return false;
        }

    }

    public function actualizar_publicacion_no_ruta($id, $titulo, $detalle) {

        try {

            $sql = "UPDATE ddc_conv_publicaciones
            SET titulo = '$titulo',
                detalle = '$detalle'
            WHERE id = $id";

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            //$tran = $this->conn->rollback();
            return false;
        }

    }

    public function eliminar_convocatoria($id) {
        try {
            $resultado = mysqli_query($this->conn,"DELETE FROM ddc_convocatorias WHERE id = $id");
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function get_convocatoria($id) {
        try {
            $sql = "SELECT tipo, ano, nro, ruta_pdf FROM ddc_convocatorias WHERE id = $id";
            $resultado = mysqli_query($this->conn,$sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function get_rutapdf_convocatoria($id) {
        try {
            $resultado = mysqli_query($this->conn,"SELECT ruta_pdf FROM ddc_convocatorias WHERE id = $id");
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function get_rutaenlace_convocatoria($id) {
        try {
            $resultado = mysqli_query($this->conn,"SELECT ruta_enlace FROM ddc_conv_publicaciones WHERE id = $id");
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function get_rutasenlaces_convocatoria($ids) {
        try {
            $sql = "SELECT ruta_enlace FROM ddc_conv_publicaciones WHERE id IN (" . $ids . ")";

            $resultado = mysqli_query($this->conn, $sql);

            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function verifica_id_publicacion($id){
        try {
            $resultado = mysqli_query($this->conn, "SELECT * FROM ddc_conv_publicaciones WHERE id = ".$id);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function elimina_conv_publicaciones($ids, $idc){
        try {
            // para el caso de eliminar un solo elemento
            $elementos = implode(', ', $ids);
            if ($elementos == '') $elementos = $ids;

            $sql = "DELETE FROM ddc_conv_publicaciones WHERE id IN (". $elementos . ") AND id_ddc_convocatorias = ".$idc;

            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    // -- bases

    public function lista_base($id){
        try {
            $sql = "SELECT * FROM ddc_conv_bases WHERE id = $id";

            $result = mysqli_query($this->conn, $sql);

            //if (!$result) {
            //    trigger_error('Invalid query: ' . $this->conn->error);
            //}

            return $result;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function lista_bases($criterio, $tb){
        try {
            $sql = "SELECT * FROM ddc_conv_bases";

            switch ($criterio) {
                case '0': // ENLACE
                    $criterio = '*';
                    break;
                case '1': // PDF
                    $criterio = 'pdf-file.png';
                    break;
                case '2': // EXCEL
                    $criterio = 'excel-file.png';
                    break;
                case '3': // IMG
                    $criterio = 'img.png';
                    break;
                case '4': // WORD
                    $criterio = 'word-file.png';
                    break;
                default:
                    $criterio = '';
                    break;
            }

            if ($criterio == '*') {
                $sql = $sql . " WHERE tipo = 1";
            }
            else
            {
                if ($criterio != '') {
                    $sql = $sql . " WHERE icon = '$criterio'";
                }
            }

            if ($tb != '') {
                if ($criterio == '') $sql = $sql . " WHERE titulo LIKE '%".$tb."%'";
                else $sql = $sql . " AND titulo LIKE '%".$tb."%'";
            }

            $sql = $sql . " ORDER BY orden";

            $result = mysqli_query($this->conn, $sql);

            return $result;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function lista_bases_publicadas(){
        try {
            $sql = "SELECT id, orden, icon, titulo, estado FROM ddc_conv_bases WHERE estado = 1 ORDER BY orden";

            $result = mysqli_query($this->conn, $sql);

            return $result;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function get_base($id){
        try {
            $sql = "SELECT tipo, ruta FROM ddc_conv_bases WHERE id = $id";
            $resultado = mysqli_query($this->conn,$sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function actualiza_base($id, $icon, $titulo, $estado, $tipo, $ruta) {
        try {
            if ($ruta == null) {
                $sql = "UPDATE ddc_conv_bases
                    SET icon = '$icon',
                        titulo = '$titulo',
                        estado = $estado,
                        tipo = $tipo,
                        ruta = null
                    WHERE id = $id";
            }
            else {
                $sql = "UPDATE ddc_conv_bases
                    SET icon = '$icon',
                        titulo = '$titulo',
                        estado = $estado,
                        tipo = $tipo,
                        ruta = '$ruta'
                    WHERE id = $id";
            }

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            //$tran = $this->conn->rollback();
            return false;
        }
    }

    public function actualiza_base2($id, $titulo, $estado) {
        try {
            $sql = "UPDATE ddc_conv_bases
                SET titulo = '$titulo',
                    estado = $estado
                WHERE id = $id";

            return mysqli_query($this->conn, $sql);

        } catch (Exception $e) {
            //$tran = $this->conn->rollback();
            return false;
        }
    }

    public function actualiza_orden($ids) {

        try {
            $result = true;
            $i = 1;

            foreach ($ids as $id) {
                $sql = "UPDATE ddc_conv_bases SET orden=$i WHERE id=$id";
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

    public function insertar_base($icon, $titulo, $estado, $tipo, $ruta) {
        try {

            $sql_orden = "SELECT IF(max(orden) is null, 1, max(orden)+1) as orden from ddc_conv_bases";
            $result_orden = mysqli_query($this->conn, $sql_orden)->fetch_object()->orden;

            if ($ruta == null) {
                $sql = "INSERT INTO ddc_conv_bases (orden, icon, fecha, titulo, estado, tipo, ruta)
                      VALUES ($result_orden,
                      '$icon',
                      CURRENT_DATE,
                      '$titulo',
                      $estado,
                      $tipo,
                      null)";
            }
            else {
                $sql = "INSERT INTO ddc_conv_bases (orden, icon, fecha, titulo, estado, tipo, ruta)
                      VALUES ($result_orden,
                      '$icon',
                      CURRENT_DATE,
                      '$titulo',
                      $estado,
                      $tipo,
                      '$ruta')";
            }

            $result = mysqli_query($this->conn, $sql);

            return $result;

        } catch (Exception $e) {
            return false;
        }
    }

    public function eliminar_base($id) {
        try {
            $resultado = mysqli_query($this->conn,"DELETE FROM ddc_conv_bases WHERE id = $id");
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }

    public function pub_nopub_base($id) {
        try {
            $sql = "UPDATE ddc_conv_bases
                      SET estado = !estado
                    WHERE id = $id";
            $resultado = mysqli_query($this->conn, $sql);
            return $resultado;
        }
        catch (Exception $e) {
            return -1;
        }
    }
}

?>