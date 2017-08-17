<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>

<?php if ( get_option('woocommerce_enable_review_rating') == 'yes' ) : ?>

	<?php $count = $product->get_rating_count(); ?>
	<div class="average-star-rating">
	<?php  if ( $count > 0 ) : ?>
		<?php $rating = $rating = $product->get_average_rating(); ?>
		<div class="star-rating" title="<?php echo __( 'Rated ', 'trego' ) . $rating . __(' out of 5', 'trego'); ?>">
			<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue">
				<?php
					if(!empty($GLOBALS['comment']->comment_ID)){
						echo intval( get_comment_meta( $GLOBALS['comment']->comment_ID, 'rating', true ) );
					}
				?>
			</strong> <?php _e( 'out of 5', 'woocommerce' ); ?>
			</span>
		</div>
		<div class="review-count">
			<a href="#comments" class="to-comments"><?php echo $count . ' '; ?><?php _e( 'Review(s)', 'trego' ) ?></a> | 
			<a href="#review_form" class="to-comments inline show_review_form button"><?php _e( 'Add Your Review', 'trego' ) ?></a>
		</div>
	<?php else: ?>
		<a href="#review_form" class="to-comments inline show_review_form button"><?php _e( 'Be the first to review this product', 'trego' ) ?></a>
	<?php endif; ?>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.to-comments').click(function(){
			$('#item_reviews').addClass('in');
		});
	});
	</script>

<?php endif; ?>