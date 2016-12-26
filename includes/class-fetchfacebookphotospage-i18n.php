<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.juavenel.fr/
 * @since      1.0.0
 *
 * @package    Fetchfacebookphotospage
 * @subpackage Fetchfacebookphotospage/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Fetchfacebookphotospage
 * @subpackage Fetchfacebookphotospage/includes
 * @author     juavenel <juavenel@outlook.fr>
 */
class Fetchfacebookphotospage_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'fetchfacebookphotospage',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
