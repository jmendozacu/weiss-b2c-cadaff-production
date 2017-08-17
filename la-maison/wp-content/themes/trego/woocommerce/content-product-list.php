<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$attachment_ids = $product->get_gallery_attachment_ids();

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;
?>
<li class="product">
	<a href="<?php the_permalink(); ?>">
		<?php
			$front_img = get_the_post_thumbnail( $post->ID, 'shop_catalog');
			if (!$front_img) {
				$front_img = '<img src="' . get_template_directory_uri().'/images/no-photo.png' . '" alt="" class="attachment-shop_catalog">';
			}
		?>
		<div class="front-img"><?php echo $front_img; ?></div>
		<?php
		if ( $attachment_ids ) {
			$loop = 0;
			foreach ( $attachment_ids as $attachment_id ) {
				$image_link = wp_get_attachment_url( $attachment_id );
				if ( ! $image_link ) continue;
				$loop++;
				printf( '<div class="back-img">%s</div>', wp_get_attachment_image( $attachment_id, 'shop_catalog' ) );
				if ($loop == 1) break;
			}
		} else {
		?>
			<div class="back-img"><?php echo $front_img; ?></div>
		<?php } ?>
	</a>
	<div class="description product-info">
		<?php
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	</div>
	<?php woocommerce_get_template( 'loop/sale-flash.php' ); ?>
</li>