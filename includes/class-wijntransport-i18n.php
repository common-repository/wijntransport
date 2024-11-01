<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wijntransport.com/
 * @since      1.0.0
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wijntransport
 * @subpackage Wijntransport/includes
 * @author     Manolache Silviu @cultofcoders <silviu.manolache@cultofcoders.com>
 */
class Wijntransport_i18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'wijntransport',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
