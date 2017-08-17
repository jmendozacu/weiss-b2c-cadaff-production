<?php 
// [team_member]
function shortcode_team_member($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"name" => '',
		"title" => '',
		'facebook' => '',
		'twitter' => '',
		'linkedin' => '',
		'flickr' => '',
		'googleplus' => '',
		'img'  => '',
		'text_align' => '',
	), $atts));
	ob_start();
    if(empty($img)){
		$img = get_template_directory_uri().'/images/no-photo.png';
    }
	?>

	<div class="team-member <?php echo $text_align; ?>">
	<div class="team-member-img">
	<img src="<?php echo $img; ?>">
 	</div>

    <h4 class="member-name"><?php echo $name; ?></h4>
    <p class="member-title"><?php echo $title; ?></p>
    <div class="member-divider"></div>
    <div class="social-icons">
    <?php
		$html = "<ul class='social-links'>";
		if($facebook){
			$html .= '<li><a class="facebook" href="' . $facebook . '" title="Facebook"> </a></li>';
		}
		if($twitter){
			$html .= '<li><a class="twitter" href="' . $twitter . '" title="Twitter"> </a></li>';
		}
		if($linkedin){
			$html .= '<li><a class="linkedin" href="' . $linkedin . '" title="Linkedin"> </a></li>';
		}
		if($flickr){
			$html .= '<li><a class="flickr" href="' . $flickr . '" title="Flickr"> </a></li>';
		}
		if($googleplus){
			$html .= '<li><a class="googleplus" href="' . $googleplus . '" title="googleplus"> </a></li>';
		}
		$html .= "</ul>";
		echo $html;
		$fix = array (
			'<br>' => '', 
			'<br/>' => '',
			'<br />' => '',
			'&nbsp;' => '',
			'<p>' => '',
			'</p>' => '',
			'<p></p>' => '',
			'<p>[' => '[',
			']</p>' => ']',
			']<br/>' => ']',
			']<br />' => ']'
		);
		$content = strtr($content, $fix);
    ?>
    </div>
    <p class="member-desc"><?php echo $content; ?></p>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

// [member_slide]
function shortcode_member_slide($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"name" => '',
		"title" => '',
		'facebook' => '',
		'twitter' => '',
		'linkedin' => '',
		'flickr' => '',
		'googleplus' => '',
		'img'  => '',
        'text_align' => '',
	), $atts));
	ob_start();
    if(empty($img)){
        $img = get_template_directory_uri().'/images/no-photo.png';
    }
	?>
	<li>
	<div class="team-member <?php echo $text_align; ?>">
	<div class="team-member-img">
	<img src="<?php echo $img; ?>">
 	</div>

    <h4 class="member-name"><?php echo $name; ?></h4>
    <p class="member-title"><?php echo $title; ?></p>
    <div class="member-divider"></div>
    <p class="member-desc"><?php echo $content; ?></p>
    <div class="social-icons">
    <?php
		$html = "<ul class='social-links'>";
		if($facebook){
			$html .= '<li><a class="facebook" href="' . $facebook . '" title="Facebook"> </a></li>';
		}
		if($twitter){
			$html .= '<li><a class="twitter" href="' . $twitter . '" title="Twitter"> </a></li>';
		}
		if($linkedin){
			$html .= '<li><a class="linkedin" href="' . $linkedin . '" title="Linkedin"> </a></li>';
		}
		if($flickr){
			$html .= '<li><a class="flickr" href="' . $flickr . '" title="Flickr"> </a></li>';
		}
		if($googleplus){
			$html .= '<li><a class="googleplus" href="' . $googleplus . '" title="googleplus"> </a></li>';
		}
		$html .= "</ul>";
		echo $html;
		$fix = array (
			'<br>' => '', 
			'<br/>' => '',
			'<br />' => '',
			'&nbsp;' => '',
			'<p>' => '',
			'</p>' => '',
			'<p></p>' => '',
			'<p>[' => '[',
			']</p>' => ']',
			']<br/>' => ']',
			']<br />' => ']'
		);
		$content = strtr($content, $fix);
    ?>
    </div>
	</div>
	</li>
	<?php
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode("team_member", "shortcode_team_member");
add_shortcode("member_slide", "shortcode_member_slide");