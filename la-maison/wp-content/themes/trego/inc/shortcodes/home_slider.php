<?php
// [home_slider]
function shortcode_homeSlider($atts, $content=null) {
    $sliderid = rand();
    ob_start();
    extract(shortcode_atts(array(
        'auto' => 'true',
        'pause' => '2000',
        'mode' => 'fade',
//        'speed' => '1000',
        'speed' => '0',
        'pager' => 'false'
    ), $atts));
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(window).load(function(){
                var resizeTimer;

                var opts = {
                    auto: <?php echo $auto; ?>,
                    pause: <?php echo (int)$pause; ?>,
                    mode: '<?php echo $mode; ?>',
                    speed: <?php echo (int)$speed; ?>,
                    infiniteLoop: true,
                    maxSlides: 1,
                    minSlides: 1,
                    moveSlides: 1,
                    slideMargin: 0,
                    pager: <?php echo $pager; ?>,
                    adaptiveHeight: false,
                    onSliderLoad: function(idx){
                        $('.bgslider .bxslide:eq('+idx+')').css('display', 'table');
                        $('.fullscreen .slider-loading, .section-block.primary .slider-loading').fadeOut();
                        $('.bgslider .slide-wrapper .content-box.animated, .bgslider .bxslide .inner-box.animated').each(function(){
                              $(this).addClass($(this).attr('data-animate'));
                        });
                        $('.bgslider .bxslide .inner-box.animation-group').each(function(){
                            var ani_group = $(this);
                            ani_group.find('.animation').each(function(){
                                var data_easing = $(this).attr("data-easing");
                                var data_endeasing = $(this).attr("data-endeasing");
                                var data_start = 'delay-' + $(this).attr("data-start");
                                var data_end = 'delay-' + $(this).attr("data-end");
                                ani_group.css('overflow', 'visible');

                                $(this).addClass(data_easing);
                                $(this).addClass(data_start);
                            });
                        });
                        <?php if($auto == 'true') { ?>
                        var delay_time = <?php echo (int)$pause; ?> - 2000;
                        setTimeout(function(){
                            $('.bgslider .bxslide .inner-box.animation-group').each(function(){
                                var ani_group = $(this);
                                ani_group.find('.animation').each(function(){
                                    var data_easing = $(this).attr("data-easing");
                                    var data_endeasing = $(this).attr("data-endeasing");
                                    var data_start = 'delay-' + $(this).attr("data-start");
                                    var data_end = 'delay-' + $(this).attr("data-end");
                                    $(this).removeClass(data_start);
                                    $(this).addClass(data_end);
                                    $(this).addClass(data_endeasing);
                                    $(this).removeClass(data_easing);
                                });
                            });
                        }, delay_time);
                        <?php } ?>
                    },
                    onSlideBefore: function(obj, oldIdx, newIdx){
                        $('.bgslider .slide-wrapper .content-box.animated, .bgslider .bxslide .inner-box.animated').addClass('fadeOut');
                        $('.bgslider .slide-wrapper .content-box.animated, .bgslider .bxslide .inner-box.animated').each(function(){
                            $(this).removeClass($(this).attr('data-animate'));
                        });
                        obj.find('.inner-box.animation-group .animation').each(function(){
                            var data_easing = $(this).attr("data-easing");
                            var data_endeasing = $(this).attr("data-endeasing");
                            var data_start = 'delay-' + $(this).attr("data-start");
                            var data_end = 'delay-' + $(this).attr("data-end");

                            $(this).removeClass(data_start);
                            $(this).removeClass(data_end);
                            $(this).removeClass(data_easing);
                            $(this).removeClass(data_endeasing);
                        });
                    },
                    onSlideAfter: function(obj, oldIdx, newIdx){
                        $('.bgslider .slide-wrapper .content-box.animated, .bgslider .bxslide .inner-box.animated').removeClass('fadeOut');
                        $('.bgslider .slide-wrapper .content-box.animated, .bgslider .bxslide .inner-box.animated').each(function(){
                            $(this).addClass($(this).attr('data-animate'));
                        });
                        obj.find('.inner-box.animation-group .animation').each(function(){
                            var data_easing = $(this).attr("data-easing");
                            var data_endeasing = $(this).attr("data-endeasing");
                            var data_start = 'delay-' + $(this).attr("data-start");
                            var data_end = 'delay-' + $(this).attr("data-end");

                            $(this).removeClass(data_end);
                            $(this).addClass(data_easing);
                            $(this).addClass(data_start);
                            $(this).removeClass(data_endeasing);
                        });
                        <?php if($auto == 'true') { ?>
                        var delay_time = <?php echo (int)$pause; ?> - 2000;
                        setTimeout(function(){
                            obj.find('.inner-box.animation-group .animation').each(function(){
                                var data_easing = $(this).attr("data-easing");
                                var data_endeasing = $(this).attr("data-endeasing");
                                var data_start = 'delay-' + $(this).attr("data-start");
                                var data_end = 'delay-' + $(this).attr("data-end");

                                $(this).removeClass(data_start);
                                $(this).addClass(data_endeasing);
                                $(this).addClass(data_end);
                                $(this).removeClass(data_easing);
                            });
                        }, delay_time);
                        <?php } ?>
                    }
                };

                var bgSlider = $('.bgslider').bxSlider(opts);

                <?php if($auto == 'true') { ?>
                $('.bx-wrapper .bx-controls-direction a, .bx-wrapper .bx-pager a').click(function(e){
                    sliderAutoStart(bgSlider, <?php echo (int)$pause; ?>);
                });
                <?php } ?>

                $(window).resize(function() {
                    // if(!($.browser.msie  && parseInt($.browser.version, 10) === 8)){
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(
                        function(){
                            bgSlider.reloadSlider(opts);
                        }, 250);
                    // }
                });

                $('.slide-wrapper .nav-box a.bg-prev, .animation-group .animation a.btn-prev').click(function(){
                    bgSlider.goToPrevSlide();
                    <?php if($auto == 'true') { ?>
                    bgSlider.stopAuto();
                    setTimeout(function(){
                        bgSlider.startAuto();
                    }, <?php echo (int)$pause; ?>);
                    <?php } ?>
                });

                $('.slide-wrapper .nav-box a.bg-next, .animation-group .animation a.btn-next').click(function(){
                    bgSlider.goToNextSlide();
                    <?php if($auto == 'true') { ?>
                    bgSlider.stopAuto();
                    setTimeout(function(){
                        bgSlider.startAuto();
                    }, <?php echo (int)$pause; ?>);
                    <?php } ?>
                });
            });
        });
    </script>
    <ul class="bgslider">
        <?php
        $fix = array (
            '<br>' => '',
            '<br/>' => '',
            '<br />' => '',
            '&nbsp;' => '',
            '<p></p>' => '',
            '<p> </p>' => '',
            '<p>&nbsp;</p>' => '',
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br>' => ']',
            ']<br/>' => ']',
            ']<br />' => ']'
        );
        $content = strtr($content, $fix);
        echo do_shortcode($content);
        ?>
    </ul>
    <div class="slider-loading"></div>
    <div class="slider-arrow-down"><a href="#les-weiss-header"><span></span></a></div>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

// [bgslide]
function shortcode_bgslide($atts, $content=null) {
	ob_start();
	extract(shortcode_atts(array(
		"img" => '',
		"type" => '',
		"title" => '',
		'animation' => 'fadeIn',
        'animation_group' => 'false'
	), $atts));

	$slide_type = "";

	if($type){
		$slide_type = $type;
	}

	$animated = "";
	if($animation != "none") $animated = "animated";
    if($animation_group == "true") $animated = "animation-group";

	$background = "";
	if($img){
		$background = ' style="background-image:url('.$img.');"';
	}
	?>
	<li class="slide-wrapper <?php echo $slide_type; ?>">
		<div class="content-box <?php echo $animated; ?>" data-animate="<?php echo $animation; ?>">
			<div class="inner">
                            <span class="inner-wrapper">
				<h2><?php echo $title; ?></h2>
				<p><?php echo $content; ?></p>
                            </span>    
			</div>
			<div class="nav-box">
				<a class="bg-prev" href="javascript:void(0)"></a>
				<a class="bg-next" href="javascript:void(0)"></a>
			</div>
		</div>
		<?php if($background !="") : ?>
		<div class="bground" <?php echo $background; ?>></div>
		<?php endif; ?>
	</li>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

// [animation]
function shortcode_animation($atts, $content=null) {
    ob_start();
    extract(shortcode_atts(array(
        "tag" => 'div',
        "class" => '',
        "data_easing" => 'slideInRight',
        "data_endeasing" => 'slideOutRight',
        'data_start' => '1',
        'data_end' => '1',
        'style' => ''
    ), $atts));
        if(empty($tag)){
            $tag = 'div';
        }
    ?>
    <<?php echo $tag; ?> class="animation <?php echo $class; ?>" data-easing="<?php echo $data_easing; ?>" data-endeasing="<?php echo $data_endeasing; ?>" data-start="<?php echo $data_start; ?>" data-end="<?php echo $data_end; ?>" style="<?php echo $style; ?>">
    <?php
        $fix = array (
           '<br>' => '',
           '<br/>' => '',
           '<br />' => '',
           '&nbsp;' => '',
           '<p></p>' => '',
           '<p> </p>' => '',
           '<p>&nbsp;</p>' => '',
           '<p>[' => '[',
           ']</p>' => ']',
           ']<br>' => ']',
           ']<br/>' => ']',
           ']<br />' => ']'
        );
        $content = strtr($content, $fix);
        echo do_shortcode( $content );
    ?>
    </<?php echo $tag; ?>>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

// [video_background]
function shortcode_video_background($atts, $content=null){
	ob_start();
	extract(shortcode_atts(array(
		'youtube' => '',
		'video_mp4' => '',
		'video_ogv' => '',
		'video_webm' => '',
		'video_img' => '',
		'mute' => 'true',
		'loop' => 'true',
	), $atts));

	if($youtube):
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('body').prepend('<div class="video-bground" data-property="{videoURL:\'<?php echo $youtube; ?>\', containment:\'body\', autoPlay:true, mute:false, startAt:0, opacity:1, showYTLogo:false, addRaster:true}"></div>');
			jQuery('.video-bground').mb_YTPlayer();
		});
	</script>
	<?php else: ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		<?php
		$video_file = '';
		if($video_mp4){
			$video_file .= '["'.$video_mp4.'", "video/mp4"],';
		}
		if($video_webm){
			$video_file .= '["'.$video_webm.'", "video/webm"],';
		}
		if($video_ogv){
			$video_file .= '["'.$video_ogv.'", "video/ogg"],';
		}
		?>
		<?php if($video_file != '') : ?>
			$('body').prepend('<div class="video-bground"></div>');
			$('.video-bground').videoBG({
				zIndex: 0,
				<?php if($video_mp4): ?>
				mp4: '<?php echo $video_mp4;?>',
				<?php endif; ?>
				<?php if($video_ogv): ?>
				ogv: '<?php echo $video_ogv;?>',
				<?php endif; ?>
				<?php if($video_webm): ?>
				webm: '<?php echo $video_webm;?>',
				<?php endif; ?>
				<?php if($video_img): ?>
				poster: '<?php echo $video_img;?>',
				<?php endif; ?>
				scale: true,
			});
		<?php endif; ?>
		});
	</script>
	<?php
	endif;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

// [product_slider]
function shortcode_productSlider($atts, $content=null) {
	$GLOBALS['product_list'] = array();
	$GLOBALS['product_count'] = 0;

	ob_start();

	if (class_exists('Woocommerce')) {
		$fix = array (
	        '<br>' => '',
	        '<br/>' => '',
	        '<br />' => '',
	        '&nbsp;' => '',
	        '<p></p>' => '',
	        '<p> </p>' => '',
	        '<p>&nbsp;</p>' => '',
	        '<p>[' => '[',
	        ']</p>' => ']',
	        ']<br>' => ']',
	        ']<br/>' => ']',
	        ']<br />' => ']'
	    );
		$content = strtr($content, $fix);
		$content = do_shortcode($content);

		if( is_array( $GLOBALS['product_list'] ) ){
			foreach( $GLOBALS['product_list'] as $product ){
				$product_desc = '<div class="ps-content">';
				$product_desc.= '<h2>' . $product['product_cat'] . '</h2>';
				$product_desc.= '<h1>' . $product['title'] . '</h1>';
				$product_desc.= '<span class="ps-price">' . $product['price_html'] . '</span>';
				$product_desc.= '<p>' . $product['desc'] . '</p>';
				$product_desc.= '<a class="btn-type" href="' . $product['link'] . '">' . __('Shop Now', 'trego') . '</a>';
				$product_desc.= '</div>';
				$product_img = '<div style="background-image:url(' . $product['image'] . ');"></div>';
				$ps_contents[] = $product_desc;
				$ps_images[] = $product_img;
			}
		}
	    ?>
		<div id="ps-container" class="ps-container">
			<div class="ps-contentwrapper">
			<?php
			foreach( $ps_contents as $detail ){
				echo $detail;
			}
			?>
			</div>
			<div class="ps-slidewrapper">
				<div class="ps-slides">
				<?php
				foreach( $ps_images as $img ){
					echo $img;
				}
				?>
				</div>
				<nav>
					<a href="#" class="ps-prev" ></a>
					<a href="#" class="ps-next" ></a>
				</nav>
			</div><!-- /ps-slidewrapper -->
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(window).load(function(){
				Slider.init();
			});
		});
		</script>
	    <?php
	}
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

// [product_slide]
function shortcode_productSlide($atts, $content=null) {
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

		if(strlen($desc) > 256){
			$desc = substr($desc, 0, 256) . ' &middot;&middot;&middot;';
		}

		$price_html = $product->get_price_html();
		$img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');

		$image = (!empty($image)) ? $image : $img_src[0];

		$item['id'] = $id;
		$item['title'] = $title;
		$item['product_cat'] = $product_cat;
		$item['image'] = $image;
		$item['price_html'] = $price_html;
		$item['desc'] = $desc;
		$item['link'] = get_permalink($id);

		$k = $GLOBALS['product_count'];
		$GLOBALS['product_list'][$k] = $item;
		$GLOBALS['product_count']++;
	}

	wp_reset_postdata();
}

add_shortcode("bgslide", "shortcode_bgslide");
add_shortcode("home_slider", "shortcode_homeSlider");
add_shortcode("video_background", "shortcode_video_background");
add_shortcode("animation", "shortcode_animation");
add_shortcode("product_slider", "shortcode_productSlider");
add_shortcode("product_slide", "shortcode_productSlide");
?>
