<?php
/**
 * Change password form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php wc_print_notices(); ?>
<h2 class="title-section"><?php _e('Change Password', 'trego'); ?></h2>
<form action="<?php echo esc_url( get_permalink( wc_get_page_id( 'change_password' ) ) ); ?>" method="post" class="change-password">
	<p class="form-row">
		<label for="password_1"><?php _e( 'New password', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password_1" id="password_1" placeholder="<?php _e( 'Enter New Password', 'woocommerce' ); ?> *" />
	</p>
	<p class="form-row">
		<label for="password_2"><?php _e( 'Re-enter new password', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password_2" id="password_2" placeholder="<?php _e( 'Re-enter New Password', 'woocommerce' ); ?> *" />
	</p>
	<div class="clear"></div>

	<p><input type="submit" class="button" size="40" name="change_password" value="<?php _e( 'Save Password', 'woocommerce' ); ?>" /></p>

	<?php wp_nonce_field('change_password'); ?>
	<input type="hidden" name="action" value="change_password" />

</form>