<?php
/*
Template Name: 4-One Page Template
*/

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>

<?php get_footer(); ?>