<?php
// [social_link]
function shortcode_social_link( $atts, $content = null ){
	extract( shortcode_atts( array(
		'facebook' => '',
		'twitter' => '',
		'linkedin' => '',
		'flickr' => '',
		'googleplus' => '',
		'pinterest' => '',
		'youtube' => '',
		'instagram' => ''
	), $atts ) );

	$html = "<ul class='social-links'>";
	if($facebook){
		$html .= '<li><a class="facebook" href="' . $facebook . '" title="Facebook" target="_blank"> </a></li>';
	}
	if($twitter){
		$html .= '<li><a class="twitter" href="' . $twitter . '" title="Twitter" target="_blank"> </a></li>';
	}
	if($linkedin){
		$html .= '<li><a class="linkedin" href="' . $linkedin . '" title="Linkedin" target="_blank"> </a></li>';
	}
	if($flickr){
		$html .= '<li><a class="flickr" href="' . $flickr . '" title="Flickr" target="_blank"> </a></li>';
	}
	if($googleplus){
		$html .= '<li><a class="googleplus" href="' . $googleplus . '" title="Google Plus" target="_blank"> </a></li>';
	}
	if($pinterest){
		$html .= '<li><a class="pinterest" href="' . $pinterest . '" title="Pinterest" target="_blank"> </a></li>';
	}
	if($youtube){
		$html .= '<li><a class="youtube" href="' . $youtube . '" title="YouTube" target="_blank"> </a></li>';
	}
	if($instagram){
		$html .= '<li><a class="instagram" href="' . $instagram . '" title="Instagram" target="_blank"> </a></li>';
	}
	$html .= "</ul>";
	return $html;
}

add_shortcode('social_link', 'shortcode_social_link');
