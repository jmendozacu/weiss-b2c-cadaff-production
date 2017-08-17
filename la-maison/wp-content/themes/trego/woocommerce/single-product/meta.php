<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
<div class="product_meta">
	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
		<div>
			<span class="stock-wrapper">
				<?php _e( 'Availability:', 'trego' ); ?>
				<span class="stock-status">
				<?php
					$availability = $product->get_availability();

					if($product->is_in_stock()){
						_e( 'In stock', 'woocommerce' );
					} elseif ($availability['availability']) {
						echo apply_filters( 'woocommerce_stock_html', '<span class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</span>', $availability['availability'] );
					}
				?>
				</span>
			</span>
		</div>
		<div>
			<span itemprop="productID" class="sku-wrapper">
				<?php _e( 'Product Code:', 'trego' ); ?>
				<span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'n/a', 'woocommerce' ); ?></span>
			</span>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>
</div>