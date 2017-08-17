<?php
/**
 * @package Trego
 * @since Trego 1.0
 */

get_header();

if(empty($trego_vars['blog_layout'])){
	$trego_vars['blog_layout'] = "";
}
?>

<div id="content" class="site-content" role="main">
	<div class="breadcrumb-container"><?php the_breadcrumbs(); ?></div>
	<div class="row-container">
		<?php if ( $trego_vars['blog_layout'] == 'left-sidebar' ) : ?>
			<div class="main-container span-8 span-m-12 span-s-12 column right">
		<?php elseif ( $trego_vars['blog_layout'] == 'right-sidebar' ) : ?>
			<div class="main-container span-8 span-m-12 span-s-12 column left">
		<?php else: ?>
			<div class="main-container span-12 column">
		<?php endif; ?>

		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

			</*?php trego_post_nav(); */?>

			<?php comments_template(); ?>

		<?php endwhile; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div><!-- #content -->

<?php get_footer(); ?>