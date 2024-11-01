<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wijntransport.com/
 * @since      1.0.0
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/admin/partials
 */

$wines = new Wijntransport_API();
$listing = $wines->get_listing_products(false);
$selected_filters = $wines->get_listing_url_params();
$block_list = $wines->get_block_list();
?>

<div class="js-wt-admin wrap cc-admin">
    <h2 class="cc-admin__title">Wijntransport <?php esc_attr_e('Blocked Products', 'wijntransport' ); ?></h2>

    <div class="js-blocked-container cc-admin__blocked">

        <div class="cc-admin__blocked-products">
            <div class="cc-search-box">
                <div class="cc-search-box__container">
                    <form class="js-filter-search-form" method="get">
                        <input class="js-filter-search cc__input" type="search" name="search" placeholder="<?php _e('Search wines...', 'wijntransport')?>" autocomplete="off" autocorrect="off" autocapitalize="off" maxlength="512" value="<?php echo esc_attr($selected_filters['search']) ;?>" />

                        <div class="cc-search-box__icon">
                            <svg width="1em" height="1em" viewBox="0 0 50 50" version="1.1" class="cc-icon">
                                <path d="M6.4 22c-.1-8.5 6.8-15.5 15.3-15.6h.3c8.5-.1 15.5 6.8 15.6 15.3v.3c.1 8.5-6.7 15.5-15.2 15.6H22c-8.5.1-15.5-6.7-15.6-15.2V22zm38.4 27.2c1.4 1 3.3.8 4.4-.6.8-1.1.8-2.6 0-3.7l-9.7-9.7c2.8-3.8 4.3-8.4 4.3-13.1.1-12-9.6-21.7-21.5-21.8H22C10 .1.3 9.8.2 21.8v.2C.1 34 9.8 43.7 21.7 43.8h.3c4.7 0 9.3-1.5 13.1-4.4l9.7 9.8z" />
                            </svg>
                        </div>
                    </form>
                </div>
            </div>

            <div class="js-search-results cc-search-results">
		        <?php if (isset($listing['results']) && !empty($listing['results'])) : ?>
                    <?php wp_nonce_field('wt-block-product', 'wt-block-product-nonce', false) ;?>
                    <ul class="js-search-results-list cc-search-results__list">
				        <?php foreach ($listing['results'] as $product) : ?>
                            <li class="js-product-<?php echo $product['baseId']; ?> cc-search-results__item <?php echo array_key_exists($product['baseId'], $block_list) ? 'cc--blocked': ''; ?>">
                                <div class="cc__link">
                                    <div class="cc__flag">
                                        <img
                                                src="<?php echo esc_url(WIJNTRANSPORT_PLUGIN_URL . 'public/assets/images/flags/' .  strtolower($product['countryCode']) . '.svg'); ?>"
                                                alt="<?php echo esc_attr($product['country']); ?>"
                                                title="<?php echo esc_attr($product['country']); ?>"
                                        />
                                    </div>

                                    <div class="cc__image">
								        <?php if (isset($product['images']) && !empty($product['images']['thumb'])) : ?>
                                            <img src="<?php echo $product['images']['thumb']; ?>" alt="<?php echo esc_attr($product['websiteName']); ?>" />
								        <?php else : ?>
                                            <img
                                                    src="<?php echo WIJNTRANSPORT_PLUGIN_URL . 'public/assets/images/product-placeholder.png'; ?>"
                                                    alt="<?php echo esc_attr($product['websiteName']) ?>"
                                            />
								        <?php endif; ?>
                                    </div>

                                    <div class="cc__title">
								        <?php echo $product['websiteName'] ?>
                                    </div>

                                    <div class="cc__meta">
                                        <button
                                                class="js-blocked-add cc-product-action-button"
                                                data-id="<?php echo esc_attr($product['baseId']);?>"
                                                data-details='<?php echo wp_json_encode(array(
				                                    'name' => esc_attr($product['websiteName']),
				                                    'image' => $product['images']['thumb'],
				                                    'countryCode' => strtolower($product['countryCode']),
				                                    'country' => $product['country'],
			                                    ));?>'
                                        >
                                           <?php _e('Add to blocked products', 'wijntransport'); ?>
                                       </button>

                                        <button class="js-blocked-remove cc-product-action-button" data-id="<?php echo esc_attr($product['baseId']);?>">
		                                    <?php _e('Remove from blocked products', 'wijntransport'); ?>
                                        </button>
                                    </div>
                                </div>
                            </li>
				        <?php endforeach; ?>
                    </ul>

                    <div class="js-footer cc-footer">
                        <div class="cc-footer__stats">
                            <b>1 - <?php echo (intval($listing['pageNumber']) - 1) * intval($listing['pageSize']) + count($listing['results']); ?></b>
					        <?php _e('from', 'wijntransport'); ?> <b><?php echo intval($listing['totalNumberOfMatches']); ?></b> <?php _e('products', 'wijntransport'); ?>
                        </div>

				        <?php if (intval($listing['pageNumber']) < intval($listing['numberOfPages'])) : ?>
                            <nav class="cc-pagination">
                                <ul class="cc-pagination__list">
                                    <li>
                                        <button class="js-load-more cc__save-button" data-page-nr="<?php echo intval($listing['pageNumber']) + 1; ?>">
									        <?php _e('Load More', 'wijntransport'); ?>
                                        </button>
                                    </li>
                                </ul>
                            </nav>
				        <?php endif; ?>
                    </div>

		        <?php else: ?>
                    <div class="cc-search-results__none">
                        <div class="cc__icon">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="89.6" height="112" viewBox="0 0 44.8 56">
                                <g transform="translate(0 0)">
                                    <path d="M15.487,17.2A17.643,17.643,0,0,1,14,10.1V5.6a.933.933,0,0,0,.933-.933V.934A.933.933,0,0,0,14,0H6.533A.933.933,0,0,0,5.6.934V4.667a.933.933,0,0,0,.933.933V10.1A17.65,17.65,0,0,1,5.046,17.2l-2.62,5.99A28.749,28.749,0,0,0,0,34.79V55.067A.933.933,0,0,0,.933,56H19.6a.933.933,0,0,0,.933-.933V34.79a28.741,28.741,0,0,0-2.427-11.6ZM7.466,1.867h5.6V3.734h-5.6Zm11.2,52.267H1.866V34.79a26.9,26.9,0,0,1,2.27-10.849l2.62-5.99A19.5,19.5,0,0,0,8.4,10.1V5.6h3.733V10.1a19.5,19.5,0,0,0,1.644,7.856l2.62,5.99a26.9,26.9,0,0,1,2.27,10.849Zm0,0" transform="translate(0)" fill="#bdbdbd"/>
                                    <path d="M103.859,192.731l.777,1.773a23.641,23.641,0,0,1,1.024,2.825.934.934,0,0,0,.9.671.947.947,0,0,0,.263-.037.933.933,0,0,0,.633-1.158,25.584,25.584,0,0,0-1.11-3.048l-.777-1.773a.933.933,0,1,0-1.71.746Zm0,0" transform="translate(-91.66 -169.067)" fill="#bdbdbd"/>
                                    <path d="M88.9,158.425a.933.933,0,0,0,.856.56.916.916,0,0,0,.373-.078.933.933,0,0,0,.48-1.228l-.639-1.463a.933.933,0,0,0-1.71.746Zm0,0" transform="translate(-77.904 -137.518)" fill="#bdbdbd"/>
                                    <path d="M32.933,280a.933.933,0,0,0-.933.933V296.8a.933.933,0,0,0,.933.933h11.2a.933.933,0,0,0,.933-.933V280.933a.933.933,0,0,0-.933-.933ZM43.2,295.867H33.867v-14H43.2Zm0,0" transform="translate(-28.267 -247.333)" fill="#bdbdbd"/>
                                    <path d="M225.546,159.76a12.214,12.214,0,0,0-6.346-2.389V144.219A10.276,10.276,0,0,0,228.533,134a.922.922,0,0,0-.009-.133l-.491-3.44v-.006l-1.375-9.62a.934.934,0,0,0-.924-.8H210.8a.933.933,0,0,0-.924.8l-1.867,13.067A.923.923,0,0,0,208,134a10.276,10.276,0,0,0,9.333,10.219v13.152a12.21,12.21,0,0,0-6.347,2.389l-.747.56A.933.933,0,0,0,210.8,162h14.933a.933.933,0,0,0,.56-1.68Zm-13.937-37.894h13.315l1.12,7.84-1.8.2a15.774,15.774,0,0,1-6.083-.507l-.111-.032a17.7,17.7,0,0,0-7.06-.532l-.387.048Zm-1.743,12.2.467-3.267.89-.109a15.783,15.783,0,0,1,6.3.467l.109.032a17.61,17.61,0,0,0,6.818.571l1.853-.207.358,2.512a8.4,8.4,0,0,1-16.8,0ZM214,160.133a10.44,10.44,0,0,1,8.542,0Zm0,0" transform="translate(-183.733 -106)" fill="#bdbdbd"/>
                                </g>
                            </svg>
                        </div>

                        <div class="cc__text">
                            <?php if (isset($listing['error'])): ?>
                                <?php if ($listing['error'] === 'unauthorized'): ?>
                                    <?php _e('The api key is not valid, please contact the administrator of wijntransport.com', 'wijntransport'); ?>
                                <?php else: ?>
                                    <?php echo wp_kses_data($listing['error']); ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php _e('We couldn\'t find any matching results, please try again', 'wijntransport'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
		        <?php endif;?>

            </div>
        </div>

        <div class="cc-admin__blocked-list">
            <div class="cc-admin__blocked-list-title">
                <?php _e('Blocked products', 'wijntransport'); ?>
            </div>

            <div class="js-blocked-list-content">
                <?php if ($block_list) : ?>
                    <ul class="js-blocked-list cc-search-results__list">
                        <?php foreach ($block_list as $id => $product) : ?>
                            <li class="js-product-<?php echo $id; ?> cc-search-results__item cc--blocked-item cc--blocked">
                                <div class="cc__link">
                                    <div class="cc__flag">
                                        <img
                                                src="<?php echo esc_url(WIJNTRANSPORT_PLUGIN_URL . 'public/assets/images/flags/' .  $product['countryCode'] . '.svg'); ?>"
                                                alt="<?php echo esc_attr($product['country']); ?>"
                                                title="<?php echo esc_attr($product['country']); ?>"/>
                                    </div>

                                    <div class="cc__image">
                                        <?php if (isset($product['image']) && !empty($product['image'])) : ?>
                                            <img  src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['name']); ?>" />
                                        <?php else : ?>
                                            <img
                                                    src="<?php echo WIJNTRANSPORT_PLUGIN_URL . 'public/assets/images/product-placeholder.png'; ?>"
                                                    alt="<?php echo esc_attr($product['name']) ?>" />
                                        <?php endif; ?>
                                    </div>

                                    <div class="cc__title">
                                        <?php echo wp_kses_data($product['name']) ?>
                                    </div>

                                    <div class="cc__meta">
                                        <button class="js-blocked-remove cc-product-action-button" data-id="<?php echo $id; ?>">
                                            <?php _e('Remove from blocked products', 'wijntransport'); ?>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <div class="cc-admin__blocked-list-none">
                        <div class="cc__icon">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="89.6" height="112" viewBox="0 0 44.8 56">
                                <g transform="translate(0 0)">
                                    <path d="M15.487,17.2A17.643,17.643,0,0,1,14,10.1V5.6a.933.933,0,0,0,.933-.933V.934A.933.933,0,0,0,14,0H6.533A.933.933,0,0,0,5.6.934V4.667a.933.933,0,0,0,.933.933V10.1A17.65,17.65,0,0,1,5.046,17.2l-2.62,5.99A28.749,28.749,0,0,0,0,34.79V55.067A.933.933,0,0,0,.933,56H19.6a.933.933,0,0,0,.933-.933V34.79a28.741,28.741,0,0,0-2.427-11.6ZM7.466,1.867h5.6V3.734h-5.6Zm11.2,52.267H1.866V34.79a26.9,26.9,0,0,1,2.27-10.849l2.62-5.99A19.5,19.5,0,0,0,8.4,10.1V5.6h3.733V10.1a19.5,19.5,0,0,0,1.644,7.856l2.62,5.99a26.9,26.9,0,0,1,2.27,10.849Zm0,0" transform="translate(0)" fill="#bdbdbd"/>
                                    <path d="M103.859,192.731l.777,1.773a23.641,23.641,0,0,1,1.024,2.825.934.934,0,0,0,.9.671.947.947,0,0,0,.263-.037.933.933,0,0,0,.633-1.158,25.584,25.584,0,0,0-1.11-3.048l-.777-1.773a.933.933,0,1,0-1.71.746Zm0,0" transform="translate(-91.66 -169.067)" fill="#bdbdbd"/>
                                    <path d="M88.9,158.425a.933.933,0,0,0,.856.56.916.916,0,0,0,.373-.078.933.933,0,0,0,.48-1.228l-.639-1.463a.933.933,0,0,0-1.71.746Zm0,0" transform="translate(-77.904 -137.518)" fill="#bdbdbd"/>
                                    <path d="M32.933,280a.933.933,0,0,0-.933.933V296.8a.933.933,0,0,0,.933.933h11.2a.933.933,0,0,0,.933-.933V280.933a.933.933,0,0,0-.933-.933ZM43.2,295.867H33.867v-14H43.2Zm0,0" transform="translate(-28.267 -247.333)" fill="#bdbdbd"/>
                                    <path d="M225.546,159.76a12.214,12.214,0,0,0-6.346-2.389V144.219A10.276,10.276,0,0,0,228.533,134a.922.922,0,0,0-.009-.133l-.491-3.44v-.006l-1.375-9.62a.934.934,0,0,0-.924-.8H210.8a.933.933,0,0,0-.924.8l-1.867,13.067A.923.923,0,0,0,208,134a10.276,10.276,0,0,0,9.333,10.219v13.152a12.21,12.21,0,0,0-6.347,2.389l-.747.56A.933.933,0,0,0,210.8,162h14.933a.933.933,0,0,0,.56-1.68Zm-13.937-37.894h13.315l1.12,7.84-1.8.2a15.774,15.774,0,0,1-6.083-.507l-.111-.032a17.7,17.7,0,0,0-7.06-.532l-.387.048Zm-1.743,12.2.467-3.267.89-.109a15.783,15.783,0,0,1,6.3.467l.109.032a17.61,17.61,0,0,0,6.818.571l1.853-.207.358,2.512a8.4,8.4,0,0,1-16.8,0ZM214,160.133a10.44,10.44,0,0,1,8.542,0Zm0,0" transform="translate(-183.733 -106)" fill="#bdbdbd"/>
                                </g>
                            </svg>
                        </div>

                        <div class="cc__text">
                            <?php _e('No blocked products', 'wijntransport'); ?>
                        </div>
                    </div>

                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
