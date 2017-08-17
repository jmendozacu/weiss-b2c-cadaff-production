<?php
/**
 * Shipping Calculator
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.8
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$woocommerce = WC();
?>
</form>
<div class='tabbable tabs-left calc-shipping'>
	<ul class='nav-panel nav-tabs'>
		<?php if ( get_option('woocommerce_enable_shipping_calc')!='no' && $woocommerce->cart->needs_shipping() ) : ?>
		<li class="active"><a data-toggle="tab" href="#tab_calculate_shipping"><?php echo __( 'Calculate Shipping', 'woocommerce' ); ?></a></li>
		<?php endif; ?>
		<?php if ( $woocommerce->cart->coupons_enabled() ) { ?>
		<li><a data-toggle="tab" href="#tab_coupon"><?php echo __( 'Coupon', 'woocommerce' ); ?></a></li>
		<?php } ?>
	</ul>
	<div class='tab-content'>
		<?php if ( $woocommerce->cart->coupons_enabled() ) { ?>
		<div class="tab-pane" id="tab_coupon">
		<form action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post">
			<div class="coupon">
				<label for="coupon_code"><?php _e( 'Coupon', 'trego' ); ?>:</label> <input name="coupon_code" class="input-text" id="coupon_code" value="" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'trego' ); ?>" />
				<?php do_action('woocommerce_cart_coupon'); ?>
			</div>
		</form>
		</div>
		<?php } ?>

		<?php if ( get_option('woocommerce_enable_shipping_calc')!='no' && $woocommerce->cart->needs_shipping() ) : ?>
		<div class="tab-pane active" id="tab_calculate_shipping">
		<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>
			<form class="shipping_calculator" action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post">

				<section class="shipping-calculator-form">

					<p class="form-row form-row-wide">
						<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" rel="calc_shipping_state">
							<option value=""><?php _e( 'Select a country&hellip;', 'woocommerce' ); ?></option>
							<?php
								foreach( $woocommerce->countries->get_allowed_countries() as $key => $value )
									echo '<option value="' . esc_attr( $key ) . '"' . selected( $woocommerce->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
							?>
						</select>
					</p>

					<p class="form-row form-row-wide">
						<?php
							$current_cc = $woocommerce->customer->get_shipping_country();
							$current_r  = $woocommerce->customer->get_shipping_state();
							$states     = $woocommerce->countries->get_states( $current_cc );

							// Hidden Input
							if ( is_array( $states ) && empty( $states ) ) {

								?><input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php _e( 'State / county', 'woocommerce' ); ?>" /><?php

							// Dropdown Input
							} elseif ( is_array( $states ) ) {

								?><span>
									<select name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php _e( 'State / county', 'woocommerce' ); ?>">
										<option value=""><?php _e( 'Select a state&hellip;', 'woocommerce' ); ?></option>
										<?php
											foreach ( $states as $ckey => $cvalue )
												echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) .'</option>';
										?>
									</select>
								</span><?php

							// Standard Input
							} else {

								?><input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php _e( 'State / county', 'woocommerce' ); ?>" name="calc_shipping_state" id="calc_shipping_state" /><?php

							}
						?>
					</p>

					<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>

						<p class="form-row form-row-wide">
							<input type="text" class="input-text" value="<?php echo esc_attr( $woocommerce->customer->get_shipping_city() ); ?>" placeholder="<?php _e( 'City', 'woocommerce' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
						</p>

					<?php endif; ?>

					<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

						<p class="form-row form-row-wide">
							<input type="text" class="input-text" value="<?php echo esc_attr( $woocommerce->customer->get_shipping_postcode() ); ?>" placeholder="<?php _e( 'Postcode / Zip', 'woocommerce' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
						</p>

					<?php endif; ?>

					<p class="update-bar"><button type="submit" name="calc_shipping" value="1" class="button"><?php _e( 'Update Totals', 'woocommerce' ); ?></button></p>

					<?php wp_nonce_field( 'woocommerce-cart' ); ?>
				</section>
			</form>
		<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$(window).load(function(){
		var resizeTimer;

		tabs_toggle();

		$(window).resize(function() {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(
				function(){
					tabs_toggle();
				}, 250);
		});

		function tabs_toggle(){
			var w = $(document).width();
			if(w < 769) {
				$('.calc-shipping.tabbable').removeClass('tabs-left');
			} else {
				$('.calc-shipping.tabbable').addClass('tabs-left');
			}
		}
	});
});
</script>