<?php
/**
 * @package Trego
 * @since Trego 1.0
 */

get_header();

global $trego_vars;

if(isset($trego_vars['portfolio_column'])){

	if($trego_vars['portfolio_column'] == 'two'){
		$columns = 2;
	} elseif($trego_vars['portfolio_column'] == 'three') {
		$columns = 3;
	} elseif($trego_vars['portfolio_column'] == 'four') {
		$columns = 4;
	} else {
		$columns = 3;
	}
} else {
	$columns = 3;
}

$col_class = "";

if($columns == 2) {
	$col_class = " col-2 col-m-2 col-s-1";
} elseif($columns == 3) {
	$col_class = " col-3 col-m-2 col-s-1";
} elseif($columns == 4) {
	$col_class = " col-4 col-m-2 col-s-1";
} else {
	$col_class = " col-3 col-m-2 col-s-1";
}

if(isset($trego_vars['portfolio_show_category']) && !$trego_vars['portfolio_show_category']){
	$show_category = 'false';
} else {
	$show_category = 'true';
}

if(isset($trego_vars['portfolio_show_title']) && !$trego_vars['portfolio_show_title']){
	$show_title = 'false';
} else {
	$show_title = 'true';
}
?>

<div id="content" class="site-content" role="main">
	<div class="breadcrumb-container"><?php the_breadcrumbs(); ?></div>
	<div class="portfolio-wrapper">
		<?php $portfolio_categories = get_terms('portfolio_category');
		if ( $portfolio_categories && ($show_category == 'true') ) :?>
			<div class="portfolio-category">
			<a href="#<?php _e('All', 'trego'); ?>" class="active" data-filter="*"><?php _e('All', 'trego'); ?></a>
			<?php foreach($portfolio_categories as $cat): ?>
				<a data-filter=".<?php echo $cat->slug; ?>" href="#<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></a>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'post_type' => 'portfolio',
				'paged' => $paged,
				'posts_per_page' => get_option('posts_per_page'),
				'orderby' => 'date',
				'order' => 'desc',
			);

			query_posts($args);
			if ( have_posts() ) : ?>
				<div class="portfolio-container">
				<?php
					while( have_posts()): the_post();
						$item_classes = '';
						if ( $item_categories = get_the_terms($post->ID, 'portfolio_category') ):
							foreach($item_categories as $cat) {
								$item_classes .= ' ' . $cat->slug;
							}
						endif;

						$thumb = get_post_meta($post->ID, 'portfolio_thumb');
						if ( $thumb && trego_get_video($thumb[0]) ){
							$video_url = trego_catch_video_url(trego_get_video($thumb[0]));
						} else {
							$video_url = '';
						}
						?>
						<div class="element<?php echo $col_class . $item_classes; ?>" data-number="<?php echo get_the_date('YmdHis'); ?>">
							<?php
								if (has_post_thumbnail()) {
									$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
									$thumb_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
								} else {
									$full_image[0] = get_template_directory_uri().'/images/no-photo.png';
									$thumb_image[0] = get_template_directory_uri().'/images/no-photo.png';
								}
								if(!empty($video_url)){
									$full_image[0] = $video_url;
								}
							?>

							<div class="portfolio-image" data-img="<?php echo $full_image[0]; ?>">
								<img src="<?php echo $thumb_image[0]; ?>" alt="">
								<div class="overlay">
                                    <a class="portfolio_popup" rel="prettyPhoto[galleries]" href="<?php echo $full_image[0]; ?>"><img class="popup-mark" src="<?php echo get_template_directory_uri().'/images/portfolio-overlay.png'; ?>"></a>
									<?php if($show_title != 'true'): ?>
									<div class="portfolio-content">
										<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<p><?php echo strip_tags(get_the_term_list($post->ID, 'portfolio_category', '', ', ', '')); ?></p>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<?php if($show_title == 'true'): ?>
							<div class="portfolio-title">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo strip_tags(get_the_term_list($post->ID, 'portfolio_category', '', ', ', '')); ?></p>
							</div>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>
				</div>
				<div class="portfolio-nav">
					<?php echo get_next_posts_link(); ?>
				</div>
				<div class="slider-loading"></div>
				<?php wp_reset_query(); ?>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						var resizeTimer;
						var selector = "*";
						var $container = $(".portfolio-container");

						$('body').addClass('portfolio');

						$container.imagesLoaded( function(){
							$container.isotope({
								itemSelector : ".element",
								layoutMode: 'masonry',
								getSortData: {
									num: '[data-number]',
								},
								sortBy: ['num'],
								sortAscending: false,
								transitionDuration: '0.7s',
							});
							$('.portfolio-wrapper .slider-loading').fadeOut();
						});

						$container.infinitescroll({
								navSelector  : '.portfolio-nav', 
								nextSelector : '.portfolio-nav a',
								itemSelector : '.element',
								loading: {
									finishedMsg: 'No more pages to load.',
									img: '<?php echo get_template_directory_uri().'/images/ajax-loader4.gif'; ?>',
								}
							},

							function( newElements ) {
								$container.imagesLoaded( function(){
									$container.append( $(newElements) ).isotope( 'appended', $(newElements) );
									$container.isotope({
										filter: $('.portfolio-category a.active').attr('data-filter'),
									});
                                    $(document).ready(function(){
                                        $("a[rel^='prettyPhoto']").prettyPhoto({
                                            deeplinking : false,
                                            hook: 'rel',
                                            keyboard_shortcuts : true,
                                            social_tools: ''
                                        });
                                    });
								});
							}
						);

						$('.portfolio-category a').click(function(){
							var $this = $(this);

							$('.portfolio-category').find('.active').removeClass('active');
							$this.addClass('active');

							selector = $(this).attr('data-filter');
							$container.isotope({ filter: selector });
							return false;
						});
					});
				</script>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
	</div><!-- #portfolio-wrapper -->
</div>
<?php get_footer(); ?>