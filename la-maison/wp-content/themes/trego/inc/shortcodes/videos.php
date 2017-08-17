<?php
// [youtube]
function shortcode_youtube( $atts, $content = null ){
	$ytid = rand();
	extract( shortcode_atts( array(
		'vid' => '',
		'width' => '100%',
	), $atts ) );

	if($vid){
		$style = '';
		if($width){
			$pxw = (substr($width, -1) == '%') ? '%;' : 'px;';
			$style = 'width:' . (int)$width . $pxw;
		}

		return '<div class="v-player" style="'.$style.'"><iframe type="text/html" width="100%" height="100%" src="http://www.youtube.com/embed/'.$vid.'?wmode=transparent" frameborder="0" wmode="Opaque"></iframe></div>';

	} else {
		return;
	}
}
add_shortcode('youtube', 'shortcode_youtube');

// [vimeo]
function shortcode_vimeo( $atts, $content = null ){
	$ytid = rand();
	extract( shortcode_atts( array(
		'vid' => '',
		'width' => '100%',
	), $atts ) );

	if($vid){
		$style = '';
		if($width){
			$pxw = (substr($width, -1) == '%') ? '%;' : 'px;';
			$style = 'width:' . (int)$width . $pxw;
		}

		return '<div class="v-player" style="'.$style.'"><iframe width="100%" height="100%" src="http://player.vimeo.com/video/'.$vid.'?wmode=transparent" frameborder="0" wmode="transparent"></iframe></div>';

	} else {
		return;
	}
}
add_shortcode('vimeo', 'shortcode_vimeo');