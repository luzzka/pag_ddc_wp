<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.facebook.com/orlandoox
 * @since      1.0.0
 *
 * @package    Mkslider_Doox
 * @subpackage Mkslider_Doox/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mkslider_Doox
 * @subpackage Mkslider_Doox/admin
 * @author     Doox <orland85k@gmail.com>
 */
class Mkslider_Doox_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mkslider_Doox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mkslider_Doox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mkslider-doox-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mkslider_Doox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mkslider_Doox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name."-blockUI", plugin_dir_url( __FILE__ ) . 'js/block-ui.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mkslider-doox-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name,"mkJS",array('ajaxurl' => admin_url('admin-ajax.php'), 'postCommentNonce' =>wp_create_nonce( 'myajax-post-comment-nonce' ), "pluginfile" => plugin_dir_url( __FILE__ ) ) );
		wp_enqueue_media();

	}

	/**
	 * [admin_menu_configuracion function para mostrar un menu extra de configuracion]
	 * @return [void] [solo agrega una opcion extra de sub menu page]
	 */
	public function admin_menu_configuracion(){
		add_menu_page( "MK Slider", "MKSlider Configuración", 'manage_options', 'mkslider-options', array( $this, "html_admin_options" ), 'dashicons-images-alt', 98 );
	}#end function admin_menu_configuracion

	/**
	 * [html_admin_options function para mostrar html de la parte de configuración del plugin]
	 * @return [html] [opciones de configuración del plugin]
	 */
	public function html_admin_options(){
		$options_slider             = "";
		$options                    = "";
		$url_nuevo                  = admin_url( "admin.php?page=mkslider-options" );
		$action                     = "nuevo";
		$id_slider                  = 0;
		$errores                    = array();
		$mensaje                    = "";
		$data_slider                = array();
		$data_slider['titulo']      = "";
		$data_slider['con_des']     = 0;
		$data_slider['descripcion'] = "";
		$data_slider['on_home']     = 0;#si se va a mostrar en el home
		#recuperar options slider
		$options_slider = get_option( $this->plugin_name, false );
		if( !empty($options_slider) OR $options_slider != false )
			$options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );


		#ver si hay que editar un slider
		if( isset( $_GET['action'] ) && $_GET['action'] == 'editar' && !isset( $_POST['action'] ) ) {
			#recuperar el id dle elemento a editar
			$action = "editar";
			$id_slider = $_GET['iden'];
			#ver que exista ese item
			$encontrado = $this->encontrar_en_arreglo_slider( $options_slider, $id_slider );
			if( !$encontrado )
				wp_redirect( $url_nuevo );
			#caso contrario recuperamos los datos
			$data_slider['titulo']      = isset( $options_slider[$id_slider]['nombre'] ) ? $options_slider[$id_slider]['nombre'] : "";
			$data_slider['con_des']     = isset( $options_slider[$id_slider]['have_des'] ) ? $options_slider[$id_slider]['have_des'] : "";
			$data_slider['descripcion'] = isset( $options_slider[$id_slider]['descripcion'] ) ? $options_slider[$id_slider]['descripcion'] : "";
			$data_slider['on_home']     = isset( $options_slider[$id_slider]['on_home'] ) ? $options_slider[$id_slider]['on_home'] : "";

		}

		#ver si viene un post
		if( isset( $_POST['action'] ) && $_POST['action'] == 'nuevo' ){
			#recuperar los datos
			$data_slider['titulo'] = $_POST['txtTitulo'];
			$data_slider['con_des'] = isset( $_POST['chb_descripcion'] ) ? 1 : 0;
			$data_slider['descripcion'] = $_POST['txadescripcion'];
			$data_slider['on_home'] = isset( $_POST['chb_home'] ) ? 1 : 0;

			#validar campo necesario
			if( $data_slider['titulo'] == '' ){
				$errores[] = "Titulo es necesario.";
			} else {
				#verificar que no exista ya un titulo parecido 
				$encontrado = false;
				if( !empty( $options_slider ) && is_array( $options_slider ) )
					foreach ($options_slider as $key => $value) {
						if( $value['nombre'] == $data_slider['titulo'] ){
							$encontrado = true;
							break;
						}
					}#end foreach options_slider
					if( $encontrado ){
						$errores[] = "Titulo ya existente.";
					}
				}

				if( count( $errores ) == 0 ){
					#echo "entro";
					#no tiene errores guardar los datos
					$iden = $this->generar_id_unico( $options_slider );
					$options_slider[$iden] = array(
						"nombre" => $data_slider['titulo'],
						"slider" => array(),
						"have_des" => $data_slider['con_des'],
						"descripcion" => $data_slider['descripcion'],
						"on_home" => $data_slider['on_home']
						);
					$data_json = base64_encode( serialize( $options_slider ) );
					update_option( $this->plugin_name, $data_json );
				}
		}#end action crear
		elseif( isset( $_POST['action'] ) && $_POST['action'] == 'editar' ){

			$id_slider                  = $_POST['txthid'];
			$data_slider['titulo']      = $_POST['txtTitulo'];
			$data_slider['con_des']     = isset( $_POST['chb_descripcion'] ) ? 1 : 0;
			$data_slider['descripcion'] = $_POST['txadescripcion'];
			$data_slider['on_home']     = isset( $_POST['chb_home'] ) ? 1 : 0;
			$action                     = "editar";

			#ver que exista este item 
			$encontrado = $this->encontrar_en_arreglo_slider( $options_slider, $id_slider );
			if( !$encontrado ){
				$errores[] = 'Item no encontrado';
			} else {
				#existe el item del slider
				if( $data_slider['titulo'] == "" ){
					$errores[] = "Titulo es necesario.";
				} else {
					#verificar que no exista ya un titulo parecido 
					$encontrado = false;
					if( !empty( $options_slider ) && is_array( $options_slider ) )
						foreach ($options_slider as $key => $value) {
							if( $value['nombre'] == $data_slider['titulo'] && $key != $id_slider ){
								$encontrado = true;
								break;
							}
					}#end foreach options_slider
					if( $encontrado ){
						$errores[] = "Titulo ya existente.";
					}
				}

			}

			if( count( $errores ) == 0 ){
				#actualizar el item
				$options_slider[$id_slider]['nombre']      = $data_slider['titulo'];
				$options_slider[$id_slider]['have_des']    = $data_slider['con_des'];
				$options_slider[$id_slider]['descripcion'] = $data_slider['descripcion'];
				$options_slider[$id_slider]['on_home']     = $data_slider['on_home'];

				$data_json = base64_encode( serialize( $options_slider ) );
				update_option( $this->plugin_name, $data_json );
				#limpiar los \ para mostrar en la barra.
				$data_slider['descripcion'] = stripslashes( $data_slider['descripcion'] );
				$action = "editar";
			}
		}#end action editar
		$options .= '<option value="0" ';
		if( $id_slider === 0 )
			$options .= ' selected="selected" ';
		$options .= ' >-- Seleccionar --</option>';
		if( is_array( $options_slider ) ){
			foreach ($options_slider as $key => $value) {
				#armar la url
				$url = admin_url('admin.php?page=mkslider-options&action=editar&iden=' . $key);
				$options .= '<option value="'.$url.'" ';
				if( $key === $id_slider )
					$options .= 'selected="selected"';
				$options .= ' >'.$value['nombre'].'</option>';
				}#end foreach options_slider
			}

			if( !empty( $errores ) ) {
				$mensaje .= '<ul>';
				foreach ($errores as $value) {
					$mensaje .= '<li>'.$value.'</li>';
			}#end foreach errores
			$mensaje .= '</ul>';
		} elseif( isset( $_POST['action'] ) && $_POST['action'] == 'nuevo' ){
			$mensaje = '<p><strong>Elementro creado</strong></p>';
		} elseif( isset( $_POST['action'] ) && $_POST['action'] == 'editar' ){
			$mensaje = '<p><strong>Elementro actualizado</strong></p>';
		}
		include('partials/mkslider-doox-admin-display.php');
	}#end function html_admin_options

	public function generar_id_unico( $arreglo ){
		do {
			$id = $this->generateID(6);
		} while ( $this->is_in_table($id, $arreglo)  );

		return $id;
	}
	public function is_in_table( $iden, $arreglo ){
		$return = false;
		if( !empty( $arreglo ) && is_array($arreglo) )
			foreach ($arreglo as $key => $value) {
				if( $key == $iden ){
					$return = true;
					break;
				}
			}
			return $return;
		}
		public function generateID( $lenght ){
			$random = '';
			for ($i = 0; $i < $lenght; $i++) {
				$random .= chr(rand(ord('a'), ord('z')));
			}
			return $random;
		}

		public function encontrar_en_arreglo_slider( $slider, $elemento ){
			$encontrado = false;
			if( !empty( $slider ) && is_array( $slider ) )
				foreach ($slider as $key => $value) {
					if( $key == $elemento ){
						$encontrado = true;
						break;
					}
				}
				return $encontrado;
	}#end function encontrar_en_arreglo_slider

	public function eliminar_slider(){
		$iden = "0";
		$send_rpta = array("eliminado" => 0, "url" => "", "mensaje" =>"Error inesperado!");

		if( isset( $_POST['iden'] ) )
			$iden = $_POST['iden'];

		#recuperar la cfg del slider
		$options_slider = get_option( $this->plugin_name, false );
		if( !empty($options_slider) OR $options_slider != false )
			$options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
		$encontrado = false;
		if( !empty( $options_slider ) && is_array( $options_slider ) )
			foreach ($options_slider as $key => $value) {
				if( $iden == $key ){
					$encontrado = true;
					break;
				}
			}#end foreach options_slider
			if( $encontrado ){
				unset( $options_slider[$iden] );
				$send_rpta['eliminado'] = 1;
				#recuperar la url
				$send_rpta['url'] = admin_url( "admin.php?page=mkslider-options" );
				$data_json = base64_encode( serialize( $options_slider ) );
				update_option( $this->plugin_name, $data_json );
			}

			echo json_encode($send_rpta);
			exit;
	}#end function eliminar_slider

	public function recuperar_items(){
		$iden = "0";
		$html = "";
		$send_rpta = array( "recuperado" => 0, "listado" => '<p class="mensajeCentral">No hay elementos en el slider.</p>', "mensaje" => "Error inesperado" );

		if( isset( $_POST['iden'] ) )
			$iden = $_POST['iden'];

		#recuperar la cfg del slider
		$options_slider = get_option( $this->plugin_name, false );
		if( !empty($options_slider) OR $options_slider != false )
			$options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
		$encontrado = false;
		if( !empty( $options_slider ) && is_array( $options_slider ) )
			foreach ($options_slider as $key => $value) {
				if( $iden == $key ){
					$encontrado = true;
					break;
				}
			}#end foreach options_slider
			if( $encontrado ){
				$items = $options_slider[$iden]['slider'];
				if( !empty($items) ){
					foreach ($items as $key => $value) {
						$html .= '<div class="itemslider itemslider_'.$key.'">';
						$html .= '<div class="opts"><div class="mkeditar" data-iden="'.$key.'" data-idensl="'.$iden.'"><span class="dashicons dashicons-edit"></span></div><div class="mkeliminar" data-iden="'.$key.'" data-idensl="'.$iden.'"><span class="dashicons dashicons-trash"></span></div></div>';
						$html .= '<img width="350" src="'.$value['imagen'].'" alt="imagen">';
						if( $value['titulo'] != '' )
							$html .= '<h4 class="titulo">'.$value['titulo'].'</h4>';
						$html .= '<p class="descripcion">'.$value['descripcion'].'</p>';
						$html .= '</div>';
				}#end foreach items
				$send_rpta['listado'] = $html;
			}
			$send_rpta['recuperado'] = 1;

		}#end if encontrado true

		echo json_encode($send_rpta);
		exit;

	}#end function recuperar_items

	public function modificar_items(){
		$id_slider   = 0;
		$id_item     = 0;
		$titulo      = "";
		$descripcion = "";
		$enlace      = "";
		$imagen      = "";
		$action      = "";
		$html        = "";
		$send_rpta   = array("modificado"=>0, "listado" => '<p class="mensajeCentral">No hay elementos en el slider.</p>', "mensaje" => "Error inesperado");

		#recuperar valores
		if( isset($_POST['cambio']) )
			$action = $_POST['cambio'];
		if( isset($_POST['titulo']) )
			$titulo = $_POST['titulo'];
		if( isset($_POST['descripcion']) )
			$descripcion = $_POST['descripcion'];
		if( isset($_POST['enlace']) )
			$enlace = $_POST['enlace'];
		if( isset($_POST['imagen']) )
			$imagen = $_POST['imagen'];
		if( isset($_POST['iditem']) )
			$id_item = $_POST['iditem'];
		if( isset($_POST['idslider']) )
			$id_slider = $_POST['idslider'];

		#recuperar la cfg del slider
		$options_slider = get_option( $this->plugin_name, false );
		if( !empty($options_slider) OR $options_slider != false )
			$options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
		$encontrado = false;
		if( !empty( $options_slider ) && is_array( $options_slider ) )
			foreach ($options_slider as $key => $value) {
				if( $id_slider == $key ){
					$encontrado = true;
					break;
				}
			}#end foreach options_slider

			if( $encontrado ){
				$slider = $options_slider[$id_slider]['slider'];
			#ver cual es la accion
				if( $action == 'a' ){
				#accion agregar
					if( empty( $imagen ) )
						$send_rpta['mensaje'] = "Imagen es necesaria";
					else {
					#tiene imagen 
						$iden = $this->generar_id_unico( $slider );
						$slider[$iden] = array(
							"titulo" => $titulo,
							"descripcion" => $descripcion,
							"enlace" => $enlace,
							"imagen" => $imagen
							);
						$options_slider[$id_slider]['slider'] = $slider;
						$data_json = base64_encode( serialize( $options_slider ) );
						update_option( $this->plugin_name, $data_json );
						$send_rpta['modificado'] = 1;
						$send_rpta['mensaje'] = "Item insertado";
				} #el se tiene imagen 
			} elseif($action == 'e'){
				#accion editar, verificar q el id del slider exista
				$encontrado = false;
				if( !empty( $slider ) && is_array( $slider ) )
					foreach ($slider as $key => $value) {
						if( $id_item == $key ){
							$encontrado = true;
							break;
						}
					}#end foreach slider
					if($encontrado){
					#se encontro
						if( empty( $imagen ) )
							$send_rpta['mensaje'] = "Imagen es necesaria";
						else{
							$slider[$id_item]["titulo"]      = $titulo;
							$slider[$id_item]["descripcion"] = $descripcion;
							$slider[$id_item]["enlace"]      = $enlace;
							$slider[$id_item]["imagen"]      = $imagen;

							$options_slider[$id_slider]['slider'] = $slider;
							$data_json = base64_encode( serialize( $options_slider ) );
							update_option( $this->plugin_name, $data_json );
							$send_rpta['modificado'] = 1;
							$send_rpta['mensaje'] = "Item actualizado";
					}#end imagen existe
				} else {
					$send_rpta['mensaje'] = "Item no localizado!";
				}
			}
		}#end encontrado

		#modificar el listado siemproe y cuando modificado == 1
		if( $send_rpta['modificado'] == 1 ){
			$items = $options_slider[$id_slider]['slider'];
			if( !empty($items) ){
				foreach ($items as $key => $value) {
					$html .= '<div class="itemslider itemslider_'.$key.'">';
					$html .= '<div class="opts"><div class="mkeditar" data-iden="'.$key.'" data-idensl="'.$id_slider.'"><span class="dashicons dashicons-edit"></span></div><div class="mkeliminar" data-iden="'.$key.'" data-idensl="'.$id_slider.'"><span class="dashicons dashicons-trash"></span></div></div>';
					$html .= '<img width="350" src="'.$value['imagen'].'" alt="imagen">';
					if( $value['titulo'] != '' )
						$html .= '<h4 class="titulo">'.$value['titulo'].'</h4>';
					$html .= '<p class="descripcion">'.$value['descripcion'].'</p>';
					$html .= '</div>';
				}#end foreach items
				$send_rpta['listado'] = $html;
			}
		}#end modificado == 1

		echo json_encode($send_rpta);
		exit;

	}#end function modificar_items

	public function obtener_item(){
		$iden = "0";
		$slider = "0";
		$send_rpta = array("recuperado"=>0, "item"=>"","url"=>admin_url( "admin.php?page=mkslider-options" ));

		if( isset( $_POST['iden'] ) )
			$iden = $_POST['iden'];
		if( isset( $_POST['slider'] ) )
			$slider = $_POST['slider'];

		#recuperar la cfg del slider
		$options_slider = get_option( $this->plugin_name, false );
		if( !empty($options_slider) OR $options_slider != false )
			$options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
		$encontrado = false;
		if( !empty( $options_slider ) && is_array( $options_slider ) )
			foreach ($options_slider as $key => $value) {
				if( $slider == $key ){
					$encontrado = true;
					break;
				}
			}#end foreach options_slider
			if($encontrado){
				$slider_array = $options_slider[$slider]['slider'];
				$encontrado = false;
				if( !empty( $slider_array ) && is_array( $slider_array ) )
					foreach ($slider_array as $key => $value) {
						if( $iden == $key ){
							$encontrado = true;
							break;
						}
				}#end foreach slider
				if($encontrado){
				#se encontro tambien el slider
					$send_rpta['item'] = $slider_array[$iden];
					$send_rpta['recuperado'] = 1;
				}
		}#end if encontrado true

		echo json_encode($send_rpta);
		exit;
	}#end function obtener_item

	public function eliminar_item(){
		$iden = "0";
		$slider = "0";
		$send_rpta = array("eliminado"=>0);

		if( isset( $_POST['iden'] ) )
			$iden = $_POST['iden'];
		if( isset( $_POST['slider'] ) )
			$slider = $_POST['slider'];

		#recuperar la cfg del slider
		$options_slider = get_option( $this->plugin_name, false );
		if( !empty($options_slider) OR $options_slider != false )
			$options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
		$encontrado = false;
		if( !empty( $options_slider ) && is_array( $options_slider ) )
			foreach ($options_slider as $key => $value) {
				if( $slider == $key ){
					$encontrado = true;
					break;
				}
			}#end foreach options_slider
			if($encontrado){
				$slider_array = $options_slider[$slider]['slider'];
				$encontrado = false;
				if( !empty( $slider_array ) && is_array( $slider_array ) )
					foreach ($slider_array as $key => $value) {
						if( $iden == $key ){
							$encontrado = true;
							break;
						}
				}#end foreach slider
				if($encontrado){
					unset($slider_array[$iden]);
					$options_slider[$slider]['slider'] = $slider_array;
					$data_json = base64_encode( serialize( $options_slider ) );
					update_option( $this->plugin_name, $data_json );
					$send_rpta['eliminado'] = 1;
				}
			}
			echo json_encode($send_rpta);
			exit;
	}#end function eliminar_item

	public function agregar_metabox(){
		add_meta_box( "mk_mbslider", '<strong>Slider configuración</strong>', array($this, "mostrar_metabox"), "mksubdireccion", "normal", "low" );
	}#end function agregar_metabox

	public function mostrar_metabox($post){
		$options = "";
		#recuperar metabox
		$idenslider = get_post_meta($post->ID, 'mkpost_slider_iden', true );
		if( !$idenslider )
			$idenslider = "0";

		$options .= '<option value="0"';
		if($idenslider == "0")
			$options .= ' selected="selected" ';
		$options .= '>No usar slider</option>';
		#recuperar la lista de sliders
		$options_slider = get_option( $this->plugin_name, false );
		if( !empty($options_slider) OR $options_slider != false )
			$options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
		if( !empty( $options_slider ) && is_array( $options_slider ) )
			foreach ($options_slider as $key => $value) {
				$options .= '<option value="'.$key.'" ';
				if($key == $idenslider)
					$options .= ' selected="selected" ';
				$options .= '>'.$value['nombre'].'</option>';
			}#end foreach options_slider
		include_once('partials/mk-metabox-form.php');
		wp_nonce_field( basename( __FILE__ ), 'mk_meta_box_icon_nonce' );
	}#end function mostrar_metabox

	public function save_metabox_slider( $post_id ){
		// verify taxonomies meta box nonce
		if ( !isset( $_POST['mk_meta_box_icon_nonce'] ) || !wp_verify_nonce( $_POST['mk_meta_box_icon_nonce'], basename( __FILE__ ) ) )
			return;
		// return if autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;
		if( isset( $_REQUEST['slt_slider_post'] ) ){
			$sld = $_REQUEST['slt_slider_post'];
			update_post_meta( $post_id, "mkpost_slider_iden", $sld );
		} #end request mk_imagen_listado
	}#end function save_metabox_slider

}


