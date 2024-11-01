<?php
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

$wines = new Wijntransport_API();
$product_wijn = $wines->get_product();
$wines->set_seo_canonical_url();

get_header();
?>

<section class="cc-section">
    <div class="cc-container cc--small">

        <div class="cc-product">
            <div class="cc-product__image">
	            <?php if (isset($product_wijn['images']) && !empty($product_wijn['images']['small'])) : ?>
                    <img  src="<?php echo esc_url($product_wijn['images']['small']); ?>" alt="<?php echo esc_attr($product_wijn['websiteName']); ?>" />
	            <?php else : ?>
                    <img  src="<?php echo WIJNTRANSPORT_PLUGIN_URL . 'public/assets/images/product-placeholder.png'; ?>" alt="<?php echo esc_attr($product_wijn['websiteName']); ?>" />
	            <?php endif; ?>
            </div>

            <div class="cc-product__details">
                <h1 class="cc-product__title">
	                <?php echo wp_kses_data($product_wijn['websiteName']) ?>
                </h1>

                <div class="cc-product__info">
                    <?php if (isset($product_wijn['generalInfo']) && !empty($product_wijn['generalInfo'])) : ?>
                        <div class="cc-product__info-item">
                            <?php echo wp_kses_post($product_wijn['generalInfo']); ?>
                        </div>
                    <?php endif; ?>

	                <?php if (isset($product_wijn['tastingNotes']) && !empty($product_wijn['tastingNotes'])) : ?>
                        <div class="cc-product__info-item">
	                        <?php echo wp_kses_post( $product_wijn['tastingNotes']); ?>
                        </div>
	                <?php endif; ?>

	                <?php if (isset($product_wijn['foodPairing']) && !empty($product_wijn['foodPairing'])) : ?>
                        <div class="cc-product__info-item">
	                        <?php echo wp_kses_post($product_wijn['foodPairing']); ?>
                        </div>
	                <?php endif; ?>
                </div>

                <div class="cc-product__specifications">
                    <div class="cc-product__specifications-title">
                        <?php _e('Specifications', 'wijntransport'); ?>
                    </div>

                    <ul class="cc-product__specifications-list">
                        <?php if (isset($product_wijn['country']) && !empty($product_wijn['country'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
                                    <?php _e('Country', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
                                    <div class="cc__flag">
                                        <img
                                                src="<?php echo esc_url(WIJNTRANSPORT_PLUGIN_URL . 'public/assets/images/flags/' .  strtolower($product_wijn['countryCode']) . '.svg'); ?>"
                                                alt="<?php echo esc_attr($product_wijn['country']); ?>"
                                                title="<?php echo esc_attr($product_wijn['country']); ?>"/>
                                    </div>
                                    <?php echo wp_kses_data($product_wijn['country']); ?>
                                </div>
                            </li>
                        <?php endif; ?>

	                    <?php if (isset($product_wijn['area']) && !empty($product_wijn['area'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Area', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo wp_kses_data($product_wijn['area']); ?>
                                </div>
                            </li>
	                    <?php endif; ?>

                        <?php if (isset($product_wijn['subarea']) && !empty($product_wijn['subarea'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Subarea', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo wp_kses_data($product_wijn['subarea']); ?>
                                </div>
                            </li>
	                    <?php endif; ?>

	                    <?php if (isset($product_wijn['color']) && !empty($product_wijn['color'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Color', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo wp_kses_data($product_wijn['color']); ?>
                                </div>
                            </li>
	                    <?php endif; ?>


	                    <?php if (isset($product_wijn['alcohol']) && !empty($product_wijn['alcohol'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Alcohol', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo wp_kses_data($product_wijn['alcohol']); ?>
                                </div>
                            </li>
	                    <?php endif; ?>

	                    <?php if (isset($product_wijn['volume']) && !empty($product_wijn['volume'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Volume', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo wp_kses_data($product_wijn['volume']); ?>
                                </div>
                            </li>
	                    <?php endif; ?>


	                    <?php if (isset($product_wijn['vintage']) && $product_wijn['vintage'] > 0 ) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Vintage', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo wp_kses_data($product_wijn['vintage']); ?>
                                </div>
                            </li>
	                    <?php endif; ?>

	                    <?php if (isset($product_wijn['allergensEgg'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Allergens egg', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo boolval($product_wijn['allergensEgg']) ? __('Yes', 'wijntransport') : __('No', 'wijntransport'); ?>
                                </div>
                            </li>
	                    <?php endif; ?>

	                    <?php if (isset($product_wijn['allergensMilk'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Allergens milk', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo boolval($product_wijn['allergensMilk']) ? __('Yes', 'wijntransport') : __('No', 'wijntransport'); ?>
                                </div>
                            </li>
	                    <?php endif; ?>

	                    <?php if (isset($product_wijn['allergensSulphites'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Allergens sulphites', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo boolval($product_wijn['allergensSulphites']) ? __('Yes', 'wijntransport') : __('No', 'wijntransport'); ?>
                                </div>
                            </li>
	                    <?php endif; ?>

	                    <?php if (isset($product_wijn['biological'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Biological', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo boolval($product_wijn['biological']) ? __('Yes', 'wijntransport') : __('No', 'wijntransport'); ?>
                                </div>
                            </li>
	                    <?php endif; ?>

	                    <?php if (isset($product_wijn['veganFriendly'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Vegan Friendly', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo boolval($product_wijn['veganFriendly']) ? __('Yes', 'wijntransport') : __('No', 'wijntransport'); ?>
                                </div>
                            </li>
	                    <?php endif; ?>

                        <?php if (isset($product_wijn['closureType']) && !empty($product_wijn['closureType'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Closure type', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo wp_kses_data($product_wijn['closureType']) ?>
                                </div>
                            </li>
	                    <?php endif; ?>

	                    <?php if (isset($product_wijn['closureType']) && !empty($product_wijn['closureType'])) : ?>
                            <li class="cc__item">
                                <div class="cc__label">
				                    <?php _e('Case Quantity', 'wijntransport'); ?>
                                </div>
                                <div class="cc__value">
				                    <?php echo wp_kses_data($product_wijn['caseQuantity']) ?>
                                </div>
                            </li>
	                    <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer();
