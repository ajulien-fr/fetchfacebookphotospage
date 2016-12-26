<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.juavenel.fr/
 * @since      1.0.0
 *
 * @package    Fetchfacebookphotospage
 * @subpackage Fetchfacebookphotospage/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Fetchfacebookphotospage
 * @subpackage Fetchfacebookphotospage/includes
 * @author     juavenel <juavenel@outlook.fr>
 */
class Fetchfacebookphotospage_Deactivator {

    /**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
    public static function deactivate() {

        wp_clear_scheduled_hook( 'fetch_photos_daily_event' );

    }

}
