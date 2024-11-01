<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://wijntransport.com/
 * @since             1.0.0
 * @package           Wijntransport
 *
 * @wordpress-plugin
 * Plugin Name:       Wijntransport
 * Plugin URI:        https://wordpress.org/plugins/wijntransport/
 * Description:       Host a catalog of Wijntransport.com products on your own website.
 * Version:           1.4.1
 * Author:            Manolache Silviu @cultofcoders
 * Author URI:        https://www.cultofcoders.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wijntransport
 * Domain Path:       /languages
 * Requires at least: 4.9
 * Tested up to:      5.7
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'WIJNTRANSPORT_VERSION', '1.4.1' );
define( 'WIJNTRANSPORT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WIJNTRANSPORT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WIJNTRANSPORT_API_URL', 'https://api.wtwine.com/api/v2');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wijntransport-activator.php
 */
function activate_wijntransport() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wijntransport-activator.php';
	Wijntransport_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wijntransport-deactivator.php
 */
function deactivate_wijntransport() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wijntransport-deactivator.php';
	Wijntransport_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wijntransport' );
register_deactivation_hook( __FILE__, 'deactivate_wijntransport' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wijntransport.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wijntransport() {
	$plugin = new Wijntransport();
	$plugin->run();
}
run_wijntransport();
