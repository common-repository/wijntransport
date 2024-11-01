<?php
/**
 * Handle AJAX calls
 *
 * @link       https://wijntransport.com/
 * @since      1.0.0
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/includes
 */

/**
 * Handle AJAX calls
 *
 * This is used to for ajax function.
 *
 * @since      1.0.0
 * @package    Wijntransport
 * @subpackage Wijntransport/includes
 * @author     Manolache Silviu @cultofcoders <silviu.manolache@cultofcoders.com>
 */

/**
 *-----------------------------------------
 * Do not delete this line
 * Added for security reasons: http://codex.wordpress.org/Theme_Development#Template_Files
 *-----------------------------------------
 */
defined('ABSPATH') or die("Direct access to the script does not allowed");

/**
 * Handle AJAX calls
 */
class Wijntransport_AJAX {

    /**
     * Add products to the block list
     *
     * @since    1.0.0
     */
    public function block_product() {
	    if (current_user_can('manage_options')) {
		    if (!empty($_POST)) {
			    check_ajax_referer('wt-block-product', 'wt-block-product-nonce');
			    $wt_options = get_option('wijntransport_options');

			    if (isset($_POST['productId']) && !empty($_POST['productId'])) {
				    $product_id = sanitize_text_field($_POST['productId']);
				    $product_details = $_POST['productDetails'];

				    $sanitized_product_details = array(
					    'name' => isset($product_details['name']) ? sanitize_text_field($product_details['name']) : '',
					    'image' => isset($product_details['image']) ? esc_url_raw($product_details['image']) : '',
					    'countryCode' => isset($product_details['countryCode']) ? sanitize_text_field(strtolower($product_details['countryCode'])) : '',
					    'country' => isset($product_details['country']) ? sanitize_text_field($product_details['country']) : ''
				    );

				    $wt_options['block_list'][$product_id] = $sanitized_product_details;

				    $update_status = update_option('wijntransport_options', $wt_options);

				    if ($update_status) {
					    wp_send_json_success('Updated', '200');
				    }
			    }
		    }
		    wp_send_json_error('Error', '400');
	    } else {
		    wp_send_json_error('Unauthorized', '401');
	    }

        die();
    }

    /**
     * Remove products from the block list
     *
     * @since    1.0.0
     */
	public function unblock_product() {
		if (current_user_can('manage_options')) {
			if (!empty($_POST)) {
				check_ajax_referer('wt-block-product', 'wt-block-product-nonce');
				$wt_options = get_option('wijntransport_options');

				if (isset($_POST['productId']) && !empty($_POST['productId'])) {
					$product_id = sanitize_text_field($_POST['productId']);

					unset($wt_options['block_list'][$product_id]);

					$update_status = update_option('wijntransport_options', $wt_options);

					if ($update_status) {
						wp_send_json_success('Updated', '200');
					}
				}
			}
			wp_send_json_error('Error', '400');
		} else {
			wp_send_json_error('Unauthorized', '401');
		}

		die();
	}
}
