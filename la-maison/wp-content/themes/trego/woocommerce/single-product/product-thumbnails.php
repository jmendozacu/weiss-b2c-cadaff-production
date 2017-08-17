<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce, $trego_vars;

$attachment_ids = $product->get_gallery_attachment_ids();
$variation_products = "";
if($product->product_type == 'variable'){
	$variation_products = $product->get_available_variations();
}

if ( $attachment_ids || ($variation_products != "")) {
	?>
	<div id="thumbnails_slider" class="thumbnails">
		<div class="bxslider-container small-ctrls">
			<ul class="bxslider">
			<?php
				if ( has_post_thumbnail() ) {
					if(empty($trego_vars['disable_cloud_zoom']) || ($trego_vars['disable_cloud_zoom'] == 0)){
						$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
						$image_link = wp_get_attachment_url( get_post_thumbnail_id() );
						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), apply_filters( 'single_product_small_thumbnail_size', 'shop_single' ) );
						$image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_thumbnail' ), array('title' => $image_title));
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<li><a href="%s" class="%s" title="%s"  rel="useZoom:\'product_zoom_%s\', smallImage: \'%s\'"><div class="front-img">%s</div></a></li>', $image_link, 'cloud-zoom-gallery', $image_title, $post->ID, $image_url[0], $image ), $post->ID );
					}
				}
				foreach ( $attachment_ids as $attachment_id ) {
					$classes = array( 'cloud-zoom-gallery' );

					$image_link = wp_get_attachment_url( $attachment_id );

					if ( ! $image_link )
						continue;

					$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
					$image_url = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_single' ) );
					$image_class = esc_attr( implode( ' ', $classes ) );
					$image_title = esc_attr( get_the_title( $attachment_id ) );
					if(isset($trego_vars['disable_cloud_zoom']) && ($trego_vars['disable_cloud_zoom'] == 1)){
						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a href="%s" rel="prettyPhoto[galleries]"><div class="front-img">%s</div></a></li>', $image_link, $image ), $attachment_id, $post->ID, $image_class );
					} else {
						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a href="%s" class="%s" title="%s"  rel="useZoom:\'product_zoom_%s\', smallImage: \'%s\'"><div class="front-img">%s</div></a></li>', $image_link, $image_class, $image_title, $post->ID, $image_url[0], $image ), $attachment_id, $post->ID, $image_class );
					}
				}

				if((empty($trego_vars['disable_cloud_zoom']) || ($trego_vars['disable_cloud_zoom'] == 0)) && ($product->product_type == 'variable')){
					$variation_products = $product->get_available_variations();
					foreach ( $variation_products as $variation ) {
						if(empty($variation['image_src'])) continue;
						echo '<li><a class="cloud-zoom-gallery" id="variation_id_' . $variation['variation_id'] . '" rel="useZoom:\'product_zoom_' . $post->ID . '\', smallImage: \'' . $variation['image_src'] . '\'" title="' . $variation['image_title'] . '" href="' . $variation['image_link'] . '">';
						echo '<div class="front-img"><img class="attachment-shop_thumbnail" width="108" height="135" alt="' . $variation['image_title'] . '" src="' . $variation['image_src'] . '"></div>';
						echo '</a></li>';
					}
				}
			?>
			</ul>
			<div class="slider-loading"></div>
		</div>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(window).load(function(){
			var resizeTimer;
			var container = $('#thumbnails_slider .bxslider-container');

			var opts = {
				maxSlides: 3,
				minSlides: 3,
				slideWidth: getSlideWidth(container, 3),
				slideMargin: 10,
				infiniteLoop: false,
				pager: false,
				onSliderLoad: function(){
					setTimeout(function(){
						$('#thumbnails_slider .bxslider-container').css('max-height', 'none');
						$('#thumbnails_slider .bxslider-container').css('overflow', 'none');
					}, 200);
					$('#thumbnails_slider .bxslider-container .slider-loading').fadeOut();
				}
			}

			var thumbnails_products = $('#thumbnails_slider .bxslider').bxSlider(opts);

			$(window).resize(function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(
					function(){
						$(".thumbnails .cloud-zoom-gallery").first().trigger('click');
						resizeFunction(thumbnails_products, container, 3, opts);
					}, 250);
			});
			<?php if((empty($trego_vars['disable_cloud_zoom']) || ($trego_vars['disable_cloud_zoom'] == 0)) && ($product->product_type == 'variable')): ?>
			$('form.variations_form').on( 'found_variation', function( event, variation ) {
				var vid = '#variation_id_' + variation.variation_id;
				var img_src = variation.image_src;

				if((img_src.length > 0) && ($(vid).length > 0)){
					$(vid).trigger('click');
				} else {
					$(".thumbnails .cloud-zoom-gallery").first().trigger('click');
				}
			});
			<?php endif; ?>
		});
	});
	</script>
	<?php
}