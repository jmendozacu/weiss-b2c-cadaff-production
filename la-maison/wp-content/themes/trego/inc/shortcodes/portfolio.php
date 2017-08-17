<?php
// [recent_portfolio]
function shortcode_recent_portfolio($atts, $content=null) {
	global $post;
	$sliderid = rand();
	ob_start();
	extract(shortcode_atts(array(
		'title' => '',
		'portfolios'  => '8',
		'orderby' => 'date',
		'order' => 'desc',
		'auto' => 'true',
		'pause' => '4000',
		'width' => '100%',
		'mode' => 'horizontal',
		'speed' => '500',
		'infinite_loop' => 'true',
		'max_slides' => '4',
		'move_slides'  => '1',
		'slide_margin' => '10',
		'bgcolor' => '',
		'auto_height' => 'false',
		'margin_bottom' => '',
		'ctrls_size' => 'large',
		'ctrls_pos' => 'top',
		'responsive' => ''
	), $atts));

	$params = array(
		'auto' => $auto,
		'pause' => $pause,
		'mode' => $mode,
		'speed' => (int)$speed,
		'infinite_loop' => $infinite_loop,
		'max_slides' => (int)$max_slides,
		'move_slides'  => (int)$move_slides,
		'slide_margin' => (int)$slide_margin,
		'auto_height' => $auto_height,
		'ctrls_pos' => $ctrls_pos
	);

	if($responsive){
		$tmp = explode(',', $responsive);
		$json = array();
		foreach ($tmp as $value) {
			$k = explode(':', $value);
			$i = explode('-', $k[0]);
			$a = (int)$i[0];
			$b = (int)$i[1];
			if($a > $b){
				$min = $b;
				$max = $a;
			} else {
				$min = $a;
				$max = $b;
			}
			$json[] = array('min'=>$min, 'max'=>$max, 'cnt'=>(int)$k[1]);
		}
		$params['responsive'] = json_encode($json);
	}

	$style = "";
	if($bgcolor){
		$style = 'background-color:'.$bgcolor.';';
	}
	if($margin_bottom){
		$style .= 'margin-bottom:'.$margin_bottom.';';
	}
	if($width){
		$style .= 'width:'.$width.';';
	}
	if($style != "") {
		$style = ' style="' . $style . '"';
	}

	$btn_size = "";
	if($ctrls_size == 'small') {
		$btn_size = ' small-ctrls';
	}

	$args = array(
		'post_type' => 'portfolio',
		'post_status' => 'publish',
		'posts_per_page' => $portfolios,
		'ignore_sticky_posts' => 1,
		'orderby' => $orderby,
		'order' => $order,
	);

	query_posts( $args );
	?>
	<?php if ( have_posts() ) { ?>
		<?php bxslider_script($sliderid, $params) ?>
		<div id="bxslider_container_<?php echo $sliderid ?>" class="bxslider-container<?php echo $btn_size; ?>"<?php echo $style; ?>>
			<?php if($title || ($ctrls_pos == 'top')){ ?>
			<div class="bxslider-title">
				<?php echo $title ?>
				<?php if($ctrls_pos == 'top'){ ?>
				<div class="top-ctrls">
					<a href="javascript:void(0)" id="btn_prev_<?php echo $sliderid ?>" class="btn-prev-top"></a>
					<a href="javascript:void(0)" id="btn_next_<?php echo $sliderid ?>" class="btn-next-top"></a>
				</div>
				<?php } ?>
			</div>
			<?php } ?>		
			<ul id="bxslider_<?php echo $sliderid ?>" class="bxslider">
			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<li class="element">
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
					<div class="portfolio-image" data-img="<?php echo $full_image[0]; ?>">
						<?php
							echo '<img src="' . get_template_directory_uri().'/images/blank-large.png' . '" alt="" class="attachment-shop_catalog">';
							$thumb_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium');

							$caption = '';
							$attachment = get_post(get_post_thumbnail_id(get_the_ID()));
							$caption = (!empty($attachment->post_excerpt)) ? $attachment->post_excerpt : get_the_title(get_post_thumbnail_id(get_the_ID()));

							if($thumb_image){
								$thumb_image = $thumb_image[0];
							} else {
								$thumb_image = get_template_directory_uri().'/images/no-photo.png';
							}
						?>
						    <div class="overlay">
                            <a class="portfolio_popup" rel="prettyPhoto[galleries]" href="<?php echo $full_image[0]; ?>"><img class="popup-mark" src="<?php echo get_template_directory_uri().'/images/portfolio-overlay.png'; ?>" alt="<?php echo $caption; ?>"></a>
							<div class="portfolio-content">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo strip_tags(get_the_term_list(get_the_ID(), 'portfolio_category', '', ', ', '')); ?></p>
							</div>
						</div>
						<div class="thumb-bg" style="background-image:url('<?php echo $thumb_image; ?>')"></div>
					</div>
				</li>
				<?php
			}
			?>
			</ul>
			<div class="slider-loading"></div>
		</div>
	<?php } ?>
	<?php
	wp_reset_query();

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

// [portfolio]
function shortcode_portfolio($atts, $content=null) {
	global $post, $trego_vars;

	ob_start();
	extract(shortcode_atts(array(
		'columns' => '',
		'show_title' => '',
		'show_category' => '',
		'category_slug' => '',
		'category_active' => '',
		'infinitescroll' => 'true',
		'show_items' => '0',
		'ajax' => 'false',
		'position' => 'default',
	), $atts));

	$col_class = "";

	$posts_per_page = (int)$show_items;
	if(!$posts_per_page){
		$posts_per_page = get_option('posts_per_page');
	}

	if(empty($columns) && isset($trego_vars['portfolio_column'])){

		if($trego_vars['portfolio_column'] == 'two'){
			$columns = 2;
		} elseif($trego_vars['portfolio_column'] == 'three') {
			$columns = 3;
		} elseif($trego_vars['portfolio_column'] == 'four') {
			$columns = 4;
		} else {
			$columns = 3;
		}
	}

	if($columns == 1) {
		$col_class = " col-1 col-m-1 col-s-1";
		$colinfo_class = " element-span-12 element-span-m-12 element-span-s-12";
	} elseif($columns == 2) {
		$col_class = " col-2 col-m-2 col-s-1";
		$colinfo_class = " element-span-6 element-span-m-12 element-span-s-12";
	} elseif($columns == 3) {
		$col_class = " col-3 col-m-2 col-s-1";
		$colinfo_class = " element-span-8 element-span-m-12 element-span-s-12";
	} elseif($columns == 4) {
		$col_class = " col-4 col-m-2 col-s-1";
		$colinfo_class = " element-span-6 element-span-m-12 element-span-s-12";
	} else {
		if(isset($trego_vars['portfolio_column'])){
			if($trego_vars['portfolio_column'] == 'two'){
				$col_class = " col-2 col-m-2 col-s-1";
				$colinfo_class = " element-span-6 element-span-m-12 element-span-s-12";
			} elseif($trego_vars['portfolio_column'] == 'three') {
				$col_class = " col-3 col-m-2 col-s-1";
				$colinfo_class = " element-span-8 element-span-m-12 element-span-s-12";
			} elseif($trego_vars['portfolio_column'] == 'four') {
				$col_class = " col-4 col-m-2 col-s-1";
				$colinfo_class = " element-span-6 element-span-m-12 element-span-s-12";
			} else {
				$col_class = " col-3 col-m-2 col-s-1";
				$colinfo_class = " element-span-8 element-span-m-12 element-span-s-12";
			}
		} else {
			$col_class = " col-3 col-m-2 col-s-1";
			$colinfo_class = " element-span-8 element-span-m-12 element-span-s-12";
		}
	}

	if(isset($trego_vars['portfolio_show_category']) && !$trego_vars['portfolio_show_category']){
		$default_show_category = 'false';
	} else {
		$default_show_category = 'true';
	}

	if(empty($show_category)){
		$show_category = $default_show_category;
	}

	if(isset($trego_vars['portfolio_show_title']) && !$trego_vars['portfolio_show_title']){
		$default_show_title = 'false';
	} else {
		$default_show_title = 'true';
	}

	if(empty($show_title)){
		$show_title = $default_show_title;
	}

	if(!empty($category_slug)){
		$category_slug = str_replace(" ", "", $category_slug);
		$category_slug = explode(",", $category_slug);
	}
	?>
	<div class="portfolio-wrapper">
		<?php $portfolio_categories = get_terms('portfolio_category');
		if ( $portfolio_categories && ($show_category == 'true') ) :?>
			<div class="portfolio-category">
			<?php if(empty($category_slug) || (!empty($category_slug) && (count($category_slug) > 1))): ?>
			<a href="#<?php _e('All', 'trego'); ?>" class="portfolio-category-all active" data-filter="*"><?php _e('All', 'trego'); ?></a>
			<?php endif; ?>
			<?php foreach($portfolio_categories as $cat): ?>
				<?php
				if(!empty($category_slug) && !in_array($cat->slug, $category_slug)){
					continue;
				}
				?>
				<a data-filter=".<?php echo $cat->slug; ?>" class="portfolio-category-<?php echo $cat->slug; ?>" href="#<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></a>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'post_type' => 'portfolio',
				'paged' => $paged,
				'posts_per_page' => $posts_per_page,
				'orderby' => 'date',
				'order' => 'desc',
			);
			if(!empty($category_slug)){
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'portfolio_category',
						'field' => 'slug',
						'terms' => $category_slug
					)
				);
			}
			query_posts($args);
			if ( have_posts() ) : ?>
				<?php if(($position == 'top') && ($ajax != 'false')): ?>
				<div class="portfolio-details"><div class="row"></div></div>
				<?php endif; ?>
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
						<div class="element<?php echo $col_class . $item_classes; ?>" data-class="<?php echo $item_classes; ?>" data-number="<?php echo get_the_date('YmdHis'); ?>">
							<?php
								$caption = '';

								if (has_post_thumbnail()) {
									$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
									$thumb_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
									$attachment = get_post(get_post_thumbnail_id(get_the_ID()));
									$caption = (!empty($attachment->post_excerpt)) ? $attachment->post_excerpt : get_the_title(get_post_thumbnail_id(get_the_ID()));

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
									<?php if($ajax == 'false'): ?>
                                    	<a class="portfolio_popup" rel="prettyPhoto[galleries]" href="<?php echo $full_image[0]; ?>"><img class="popup-mark" src="<?php echo get_template_directory_uri().'/images/portfolio-overlay.png'; ?>" alt="<?php echo $caption; ?>"></a>
                                    <?php else: ?>
                                    	<a class="portfolio_popup" data-post-id="<?php echo $post->ID;?>" href="#"><img class="popup-mark" src="<?php echo get_template_directory_uri().'/images/portfolio-overlay.png'; ?>"></a>
                                    <?php endif; ?>
									<?php if(($show_title != 'true') && ($ajax == 'false')): ?>
									<div class="portfolio-content">
										<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
										<p><?php echo strip_tags(get_the_term_list($post->ID, 'portfolio_category', '', ', ', '')); ?></p>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<?php if(($show_title == 'true') && ($ajax == 'false')): ?>
							<div class="portfolio-title">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo strip_tags(get_the_term_list($post->ID, 'portfolio_category', '', ', ', '')); ?></p>
							</div>
							<?php endif; ?>
						</div>
					<?php endwhile; ?>
				</div>
				<?php if(($position == 'bottom') && ($ajax != 'false')): ?>
				<div class="portfolio-details"><div class="row"></div></div>
				<?php endif; ?>
				<?php if($infinitescroll != 'false'): ?>
				<div class="portfolio-nav">
					<?php echo get_next_posts_link(); ?>
				</div>
				<?php endif; ?>
				<div class="slider-loading"></div>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						var resizeTimer;
						var selector = "*";
						var $container = $(".portfolio-container");

						$('body').addClass('portfolio');

						<?php if(!empty($category_active)){ ?>
						$('.portfolio-category-all').removeClass('active');
						$('.portfolio-category-<?php echo $category_active; ?>').addClass('active');
						<?php } ?>

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
								<?php if(!empty($category_active)){ ?>
								filter: '.<?php echo $category_active;?>'
								<?php } ?>
							});
							$('.portfolio-wrapper .slider-loading').fadeOut();
						});

						<?php if($infinitescroll != 'false'): ?>
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
						<?php endif; ?>

						$('.portfolio-category a').click(function(){
							var $this = $(this);

							$('.portfolio-category').find('.active').removeClass('active');
							$this.addClass('active');

							selector = $(this).attr('data-filter');
							$container.isotope({ filter: selector });
							return false;
						});
						<?php if($ajax != 'false'): ?>
						$(document).on('click', '.portfolio_popup', function(e){
							e.preventDefault();
							e.stopPropagation();
							var target = $(this);
							var pid = $(this).attr('data-post-id');
							var pnum = $(this).parent().parent().parent().attr('data-number');
							var pclass = $(this).parent().parent().parent().attr('data-class');
							var overlay = $(this).parent();
							var data = {
								'action': 'load_portfolio',
								'pid': pid
							};
							overlay.addClass('portfolio-loading');
							$.post(ajax_url, data, function(response) {
								if(response == 'failure'){
									overlay.removeClass('portfolio-loading');
									return;
								}

								<?php if(($position == 'top') || ($position == 'bottom')): ?>

								imagesLoaded('.portfolio-details .row', function(){
									$('.portfolio-details .row').html(response)

                                    $("a[rel^='prettyPhoto']").prettyPhoto({
                                        deeplinking : false,
                                        hook: 'rel',
                                        keyboard_shortcuts : true,
                                        social_tools: ''
                                    });

								}).on( 'done', function( instance ) {
									var offset_y = 0;
									var scroll_offset = parseInt($('.site-main').css('padding-top'));
									overlay.removeClass('portfolio-loading');
									if(!isNaN(scroll_offset)){
										offset_y = scroll_offset * -1;
									}
									$.scrollTo('.portfolio-details', {axis:'y', duration: 800, offset: offset_y});
								});

								<?php else: ?>

								var $newItems = $('<div class="element<?php echo $colinfo_class; ?>' + pclass + '" id="portfolio-details" data-number="' + ( pnum - 1 ) + '">' + response + '</div>');
								$newItems.imagesLoaded(function(){
									$container.isotope( 'remove', $('#portfolio-details') );
									$container.append( $newItems ).isotope( 'insert', $newItems );
                                    $(document).ready(function(){
                                        $("a[rel^='prettyPhoto']").prettyPhoto({
                                            deeplinking : false,
                                            hook: 'rel',
                                            keyboard_shortcuts : true,
                                            social_tools: ''
                                        });
                                    });
									overlay.removeClass('portfolio-loading');
									var offset_y = 0;
									var scroll_offset = parseInt($('.site-main').css('padding-top'));
									if(!isNaN(scroll_offset)){
										offset_y = scroll_offset * -1;
									}
									setTimeout(function(){
										$.scrollTo('#portfolio-details', {axis:'y', duration: 800, offset: offset_y});
									}, 900);
								});
								<?php endif; ?>
							});
						});
						$(document).on('click', '.portfolio-close', function(e){
							if(!!$('#portfolio-details').length){
								$container.isotope( 'remove', $('#portfolio-details') ).isotope('layout');
							} else {
								var offset_y = 0;
								var scroll_offset = parseInt($('.site-main').css('padding-top'));
								if(!isNaN(scroll_offset)){
									offset_y = scroll_offset * -1;
								}
								$('.portfolio-details .row .portfolio-desc-wrapper').slideToggle(function(){
									$('.portfolio-details .row').html("");
									$.scrollTo('.portfolio-container', {axis:'y', duration: 800, offset: offset_y});
								});
							}
						});
						<?php endif; ?>
					});
				</script>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
			<?php wp_reset_query(); ?>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode('portfolio', 'shortcode_portfolio');
add_shortcode('recent_portfolio', 'shortcode_recent_portfolio');