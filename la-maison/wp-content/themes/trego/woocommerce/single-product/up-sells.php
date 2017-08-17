<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce, $woocommerce_loop, $trego_vars;

if(isset($trego_vars['disable_upselling_products']) && ($trego_vars['disable_upselling_products'] == 1)) return;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = $woocommerce->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= $columns;

if ( $products->have_posts() ) : ?>
<div class="accordion-group upsells products">
	<div class="accordion-heading">
		<a href="#item_upsells" class="accordion-toggle collapsed" data-toggle="collapse">
			<?php _e( 'Upselling Product(s)', 'trego' ) ?>
			<span class="icon-toggle"></span>
		</a>
		<div class="top-ctrls">
			<a href="javascript:void(0)" id="item_upsells_prev" class="btn-prev-top"></a>
			<a href="javascript:void(0)" id="item_upsells_next" class="btn-next-top"></a>
		</div>
	</div>
	<div id="item_upsells" class="collapse">
		<div itemprop="description" class="accordion-inner">
		<div class="bxslider-container">
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
				var container = $('#item_upsells .bxslider-container');

				var opts = {
					controls: false,
					maxSlides: 3,
					minSlides: 3,
					slideWidth: getSlideWidth(container, 3),
					slideMargin: 10,
					pager: false,
					onSliderLoad: function(){
						setTimeout(function(){
							$('#item_upsells .bxslider-container').css('max-height', 'none');
							$('#item_upsells .bxslider-container').css('overflow', 'none');
						}, 200);
						$('#item_upsells .bxslider-container .slider-loading').fadeOut();
					},
					responsive: [{min: 321, max: 639, cnt: 2},
								{min: 0, max: 320, cnt: 1}]
				}

				var upselling_products = $('#item_upsells .bxslider').bxSlider(opts);

				$('#item_upsells_prev').click(function(){
					upselling_products.goToPrevSlide();
					return false;
				});

				$('#item_upsells_next').click(function(){
					upselling_products.goToNextSlide();
					return false;
				});

				$('.upsells.products a.accordion-toggle').click(function(){
					$('.upsells .top-ctrls').toggle();
				});

				var resizeTimer;

				$(window).resize(function() {
					if(!($.browser.msie  && parseInt($.browser.version, 10) === 8)){
						clearTimeout(resizeTimer);
						resizeTimer = setTimeout(
							function(){
								resizeFunction(upselling_products, container, 3, opts)
							}, 250);
					}
				});
			});
		});
		</script>
		</div>
	</div>
</div>

<?php endif;

wp_reset_postdata();
