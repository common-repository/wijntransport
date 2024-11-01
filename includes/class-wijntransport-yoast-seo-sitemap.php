<?php

/**
 * Wijntransport Yoast SEO Sitemap class
 *
 *
 * @link       https://wijntransport.com/
 * @since      1.4.0
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/includes
 */

/**
 * Wijntransport Yoast SEO Sitemap class
 *
 * This is used to generate the sitemap for api items
 *
 *
 * @since      1.4.0
 * @package    Wijntransport
 * @subpackage Wijntransport/includes
 * @author     Manolache Silviu @cultofcoders <silviu.manolache@cultofcoders.com>
 */
class Wijntransport_Yoast_SEO_Sitemap {
	/**
	 * Add wine-sitemap.xml to Yoast sitemap index
     *
     * @since    1.4.0
	 */
	function sitemap_add_index($sitemap_index) {
		$sitemap_url = home_url("wine-sitemap.xml");
		$sitemap_date = date(DATE_W3C);  # Current date and time in sitemap format.
		$custom_sitemap = <<<SITEMAP_INDEX_ENTRY
<sitemap>
    <loc>%s</loc>
    <lastmod>%s</lastmod>
</sitemap>
SITEMAP_INDEX_ENTRY;

		$sitemap_index .= sprintf($custom_sitemap, $sitemap_url, $sitemap_date);
		return $sitemap_index;
	}

	/**
	 * Register wines sitemap with Yoast
     *
     * @since    1.4.0
	 */
	public function sitemap_register() {
		global $wpseo_sitemaps;
		if (isset($wpseo_sitemaps) && !empty($wpseo_sitemaps)) {
			$wpseo_sitemaps->register_sitemap("wine", array($this, 'sitemap_generate'));
		}
	}

	/**
	 * Generate wines sitemap XML body
     *
     * @since    1.4.0
	 */
	public function sitemap_generate() {
		global $wpseo_sitemaps;
		$urls  = array();

		$wines_page_template = $this->get_wine_page_templates();

		if ($wines_page_template) {
			$permalink_option = get_option('permalink_structure');

			$wines = new Wijntransport_API();
			$data  = $wines->get_listing_products(true, 999999);

			if (isset($data['results']) && !empty($data['results'])) {
			    foreach ($wines_page_template as $page_template) {
			        $template_permalink = get_the_permalink($page_template->ID);

				    foreach ($data['results'] as $product) {
					    $urls[] = $wpseo_sitemaps->renderer->sitemap_url(array(
						    "mod"    => date(DATE_W3C, strtotime($product['updatedAt'])),  # <lastmod></lastmod>
						    "loc"    => ('' != $permalink_option) ? $template_permalink . 'wine/' . $product['slug'] : add_query_arg('wine', $product['slug'], $template_permalink),
						    "images" => array(
							    array(  # <image:image></image:image>
								    "src"   => isset($product['images']) && !empty($product['images']['small']) ? $product['images']['small'] : WIJNTRANSPORT_PLUGIN_URL . 'public/assets/images/product-placeholder.png',  # <image:loc></image:loc>
								    "title" => $product['websiteName'],  # <image:title></image:title>
								    "alt"   => $product['websiteName'],  # <image:caption></image:caption>
							    ),
						    ),
					    ));
				    }
			    }
			}
		}

		$sitemap_body = <<<SITEMAP_BODY
<urlset
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd"
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
%s
</urlset>
SITEMAP_BODY;

		$sitemap = sprintf($sitemap_body, implode("\n", $urls));
		$wpseo_sitemaps->set_sitemap($sitemap);
	}

	/**
     * Get all pages with the wine listing template
     *
     * @since    1.4.0
	 * @return array|false
	 */
	public function get_wine_page_templates() {
		$args = array(
			'meta_key' => '_wp_page_template',
			'meta_value' => 'wijntransport-wine-listing.php'
		);

		return get_pages($args);
	}
}
