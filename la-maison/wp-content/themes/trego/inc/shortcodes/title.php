<?php
// [title]
function shortcode_title( $atts, $content = null ){
	extract( shortcode_atts( array(
		'text' => '',
		'style' => '',
		'text_align' => 'left',
		'link' => ''
	), $atts ) );

	$link_output = '';
	$style_output = '';
	$align = '';
	if($style) $style_output = 'title_'.$style;
	if($link) $text = '<a href="'.$link.'">'.$text.'</a>';
	if($text_align) $align = ' style="text-align:' . $text_align . ';"';

	return '<div class="span-12 columns title-wrapper"><h3 class="section-title '.$style_output.'"' . $align . '>'.$text.'</h3></div>';
}

// [divider]
function shortcode_divider( $atts, $content = null ){
	extract( shortcode_atts( array(
        'width' => '50px',
        'height' => '',
        'color' => '#AAAAAA',
        'align' => 'center',
		'margin_top' => '15px',
		'margin_bottom' => '15px'
	), $atts ) );
	$style = '';
	if($width) $style = 'width:' . $width . ';';
    if($height) $style .= 'height:' . $height . ' !important;';
	if($color) $style .= 'background-color:' . $color . ';';
	if($margin_top) $style .= 'margin-top:' . $margin_top . ';';
	if($margin_bottom) $style .= 'margin-bottom:' . $margin_bottom . ';';
    if($align != 'center'){
        if($align == 'left'){
            $style .= 'margin-left: 0 !important;';
        } elseif($align == 'right') {
            $style .= 'margin-right: 0 !important;';
        }
    }

	return '<div class="divider" style="'.$style.'"></div>';
}

// [pre]
function shortcode_pre( $atts, $content = null ){
    $fix = array (
        '<br>' => '',
        '<br/>' => '',
        '<br />' => '',
        '&nbsp;' => '',
        '<p>' => '',
        '</p>' => '',
    );
    $content = strtr($content, $fix);
    $content = htmlspecialchars($content);
    return '<pre>'.$content.'</pre>';
}

add_shortcode('title', 'shortcode_title');
add_shortcode('divider', 'shortcode_divider');
add_shortcode('pre', 'shortcode_pre');
?>
