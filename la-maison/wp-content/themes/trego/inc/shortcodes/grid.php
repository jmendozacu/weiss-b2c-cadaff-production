<?php 
// [row]
function shortcode_row($atts = array(), $content = null) {
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
	$container = '<div class="row-container"><div class="row">'.$content.'</div></div>';
	return $container;
} 

function span_width_calc($span) {

	$tmp = explode("/", $span);
	$a = (int)$tmp[0];
	$b = (int)$tmp[1];

	if(!$b) return 3;

    return (($a / $b) * 12);
}

// [col]
function shortcode_col($atts, $content = null) {
	extract( shortcode_atts( array(
		'span' => '3',
        'text_align' => '',
	), $atts ) );

	$span = span_width_calc($span);

    $style = "";
    if($text_align){
        $style = ' style="text-align: ' . $text_align . ';"';
    }

	$content = do_shortcode($content);
	$column = '<div class="span-'.$span.'  span-m-6 span-s-12 column" ' . $style . '>'.$content.'</div>';
	return $column;
}

// [spacebar]
function shortcode_spacebar($atts, $content = null) {
	extract( shortcode_atts( array(
		'height' => '10',
	), $atts ) );

	$div = '<div style="height:' . (int)$height . 'px;"></div>';
	return $div;
}

add_shortcode('col', 'shortcode_col');
add_shortcode('row', 'shortcode_row');
add_shortcode('spacebar', 'shortcode_spacebar');