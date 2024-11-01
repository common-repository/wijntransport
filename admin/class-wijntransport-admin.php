<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wijntransport.com/
 * @since      1.0.0
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/admin
 * @author     Manolache Silviu @cultofcoders <silviu.manolache@cultofcoders.com>
 */
class Wijntransport_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, WIJNTRANSPORT_PLUGIN_URL . 'admin/assets/css/mds-admin.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {
		if ( 'wijntransport_page_wijntransport-blocked-products' != $hook ) {
			return;
		}

		wp_enqueue_script( $this->plugin_name, WIJNTRANSPORT_PLUGIN_URL . 'admin/assets/js/mds-admin.min.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Add the page template to the pages dropdown
	 *
	 * @param $templates
	 *
	 * @return mixed
	 *
	 * @since    1.0.0
	 */
	public function add_page_template ($templates) {
		$templates['wijntransport-wine-listing.php'] = __('[Wijntransport] Wine listing', 'wijntransport');

		return $templates;
	}

	/**
	 * Redirect to the plugin page template file
	 *
	 * @param $template
	 *
	 * @return string
	 *
	 * @since    1.0.0
	 */
	public function redirect_page_template ($template) {
		global $wp_query;
		$post = get_post();
		$page_template = get_post_meta( $post->ID, '_wp_page_template', true );

		if ('wijntransport-wine-listing.php' == basename ($page_template)) {
			if ( isset( $wp_query->query_vars['wine'] ) ) {
				$template = WIJNTRANSPORT_PLUGIN_DIR . 'templates/wine-single-template.php';
			} else {
				$template = WIJNTRANSPORT_PLUGIN_DIR . 'templates/wine-listing-template.php';
			}
		}
		return $template;
	}

    /**
     * Add plugin admin pages to the menu
     *
     * @since    1.0.0
     */
	public function add_admin_menu() {
		add_menu_page(
			'Wijntransport',
			'Wijntransport',
			'manage_options',
			'wijntransport-settings',
			array($this, 'admin_options'),
		'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNC4yLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAzODEuNyAyODcuOSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMzgxLjcgMjg3Ljk7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsLXJ1bGU6ZXZlbm9kZDtjbGlwLXJ1bGU6ZXZlbm9kZDtmaWxsOiNGRUZFRkU7fQ0KCS5zdDF7ZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7ZmlsbDojQjQxRTQ0O30NCjwvc3R5bGU+DQo8ZyBpZD0iTGF5ZXJfeDAwMjBfMSI+DQoJPGcgaWQ9Il8yMjkzNDI2NDYzNTA0Ij4NCgkJPGc+DQoJCQk8cG9seWdvbiBjbGFzcz0ic3QwIiBwb2ludHM9IjI1My44LDE5Mi44IDM4MS43LDAgMzgxLjcsOTggMjUzLjgsMjg3LjkgCQkJIi8+DQoJCQk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNMjUzLjgsMTkyLjhMMTI2LDB2OThsMTI3LjgsMTg5LjlMMzgxLjcsOThWMEwyNTMuOCwxOTIuOHogTTM4MC42LDMuM0wyNTQuOCwxOTMuMXY5MS41TDM4MC42LDk3LjdWMy4zeiIvPg0KCQk8L2c+DQoJCTxnPg0KCQkJPHBvbHlnb24gY2xhc3M9InN0MCIgcG9pbnRzPSIxMjcuOCwxOTIuOCAyNTUuNywwIDI1NS43LDk4IDEyNy44LDI4Ny45IAkJCSIvPg0KCQkJPHBhdGggY2xhc3M9InN0MSIgZD0iTTEyNy44LDE5Mi44TDAsMHY5OGwxMjcuOCwxODkuOUwyNTUuNyw5OFYwTDEyNy44LDE5Mi44eiBNMjU0LjcsMy4zTDEyOC44LDE5My4xdjkxLjVMMjU0LjcsOTcuN1YzLjN6Ii8+DQoJCTwvZz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg=='
		);

		add_submenu_page(
			'wijntransport-settings',
			__('Wijntransport settings', 'wijntransport'),
			__('Settings','wijntransport'),
			'manage_options',
			'wijntransport-settings',
			array($this, 'admin_options')
		);

		add_submenu_page(
			'wijntransport-settings',
			__('Wijntransport blocked products', 'wijntransport'),
			__('Blocked products','wijntransport'),
			'manage_options',
			'wijntransport-blocked-products',
			array($this, 'admin_block_options') );
	}

    /**
     * Admin options page for the plugin
     *
     * @since    1.0.0
     */
	public function admin_options() {
        settings_errors('wijntransport_options');
		include('partials/wijntransport-admin-options.php');
	}

    /**
     * Admin blocked products page for the plugin
     *
     * @since    1.0.0
     */
	public function admin_block_options() {
		include('partials/wijntransport-admin-block-options.php');
	}

    /**
     * Register settings for the options page
     *
     * @since    1.0.0
     */
	public function register_settings() {
		register_setting( 'wijntransport_options', 'wijntransport_options', array($this, 'settings_validate') );
		add_settings_section( 'api_settings', 'API Settings', array($this, 'settings_section_text'), 'wijntransport-settings' );

		add_settings_field( 'wijntransport_settings_api_key', 'API Key', array($this, 'setting_api_key'), 'wijntransport-settings', 'api_settings' );
		add_settings_field( 'wijntransport_settings_list_filter', 'Listing filter', array($this, 'setting_list_filter'), 'wijntransport-settings', 'api_settings' );
	}

    /**
     * Options page text
     *
     * @since    1.0.0
     */
	public function settings_section_text() {
		echo '<p>Here you will set all the options for the API</p>';
	}

    /**
     * Options page api key field
     *
     * @since    1.0.0
     */
	public function setting_api_key() {
		$options = get_option( 'wijntransport_options' );
		?>
		<input id='wijntransport_settings_api_key' class="cc--full-width" name='wijntransport_options[api_key]' type='text' value='<?php echo esc_attr( $options['api_key'] ); ?>' />
        <?php
	}

    /**
     * Options page api key filter settings
     *
     * @since    1.0.0
     */
	public function setting_list_filter() {
		$options = get_option( 'wijntransport_options' );
		?>
        <select id="wijntransport_settings_list_filter" name="wijntransport_options[list_filter]">
            <option value="" <?php echo $options['list_filter'] == '' ? "selected='selected'" : '' ?>><?php esc_html_e( 'All wines', 'wijntransport' ) ?></option>
            <option value="12" <?php echo $options['list_filter'] == '12' ? "selected='selected'" : '' ?>><?php esc_html_e( 'All Wines purchased in the last 12 months', 'wijntransport' ) ?></option>
            <option value="14" <?php echo $options['list_filter'] == '999' ? "selected='selected'" : '' ?>><?php esc_html_e( 'All wines purchased', 'wijntransport' ) ?></option>
        </select>
		<?php
	}

    /**
     * Options validation
     *
     * @since    1.0.0
     */
	public function settings_validate( $input ) {
		$newinput = $input;
		$newinput['api_key'] = sanitize_text_field($input['api_key']);

        if (isset($newinput['api_key']) && !empty($newinput['api_key'])) {
            $wines = new Wijntransport_API();
            $is_key_valid = $wines->is_api_key_valid($newinput['api_key']);

            if (!$is_key_valid) {
                add_settings_error('wijntransport_options', esc_attr('wijn_apy_key_error'), __('The api key you entered it\'s not valid, please verify if the key you entered matches the one sent to you by the wijntransport.com admin', 'wijntransport'),'error');
            } else {
                add_settings_error('wijntransport_options', esc_attr('wijn_apy_key_updated'), __('The api key you entered is valid, settings have been saved', 'wijntransport'),'updated');
            }
        }

		return $newinput;
	}
}
