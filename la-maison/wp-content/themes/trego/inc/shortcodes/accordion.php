<?php 
// [accordion]
function shortcode_accordion($atts, $content = null) {
	$GLOBALS['items'] = array();
	$GLOBALS['cnt'] = 0;

	ob_start();

	$i = 1;
	$accordionid = rand();

	extract(shortcode_atts(array(
		'title' => '',
		'toggle' => 'false',
		'toggle_position' => 'right',
		'active_index' => '1',
		'margin_bottom' => '30px'
	), $atts));

	$pos = "";
	if($toggle_position == 'left'){
		$pos = ' toggle-left';
	}
	
	$parent = "";
	if($toggle == 'false'){
		$parent = 'data-parent="#accordion_' . $accordionid . '"';
	}

	$margin = "";
	if($margin_bottom){
		$margin = ' style="margin-bottom:' . $margin_bottom . ';"';
	}

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

	if( is_array( $GLOBALS['items'] ) ){
		echo "<div id='accordion_".$accordionid."' class='accordion'" . $margin . ">\r\n";
		if($title){
			echo "<h3>".$title."</h3>\r\n";
		}

		foreach( $GLOBALS['items'] as $item ){
			if($i == $active_index){
				$class_h = 'accordion-toggle';
				$class = 'in collapse';
			} else {
				$class_h = 'accordion-toggle collapsed';
				$class = 'collapse';
			}
			?>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="<?php echo $class_h; ?><?php echo $pos; ?>" data-toggle="collapse" <?php echo $parent; ?> href="#accordion_<?php echo $accordionid.$i; ?>">
						<?php echo $item['title']; ?>
						<span class="icon-toggle"></span>
					</a>
				</div>
				<div id="accordion_<?php echo $accordionid.$i; ?>" class="<?php echo $class; ?>">
					<div class="accordion-inner">
						<?php echo do_shortcode($item['content']); ?>
					</div>
				</div>
			</div>
			<?php
			$i++;
		}
		echo "</div>\r\n";
	}

	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

function shortcode_accordion_item($atts, $content=null) {
	extract(shortcode_atts(array(
		'title' => ''
	), $atts));

	$k = $GLOBALS['cnt'];

	$GLOBALS['items'][$k] = array( 'title' => sprintf( $title, $GLOBALS['cnt'] ), 'content' =>  $content );
	$GLOBALS['cnt']++;
}

add_shortcode('accordion', 'shortcode_accordion');
add_shortcode('accordion_item', 'shortcode_accordion_item');
?>