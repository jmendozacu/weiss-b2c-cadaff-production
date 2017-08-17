<?php
function bxSlider_script($sliderid, $params = array()){
	$timerid = rand();
    $ctrls_pos = ($params['ctrls_pos'] == 'top') ? 'false' : 'true';
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(window).load(function(){
                var resizeTimer_<?php echo $timerid;?>;
                var container = $('#bxslider_container_<?php echo $sliderid ?>');

                <?php if(isset($params["responsive"])) : ?>
                var responsive = <?php echo $params["responsive"]; ?>;
                <?php endif; ?>

                <?php if(isset($params["pager"])) : ?>
                var pager = <?php echo $params["pager"]; ?>;
                <?php else : ?>
                var pager = false;
                <?php endif; ?>

                var opts = {
                    auto: <?php echo $params["auto"]; ?>,
                    pause: <?php echo (int)$params["pause"]; ?>,
                    controls: <?php echo $ctrls_pos; ?>,
                    mode: '<?php echo $params["mode"]; ?>',
                    speed: <?php echo (int)$params["speed"]; ?>,
                    infiniteLoop: <?php echo $params["infinite_loop"]; ?>,
                    maxSlides: <?php echo (int)$params["max_slides"]; ?>,
                    minSlides: <?php echo (int)$params["max_slides"]; ?>,
                    moveSlides: <?php echo (int)$params["move_slides"]; ?>,
                    slideWidth: getSlideWidth(container, <?php echo (int)$params["max_slides"]; ?>),
                    slideMargin: <?php echo (int)$params["slide_margin"]; ?>,
                    pager: pager,
                    adaptiveHeight: <?php echo $params["auto_height"]; ?>,
                    onSliderLoad: function(idx){
                        setTimeout(function(){
                            $('#bxslider_container_<?php echo $sliderid ?>').css('max-height', 'none');
                            $('#bxslider_container_<?php echo $sliderid ?>').css('overflow', 'none');
                        }, 200);
                        $('#bxslider_container_<?php echo $sliderid ?> .bxslide:eq('+idx+')').css('display', 'table');
                        $('#bxslider_container_<?php echo $sliderid ?> .banner:eq('+idx+')').css('display', 'table');
                        $('#bxslider_container_<?php echo $sliderid ?> .slider-loading').fadeOut();
                        $('#bxslider_container_<?php echo $sliderid ?> .inner-box.animated').each(function(){
                            $(this).addClass($(this).attr('data-animate'));
                        });
                        $('#bxslider_container_<?php echo $sliderid ?> .inner-box.animation-group').each(function(){
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
                        <?php if($params["auto"] == 'true') { ?>
                        var delay_time = <?php echo (int)$params["pause"]; ?> - 2000;
                        setTimeout(function(){
                            $('#bxslider_container_<?php echo $sliderid ?> .inner-box.animation-group').each(function(){
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
                    onSlideBefore: function(){
                        $('#bxslider_container_<?php echo $sliderid ?> .inner-box.animated').addClass('fadeOut');
                        $('#bxslider_container_<?php echo $sliderid ?> .inner-box.animated').each(function(){
                            $(this).removeClass($(this).attr('data-animate'));
                        });
                        $('#bxslider_container_<?php echo $sliderid ?> .inner-box.animation-group').each(function(){
                            var ani_group = $(this);
                            ani_group.find('.animation').each(function(){
                                var data_easing = $(this).attr("data-easing");
                                var data_endeasing = $(this).attr("data-endeasing");
                                var data_start = 'delay-' + $(this).attr("data-start");
                                var data_end = 'delay-' + $(this).attr("data-end");

                                $(this).removeClass(data_start);
                                $(this).removeClass(data_end);
                                $(this).removeClass(data_easing);
                                $(this).removeClass(data_endeasing);
                            });
                        });
                    },
                    onSlideAfter: function(obj){
                        $('#bxslider_container_<?php echo $sliderid ?> .inner-box.animated').removeClass('fadeOut');
                        $('#bxslider_container_<?php echo $sliderid ?> .inner-box.animated').each(function(){
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
                        <?php if($params["auto"] == 'true') { ?>
                        var delay_time = <?php echo (int)$params["pause"]; ?> - 2000;
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
                    },
                    <?php if(isset($params["responsive"])) : ?>
                    responsive: <?php echo $params["responsive"]; ?>
                    <?php endif; ?>
                };

                var bxSlider_<?php echo $sliderid ?> = $('#bxslider_<?php echo $sliderid ?>').bxSlider(opts);

                resizeFunction(bxSlider_<?php echo $sliderid ?>, container, <?php echo (int)$params["max_slides"]; ?>, opts);

                $(window).resize(function() {
                    if(!($.browser.msie && parseInt($.browser.version, 10) === 8)){
	                    clearTimeout(resizeTimer_<?php echo $timerid;?>);
	                    resizeTimer_<?php echo $timerid;?> = setTimeout(
	                        function(){
	                            resizeFunction(bxSlider_<?php echo $sliderid ?>, container, <?php echo (int)$params["max_slides"]; ?>, opts)
	                        }, 250);
                    }
                });

                <?php if($params["auto"] == 'true') { ?>
                $('#bxslider_container_<?php echo $sliderid ?> .bx-controls-direction a, #bxslider_container_<?php echo $sliderid ?> .bx-wrapper .bx-pager a').click(function(e){
                    sliderAutoStart(bxSlider_<?php echo $sliderid ?>, <?php echo (int)$params["pause"]; ?>);
                });
                <?php } ?>

                <?php if($params['ctrls_pos'] == 'top'){?>
                $('#btn_prev_<?php echo $sliderid ?>').click(function(){
                    bxSlider_<?php echo $sliderid ?>.goToPrevSlide();
                    <?php if($params["auto"] == 'true') { ?>
                        bxSlider_<?php echo $sliderid ?>.stopAuto();
                        setTimeout(function(){
                            bxSlider_<?php echo $sliderid ?>.startAuto();
                        }, <?php echo (int)$params["pause"]; ?>);
                    <?php } ?>
                    return false;
                });

                $('#btn_next_<?php echo $sliderid ?>').click(function(){
                    bxSlider_<?php echo $sliderid ?>.goToNextSlide();
                    <?php if($params["auto"] == 'true') { ?>
                        bxSlider_<?php echo $sliderid ?>.stopAuto();
                        setTimeout(function(){
                            bxSlider_<?php echo $sliderid ?>.startAuto();
                        }, <?php echo (int)$params["pause"]; ?>);
                    <?php } ?>
                    return false;
                });
                <?php } ?>
            });
        });
    </script>
<?php
}

// [slide]
function shortcode_slide( $atts, $content = null ){
    extract( shortcode_atts( array(
        'height' => '235px',
        'width' => '100%',
        'link' => '',
        'img' => '',
        'text_width' => '',
        'text_align' => 'center',
        'text_position' => 'center middle',
        'text_color' => '#FFFFFF',
        'animation' => 'flipInY',
        'animation_group' => 'false',
        'bground' => '#666666'
    ), $atts ) );

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
    $content = do_shortcode( $content );

    $animated = "";
    if($animation != "none") $animated = "animated";
    if($animation_group == "true") $animated = "animation-group";

    $start_link = "";
    $end_link = "";
    if($link) {$start_link = '<a href="'.$link.'">'; $end_link = '</a>';};

    $background = "";
    $background_color = "";
    if (strpos($bground,'http://') !== false) {
        $background = 'background-image:url(' . $bground . ');';
    } elseif (strpos($bground,'#') !== false) {
        $background_color = 'background-color:' . $bground . ' !important;';
    } else {
        $bground = 'none';
    }

    $txtAlign = "";
    if($text_align) {$txtAlign = "text-".$text_align;}

    $style = "";
    if($text_width) {$style = 'width:' . $text_width . ' !important;';}
    if($text_color) {$style .= 'color:' . $text_color . ';';}
    $slide = '<li class="bxslide ' . '" style="height:' . $height . '; width:' . $width . '">';
    $slide .= $start_link;
    if($img){
        $slide .= '<img src="' . $img . '" alt="">';
    } else {
        $slide .= '<div class="outer-box ' . $text_position . '">';
        $slide .= ' <div class="inner-box ' . $animated . ' ' .  $txtAlign . '" data-animate="' . $animation . '" style="' . $style . '">';
        $slide .=       $content;
        $slide .= ' </div>';
        $slide .= '</div>';
        if($bground != 'none'){
            $slide .= '<div class="banner-bground" style="' . $background . ' ' . $background_color . '"></div>';
        }
    }
    $slide .= $end_link . '</li>';
    return $slide;
}

// [bxslider]
function shortcode_bxslider($atts, $content=null) {
    $sliderid = rand();
    ob_start();
    extract(shortcode_atts(array(
        'title' => '',
        'auto' => 'true',
        'pause' => '7000',
        'width' => '100%',
        'mode' => 'horizontal',
        'speed' => '700',
        'loop' => 'true',
        'max_slides' => '1',
        'move_slides'  => '1',
        'slide_margin' => '0',
        'bgcolor' => '',
        'auto_height' => 'true',
        'margin_bottom' => '',
        'ctrls_size' => 'large',
        'ctrls_pos' => 'default',
        'class' => '',
        'pager' => 'false',
        'responsive' => ''
    ), $atts));

    if($max_slides > 1) $pager = 'false';

    $params = array(
        'auto' => $auto,
        'pause' => $pause,
        'mode' => $mode,
        'speed' => (int)$speed,
        'infinite_loop' => $loop,
        'max_slides' => (int)$max_slides,
        'move_slides'  => (int)$move_slides,
        'slide_margin' => (int)$slide_margin,
        'pager' => $pager,
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
    </div>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode("slide", "shortcode_slide");
add_shortcode("bxslider", "shortcode_bxslider");

