<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
<div class="product_badge">
<?php if ($product->is_on_sale()) : ?>

	<?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'Sale', 'trego' ).'</span>', $post, $product); ?>

<?php endif; ?>
<?php do_action('trego_product_newness'); ?>
</div>