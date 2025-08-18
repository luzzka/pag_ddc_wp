<?php

// Conexion MySQLi

require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );

class ConnectDB {
	private $host = 'localhost';
	private $database = 'wp_mdc';
	private $username = 'root';
	private $password = 'DDC1821$p%%AFIT';

	private $conn = null;
	private $conectado = false;

	public function conectar() {
		try {
			$this->conn = mysqli_connect( $this->host, $this->username, $this->password, $this->database );

			if ( $this->conn ) {
				$this->conectado = true;

				$pre_sql = "SET NAMES utf8";
				mysqli_query( $this->conn, $pre_sql );

				return true;
			}

			// if (mysqli_connect_errno())
			// {
			//     echo "Failed to connect to MySQL: " . mysqli_connect_error();
			// }

			return false;
		} catch ( Exception $e ) {
			return false;
		}
	}

	public function desconectar() {
		if ( $this->conectado ) {
			return mysqli_close( $this->conn );
		}

		return false;
	}

	// -- METODOS - CONVOCATORIAS2 --

	// obtiene las convocatorias
	public function getdata_convocatorias2($anio) {
		try {
			$sql = "SELECT id, nombre, fecha_publicacion, estado, publicado FROM ddc_conv2 WHERE YEAR(fecha_publicacion) = $anio ORDER BY fecha_publicacion DESC";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function getdata_convocatoria_x_id( $id ) {
		try {
			$sql = "SELECT nombre, fecha_publicacion, estado, publicado FROM ddc_conv2 WHERE id = $id";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	// obtiene un proceso segun su id
	public function getdata_proceso( $id ) {
		try {
			$sql = "SELECT id, numero, puesto FROM ddc_conv2_proceso WHERE id = $id";

			$resultado = mysqli_query( $this->conn, $sql );

//			if ( ! $resultado ) {
//				trigger_error( 'Invalid query: ' . $this->conn->error );
//			}

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	// obtiene id de convocatoria de un proceso
	public function get_id_convocatoria( $id_proceso ) {
		try {
			$sql = "select c.id from ddc_conv2 c inner join ddc_conv2_proceso p on c.id = p.id_convocatoria where p.id = $id_proceso";

			$resultado = mysqli_query( $this->conn, $sql );

//			if ( ! $resultado ) {
//				trigger_error( 'Invalid query: ' . $this->conn->error );
//			}

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	// obtiene un proceso segun una determinada convocatoria
	public function getdata_procesos( $id ) {
		try {
			$sql = "SELECT id, numero, puesto FROM ddc_conv2_proceso WHERE id_convocatoria = $id ORDER BY orden";

			$resultado = mysqli_query( $this->conn, $sql );

//			if ( ! $resultado ) {
//				trigger_error( 'Invalid query: ' . $this->conn->error );
//			}

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	// obtiene los documentos de un determinado proceso
	public function getdata_docs_proceso( $id, $tipo ) {
		try {
			$sql = "SELECT id, nombre_pdf, tipo FROM ddc_conv2_docs_proceso WHERE id_proceso = $id AND tipo = $tipo ORDER BY orden";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	// inserta docs
	public function insertar_documentos( $tipo, $nombre_pdf, $orden, $id_proceso ) {
		try {
			$sql = "INSERT INTO ddc_conv2_docs_proceso (tipo, nombre_pdf, orden, id_proceso)
                VALUES ($tipo,
                        '$nombre_pdf',
                        $orden,
                        $id_proceso)";

			return mysqli_query( $this->conn, $sql );

		} catch ( Exception $e ) {
			return false;
		}
	}

	public function getdata_ruta( $id_proceso ) {
		try {
			$sql = "select year(c.fecha_publicacion) as anio,
							       c.nombre,
							       p.numero
							from ddc_conv2 c
							       INNER join ddc_conv2_proceso p on c.id = p.id_convocatoria
							where p.id = $id_proceso";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function getdata_ruta_x_idconv( $id_convocatoria ) {
		try {
			$sql = "select year(fecha_publicacion) as anio, nombre
							from ddc_conv2 where id = $id_convocatoria";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function get_max_orden_x_tipo( $tipo, $id_proceso ) {
		try {
			$sql = "select max(orden)
							from ddc_conv2_docs_proceso
							where tipo = $tipo AND id_proceso = $id_proceso";

			return mysqli_query( $this->conn, $sql );

		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function get_docs_x_nombre( $tipo, $ids ) {
		// Obtiene la lista de NOMBRES_PDF segun un arreglo de IDS
		try {
			$sql = 'SELECT nombre_pdf FROM ddc_conv2_docs_proceso WHERE tipo = ' . $tipo . ' AND id IN (' . $ids . ')';

			return mysqli_query( $this->conn, $sql );
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function elimina_docs( $ids, $id_proceso ) {
		try {

			$elementos = implode( ', ', $ids );

			// para el caso de eliminar un solo elemento
			if ( $elementos == '' ) {
				$elementos = $ids;
			}

			$sql = "DELETE FROM ddc_conv2_docs_proceso WHERE id IN (" . $elementos . ") AND id_proceso = " . $id_proceso;

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function reset_orden_docs( $tipo, $id_proceso ) {
		try {
			$sql = "UPDATE ddc_conv2_docs_proceso SET orden = 0 WHERE tipo = $tipo AND id_proceso = $id_proceso";

			return mysqli_query( $this->conn, $sql );
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function lista_docs_x_tipo( $tipo, $id_proceso ) {
		try {
			$sql = "SELECT id, nombre_pdf FROM ddc_conv2_docs_proceso WHERE tipo = $tipo AND id_proceso = $id_proceso ORDER BY orden";

			return mysqli_query( $this->conn, $sql );
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function store_orden_docs( $ids ) {
		try {
			$result = true;
			$i      = 1;

			foreach ( $ids as $id ) {
				$sql    = "UPDATE ddc_conv2_docs_proceso SET orden=$i WHERE id=$id";
				$result = $result && mysqli_query( $this->conn, $sql );
				$i ++;
			}

			return false || $result;

		} catch ( Exception $e ) {
			return false;
		}
	}

	public function crea_proceso( $numero, $puesto, $id_convocatoria ) {
		try {
			$sql  = "INSERT INTO ddc_conv2_proceso (numero, puesto, orden, id_convocatoria) VALUES ('$numero', '$puesto', (SELECT coalesce(MAX(orden), 0) + 1 as max FROM ddc_conv2_proceso p), $id_convocatoria)";
			$sql2 = "SELECT LAST_INSERT_ID()";

			$resultado  = mysqli_query( $this->conn, $sql );
			$resultado2 = mysqli_query( $this->conn, $sql2 );

			if ( ! $resultado || ! $resultado2 ) {
				trigger_error( 'Invalid query: ' . $this->conn->error );
			}

			if ( $resultado ) {
				return $resultado2;
			}

			return false;

		} catch ( Exception $e ) {
			return false;
		}
	}

	public function actualiza_nro( $numero, $id_proceso ) {
		try {
			$sql = "UPDATE ddc_conv2_proceso SET numero = '$numero' WHERE id = $id_proceso";

			$resultado = mysqli_query( $this->conn, $sql );

//			if ( !$resultado ) {
//				trigger_error( 'Invalid query: ' . $this->conn->error );
//			}

			return $resultado;

		} catch ( Exception $e ) {
			return false;
		}
	}

	public function actualiza_puesto( $puesto, $id_proceso ) {
		try {
			$sql = "UPDATE ddc_conv2_proceso SET puesto = '$puesto' WHERE id = $id_proceso";

			$resultado = mysqli_query( $this->conn, $sql );

//			if ( !$resultado ) {
//				trigger_error( 'Invalid query: ' . $this->conn->error );
//			}

			return $resultado;

		} catch ( Exception $e ) {
			return false;
		}
	}

	public function inserta_convocatoria( $nombre, $fecha, $estado, $publicado ) {
		try {
			$sql = "INSERT INTO ddc_conv2 (nombre, fecha_publicacion, estado, publicado) VALUES ('$nombre', '$fecha', $estado, $publicado)";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;

		} catch ( Exception $e ) {
			return false;
		}
	}

	public function cambia_estado( $id ) {
		try {
			$sql       = "UPDATE ddc_conv2
                      SET publicado = !publicado
                    WHERE id = $id";
			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function edita_convocatoria( $nombre, $fecha, $estado, $publicado, $id ) {
		try {
			$sql = "UPDATE ddc_conv2 SET nombre = '$nombre' ,fecha_publicacion = '$fecha' ,estado = $estado ,publicado = $publicado WHERE id = $id";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;

		} catch ( Exception $e ) {
			return false;
		}
	}

	public function get_nombres_pdf( $id_proceso ) {
		// Obtiene la lista de NOMBRES de PDF segun un id_proceso
		try {
			$sql = "SELECT id, nombre_pdf FROM ddc_conv2_docs_proceso WHERE id_proceso = $id_proceso";

			return mysqli_query( $this->conn, $sql );
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function elimina_docs_x_proceso( $id_proceso ) {
		try {
			$sql = "DELETE FROM ddc_conv2_docs_proceso WHERE id_proceso = " . $id_proceso;

			$resultado = mysqli_query( $this->conn, $sql );

			if ( !$resultado ) {
				trigger_error( 'Invalid query: ' . $this->conn->error );
			}

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function elimina_proceso( $id_proceso ) {
		try {
			$sql = "DELETE FROM ddc_conv2_proceso WHERE id = " . $id_proceso;

			$resultado = mysqli_query( $this->conn, $sql );

			if ( !$resultado ) {
				trigger_error( 'Invalid query: ' . $this->conn->error );
			}

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function elimina_doc_x_idconv( $id_convocatoria ) {
		try {
			$sql = "DELETE FROM ddc_conv2_docs_proceso
							WHERE id IN (select * from (select dp.id
							             from ddc_conv2_docs_proceso dp
							                    inner join ddc_conv2_proceso p on dp.id_proceso = p.id
							                    inner join ddc_conv2 c on p.id_convocatoria = c.id
							             where c.id = $id_convocatoria) as tp)";

			$resultado = mysqli_query( $this->conn, $sql );

			if ( !$resultado ) {
				trigger_error( 'Invalid query: ' . $this->conn->error );
			}

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function elimina_proc_x_idconv( $id_convocatoria ) {
		try {
			$sql = "DELETE FROM ddc_conv2_proceso WHERE id IN (select * from (select p.id from ddc_conv2_proceso p inner join ddc_conv2 c on p.id_convocatoria = c.id where c.id = $id_convocatoria) as tp)";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function elimina_convocatoria( $id_convocatoria ) {
		try {
			$sql = "DELETE FROM ddc_conv2 WHERE id = $id_convocatoria";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function get_data_convocatoria( $id_convocatoria ) {
		try {
			$sql = "SELECT nombre, YEAR(fecha_publicacion) as anio FROM ddc_conv2 WHERE id = $id_convocatoria";

			return mysqli_query( $this->conn, $sql );
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	// -- Fe de Erratas

	public function getdata_docs_fde( $id_convocatoria ) {

		try {
			$sql = "SELECT id, titulo, orden FROM ddc_conv2_fderratas WHERE id_convocatoria = $id_convocatoria ORDER BY orden";

			return mysqli_query( $this->conn, $sql );
		} catch ( Exception $e ) {
			return - 1;
		}

	}

	public function get_max_orden_fde( $id_convocatoria ) {
		try {
			$sql = "select max(orden)
							from ddc_conv2_fderratas
							where id_convocatoria = $id_convocatoria";

			return mysqli_query( $this->conn, $sql );

		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function insertar_fde( $titulo, $nombre_pdf, $orden, $id_convocatoria ) {
		try {
			$sql = "INSERT INTO ddc_conv2_fderratas (titulo, nombre_pdf, orden, id_convocatoria)
                VALUES ('$titulo',
                				'$nombre_pdf',
                        $orden,
                        $id_convocatoria)";

			return mysqli_query( $this->conn, $sql );

		} catch ( Exception $e ) {
			return false;
		}
	}

	public function get_docs_fde_x_nombre( $ids ) {
		// Obtiene la lista de NOMBRES_PDF de documentos en la carpeta Fe de Erratas segun un arreglo de IDS
		try {
			$sql = 'SELECT nombre_pdf FROM ddc_conv2_fderratas WHERE id IN (' . $ids . ')';

			return mysqli_query( $this->conn, $sql );
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function elimina_docs_fde( $ids ) {
		try {

			$elementos = implode( ', ', $ids );

			// para el caso de eliminar un solo elemento
			if ( $elementos == '' ) {
				$elementos = $ids;
			}

			$sql = "DELETE FROM ddc_conv2_fderratas WHERE id IN (" . $elementos . ")";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
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

	// -- docs global

	public function getdata_docs_global( $id_convocatoria, $tipo ) {

		try {
			$sql = "select id, nombre, nombre_pdf from ddc_conv2_docs_global where tipo = $tipo and id_convocatoria = $id_convocatoria order by orden;";

			return mysqli_query( $this->conn, $sql );
		} catch ( Exception $e ) {
			return - 1;
		}

	}

	public function get_max_orden_x_tipo_global( $tipo, $id_convocatoria ) {
		try {
			$sql = "select max(orden)
							from ddc_conv2_docs_global
							where tipo = $tipo AND id_convocatoria = $id_convocatoria";

			return mysqli_query( $this->conn, $sql );

		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function insertar_documentos_global( $tipo, $nombre_pdf, $orden, $id_convocatoria ) {
		try {
			$sql = "INSERT INTO ddc_conv2_docs_global (nombre, nombre_pdf, tipo, orden, id_convocatoria)
                VALUES ('$nombre_pdf',
                        '$nombre_pdf',
                        $tipo,
                        $orden,
                        $id_convocatoria)";

			return mysqli_query( $this->conn, $sql );

		} catch ( Exception $e ) {
			return false;
		}
	}

	public function get_docs_global_x_nombre( $ids ) {
		// Obtiene la lista de NOMBRES_PDF segun un arreglo de IDS
		try {
			$sql = 'SELECT nombre_pdf FROM ddc_conv2_docs_global WHERE id IN (' . $ids . ')';

			return mysqli_query( $this->conn, $sql );
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	public function elimina_docs_global( $ids, $id_convocatoria ) {
		try {

			$elementos = implode( ', ', $ids );

			// para el caso de eliminar un solo elemento
			if ( $elementos == '' ) {
				$elementos = $ids;
			}

			$sql = "DELETE FROM ddc_conv2_docs_global WHERE id IN (" . $elementos . ")";

			$resultado = mysqli_query( $this->conn, $sql );

			return $resultado;
		} catch ( Exception $e ) {
			return - 1;
		}
	}

	// -- --

	// is_user_logged_in
	public function verifica_loggeo() {
		// si el usuario esta loggeado mostrar, si no, redirigir a pantalla de loggeo
		if ( is_user_logged_in() ) {
			return true;
		} else {
			echo 'ACCESO RESTRINGIDO';
		}

		exit( 0 );
	}

	public function redirigir_con_mensaje( $page, $type, $message ) {
		$_SESSION['message'] = [ $type, $message ];
		header( 'Location: ' . $page );
		exit;
	}

}
