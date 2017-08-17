<?php
// [banner]
function bannerShortcode( $atts, $content = null ){
	$bannerid = rand();
	extract( shortcode_atts( array(
		'height' => '235px',
		'width' => '100%',
		'link' => '',
		'text_width' => '',
		'text_align' => 'center',
		'text_position' => 'center middle',
		'text_color' => '#FFFFFF',
		'animation' => 'flipInY',
        'animation_group' => 'false',
		'bground' => '#666666',
        'margin_bottom' => '0',
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

	$banner ='
		<div id="banner_' . $bannerid . '" class="animation-group banner ' . '" style="height:' . $height . '; width:' . $width . '; margin-bottom:' . $margin_bottom . ';">
		'. $start_link .' 
			<div class="outer-box ' . $text_position . '">
				<div class="inner-box ' . $animated . ' ' .  $txtAlign . '" data-animate="' . $animation . '" style="' . $style . '">
				'.$content.'
				</div>  
			</div>';
	if($bground != 'none'){
		$banner .= '<div class="banner-bground" style="' . $background . ' ' . $background_color . '"></div>';
	}
	$banner .= $end_link .'</div>';

	return $banner;
}
add_shortcode('banner', 'bannerShortcode');
