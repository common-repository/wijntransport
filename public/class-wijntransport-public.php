<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wijntransport.com/
 * @since      1.0.0
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/public
 * @author     Manolache Silviu @cultofcoders <silviu.manolache@cultofcoders.com>
 */
class Wijntransport_Public {

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
		if (is_page_template('wijntransport-wine-listing.php')) {
			wp_enqueue_style($this->plugin_name, WIJNTRANSPORT_PLUGIN_URL . 'public/assets/css/mds-public.min.css', array(), $this->version, 'all');
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if (is_page_template('wijntransport-wine-listing.php')) {
			wp_enqueue_script($this->plugin_name, WIJNTRANSPORT_PLUGIN_URL . 'public/assets/js/mds-public.min.js', array('jquery'), $this->version, true);

			$wines = new Wijntransport_API();
			$selected_filters = $wines->get_selected_filters();

			wp_localize_script($this->plugin_name, 'WT', array(
				'ajaxUrl'     => admin_url('admin-ajax.php'),
				'listingPageUrl' => get_the_permalink(),
				'activeFilters' => $selected_filters,
			));
		}
	}

    /**
     * Add new frontend endpoin for single products.
     *
     * @since    1.0.0
     */
	public function add_rewrite_endpoint() {
		add_rewrite_endpoint( 'wine', EP_PERMALINK | EP_PAGES );
	}
}
