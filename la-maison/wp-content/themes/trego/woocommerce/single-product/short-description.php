<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

if ( ! $post->post_excerpt ) return;
?>
<div class="accordion-group">
	<div class="accordion-heading">
		<a href="#item_excerpt" class="accordion-toggle" data-toggle="collapse">
		<?php _e( 'Description', 'woocommerce' ) ?>
		<span class="icon-toggle"></span></a>
	</div>
	<div id="item_excerpt" class="in collapse">
		<div itemprop="description" class="accordion-inner">
		<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
		</div>
	</div>
</div>