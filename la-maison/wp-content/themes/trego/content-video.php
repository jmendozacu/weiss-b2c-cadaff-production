<?php
/**
 * @package Trego
 * @since Trego 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php $thumb_video = get_post_meta($post->ID, 'post_thumb'); ?>

		<?php if ( $thumb_video && trego_get_video($thumb_video[0]) ) : ?>

		<div class="entry-thumbnail">
			<?php echo trego_get_video($thumb_video[0]); ?>
		</div>

		<?php elseif ( has_post_thumbnail() && ! post_password_required() ) : ?>

		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>

		<?php endif; ?>

		<div class="entry-meta">
			<?php trego_entry_meta(); ?>
		</div><!-- .entry-meta -->

		<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<?php endif; // is_single() ?>

	</header><!-- .entry-header -->

	<?php if ( !is_single() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'trego' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'trego' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
		<?php edit_post_link( __( '[ Edit ]', 'trego' ), '<div class="edit-link">', '</div>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
