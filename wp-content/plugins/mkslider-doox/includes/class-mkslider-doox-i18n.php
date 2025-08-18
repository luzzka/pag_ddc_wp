<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.facebook.com/orlandoox
 * @since      1.0.0
 *
 * @package    Mkslider_Doox
 * @subpackage Mkslider_Doox/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mkslider_Doox
 * @subpackage Mkslider_Doox/includes
 * @author     Doox <orland85k@gmail.com>
 */
class Mkslider_Doox_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mkslider-doox',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
