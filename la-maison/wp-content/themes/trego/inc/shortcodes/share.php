<?php
// [share]

function shareShortcode($atts, $content = null) {
	global $post;

	extract(shortcode_atts(array(
		'post_id' => '',
	), $atts));

	if(!empty($post_id)){
		$pid = $post_id;
	} else {
		$pid = $post->ID;
	}
	$permalink = get_permalink($pid);
	$featured_image =  wp_get_attachment_image_src( get_post_thumbnail_id($pid), 'thumbnail');
	$featured_image_2 = $featured_image['0'];
	$post_title = rawurlencode(get_the_title($pid)); 

	$container = '
		<div class="share-icons">
       	  	<a href="http://www.facebook.com/sharer.php?u='.$permalink.'&amp;images='.$featured_image_2.'" target="_blank" class="icon-facebook" title="Share on Facebook"> </a>
            <a href="https://twitter.com/share?url='.$permalink.'" target="_blank" class="icon-tweet" title="Share on Twitter"> </a>
            <a href="mailto:enteryour@addresshere.com?subject='.$post_title.'&amp;body=Check%20this%20out:%20'.$permalink.'" class="icon-mail" title="Email to a Friend"> </a>
       	  	<a href="http://www.linkedin.com/shareArticle?url='.$permalink.'&amp;title='.$post_title.'" target="_blank" class="icon-linkedin" title="Share on Linkedin"> </a>
       	  	<a href="https://plus.google.com/share?url='.$permalink.'" target="_blank" class="icon-googleplus" title="Share on GooglePlus"> </a>
       </div>
	';

	return $container;
} 

add_shortcode('share','shareShortcode');
?>
