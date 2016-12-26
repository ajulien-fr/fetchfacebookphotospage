<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.juavenel.fr/
 * @since             1.0.0
 * @package           Fetchfacebookphotospage
 *
 * @wordpress-plugin
 * Plugin Name:       FetchFacebookPhotosPage
 * Plugin URI:        http://projects.juavenel.fr
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            juavenel
 * Author URI:        http://www.juavenel.fr/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fetchfacebookphotospage
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fetchfacebookphotospage-activator.php
 */
function activate_fetchfacebookphotospage() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fetchfacebookphotospage-activator.php';
	Fetchfacebookphotospage_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fetchfacebookphotospage-deactivator.php
 */
function deactivate_fetchfacebookphotospage() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fetchfacebookphotospage-deactivator.php';
	Fetchfacebookphotospage_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fetchfacebookphotospage' );
register_deactivation_hook( __FILE__, 'deactivate_fetchfacebookphotospage' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fetchfacebookphotospage.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fetchfacebookphotospage() {

	$plugin = new Fetchfacebookphotospage();
	$plugin->run();

}
run_fetchfacebookphotospage();
