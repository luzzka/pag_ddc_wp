<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.facebook.com/orlandoox
 * @since      1.0.0
 *
 * @package    Mkslider_Doox
 * @subpackage Mkslider_Doox/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mkslider_Doox
 * @subpackage Mkslider_Doox/public
 * @author     Doox <orland85k@gmail.com>
 */
class Mkslider_Doox_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mkslider-doox-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mkslider-doox-public.js', array( 'jquery' ), $this->version, true );

	}

	public function verificar_slider(){
		
		global $wp_query;
		$mostrar_sld = false;
		$id_sld = 0;
		if( is_home() || is_front_page() ){
				#es home entonces recuperar el slider y ver si hay en el home
			$options_slider = get_option( $this->plugin_name, false );
			if( !empty($options_slider) OR $options_slider != false )
				$options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
			$encontrado = false;
			if( !empty( $options_slider ) && is_array( $options_slider ) )
				foreach ($options_slider as $key => $value) {
					if( isset( $value['on_home'] ) && $value['on_home'] == '1' ){
						$encontrado = true;
						$mostrar_sld = true;
						$id_sld = $key;
						break;
					}
				}#end foreach options_slider

				if( $encontrado ){
					$slider_item = $options_slider[$id_sld];
				}

				}#end if home or front_end
				else {
				#recupear objeto
				
					$mkobjeto = get_queried_object();
					if(!empty( $mkobjeto )){
						$clase_objeto = get_class( $mkobjeto );
						if( $clase_objeto == 'WP_Post' ){
							#es un post recuperar el meta del sld
							$sld = get_post_meta( $mkobjeto->ID, "mkpost_slider_iden", true );
							if( !empty( $sld ) && $sld != "0" ){
							#recuperar el slider que vamos a mostrar
								$options_slider = get_option( $this->plugin_name, false );
								if( !empty($options_slider) OR $options_slider != false )
									$options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
								$encontrado = false;
								if( !empty( $options_slider ) && is_array( $options_slider ) )
									foreach ($options_slider as $key => $value) {
										if( $sld == $key ){
											$encontrado = true;
											break;
										}
						}#end foreach options_slider
						if( $encontrado ){
							$slider_item = $options_slider[$sld];
							if( !empty( $slider_item ) && isset( $slider_item['slider'] ) && !empty( $slider_item['slider'] ) ){
								$mostrar_sld = true;
							}
						}#end encontrado
					}
				} 
			}#end not empty mkobjeto
		}#else not home

		if( $mostrar_sld ){

			if( isset( $slider_item['have_des'] ) && $slider_item['have_des'] == 1 )
				include_once( "partials/mkslider-doox-public-display-description.php" );
			else
				include_once( "partials/mkslider-doox-public-display.php" );

		}
	}#end function verificar_slider

}
