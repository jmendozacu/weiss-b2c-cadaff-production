<?php
if(isset($trego_vars['font_primary']) || isset($trego_vars['font_head']) || isset($trego_vars['font_menu']) || isset($trego_vars['font_button']) || isset($trego_vars['font_price_1']) || isset($trego_vars['font_price_2']) || isset($trego_vars['font_widget_title']) || isset($trego_vars['font_title_1']) || isset($trego_vars['font_title_2']) || isset($trego_vars['font_other_1']) || isset($trego_vars['font_other_2']) || isset($trego_vars['font_other_3'])){
	$customfont = '';
	$default = array(
			'arial',
			'verdana',
			'trebuchet',
			'georgia',
			'times',
			'tahoma',
			'helvetica',
			'Raleway',
			'Lato',
		);
	$googlefonts = array(
			$trego_vars['font_primary'],
			$trego_vars['font_head'],
			$trego_vars['font_menu'],
			$trego_vars['font_button'],
			$trego_vars['font_price_1'],
			$trego_vars['font_price_2'],
			$trego_vars['font_widget_title'],
			$trego_vars['font_title_1'],
			$trego_vars['font_title_2'],
			$trego_vars['font_other_1'],
			$trego_vars['font_other_2'],
			$trego_vars['font_other_3']
		);

	foreach($googlefonts as $googlefont) {
		if(empty($googlefont)) continue;
		if(!in_array($googlefont, $default)) {
			$customfont = str_replace(' ', '+', $googlefont). ':300,300italic,400,400italic,700,700italic,900,900italic|' . $customfont;
		}
	}

	if ($customfont != "") {
		function google_fonts() {	
			global $customfont;		
			$protocol = is_ssl() ? 'https' : 'http';
			wp_enqueue_style( 'trego-googlefonts', "$protocol://fonts.googleapis.com/css?family=". substr_replace($customfont ,"",-1));
		}
		add_action( 'wp_enqueue_scripts', 'google_fonts' );
	}
}
?>
