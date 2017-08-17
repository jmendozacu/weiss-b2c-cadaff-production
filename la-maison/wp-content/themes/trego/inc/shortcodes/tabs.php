<?php
// [tabgroup]
function shortcode_tabgroup( $atts, $content = null ) {
	$GLOBALS['tabs'] = array();
	$GLOBALS['count'] = 0;
	$i = 1;
	$tabid = rand();

	extract(shortcode_atts(array(
		'title' => '',
		'tab_position' => '',
		'active_index' => '1',
		'margin_bottom' => '30px'
	), $atts));

	$position = '';
	switch ($tab_position) {
		case 'bottom':
			$position = 'tabs-below';
			break;
		case 'left':
			$position = 'tabs-left';
			break;
		case 'right':
			$position = 'tabs-right';
			break;
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

	$content = do_shortcode($content);

	if( is_array( $GLOBALS['tabs'] ) ){

		foreach( $GLOBALS['tabs'] as $tab ){
			if($i == $active_index){
				$tabs[] = '<li class="active"><a data-toggle="tab" href="#tab_'.$tabid.$i.'">'.$tab['title'].'</a></li>';
				$tab_contents[] = '<div class="tab-pane active" id="tab_'.$tabid.$i.'">'.do_shortcode($tab['content']).'</div>';
			} else {
				$tabs[] = '<li><a data-toggle="tab" href="#tab_'.$tabid.$i.'">'.$tab['title'].'</a></li>';
				$tab_contents[] = '<div class="tab-pane" id="tab_'.$tabid.$i.'">'.do_shortcode($tab['content']).'</div>';
			}
			$i++;
		}

		$return = "<div class='tabbable " . $position . "' " . $margin . ">\r\n";
		if($title){
			$return .= "<h3>".$title."</h3>\r\n";
		}
		if($position != 'tabs-below'){
			$return .= "<ul class='nav-panel nav-tabs'>" . implode("\r\n", $tabs) . "</ul>\r\n";
		}
		$return .= "<div class='tab-content'>\r\n";
		$return .= implode( "\r\n", $tab_contents );
		$return .= "</div>\r\n";
		if($position == 'tabs-below'){
			$return .= "<ul class='nav-panel nav-tabs'>" . implode("\r\n", $tabs) . "</ul>\r\n";
		}
		$return .= "</div>\r\n";
	}
	return $return;
}

function tab( $atts, $content = null) {
	extract(shortcode_atts(array(
		'title' => ''
	), $atts));

	$k = $GLOBALS['count'];

	$GLOBALS['tabs'][$k] = array( 'title' => sprintf( $title, $GLOBALS['count'] ), 'content' =>  $content );
	$GLOBALS['count']++;
}


add_shortcode('tabgroup', 'shortcode_tabgroup');
add_shortcode('tab', 'tab');
?>