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

?>
<div class="wrap">
    <h2>Wijntransport <?php esc_attr_e('Settings', 'wijntransport' ); ?></h2>

    <form action="options.php" method="post">
		<?php
		settings_fields( 'wijntransport_options' );
		do_settings_sections( 'wijntransport-settings' ); ?>

        <div class="cc-submit">
            <button type="submit" name="submit" class="button button-primary" type="submit" >
                <?php _e( 'Save settings', 'wijntransport' ); ?>
            </button>
        </div>
    </form>
</div>
