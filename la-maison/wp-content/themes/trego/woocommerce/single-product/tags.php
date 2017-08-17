<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $trego_vars;

if(isset($trego_vars['disable_product_tags']) && ($trego_vars['disable_product_tags'] == 1)) return;

$size = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
$tags = $product->get_tags( '', '<span class="tagged_as">' . _n( '', '', $size, 'woocommerce' ) . ' ', '</span>' );
?>
<?php if($tags) : ?>
<div class="accordion-group">
	<div class="accordion-heading">
		<a href="#product_tags" class="accordion-toggle collapsed" data-toggle="collapse"><?php _e('Product Tags', 'woocommerce'); ?> <span class="icon-toggle"></span></a>
	</div>
	<div id="product_tags" class="collapse">
		<div itemprop="description" class="accordion-inner">
		<?php echo $tags; ?>
		</div>
	</div>
</div>
<?php endif; ?>