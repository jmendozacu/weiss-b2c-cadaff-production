<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $woocommerce, $product;

$crosssells = $woocommerce->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = $woocommerce->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', 8 ),
	'no_found_rows'       => 1,
	'orderby'             => 'rand',
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= apply_filters( 'woocommerce_cross_sells_columns', 8 );

if ( $products->have_posts() ) : ?>

	<div class="cross-sells">
		<div class="bxslider-container">
			<div class="bxslider-title">
				<?php _e( 'Cross-Selling Product(s)', 'woocommerce' ) ?>
				<div class="top-ctrls">
					<a href="javascript:void(0)" id="btn_prev_cross" class="btn-prev-top"></a>
					<a href="javascript:void(0)" id="btn_next_cross" class="btn-next-top"></a>
				</div>
			</div>
			<ul class="bxslider">
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'product-list' ); ?>

			<?php endwhile; // end of the loop. ?>
			</ul>
			<div class="slider-loading"></div>
		</div>
	</div>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(window).load(function(){
			var container = $('.cross-sells .bxslider-container');

			var opts = {
				controls: false,
				maxSlides: 4,
				minSlides: 4,
				slideWidth: getSlideWidth(container, 4),
				slideMargin: 10,
				pager: false,
				onSliderLoad: function(){
					setTimeout(function(){
						$('.cross-sells .bxslider-container').css('max-height', 'none');
						$('.cross-sells .bxslider-container').css('overflow', 'none');
					}, 200);
					$('.cross-sells .bxslider-container .slider-loading').fadeOut();
				},
				responsive: [{min: 700, max: 767, cnt: 3},
							{min: 520, max: 699, cnt: 2},
							{min: 0, max: 520, cnt: 1}]
			}

			var cross_sells_products = $('.cross-sells .bxslider').bxSlider(opts);

			$('#btn_prev_cross').click(function(){
				cross_sells_products.goToPrevSlide();
				return false;
			});

			$('#btn_next_cross').click(function(){
				cross_sells_products.goToNextSlide();
				return false;
			});

			var resizeTimer;

			$(window).resize(function() {
				if(!($.browser.msie  && parseInt($.browser.version, 10) === 8)){
					clearTimeout(resizeTimer);
					resizeTimer = setTimeout(
						function(){
							resizeFunction(cross_sells_products, container, 4, opts)
						}, 250);
				}
			});
		});
	});
	</script>

<?php endif;

wp_reset_query();