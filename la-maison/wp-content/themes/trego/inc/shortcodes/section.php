<?php 
// [section]
function shortcode_section($atts = array(), $content = null) {
	extract(shortcode_atts(array(
		'id' => '',
		'title' => '',
		'type' => 'secondary',
		'bg_image' => '',
		'bg_ratio' => '0.5',
		'bg_opacity' => '0.4',
		'parallax' => 'true',
		'margin_bottom' => '',
		'padding_bottom' => '',
	), $atts));

	if(!empty($title)){
		$section_id = strtolower(preg_replace('/\s+/', '-', $title));
		$section_id = str_replace(array('.', '&', '#', '$'), '', $section_id);
	} else {
		$section_id = "section-" . rand();
	}

	$section_type = "";
	if($type == 'primary'){
		$section_type = 'primary';
		$section_id = "section-primary";
	} elseif ($type == 'fullwidth') {
		$section_type = 'fullwidth';
	}

	if($id != ''){
		$section_id = $id;
	}

	$style = '';
	if(!empty($margin_bottom)){
		$style = 'margin-bottom:' . (int)$margin_bottom . 'px;';
	}
	if(!empty($padding_bottom)){
		$style .= 'padding-bottom:' . (int)$padding_bottom . 'px;';
	}
	if($style != ''){
		$style = 'style="' . $style . '"';
	}

	$ratio = '';
	$background = '';
	if(!empty($bg_image)){
		$background = 'background-image: url(' . $bg_image . ');';

		if($parallax == 'true'){
			$section_type .= ' parallax';
			if(!empty($bg_ratio)){
				$ratio = 'data-stellar-background-ratio="' . $bg_ratio . '"';
			}
		}

		if(!empty($bg_opacity)){
			$background .= 'opacity: ' . $bg_opacity . ';';
		}
	}

	$fix = array (
		'<p>[' => '[',
		']</p>' => ']',
		'<br>[' => '[',
		'<br/>[' => '[',
		'<br />[' => '[',
        '&nbsp;' => '',
        '<p></p>' => '',
        '<p> </p>' => '',
        '<p>&nbsp;</p>' => '',
		']<br>' => ']',
		']<br/>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $fix);
	$content = do_shortcode($content);

	ob_start();
	?>
	<div id="<?php echo $section_id; ?>" class="section-block <?php echo $section_type; ?>" <?php echo $style; ?>>
		<?php if($type == 'primary') : ?>
			<?php echo $content; ?>
		<?php else: ?>
		<div class="section-content">
			<?php if($type != 'fullwidth') : ?>
				<div class="site-content">
			<?php endif; ?>
			<?php if(!empty($title)) : ?>
				<h1 class="section-name"><?php echo $title; ?></h1>
				<div class="section-divider"></div>
			<?php endif; ?>
			<?php echo $content; ?>
			<?php if($type != 'fullwidth') : ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
		if($background != ''){
			echo '<div class="section-background" ' . $ratio . ' style="' . $background . '"></div>';
		}
		?>
		<?php endif; ?>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;	
}

// [section_description]
function shortcode_section_description($atts = array(), $content = null) {
	extract(shortcode_atts(array(
		'margin_bottom' => '75px'
	), $atts));

	$fix = array (
		'<p>[' => '[',
		']</p>' => ']',
		'<br>[' => '[',
		'<br/>[' => '[',
		'<br />[' => '[',
        '&nbsp;' => '',
        '<p></p>' => '',
        '<p> </p>' => '',
        '<p>&nbsp;</p>' => '',
		']<br>' => ']',
		']<br/>' => ']',
		']<br />' => ']'
	);

	$margin = "";
	if(!empty($margin_bottom)){
		$margin = 'style="margin-bottom: ' . (int)$margin_bottom . 'px;"';
	}
	$content = strtr($content, $fix);
	$content = do_shortcode($content);

	$section_desc = '<div class="section-desc" ' . $margin . '>' . $content . '</div>';
	return $section_desc;	
}

// [icon_block]
function shortcode_icon_block($atts = array(), $content = null) {
	extract(shortcode_atts(array(
		'title' => '',
		'icon' => '',
		'type' => 'horizontal',
		'animate' => 'fadeIn',
		'link' => '',
	), $atts));

	$fix = array (
		'<p>[' => '[',
		']</p>' => ']',
		'<br>[' => '[',
		'<br/>[' => '[',
		'<br />[' => '[',
        '&nbsp;' => '',
        '<p></p>' => '',
        '<p> </p>' => '',
        '<p>&nbsp;</p>' => '',
		']<br>' => ']',
		']<br/>' => ']',
		']<br />' => ']'
	);

	$block_type = "";
	if($type == 'vertical'){
		$block_type = 'vertical';
	}
	if($type == 'single'){
		$block_type = 'single';
	}

	$content = strtr($content, $fix);
	$content = do_shortcode($content);

	ob_start();?>

	<div class="ico-block animated <?php echo $block_type; ?>" data-icon-animate="<?php echo $animate; ?>">
		<div class="ico-mark">
		<span class="<?php echo $icon; ?>"></span>
		</div>
		<div class="ico-block-content">
                    <h3 class="ico-block-title">
				<?php  if(!empty($link)): ?>
				<a href="<?php echo $link; ?>">
				<?php  endif; ?>
					<?php echo $title; ?>
				<?php if(!empty($link)): ?>
				</a>
				<?php endif; ?>
			</h3>
			<?php if($type != 'single'): ?>
				<?php if($type == 'vertical'): ?>
					<div class="section-divider"></div>
				<?php endif; ?>
				<div class="ico-block-desc"><?php echo $content; ?></div>
			<?php endif; ?>
		</div>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;	
}

// [progress_bar]
function shortcode_progress_bar($atts = array(), $content = null) {
	extract(shortcode_atts(array(
		'label' => '',
		'percent' => '',
	), $atts));

	ob_start();?>
	<div class="progress-bar">
		<div class="progress-label"><?php echo $label; ?> <span class="progress-units"><?php echo $percent; ?></span></div>
		<div class="progress-value" data-progress-animate="<?php echo (int)$percent; ?>"></div>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}


// [section_testimonial]
function shortcode_section_testimonial_slider($atts, $content=null) {
	$sliderid = rand();
	ob_start();
	extract(shortcode_atts(array(
		'title' => '',
		'limit'  => '8',
		'orderby' => 'date',
		'order' => 'desc',
		'auto' => 'true',
		'pause' => '8000',
		'width' => '100%',
		'mode' => 'horizontal',
		'speed' => '800',
		'infinite_loop' => 'true',
		'move_slides'  => '1',
		'slide_margin' => '10',
		'bgcolor' => '',
		'auto_height' => 'true',
		'margin_bottom' => '',
		'ctrls_size' => 'small',
		'pager' => 'true',
		'ctrls_pos' => 'default',
		'responsive' => ''
	), $atts));

	$max_slides = 1;

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
		'pager' => $pager,
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
		'post_status' => 'publish',
		'post_type' => 'testimonial',
		'posts_per_page' => $limit,
		'orderby' => $orderby,
		'order' => $order,
	);

	query_posts( $args );
?>
	<?php if ( have_posts() ) { ?>
		<?php bxSlider_script($sliderid, $params) ?>
		<div id="bxslider_container_<?php echo $sliderid ?>" class="section-testimonial bxslider-container<?php echo $btn_size; ?>"<?php echo $style; ?>>
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
			<?php while ( have_posts() ) : the_post(); ?>
			<li>
				<div class="testimonial-text">
					<?php echo get_the_excerpt(); ?>
				</div>
				<div class="author-thumbnail">
					<?php the_post_thumbnail(); ?>
				</div>
				<div class="testimonial_author">
					<?php the_author(); ?>
				</div>
			</li>
			<?php endwhile; ?>
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

// [section_tweets]
function shortcode_section_tweets_slider($atts, $content=null) {
	$sliderid = rand();
	ob_start();
	extract(shortcode_atts(array(
		'title' => '',
		'twitter_id' => '',
		'limit'  => '3',
		'orderby' => 'date',
		'order' => 'desc',
		'auto' => 'true',
		'pause' => '8000',
		'width' => '100%',
		'mode' => 'horizontal',
		'speed' => '800',
		'infinite_loop' => 'true',
		'move_slides'  => '1',
		'slide_margin' => '10',
		'bgcolor' => '',
		'auto_height' => 'true',
		'margin_bottom' => '',
		'ctrls_size' => 'small',
		'pager' => 'true',
		'ctrls_pos' => 'default',
		'responsive' => ''
	), $atts));

	if(!isset($twitter_id)){
		return;
	}

	$max_slides = 1;

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
		'pager' => $pager,
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
?>
		<?php bxSlider_script($sliderid, $params) ?>
		<div id="bxslider_container_<?php echo $sliderid ?>" class="section-tweets bxslider-container<?php echo $btn_size; ?>"<?php echo $style; ?>>
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
			<li></li>
			</ul>
			<div class="slider-loading"></div>
		</div>
		<script type="text/javascript">
			function handleTweets(tweets) {
				var x = tweets.length;
				var n = 0;
				var element = document.getElementById('bxslider_<?php echo $sliderid ?>');
				var html = '';
				while(n < x) {
					html += '<li>' + tweets[n] + '</li>';
					n++;
				}
				element.innerHTML = html;
			}

			var api_key = '<?php echo $twitter_id; ?>';
			var showcounts = <?php echo (int)$limit; ?>;

			twitterFetcher.fetch(api_key, 'bxslider_<?php echo $sliderid ?>', showcounts, true, false, true, '', false, handleTweets);
			
			jQuery(document).ready(function($) {
				$(window).load(function(){
					$.each($('#bxslider_<?php echo $sliderid ?> > li'), function(){
						var follow_link = $(this).find('p.tweet a[data-scribe="element:url"]').attr('href');
						$(this).find('p.interact').html('<a href="' + follow_link + '" class="btn-type"><?php echo __('Follow Us', 'trego'); ?></a>');
					});
				});
			});
		</script>
<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode('section', 'shortcode_section');
add_shortcode('section_description', 'shortcode_section_description');
add_shortcode('icon_block', 'shortcode_icon_block');
add_shortcode('progress_bar', 'shortcode_progress_bar');
add_shortcode("section_testimonial", "shortcode_section_testimonial_slider");
add_shortcode('section_tweets', 'shortcode_section_tweets_slider');

