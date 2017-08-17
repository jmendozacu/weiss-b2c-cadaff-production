<?php
// [testimonial]
function shortcode_testimonial_slider($atts, $content=null) {
	$sliderid = rand();
	ob_start();
	extract(shortcode_atts(array(
		'title' => '',
		'limit'  => '8',
		'orderby' => 'date',
		'order' => 'desc',
		'auto' => 'true',
		'pause' => '5000',
		'width' => '100%',
		'mode' => 'horizontal',
		'speed' => '500',
		'infinite_loop' => 'true',
		'max_slides' => '2',
		'move_slides'  => '1',
		'slide_margin' => '10',
		'bgcolor' => '',
		'auto_height' => 'false',
		'margin_bottom' => '15px',
		'ctrls_size' => 'small',
		'ctrls_pos' => 'default',
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
		<div id="bxslider_container_<?php echo $sliderid ?>" class="testimonial_slider bxslider-container<?php echo $btn_size; ?>"<?php echo $style; ?>>
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
				<?php
					the_post_thumbnail();
					echo get_the_excerpt();
				?>
				<div class="testimonial_author">
					<?php
						echo '<strong>';
						the_author();
						echo '</strong>';

						$role = get_post_meta(get_the_ID(), 'role');

						if($role){
							echo ', <span>' . $role[0] . '</span>';
						}
					?>
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

add_shortcode("testimonial", "shortcode_testimonial_slider");