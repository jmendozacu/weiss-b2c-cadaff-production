<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Trego
 * @since Trego 1.0
 */

get_header(); ?>

<div id="content" class="site-content" role="main">
	<div class="row-container">
		<div class="main-container span-12 span-m-12 span-s-12 column page-404">
			<div class="return-to-home">
				<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e('Back to homepage', 'trego'); ?></a>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>