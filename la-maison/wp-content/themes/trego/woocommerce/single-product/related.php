<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$posts_per_page = 8;

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters('woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> $posts_per_page,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related,
	'post__not_in'			=> array($product->id)
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= $columns;

if ( $products->have_posts() ) : ?>

	<div id="related_products" class="related products">

		<div class="bxslider-container">
			<div class="bxslider-title">
				<?php _e( 'Related Products', 'woocommerce' ); ?>
				<div class="top-ctrls">
					<a href="javascript:void(0)" id="btn_prev_related" class="btn-prev-top"></a>
					<a href="javascript:void(0)" id="btn_next_related" class="btn-next-top"></a>
				</div>
			</div>
			<ul class="bxslider">
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'product-list' ); ?>

			<?php endwhile; // end of the loop. ?>
			</ul>
			<div class="slider-loading"></div>
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(window).load(function(){
				var container = $('#related_products .bxslider-container');

				var opts = {
					controls: false,
					maxSlides: 4,
					minSlides: 4,
					slideWidth: getSlideWidth(container, 4),
					slideMargin: 10,
					pager: false,
					onSliderLoad: function(){
						setTimeout(function(){
							$('#related_products .bxslider-container').css('max-height', 'none');
							$('#related_products .bxslider-container').css('overflow', 'none');
						}, 200);
						$('#related_products .bxslider-container .slider-loading').fadeOut();
					},
					responsive: [{min: 700, max: 767, cnt: 3},
								{min: 520, max: 699, cnt: 2},
								{min: 0, max: 520, cnt: 1}]
				}

				var related_products = $('#related_products .bxslider').bxSlider(opts);

				$('#btn_prev_related').click(function(){
					related_products.goToPrevSlide();
					return false;
				});

				$('#btn_next_related').click(function(){
					related_products.goToNextSlide();
					return false;
				});

				var resizeTimer;

				$(window).resize(function() {
					if(!($.browser.msie  && parseInt($.browser.version, 10) === 8)){
						clearTimeout(resizeTimer);
						resizeTimer = setTimeout(
							function(){
								resizeFunction(related_products, container, 4, opts)
							}, 250);
					}
				});
			});
		});
		</script>
	</div>

<?php endif;

wp_reset_postdata();
