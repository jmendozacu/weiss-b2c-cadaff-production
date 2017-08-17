<?php
/**
 * @package Trego
 * @since Trego 1.0
 */
?>

<div>
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	<p class="woocommerce-info"><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'trego' ), admin_url( 'post-new.php' ) ); ?></p>

	<?php elseif ( is_search() ) : ?>

	<p class="woocommerce-info"><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'trego' ); ?></p>

	<?php else : ?>

	<p class="woocommerce-info"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'trego' ); ?></p>

	<?php endif; ?>
</div>
