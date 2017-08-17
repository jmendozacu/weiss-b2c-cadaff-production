<?php
/**
 * Edit address form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $current_user;

$page_title = ( $load_address === 'billing' ) ? __( 'Billing Address', 'woocommerce' ) : __( 'Shipping Address', 'woocommerce' );

get_currentuserinfo();
?>

<?php wc_print_notices(); ?>

<?php if (!$load_address) : ?>

	<?php woocommerce_get_template('myaccount/my-address.php'); ?>

<?php else : ?>

	<form method="post" class="edit-address">

		<h2 class="title-section"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></h2>

		<?php
		foreach ($address as $key => $field) :
			$value = (isset($_POST[$key])) ? $_POST[$key] : get_user_meta( get_current_user_id(), $key, true );

			if(!isset($field['placeholder'])){
				$field['placeholder'] = $field['label'];
			}

			$field['placeholder'] .= !empty($field['required']) ? ' *' : '';

			// Default values
			if (!$value && ($key=='billing_email' || $key=='shipping_email')) $value = $current_user->user_email;
			if (!$value && ($key=='billing_country' || $key=='shipping_country')) $value = $woocommerce->countries->get_base_country();
			if (!$value && ($key=='billing_state' || $key=='shipping_state')) $value = $woocommerce->countries->get_base_state();

			woocommerce_form_field( $key, $field, $value );
		endforeach;
		?>

		<p>
			<input type="submit" class="button" name="save_address" value="<?php _e( 'Save Address', 'woocommerce' ); ?>" />
			<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
			<input type="hidden" name="action" value="edit_address" />
		</p>

	</form>

<?php endif; ?>