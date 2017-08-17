<?php
/**
 * @package Trego
 * @since Trego 1.0
 */
?>

<div class="author-info">
	<div class="author-description">
		<?php
			$permalink = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
			$author_bio_avatar_size = apply_filters( 'trego_author_bio_avatar_size', 120 );
			$avatar = get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
			$title = sprintf( __( 'About %s', 'trego' ), get_the_author() );

			$facebook = 'http://www.facebook.com/sharer.php?u='.urlencode($permalink.'&images='.$avatar.'&t='.$title);
			$twitter = 'https://twitter.com/share?url='.urlencode($permalink.'&text=' . $title);
			$google = 'https://plusone.google.com/_/+1/confirm?hl=en&url='.urlencode($permalink.'&title='.$title); 
		?>

		<?php if(is_author()) : ?>

			<h2 class="author-title">
				<?php
					echo $title;
					echo do_shortcode('[social_link facebook="'.$facebook.'" twitter="'.$twitter.'" googleplus="'.$google.'"]');
				?>
			</h2>
			<?php echo $avatar; ?>

		<?php else : ?>

			<?php echo $avatar; ?>
			<h2 class="author-title">
				<?php
					echo $title;
					echo do_shortcode('[social_link facebook="'.$facebook.'" twitter="'.$twitter.'" googleplus="'.$google.'"]');
				?>
			</h2>

		<?php endif; ?>

		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<?php if(!is_author()) : ?>
				<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                    <?php echo __( 'Other authors posts', 'trego' ) . ' <span class="meta-nav">&raquo;</span>'; ?>
				</a>
			<?php endif; ?>
		</p>
	</div><!-- .author-description -->
</div><!-- .author-info -->