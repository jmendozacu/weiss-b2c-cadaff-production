<?php
/*
Template Name: 2-Right Sidebar
*/

get_header(); ?>

              
<div id="content" class="site-content" role="main">
	<div class="breadcrumb-container"><?php the_breadcrumbs(); ?></div>
	<div class="row-container">
		<?php $banner = get_post_meta($post->ID, 'banner'); ?>
		<?php if ( $banner ) : ?>
		<div class="banner-container span-12 column">
			<?php echo do_shortcode($banner[0]); ?>
		</div>
		<?php endif; ?>
		<div class="main-container span-8 span-m-12 span-s-12 column left">
		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
					<div class="entry-thumbnail">
						<?php the_post_thumbnail(); ?>
					</div>
					<?php endif; ?>
					<?php if ( is_single() ) : ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php endif; ?>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'trego' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
				</div><!-- .entry-content -->

				<footer class="entry-meta">
					<?php edit_post_link( __( '[ Edit ]', 'trego' ), '<div class="edit-link">', '</div>' ); ?>
				</footer><!-- .entry-meta -->
			</article><!-- #post -->
		<?php endwhile; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>