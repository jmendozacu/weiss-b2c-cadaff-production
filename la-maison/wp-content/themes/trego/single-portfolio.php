<?php
/**
 * @package Trego
 * @since Trego 1.0
 */

get_header(); ?>

<div id="content" class="site-content post-portfolio" role="main">
	<div class="breadcrumb-container">
		<?php the_breadcrumbs(); ?>
		<div class="portfolio-navbar">
			<?php next_post_link('%link', '&lt;' . __('Previous', 'trego')); ?>
			<?php previous_post_link('%link', __('Next', 'trego') . '&gt;'); ?>
		</div>
	</div>
	<div class="row-container">
		<div class="main-container span-12 column">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="portfolio-thumbnail">
				<?php $thumb = get_post_meta($post->ID, 'portfolio_thumb'); ?>
				<?php if ( $thumb && has_shortcode($thumb[0], 'gallery') ) : ?>
					<?php echo do_shortcode($thumb[0]);	?>
				<?php elseif ( $thumb && trego_get_video($thumb[0]) ) : ?>
					<?php echo trego_get_video($thumb[0]); ?>
				<?php elseif ( $thumb && trego_catch_that_image($thumb[0]) ) : ?>
					<a rel="prettyPhoto" href="<?php echo trego_catch_that_image($thumb[0]); ?>" ><img src="<?php echo trego_catch_that_image($thumb[0]); ?>" alt="" /></a>
				<?php else : ?>
                    <?php
                    if (has_post_thumbnail()) {
                        $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                        $thumb_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                        echo '<a rel="prettyPhoto" href="' . $full_image[0] . '" ><img src="' . $thumb_image[0] . '" alt="" /></a>';
                    } else {
                        echo '<img src="' . get_template_directory_uri().'/images/no-photo.png" alt="" />';
                    }
                    ?>
				<?php endif; ?>
				</div>
				<div class="portfolio-desc">
				    <h3 class="entry-title"><?php the_title(); ?></h4>
					<div class="entry-content">
						<?php the_content(); ?>
						<div class="portfolio-meta">
							<p><span><?php echo __('Date', 'trego');?>: </span><?php echo get_the_date(); ?></p>
							<p><span><?php echo __('Categories', 'trego');?>: </span><?php echo strip_tags(get_the_term_list($post->ID, 'portfolio_category', '', ', ', '')); ?></p>
						</div>
						<span class="share-label"><?php echo __('Share This', 'trego');?>: </span>
						<?php echo do_shortcode('[share]'); ?>
				    </div>
				</div>
			<?php endwhile; ?>
		</div>
		<div class="span-12 column left">
		<?php
			$atts = 'title="'.__('Recent Projects:', 'trego').'"';
			$atts .= ' max_slides="4"';
			$atts .= ' responsive="0-460:1,461-640:2,641-1024:3"';

			echo do_shortcode('[recent_portfolio ' . $atts . ']');
		?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
