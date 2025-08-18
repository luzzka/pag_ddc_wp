<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.facebook.com/orlandoox
 * @since             1.0.0
 * @package           Mkslider_Doox
 *
 * @wordpress-plugin
 * Plugin Name:       Simple and Easy Slider WP
 * Plugin URI:        http://www.google.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Doox
 * Author URI:        http://www.facebook.com/orlandoox
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mkslider-doox
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mkslider-doox-activator.php
 */
function activate_mkslider_doox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mkslider-doox-activator.php';
	Mkslider_Doox_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mkslider-doox-deactivator.php
 */
function deactivate_mkslider_doox() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mkslider-doox-deactivator.php';
	Mkslider_Doox_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mkslider_doox' );
register_deactivation_hook( __FILE__, 'deactivate_mkslider_doox' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mkslider-doox.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mkslider_doox() {

	$plugin = new Mkslider_Doox();
	$plugin->run();

}
run_mkslider_doox();
