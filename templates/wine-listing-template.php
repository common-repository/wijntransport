<?php
/*
Template Name: [Wijntransport] Wine listing
*/

/**
 * Provide a public area view for the plugin
 *
 *
 * @link       https://wijntransport.com/
 * @since      1.0.0
 *
 * @package    Wijntransport
 * @subpackage Wijntransport/admin/partials
 */
global $wijn_total_pages;

$wines = new Wijntransport_API();
$listing = $wines->get_listing_products();
$selected_filters = $wines->get_selected_filters();
$wijn_total_pages = intval($listing['numberOfPages']);
$wines->set_seo_canonical_url();
$wines->set_seo_prev_next_url_link();

$active_filters_count = count($selected_filters['country']) + count($selected_filters['volume']) + count($selected_filters['color']) + count($selected_filters['producer']);
$permalink_option = get_option('permalink_structure');
?>

<?php get_header(); ?>

<section class="cc-section">
    <div class="cc-container">
        <div class="cc-title">
            <?php the_title(); ?>
        </div>

        <div class="cc-content">
            <div class="cc-phone-filter">
                <div class="cc-phone-filter__button">
                    <button type="button" class="js-open cc__open">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12" width="1em" height="1em" version="1.1" class="cc-icon">
                                <path d="M11.437 0H.563a.563.563 0 00-.4.96L4.5 5.3v4.825a.563.563 0 00.24.461L6.615 11.9a.563.563 0 00.885-.463V5.3L11.835.96a.563.563 0 00-.398-.96z"/>
                            </svg>

                            <?php _e('Filters', 'wijntransport'); ?>
                        </span>
                    </button>
                </div>

                <div class="cc-phone-filter__text">
			        <?php if ($active_filters_count > 0) : ?>
				        <?php echo sprintf( _n('%s active filter', '%s active filters', $active_filters_count, 'wijntransport' ), $active_filters_count ); ?>

			        <?php else: ?>
                        <span class="cc--gray"><?php _e('No Active Filters', 'wijntransport'); ?></span>
			        <?php endif; ?>
                </div>
            </div>

            <?php if (isset($listing['filters'])) : ?>
                <div class="js-sidebar cc-sidebar cc--closed">
                    <div class="cc-sidebar__container">
                        <div class="cc-sidebar__title">
                            <?php _e('Filters', 'wijntransport') ?>

                            <button type="button" class="js-close cc__close">
                                <svg width="1em" height="1em" viewBox="0 0 300 300" version="1.1" class="cc-icon">
                                    <path d="M206.9 150l85.3-85.3c10.5-10.5 10.5-27.4 0-37.9l-19-19a26.738 26.738 0 00-37.9 0L150 93.1 64.7 7.8C54.2-2.6 37.3-2.6 26.8 7.8l-19 19a26.738 26.738 0 000 37.9L93.1 150 7.8 235.3a26.738 26.738 0 000 37.9l19 19c10.5 10.5 27.4 10.5 37.9 0l85.3-85.3 85.3 85.3c10.5 10.5 27.4 10.5 37.9 0l19-19c10.5-10.5 10.5-27.4 0-37.9L206.9 150z" />
                                </svg>
                            </button>
                        </div>

                        <div class="js-filter-list-container cc-sidebar__filter-list">
                            <div class=" cc-sidebar__filter-list-container">

                                <?php if (isset($listing['filters']['country']) && !empty($listing['filters']['country'])) : ?>
                                    <div class="cc-sidebar__section">
                                        <div class="js-filter-header cc__header cc--open">
                                            <?php _e('Country', 'wijntransport') ?>

                                            <span class="cc__icon">
                                                <svg width="1em" height="1em" viewBox="0 0 300 300" version="1.1" class="cc-icon">
                                                    <path d="M138.4 240.2L5 100.5c-6.4-6.7-6.4-17.7 0-24.4l15.6-16.3c6.4-6.7 16.8-6.7 23.3 0L150 170.5 256.2 59.7c6.4-6.7 16.8-6.7 23.3 0L295 76.1c6.4 6.7 6.4 17.7 0 24.4L161.6 240.2c-6.4 6.8-16.8 6.8-23.2 0z" />
                                                </svg>
                                            </span>
                                        </div>

                                        <div class="cc__filter">
                                            <ul class="js-filter-list cc__filter-list">
                                                <?php foreach ($listing['filters']['country'] as $country) : ?>
                                                    <?php $id = sanitize_title($country['value']); ?>
                                                    <?php if (!isset($country['value']) || empty($country['value'])) continue; ?>
                                                    <?php $is_selected = in_array($country['value'], $selected_filters['country']); ?>

                                                    <li class="cc__filter-item">
                                                        <div class="cc-checkbox">
                                                            <input class="js-filter" data-type="country" name="country[]" id="<?php echo $id; ?>" type="checkbox" value="<?php echo esc_attr($country['value']); ?>" <?php echo $is_selected ? 'checked="checked"' : '' ?> autocomplete="off" />

                                                            <label for="<?php echo $id; ?>">
                                                                <?php echo wp_kses_data($country['value'])?>
                                                                <span class="cc__filter-count">(<?php echo intval($country['count']); ?>)</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($listing['filters']['color']) && !empty($listing['filters']['color'])) : ?>
                                    <div class="cc-sidebar__section">
                                        <div class="js-filter-header cc__header cc--open">
                                            <?php _e('Color', 'wijntransport') ?>

                                            <span class="cc__icon">
                                                <svg width="1em" height="1em" viewBox="0 0 300 300" version="1.1" class="cc-icon">
                                                    <path d="M138.4 240.2L5 100.5c-6.4-6.7-6.4-17.7 0-24.4l15.6-16.3c6.4-6.7 16.8-6.7 23.3 0L150 170.5 256.2 59.7c6.4-6.7 16.8-6.7 23.3 0L295 76.1c6.4 6.7 6.4 17.7 0 24.4L161.6 240.2c-6.4 6.8-16.8 6.8-23.2 0z" />
                                                </svg>
                                            </span>
                                        </div>

                                        <div class="cc__filter">
                                            <ul class="js-filter-list cc__filter-list">
                                                <?php foreach ($listing['filters']['color'] as $color) : ?>
                                                    <?php $id = sanitize_title($color['value']); ?>
                                                    <?php if (!isset($color['value']) || empty($color['value'])) continue; ?>
                                                    <?php $is_selected = in_array($color['value'], $selected_filters['color']); ?>

                                                    <li class="cc__filter-item">
                                                        <div class="cc-checkbox">
                                                            <input class="js-filter" data-type="color" name="color[]" id="<?php echo $id; ?>" type="checkbox" value="<?php echo esc_attr($color['value']); ?>" <?php echo $is_selected ? 'checked="checked"' : '' ?> autocomplete="off" />

                                                            <label for="<?php echo $id; ?>">
                                                                <?php echo wp_kses_data($color['value']); ?>
                                                                <span class="cc__filter-count">(<?php echo intval($color['count']); ?>)</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($listing['filters']['volume']) && !empty($listing['filters']['volume'])) : ?>
                                    <div class="cc-sidebar__section">
                                        <div class="js-filter-header cc__header cc--open">
                                            <?php _e('Volume', 'wijntransport') ?>

                                            <span class="cc__icon">
                                                <svg width="1em" height="1em" viewBox="0 0 300 300" version="1.1" class="cc-icon">
                                                    <path d="M138.4 240.2L5 100.5c-6.4-6.7-6.4-17.7 0-24.4l15.6-16.3c6.4-6.7 16.8-6.7 23.3 0L150 170.5 256.2 59.7c6.4-6.7 16.8-6.7 23.3 0L295 76.1c6.4 6.7 6.4 17.7 0 24.4L161.6 240.2c-6.4 6.8-16.8 6.8-23.2 0z" />
                                                </svg>
                                            </span>
                                        </div>

                                        <div class="cc__filter">
                                            <ul class="js-filter-list cc__filter-list">
                                                <?php $listVolumeCounter = 0 ;?>
                                                <?php foreach ($listing['filters']['volume'] as $volume) : ?>
                                                    <?php $id = sanitize_title($volume['value']); ?>
                                                    <?php if (!isset($volume['value']) || empty($volume['value'])) continue; ?>
                                                    <?php $is_selected = in_array($volume['value'], $selected_filters['volume']); ?>

                                                    <li class="cc__filter-item <?php echo ($listVolumeCounter > 5) ? 'cc--hide' : ''; ?>">
                                                        <div class="cc-checkbox">
                                                            <input class="js-filter" data-type="volume" name="volume[]" id="<?php echo $id; ?>" type="checkbox" value="<?php echo esc_attr($volume['value']); ?>" <?php echo $is_selected ? 'checked="checked"' : '' ?> autocomplete="off" />

                                                            <label for="<?php echo $id; ?>">
                                                                <?php echo wp_kses_data($volume['value']); ?>L
                                                                <span class="cc__filter-count">(<?php echo intval($volume['count']); ?>)</span>
                                                            </label>
                                                        </div>
                                                    </li>

                                                    <?php $listVolumeCounter++; ?>
                                                <?php endforeach; ?>
                                            </ul>

                                            <?php if ($listVolumeCounter > 6): ?>
                                                <div class="cc__filter-more">
                                                    <a href="javascript:;" class="js-show-more cc-link"><?php _e('Show more', 'wijntransport') ?></a>
                                                    <a href="javascript:;" class="js-show-less cc--hide"><?php _e('Show less', 'wijntransport') ?></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($listing['filters']['producer']) && !empty($listing['filters']['producer'])) : ?>
                                    <div class="cc-sidebar__section">
                                        <div class="js-filter-header cc__header cc--open">
                                            <?php _e('Producer', 'wijntransport') ?>

                                            <span class="cc__icon">
                                                <svg width="1em" height="1em" viewBox="0 0 300 300" version="1.1" class="cc-icon">
                                                    <path d="M138.4 240.2L5 100.5c-6.4-6.7-6.4-17.7 0-24.4l15.6-16.3c6.4-6.7 16.8-6.7 23.3 0L150 170.5 256.2 59.7c6.4-6.7 16.8-6.7 23.3 0L295 76.1c6.4 6.7 6.4 17.7 0 24.4L161.6 240.2c-6.4 6.8-16.8 6.8-23.2 0z" />
                                                </svg>
                                            </span>
                                        </div>

                                        <div class="cc__filter">
                                            <div class="cc__filter-search">
                                                <div class="cc__filter-search-container">
                                                    <input class="js-filter__input-producer cc__filter-search-input" type="search" placeholder="<?php _e('Search producer...', 'wijntransport')?>" autocomplete="off" autocorrect="off" autocapitalize="off" maxlength="512" />

                                                    <div class="cc__filter-search-icon">
                                                        <svg width="1em" height="1em" viewBox="0 0 50 50" version="1.1" class="cc-icon">
                                                            <path d="M6.4 22c-.1-8.5 6.8-15.5 15.3-15.6h.3c8.5-.1 15.5 6.8 15.6 15.3v.3c.1 8.5-6.7 15.5-15.2 15.6H22c-8.5.1-15.5-6.7-15.6-15.2V22zm38.4 27.2c1.4 1 3.3.8 4.4-.6.8-1.1.8-2.6 0-3.7l-9.7-9.7c2.8-3.8 4.3-8.4 4.3-13.1.1-12-9.6-21.7-21.5-21.8H22C10 .1.3 9.8.2 21.8v.2C.1 34 9.8 43.7 21.7 43.8h.3c4.7 0 9.3-1.5 13.1-4.4l9.7 9.8z" />
                                                        </svg>
                                                    </div>

                                                    <div class="cc__filter-search-reset cc--hide">
                                                        <button type="button" class="cc__reset">
                                                            <svg width="1em" height="1em" viewBox="0 0 300 300" version="1.1" class="cc-icon">
                                                                <path d="M206.9 150l85.3-85.3c10.5-10.5 10.5-27.4 0-37.9l-19-19a26.738 26.738 0 00-37.9 0L150 93.1 64.7 7.8C54.2-2.6 37.3-2.6 26.8 7.8l-19 19a26.738 26.738 0 000 37.9L93.1 150 7.8 235.3a26.738 26.738 0 000 37.9l19 19c10.5 10.5 27.4 10.5 37.9 0l85.3-85.3 85.3 85.3c10.5 10.5 27.4 10.5 37.9 0l19-19c10.5-10.5 10.5-27.4 0-37.9L206.9 150z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <ul class="js-filter-list js-filter__list-producer cc__filter-list">
                                                <?php $listProducerCounter = 0 ;?>

                                                <?php foreach ($listing['filters']['producer'] as $producer) : ?>
                                                    <?php $id = sanitize_title($producer['value']); ?>
                                                    <?php if (!isset($producer['value']) || empty($producer['value'])) continue; ?>
                                                    <?php $is_selected = in_array($producer['value'], $selected_filters['producer']); ?>

                                                    <li class="cc__filter-item <?php echo ($listProducerCounter > 5) ? 'cc--hide' : ''; ?>">
                                                        <div class="cc-checkbox">
                                                            <input class="js-filter" data-type="producer" name="producer[]" id="<?php echo $id; ?>" type="checkbox" value="<?php echo esc_attr($producer['value']); ?>" <?php echo $is_selected ? 'checked="checked"' : '' ?> autocomplete="off" />

                                                            <label for="<?php echo $id; ?>">
                                                                <span class="cc__filter-text"><?php echo wp_kses_data($producer['value']); ?></span>
                                                                <span class="cc__filter-count">(<?php echo intval($producer['count']); ?>)</span>
                                                            </label>
                                                        </div>
                                                    </li>

                                                    <?php $listProducerCounter++; ?>
                                                <?php endforeach; ?>
                                            </ul>

                                            <?php if ($listProducerCounter > 6): ?>
                                                <div class="js-filter__more-producer cc__filter-more">
                                                    <a href="javascript:;" class="js-show-more cc-link"><?php _e('Show more', 'wijntransport') ?></a>
                                                    <a href="javascript:;" class="js-show-less cc--hide"><?php _e('Show less', 'wijntransport') ?></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="cc-sidebar__apply">
                            <button type="submit" class="js-filter-submit cc__apply-button cc--hidden"><?php _e('Apply Filters', 'wijntransport'); ?></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="cc-right">
                <div class="cc-search-box">
                    <div class="cc-search-box__container">
                        <form class="js-filter-search-form" method="get" action="<?php echo get_the_permalink(); ?>">
                            <input class="js-filter-search cc__input" type="search" name="search" placeholder="<?php _e('Search wines...', 'wijntransport')?>" autocomplete="off" autocorrect="off" autocapitalize="off" maxlength="512" value="<?php echo esc_attr($selected_filters['search']) ;?>" />

                            <div class="cc-search-box__icon">
                                <svg width="1em" height="1em" viewBox="0 0 50 50" version="1.1" class="cc-icon">
                                    <path d="M6.4 22c-.1-8.5 6.8-15.5 15.3-15.6h.3c8.5-.1 15.5 6.8 15.6 15.3v.3c.1 8.5-6.7 15.5-15.2 15.6H22c-8.5.1-15.5-6.7-15.6-15.2V22zm38.4 27.2c1.4 1 3.3.8 4.4-.6.8-1.1.8-2.6 0-3.7l-9.7-9.7c2.8-3.8 4.3-8.4 4.3-13.1.1-12-9.6-21.7-21.5-21.8H22C10 .1.3 9.8.2 21.8v.2C.1 34 9.8 43.7 21.7 43.8h.3c4.7 0 9.3-1.5 13.1-4.4l9.7 9.8z" />
                                </svg>
                            </div>

                            <div class="cc-search-box__reset cc--hide">
                                <button type="button" class="cc__reset-button">
                                    <svg width="1em" height="1em" viewBox="0 0 300 300" version="1.1" class="cc-icon">
                                        <path d="M206.9 150l85.3-85.3c10.5-10.5 10.5-27.4 0-37.9l-19-19a26.738 26.738 0 00-37.9 0L150 93.1 64.7 7.8C54.2-2.6 37.3-2.6 26.8 7.8l-19 19a26.738 26.738 0 000 37.9L93.1 150 7.8 235.3a26.738 26.738 0 000 37.9l19 19c10.5 10.5 27.4 10.5 37.9 0l85.3-85.3 85.3 85.3c10.5 10.5 27.4 10.5 37.9 0l19-19c10.5-10.5 10.5-27.4 0-37.9L206.9 150z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="js-search-results">
                    <div class="cc-stats">
                        <?php if (isset($listing['totalNumberOfMatches'])) : ?>
                            <?php _e('Results', 'wijntransport') ?>:
                            <span class="cc-stats__total">
                                <?php echo sprintf( _n('%s product', '%s products', intval($listing['totalNumberOfMatches']), 'wijntransport' ), intval($listing['totalNumberOfMatches']) ); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="cc-search-results">
                        <?php if (isset($listing['results']) && !empty($listing['results'])) : ?>
                            <ul class="cc-search-results__list">
                                <?php foreach ($listing['results'] as $product) : ?>
                                    <li class="cc-search-results__item">
                                        <a href="<?php echo ('' != $permalink_option) ?
	                                        get_the_permalink() . 'wine/' . $product['slug'] :
                                            add_query_arg('wine', $product['slug'], get_the_permalink()) ; ?>"
                                                class="cc__link">
                                            <div class="cc__flag">
                                                <img
                                                        src="<?php echo esc_url(WIJNTRANSPORT_PLUGIN_URL . 'public/assets/images/flags/' .  strtolower($product['countryCode']) . '.svg'); ?>"
                                                        alt="<?php echo esc_attr($product['country']); ?>"
                                                        title="<?php echo esc_attr($product['country']); ?>"/>
                                            </div>

                                            <div class="cc__image">
                                                <?php if (isset($product['images']) && !empty($product['images']['thumb'])) : ?>
                                                    <img  src="<?php echo esc_url($product['images']['thumb']); ?>" alt="<?php echo esc_attr($product['websiteName']); ?>" />
                                                <?php else : ?>
                                                    <img  src="<?php echo WIJNTRANSPORT_PLUGIN_URL . 'public/assets/images/product-placeholder.png'; ?>" alt="<?php echo esc_attr($product['websiteName']); ?>" />
                                                <?php endif; ?>
                                            </div>

                                            <div class="cc__title">
                                                <?php echo wp_kses_data($product['websiteName']) ?>
                                            </div>

                                            <div class="cc__meta">
                                                <div class="cc__meta-line">
                                                    <?php _e('Alcohol','wijntransport'); ?>: <?php echo wp_kses_data($product['alcohol']); ?>%  -  <?php _e('Color','wijntransport'); ?>: <?php echo wp_kses_data($product['color']); ?>
                                                </div>
                                                <div class="cc__meta-line">
                                                    <?php _e('Volume','wijntransport'); ?>: <?php echo wp_kses_data($product['volume']); ?>L  -  <?php _e('Case Quantity','wijntransport'); ?>: <?php echo wp_kses_data($product['caseQuantity']); ?>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

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
                                    <?php _e('We couldn\'t find any matching results, please try again', 'wijntransport'); ?>

                                    <div class="cc__reset">
                                        <a href="?clear=1" class="cc__reset-button">
			                                <?php _e('Reset Filters', 'wijntransport'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>

	                    <?php if ($listing['numberOfPages'] > 1) : ?>
                            <div class="cc-footer">
                                <div class="cc-footer__stats">
                                    <b><?php echo (intval($listing['pageNumber']) - 1) *  intval($listing['pageSize']) + 1 ?> - <?php echo (intval($listing['pageNumber']) - 1) * intval($listing['pageSize']) + count($listing['results']); ?></b>
				                    <?php _e('from', 'wijntransport'); ?> <b><?php echo intval($listing['totalNumberOfMatches']); ?></b> <?php _e('products', 'wijntransport'); ?>

                                </div>

                                <nav class="cc-pagination">
                                    <ul class="js-pagination cc-pagination__list">
					                    <?php $wines->pagination($wijn_total_pages); ?>
                                    </ul>
                                </nav>
                            </div>
	                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer();
