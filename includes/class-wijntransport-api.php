<?php

/**
 * Wijntransport api data class
 *
 *
 * @link       https://wijntransport.com/
 * @since      1.0.0
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/includes
 */

/**
 * Wijntransport api data class
 *
 * This is used to get the data from the api
 *
 *
 * @since      1.0.0
 * @package    Wijntransport
 * @subpackage Wijntransport/includes
 * @author     Manolache Silviu @cultofcoders <silviu.manolache@cultofcoders.com>
 */
class Wijntransport_API {
	/**
	 * Responsible to store the available endpoints for the api
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array  $api_endpoints    The available endpoints for the api.
	 */
	protected $api_endpoints = array(
		'products' => 'products',
		'product' => 'product'
	);

    /**
     * Get the list of products from the api
     *
     * @since    1.0.0
     * @param    bool   $with_blocked_list  Retrieve the list of products including blocked list.
     */
	public function get_listing_products($with_blocked_list = true, $pageSize = 18) {
		$options = get_option('wijntransport_options');
		$url_params = $this->get_listing_url_params($with_blocked_list, $pageSize);

		if (isset($options['list_filter']) && !empty($options['list_filter'])) {
			$url_params['history'] = $options['list_filter'];
		}

		$url = add_query_arg($url_params, trailingslashit(WIJNTRANSPORT_API_URL) . $this->api_endpoints['products']);

		$response = wp_remote_get($url, array('headers' => array('authorization' => $options['api_key'])));

        return json_decode(wp_remote_retrieve_body($response), true);
	}

    /**
     * Get the single product details
     *
     * @since    1.0.0
     */
	public function get_product() {
		$options = get_option('wijntransport_options');
		$url = add_query_arg(array('lang' => $this->get_language_iso()), trailingslashit(WIJNTRANSPORT_API_URL) . $this->api_endpoints['product'] . '/' . get_query_var('wine'));
		$response = wp_remote_get($url, array('headers' => array('authorization' => $options['api_key'])));

		return json_decode(wp_remote_retrieve_body($response), true);
	}

    /**
     * Build the url params list for the request
     *
     * @since    1.0.0
     * @param    bool   $with_blocked_list  Retrieve the list of products including blocked list.
     */
	public function get_listing_url_params($with_blocked_list = true, $pageSize = 18) {
		$url_params = array();

		if (isset($_GET['search'])) {
			$url_params['search'] = sanitize_text_field($_GET['search']);
		}

		if (isset($_GET['country'])) {
			$url_params['country'] = array_map('sanitize_text_field', $_GET['country']);
		}

		if (isset($_GET['color'])) {
			$url_params['color'] = array_map('sanitize_text_field', $_GET['color']);
		}

		if (isset($_GET['volume'])) {
			$url_params['volume'] = array_map('sanitize_text_field', $_GET['volume']);
		}

		if (isset($_GET['producer'])) {
			$url_params['producer'] = array_map('sanitize_text_field', $_GET['producer']);
		}

		$page_number = get_query_var('paged');

		if ($page_number) {
			$url_params['pageNumber'] = $page_number;
			$url_params['pageSize'] = 80;
		}

		if (isset($_GET['pageNumber'])) {
			$url_params['pageNumber'] = intval(($_GET['pageNumber']));
		}

		if ($pageSize) {
			$url_params['pageSize'] = $pageSize;
		}

		if ($with_blocked_list) {
			$blocked_products = $this->get_block_list_ids();

			if ($blocked_products) {
				$url_params['blockedProducts'] = $blocked_products;
			}
		}

		$url_params['lang'] = $this->get_language_iso();

		return $url_params;
	}

    /**
     * Pagination for the product list
     *
     * @since    1.0.0
     * @param    int   $total_pages  Total number of available pages
     */
	public function pagination($total_pages) {
		$big = 999999999;
		if ($total_pages > 1)  {
			if(get_option('permalink_structure')) {
				$format = 'page/%#%/';
			} else {
				$format = '&paged=%#%';
			}

			$pagination_links = paginate_links(array(
				'base'			=> str_replace( $big, '%#%', get_pagenum_link($big, false) ),
				'format'		=> $format,
				'current'		=> max( 1, get_query_var('paged') ),
				'total' 		=> $total_pages,
				'end_size'      => 0,
				'mid_size'		=> 1,
				'type' 			=> 'array',
				'prev_text'		=> __('Previous page', 'wijntransport'),
				'next_text'		=> __('Next page', 'wijntransport'),
			));

			foreach ($pagination_links as $link) {
				echo '<li>' . $link . '</li>';
			}
		}
	}

    /**
     * List of all selected filters of the user on the current page
     *
     * @since    1.0.0
     */
	public function get_selected_filters () {
		$selected_filters = array(
			'country' => array(),
			'color' => array(),
			'volume' => array(),
			'producer' => array(),
			'search' => '',
		);

		if (isset($_GET['country'])) {
			$selected_filters['country'] = array_map('sanitize_text_field', $_GET['country']);
		}

		if (isset($_GET['color'])) {
			$selected_filters['color'] = array_map('sanitize_text_field', $_GET['color']);
		}

		if (isset($_GET['volume'])) {
			$selected_filters['volume'] = array_map('sanitize_text_field', $_GET['volume']);
		}

		if (isset($_GET['producer'])) {
			$selected_filters['producer'] = array_map('sanitize_text_field', $_GET['producer']);
		}

		if (isset($_GET['search'])) {
			$selected_filters['search'] = sanitize_text_field($_GET['search']);
		}

		return $selected_filters;
	}

    /**
     * Retrieve the list of ids of blocked products
     *
     * @since    1.0.0
     */
	public function get_block_list_ids() {
		$wt_options = get_option('wijntransport_options');

		$blocked_ids = array();

		if (isset($wt_options['block_list']) && !empty($wt_options['block_list'])) {
			$blocked_ids = array_keys($wt_options['block_list']);
		}

		return $blocked_ids;
	}

    /**
     * Retrieve the list of blocked products details
     *
     * @since    1.0.0
     */
	public function get_block_list() {
		$wt_options = get_option('wijntransport_options');

		$block_list = array();

		if (isset($wt_options['block_list']) && !empty($wt_options['block_list'])) {
			$block_list = $wt_options['block_list'];
		}

		return $block_list;
	}

    /**
     * Get the language the data from the api will be retrieved
     *
     * @since    1.0.0
     */
	public function get_language_iso() {
		$language_code = 'en';

		$wp_local = array(
			'de' => 'de',
			'de_DE' => 'de',
			'de_CH' => 'de',
			'nl' => 'nl',
			'nl_NL' => 'nl',
			'nl_BE' => 'nl',
		);

		$wordpress_locale = get_locale();

		if (isset($wp_local[$wordpress_locale])) {
			$language_code = $wp_local[$wordpress_locale];
		}

		return $language_code;
	}

    /**
     * Check validity of an api key
     *
     * @since    1.0.0
     */
    public function is_api_key_valid($api_key) {
        $response = wp_remote_get(trailingslashit(WIJNTRANSPORT_API_URL), array('headers' => array('authorization' => $api_key)));
        $request_response =  json_decode(wp_remote_retrieve_body($response), true);

        if (isset($request_response['error']) && !empty($request_response['error'])) {
            if ($request_response['error'] === 'unauthorized') {
                return false;
            }
        }

        return true;
    }

	/**
	 * Add filter for canonical url for wines page
     *
     * @since    1.3.0
	 */
    public function set_seo_canonical_url() {
	    add_filter('get_canonical_url', array($this, 'get_seo_canonical_url'), 10, 2);
    }

	/**
     * Get canonical url for wines page
     *
     * @since    1.3.0
	 * @return string
	 */
    public function get_seo_canonical_url() {
	    global $paged;

	    $canonical_url = get_pagenum_link($paged);

	    return $canonical_url;
    }

	/**
	 * Add filter for prev/next links for wines page
     *
     * @since    1.3.0
	 */
    public function set_seo_prev_next_url_link() {
	    add_action('wp_head', array($this, 'get_next_prev_link'));
    }

	/**
	 * Get prev/next link for current wines page
     *
     * @since    1.3.0
	 */
	public function get_next_prev_link() {
		global $paged, $wijn_total_pages;

		if($paged && $paged === $wijn_total_pages): ?>
			<link rel="prev" href="<?php echo get_pagenum_link($paged - 1); ?>" />
	    <?php elseif ($paged): ?>
			<link rel="prev" href="<?php echo get_pagenum_link($paged - 1); ?>" />
			<link rel="next" href="<?php echo get_pagenum_link($paged + 1); ?>" />
		<?php else : ?>
			<link rel="next" href="<?php echo get_pagenum_link(2); ?>" />
		<?php endif;
	}
}
