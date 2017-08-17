<?php
// [gallery]
function trego_gallery_shortcode($atts) {

    global $post;

	if (!empty($atts['type']) && ($atts['type'] == 'slider')) {

		$gallery_slider = "[gallery_slider";

		foreach ($atts as $key => $value) {
			$gallery_slider .= ' '.$key . '="' . $value . '"';
		}

		$gallery_slider .= "]";

		return do_shortcode($gallery_slider);
	} elseif(!empty($atts['type']) && ($atts['type'] == 'home-slider')){
		$gallery_slider = "[gallery_home_slider";

		foreach ($atts as $key => $value) {
			$gallery_slider .= ' '.$key . '="' . $value . '"';
		}

		$gallery_slider .= "]";

		return do_shortcode($gallery_slider);
	}

	if ( ! empty( $atts['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $atts['orderby'] ) )
			$atts['orderby'] = 'post__in';
		$atts['include'] = $atts['ids'];
	}

	extract(shortcode_atts(array(
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'include' => '',
		'id' => $post ? $post->ID : 0,
		'columns' => 3,
		'size' => 'full',
		'type' => 'default',
		'link' => ''
	), $atts));

	$args = array(
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'post_mime_type' => 'image',
		'order' => $order,
		'orderby' => $orderby
	);

	if ( !empty($include) )
		$args['include'] = $include;
	else {
		$args['post_parent'] = $id;
		$args['numberposts'] = -1;
	}

	$images = get_posts($args);

	$columns = intval($columns);

	$gid = rand();
	if($type == 'tile') {

		if(!$columns){
			$classes = "span-4 span-grid-m-4 span-s-12";
		} elseif($columns == 4) {
			$classes = "span-3 span-m-4 span-s-12";

		} elseif($columns == 2) {
			$classes = "span-6 span-m-6 span-s-12";

		} else {
			$classes = "span-4 span-m-4 span-s-12";
		}
		
		$gallery = '<div id="tile_container_' . $gid . '" class="tile-container">';

	} else {

		if(!$columns){
			$classes = "block-grid-3 block-grid-m-2 block-grid-s-1";
		} elseif($columns == 1) {
			$classes = "block-grid-1 block-grid-m-1 block-grid-s-1";
		} elseif($columns == 2) {
			$classes = "block-grid-2 block-grid-m-2 block-grid-s-1";
		} else {
			$classes = "block-grid-" . $columns . " block-grid-m-2 block-grid-s-1";
		}

		$gallery = '<ul class="gallery ' . $classes . '">';
	}

	foreach ( $images as $id => $image ) {

		$gallery .= ($type == 'tile') ? '<div class="tile-item ' . $classes . '">' : '<li>';

		$caption = wptexturize($image->post_excerpt);
		$caption = (!empty($image->post_excerpt)) ? $image->post_excerpt : get_the_title($image->ID);

        $img_full = wp_get_attachment_image_src($image->ID, 'full');
        $img_thumb = wp_get_attachment_image_src($image->ID, 'full');

		if ( ! empty( $link ) && 'file' === $link )
            $image_output = '<a rel="prettyPhoto[gallery_'.$gid.']" href="' . $img_full[0] . '" title="' . $caption . '"><img src="' . $img_thumb[0] . '"></a>';

		elseif ( ! empty( $link ) && 'none' === $link )
            $image_output = wp_get_attachment_image( $image->ID, $size, false );

		else
			$image_output = wp_get_attachment_link( $image->ID, $size, true, false );

		$gallery .= preg_replace( '/(height|width)="\d*"\s/', "", $image_output );

		$gallery .= ($type == 'tile') ? '</div>' : '</li>';
	}

	$gallery .= ($type == 'tile') ? '</div>' : '</ul>';

	if($type == 'tile') {
		tile_gallery_script($gid);
	}

	return $gallery;
}

function tile_gallery_script($gid) {
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$(window).load(function(){
		var resizeTimer;
		var $container = $("#tile_container_<?php echo $gid; ?>");
		$container.isotope({
			itemSelector : ".tile-item",
		});

		$(window).resize(function() {
//			if(!($.browser.msie  && parseInt($.browser.version, 10) === 8)){
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(
					function(){
						$container.isotope('reLayout');
					}, 250);
//			}
		});
	});
});
</script>
<?php
}

// [product_tile_gallery]
function shortcode_product_tile_gallery($atts, $content=null) {
    ob_start();
?>
	<div class="product-tile-container">
		<div class="description-container">
			<div class="product-desc">&nbsp;</div>
		</div>
		<div class="image-container">
			<div class="tile-container">
			<?php
				$fix = array (
					'<br>' => '', 
					'<br/>' => '',
					'<br />' => '',
					'&nbsp;' => '',
					'<p>' => '',
					'</p>' => '',
					'<p></p>' => '',
					'<p>[' => '[',
					']</p>' => ']',
					']<br/>' => ']',
					']<br />' => ']'
				);
				$content = strtr($content, $fix);
				echo do_shortcode($content);
			?>
			</div>
		</div>
	</div>
<?php
	tile_product_script();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

// [product_tile]
function shortcode_product_tile($atts, $content=null) {
	extract(shortcode_atts(array(
		'image' => '',
		'sku' => '',
		'id' => ''
	), $atts));

	if (empty($sku) && empty($id)) return;

	$args = array(
	    'post_type' => 'product',
	    'posts_per_page' => 1,
	    'no_found_rows' => 1,
	    'post_status' => 'publish',
	    'meta_query' => array(
			array(
				'key' => '_visibility',
				'value' => array('catalog', 'visible'),
				'compare' => 'IN'
			)
		)
	);

	if(isset($atts['sku'])){
	    $args['meta_query'][] = array(
	      	'key' => '_sku',
	      	'value' => $sku,
	      	'compare' => '='
	    );
	}

	if(isset($atts['id'])){
	    $args['p'] = $id;
	}

	$products = new WP_Query( $args );

	if ( $products->have_posts() ) {
		$products->the_post();

		global $product, $post;

		$terms = get_the_terms( $id, 'product_cat' );
		if($terms){
			foreach ($terms as $term) {
				$product_cat = $term->name;
				break;
			}
		}

		if(empty($product_cat)){
			$product_cat = '';
		}

		$title = get_the_title($id);
		$desc = strip_tags(apply_filters( 'woocommerce_short_description', $post->post_excerpt ));

		if(strlen($desc) > 127){
			$desc = substr($desc, 0, 127) . ' &middot;&middot;&middot;';
		}

		$price_html = $product->get_price_html();
		$img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

		$image = (!empty($image)) ? $image : $img_src[0];

		$content = '<div class="product-tile">';
		$content .= '	<div class="front">';
		$content .= '		<img src="'.$image.'" alt="" />';
		$content .= '		<div class="overlay">';
		$content .= '			<div class="description">';
		$content .= '				<div class="title">'.$product_cat.'</div>';
		$content .= '				<h1>'.$title.'</h1>';
		$content .= '				<div class="price">'.$price_html.'</div>';
		$content .= '				<div class="desc">'.$desc.'</div>';
		$content .= '				<div class="view-btn"><a href="'.get_permalink($id).'" class="btn-type">' . __('Shop Now', 'trego') . '</a></div>';
		$content .= '			</div>';
		$content .= '		</div>';
		$content .= '		<div class="black-bar"></div>';
		$content .= '	</div>';
		$content .= '</div>';
	}

	wp_reset_postdata();

	return $content;
}

function tile_product_script() {
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$(window).load(function(){
		var resizeTimer;
		var $container = $(".tile-container");

		$('body').addClass('tile-screen');

		$container.imagesLoaded( function(){
			$container.isotope({
				itemSelector : ".product-tile"
			});
		});

		$(window).resize(function() {
			// if(!($.browser.msie  && parseInt($.browser.version, 10) === 8)){
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(
				function(){
					$container.isotope('reLayout');
				}, 250);
			// }
		});

		$(".product-tile").first().addClass('active');
		$('.product-desc').html($(".product-tile").first().find('.description').html());

		$(".product-tile").click(function(){
			$(".product-tile").removeClass('active');
			$(this).addClass('active');
			var desc = $(this).find('.description').html();
			$('.product-desc').fadeOut(300, function() {
				$('.product-desc').html(desc).fadeIn(300);
			});
		});

        $('.image-container').niceScroll({horizrailenabled: false, zindex: 9999, cursorwidth:'7px', cursorborderradius:'7px'});
	});
});
</script>
<?php
}

// [gallery_slider]
function shortcode_gallery_slider($atts) {
    global $post;

	if ( ! empty( $atts['ids'] ) ) {
		if ( empty( $atts['orderby'] ) )
			$atts['orderby'] = 'post__in';
		$atts['include'] = $atts['ids'];
	}

	$sliderid = rand();
	extract(shortcode_atts(array(
		'title' => '',
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'include' => '',
		'id' => $post ? $post->ID : 0,
		'columns' => 3,
		'size' => 'full',
		'link' => '',
		'auto' => 'true',
		'pause' => '4000',
		'width' => '100%',
		'mode' => 'horizontal',
		'speed' => '500',
		'infinite_loop' => 'true',
		'move_slides'  => '1',
		'slide_margin' => '0',
		'bgcolor' => '',
		'auto_height' => 'true',
		'margin_bottom' => '',
		'ctrls_size' => 'small',
		'ctrls_pos' => 'default',
		'class' => '',
		'responsive' => ''
	), $atts));

    if(($slide_margin == 0) && ($columns > 1)){
        $slide_margin = 10;
    }
	$params = array(
		'auto' => $auto,
		'pause' => $pause,
		'mode' => $mode,
		'speed' => (int)$speed,
		'infinite_loop' => $infinite_loop,
		'max_slides' => (int)$columns,
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

    ob_start();
    ?>
	<?php bxSlider_script($sliderid, $params)?>
	<div id="bxslider_container_<?php echo $sliderid ?>" class="bxslider-container<?php echo $btn_size . ' ' . $class; ?>"<?php echo $style; ?>>
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
		$args = array(
			'post_type' => 'attachment',
			'post_status' => 'inherit',
			'post_mime_type' => 'image',
			'order' => $order,
			'orderby' => $orderby
		);

		if ( !empty($include) )
			$args['include'] = $include;
		else {
			$args['post_parent'] = $id;
			$args['numberposts'] = -1;
		}

		$images = get_posts($args);

		foreach ( $images as $id => $image ) {
			echo '<li>';

			$caption = (!empty($image->post_excerpt)) ? $image->post_excerpt : get_the_title($image->ID);

            $img_full = wp_get_attachment_image_src($image->ID, 'full');
            $img_thumb = wp_get_attachment_image_src($image->ID, 'full');

			if ( ! empty( $link ) && 'file' === $link )
                $image_output = '<a rel="prettyPhoto" href="' . $img_full[0] . '" title="'. $caption . '"><img src="' . $img_thumb[0] . '"></a>';
			elseif ( ! empty( $link ) && 'none' === $link )
				$image_output = wp_get_attachment_image( $image->ID, $size, false );
			else
				$image_output = wp_get_attachment_link( $image->ID, $size, true, false );

			echo $image_output;
//			echo '<div class="gallery_caption">' . $caption . '</div>';
			echo '</li>';
		}
	?>
	</ul>
	<div class="slider-loading"></div>
	</div>
	<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}


// [gallery_home_slider]
function shortcode_gallery_home_slider($atts) {
    global $post;

	if ( ! empty( $atts['ids'] ) ) {
		if ( empty( $atts['orderby'] ) )
			$atts['orderby'] = 'post__in';
		$atts['include'] = $atts['ids'];
	}

	$sliderid = rand();
	extract(shortcode_atts(array(
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'include' => '',
		'id' => $post ? $post->ID : 0,
		'pause' => '4000',
		'mode' => 'fade',
		'speed' => '1000',
	), $atts));

    ob_start();

    if(!isset($mode)) $mode = 'none';

	$args = array(
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'post_mime_type' => 'image',
		'order' => $order,
		'orderby' => $orderby
	);

	if ( !empty($include) )
		$args['include'] = $include;
	else {
		$args['post_parent'] = $id;
		$args['numberposts'] = -1;
	}

	$images = get_posts($args);

	$slides = "";
	foreach ( $images as $id => $image ) {
        $img_full = wp_get_attachment_image_src($image->ID, 'full');
        $img_thumb = wp_get_attachment_image_src($image->ID, 'thumbnail');
        $slides .= '{image : "'.$img_full[0].'", thumb : "'.$img_thumb[0].'"},'."\n";
	}?>
	<script type="text/javascript">
		jQuery(function($){
			$.supersized({
				fit_portrait: 0,
				slide_interval: <?php echo (int)$pause; ?>,
				transition: '<?php echo $mode; ?>',
				transition_speed: <?php echo (int)$speed; ?>,
				slide_links: 0,
				slides: [<?php echo $slides; ?>]
			});
		});
	</script>
	<div id="prevthumb"></div>
	<div id="nextthumb"></div>
	<div id="thumb-tray-wrapper">
		<div id="thumb-tray" class="load-item">
			<div id="thumb-back"></div>
			<div id="thumb-forward"></div>
		</div>
	</div>
	<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

remove_shortcode('gallery');
add_shortcode('gallery', 'trego_gallery_shortcode');
add_shortcode('gallery_slider', 'shortcode_gallery_slider');
add_shortcode('gallery_home_slider', 'shortcode_gallery_home_slider');
add_shortcode('product_tile_gallery', 'shortcode_product_tile_gallery');
add_shortcode('product_tile', 'shortcode_product_tile');
?>