<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://datamad.co.uk
 * @since      1.0.0
 *
 * @package    Widgets_On_Pages
 * @subpackage Widgets_On_Pages/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Widgets_On_Pages
 * @subpackage Widgets_On_Pages/public
 * @author     Todd Halfpenny <todd@toddhalfpenny.com>
 */
class Widgets_On_Pages_Public {

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
	 * @param string $plugin_name       The name of the plugin.
	 * @param string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->widgets_on_template();

		add_shortcode( 'widgets_on_pages', array( $this, 'widgets_on_page' ) );

		if ( wop_fs()->is__premium_only() ) {
			add_filter( 'the_content', array( $this, 'maybe_insert_with_content__premium_only' ) );
			add_filter( 'custom-header', array( $this, 'maybe_insert_with_header__premium_only' ) );
		}
	}


	/**
	 * Our lovely shortcode.
	 *
	 * @param array $atts Should contain '$id' that should match to Turbo Sidebar.
	 * @since    1.0.0
	 */
	public static function widgets_on_page( $atts ) {
		foreach ($atts as &$value) {
			$value = esc_attr($value);
		}
		extract( shortcode_atts( array( 'id' => '1', 'tiny' => '1', 'small' => '1', 'medium' => '1', 'large' => '1', 'wide' => '1' ), $atts ) );
		$str = "<div id='" . str_replace( ' ', '_', $id ) . "' class='widgets_on_page wop_tiny" . $tiny . '  wop_small' . $small . '  wop_medium' . $medium . '  wop_large' . $large . '  wop_wide' . $wide  ."'>
			<ul>";

		// Legacy bullshit.
		if ( is_numeric( $id ) ) {
			$id = 'wop-' . $id;
		}

		ob_start();
		if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( $id ) ) {
			$my_str = ob_get_contents();
		} else {
			// Ouput somethign nice to the source.
			$my_str = '<!-- ERROR NO TURBO SIDEBAR FOUND WITH ID ' . $id . '-->';
		}
		ob_end_clean();
		$str .= $my_str;
		$str .= '</ul></div><!-- widgets_on_page -->';
		return $str;
	}


	/**
	 * Our lovely template tage handler.
	 *
	 * @param string $id Id that should match the ID of our Turbo Sidebar.
	 * @since    1.0.0
	 */
	public static function widgets_on_template( $id = '1' ) {
		$arr = array( 'id' => $id );
		return Widgets_On_Pages_Public::widgets_on_page( $arr );
	}

	/**
	 * Our filter to maybe add our sidebar(s) before/after the content
	 *
	 * @param  string $content The content of our post.
	 * @return string $content the content maybe with our sidebar(s) in.
	 */
	public function maybe_insert_with_content__premium_only( $content ) {
		if ( ! in_the_loop() || ! is_main_query() || ! is_singular() ) {
			return $content;
		}

		$args = array(
			'post_type' => 'turbo-sidebar-cpt',
			'posts_per_page' => 50,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => '_wop_auto_insert',
					'value' => 0,
				),
				array(
					'key' => '_wop_before_after',
					'value' => array( '0', '1' ), // Before content, after content.
					'compare' => 'IN',
				),
			),
		);
		$potential_turbo_sidebars = get_posts( $args );

		if ( empty( $potential_turbo_sidebars ) ) {
			return $content;
		}

		$pst_id = get_the_ID();
		// Check if we should exclude for this post_id.
		$pst_exclude = get_post_meta( $pst_id, '_wop_exclude', true );
		if ( $pst_exclude ) {
			return $content;
		}

		// Check if we should show for this post type.
		$valid_post_types = $potential_turbo_sidebars[0]->_wop_valid_post_types;
		if ( 'all' == $valid_post_types ) {
			$valid_post_type = true;
		} else {
			$pst_type = get_post_type( $pst_id );
			if ( $pst_type == $valid_post_types ) {
				$valid_post_type = true;
			} else {
				$valid_post_type = false;
			}
		}

		if ( $valid_post_type ) {
			$arr = array(
				'id' => $potential_turbo_sidebars[0]->post_title,
				'small' => $potential_turbo_sidebars[0]->_wop_cols_small,
				'medium' => $potential_turbo_sidebars[0]->_wop_cols_medium,
				'large' => $potential_turbo_sidebars[0]->_wop_cols_large,
				'wide' => $potential_turbo_sidebars[0]->_wop_cols_wide,
				);
			if ( 1 == $potential_turbo_sidebars[0]->_wop_before_after ) {
				return $content . $this->widgets_on_page( $arr );
			} else {
				return $this->widgets_on_page( $arr ) . $content;
			}
		} else {
			return $content;
		}
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
		 * defined in Widgets_On_Pages_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Widgets_On_Pages_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$options = get_option( 'wop_options_field' );
		if ( ! is_array( $options ) ) {
			$options = array();
		}
		if ( array_key_exists( 'enable_css', $options ) ) {
			$tmp = get_option( 'wop_options_field' );
			$enable_css = $tmp['enable_css'];
			// $enable_css = $options["enable_css"];
			if ( wop_fs()->is__premium_only() ) {
				wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/widgets-on-pages-public__premium_only.css', array(), $this->version, 'all' );
			} else {
				if ( $enable_css ) {
					wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/widgets-on-pages-public.css', array(), $this->version, 'all' );
				}
			}
		}

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
		 * defined in Widgets_On_Pages_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Widgets_On_Pages_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( wop_fs()->is__premium_only() ) {
			if ( in_the_loop() || is_main_query() || is_singular() ) {
				global $post;
				// Check to see if we have any TurboSidebars that have auto_include into headers/footers.
				$args = array(
					'post_type' => 'turbo-sidebar-cpt',
					'posts_per_page' => 50,
					'meta_query' => array(
		        array(
							'key' => '_wop_before_after',
							'value' => array( '2', '3', '4', '5' ), // Before header, afetr header, before footer, after footer.
							'compare' => 'IN',
		        ),
					),
				);
				$potential_turbo_sidebars = get_posts( $args );

				if ( ! empty( $potential_turbo_sidebars ) ) {
					wp_enqueue_script( $this->plugin_name . '_prem', plugin_dir_url( __FILE__ ) . 'js/wop-public__premium_only.js', array( 'jquery' ), $this->version, true );
					// Make our current $post->ID available to our JS.
					wp_localize_script( $this->plugin_name . '_prem', 'wop_vars', array( 'post_id' => $post->ID, 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
				}
			}
		}
	}
}
