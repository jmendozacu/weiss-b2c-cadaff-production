<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product, $trego_vars;

?>
<div class="images">

	<?php
		if ( has_post_thumbnail() ) {

			$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
			$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array('title' => $image_title));

			$attachment_count   = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			if(isset($trego_vars['disable_cloud_zoom']) && ($trego_vars['disable_cloud_zoom'] == 1)){
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" rel="prettyPhoto[galleries]">%s</a>', $image_link, $image ), $post->ID );
			} else {
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" id="product_zoom_%s" class="woocommerce-main-image cloud-zoom" title="%s"  rel="showTitle:false, smoothMove:5, position:\'inside\'">%s</a>', $image_link, $post->ID, $image_title, $image ), $post->ID );
			}
		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );

		}
	?>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	<div class="product-share">
	<span class="share-label"><?php echo __('Share: ', 'trego'); ?></span>
	<?php echo do_shortcode('[share]'); ?>
	</div>
</div>
