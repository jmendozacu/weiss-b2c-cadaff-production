<?php
// [bestseller_products_slider]
function shortcode_bestsellers($atts, $content=null) {
	$sliderid = rand();
	ob_start();
	extract(shortcode_atts(array(
		'title' => '',
		'products'  => '8',
		'orderby' => 'date',
		'order' => 'desc',
		'auto' => 'false',
		'pause' => '4000',
		'width' => '100%',
		'mode' => 'horizontal',
		'speed' => '500',
		'infinite_loop' => 'false',
		'max_slides' => '3',
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
	
	if (class_exists('Woocommerce')) {
		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $products,
			'meta_key' => 'total_sales',
			'orderby' => 'meta_value'
		);

		$products = new WP_Query( $args );
?>
		<?php if ( $products->have_posts() ) { ?>
			<?php bxSlider_script($sliderid, $params) ?>
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
				while ( $products->have_posts() ) {
					$products->the_post();
					woocommerce_get_template_part( 'content', 'product-list' );
				}
				?>
				</ul>
				<div class="slider-loading"></div>
			</div>
		<?php } ?>
<?php
		wp_reset_query();
	}

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

// [latest_products_slider]
function shortcode_latest_products($atts, $content=null) {
	$sliderid = rand();
	ob_start();
	extract(shortcode_atts(array(
		'title' => '',
		'products'  => '8',
		'orderby' => 'date',
		'order' => 'desc',
		'auto' => 'false',
		'pause' => '4000',
		'width' => '100%',
		'mode' => 'horizontal',
		'speed' => '500',
		'infinite_loop' => 'false',
		'max_slides' => '3',
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
	
	if (class_exists('Woocommerce')) {

		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'   => 1,
			'posts_per_page' => $products
		);

		$products = new WP_Query( $args );
?>
		<?php if ( $products->have_posts() ) { ?>
			<?php bxSlider_script($sliderid, $params) ?>
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
				while ( $products->have_posts() ) {
					$products->the_post();
					woocommerce_get_template_part( 'content', 'product-list' );
				}
				?>
				</ul>
				<div class="slider-loading"></div>
			</div>
		<?php } ?>
<?php
		wp_reset_query();
	}

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

// [sale_products_slider]
function shortcode_sale_products($atts, $content=null) {
	$sliderid = rand();
	ob_start();
	extract(shortcode_atts(array(
		'title' => '',
		'products'  => '8',
		'orderby' => 'date',
		'order' => 'desc',
		'auto' => 'false',
		'pause' => '4000',
		'width' => '100%',
		'mode' => 'horizontal',
		'speed' => '500',
		'infinite_loop' => 'false',
		'max_slides' => '3',
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
	
	if (class_exists('Woocommerce')) {

		$args = array(
		    'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'   => 1,
			'posts_per_page' => $products,
			'orderby' => $orderby,
			'order' => $order,
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => '_sale_price',
					'value' =>  0,
					'compare' => '>',
					'type' => 'NUMERIC'
				),
				array(
					'key' => '_min_variation_sale_price',
					'value' => 0,
					'compare' => '>',
					'type' => 'NUMERIC'
				)
			)
		);

		$products = new WP_Query( $args );
?>
		<?php if ( $products->have_posts() ) { ?>
			<?php bxSlider_script($sliderid, $params) ?>
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
				while ( $products->have_posts() ) {
					$products->the_post();
					woocommerce_get_template_part( 'content', 'product-list' );
				}
				?>
				</ul>
				<div class="slider-loading"></div>
			</div>
		<?php } ?>
<?php
		wp_reset_query();
	}

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

// [featured_products_slider]
function shortcode_featured_products($atts, $content=null) {
	$sliderid = rand();
	ob_start();
	extract(shortcode_atts(array(
		'title' => '',
		'products'  => '8',
		'orderby' => 'date',
		'order' => 'desc',
		'auto' => 'false',
		'pause' => '4000',
		'width' => '100%',
		'mode' => 'horizontal',
		'speed' => '500',
		'infinite_loop' => 'false',
		'max_slides' => '3',
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
	
	if (class_exists('Woocommerce')) {

		$args = array(
			'post_status' => 'publish',
			'post_type' => 'product',
			'ignore_sticky_posts'   => 1,
			'meta_key' => '_featured',
			'meta_value' => 'yes',
			'posts_per_page' => $products,
			'orderby' => $orderby,
			'order' => $order,
		);

		$products = new WP_Query( $args );
?>
		<?php if ( $products->have_posts() ) { ?>
			<?php bxSlider_script($sliderid, $params) ?>
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
				while ( $products->have_posts() ) {
					$products->the_post();
					woocommerce_get_template_part( 'content', 'product-list' );
				}
				?>
				</ul>
				<div class="slider-loading"></div>
			</div>
		<?php } ?>
<?php
		wp_reset_query();
	}

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode("bestseller_products_slider", "shortcode_bestsellers");
add_shortcode("latest_products_slider", "shortcode_latest_products");
add_shortcode("sale_products_slider", "shortcode_sale_products");
add_shortcode("featured_products_slider", "shortcode_featured_products");
