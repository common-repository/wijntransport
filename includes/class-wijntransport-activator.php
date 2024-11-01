<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wijntransport.com/
 * @since      1.0.0
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wijntransport
 * @subpackage Wijntransport/includes
 * @author     Manolache Silviu @cultofcoders <silviu.manolache@cultofcoders.com>
 */
class Wijntransport_Activator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		add_rewrite_endpoint( 'wine', EP_PERMALINK | EP_PAGES );
		flush_rewrite_rules();

		if (!get_option('wijntransport_options')) {
			add_option('wijntransport_options', array('api_key' => '', 'list_filter' => '', 'block_list' => array()));
		}
	}
}
