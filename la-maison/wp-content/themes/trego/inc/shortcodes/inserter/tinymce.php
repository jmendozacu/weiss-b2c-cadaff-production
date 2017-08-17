<?php

class TinyMCE_Buttons {
	function __construct() {
    	add_action( 'init', array(&$this,'init') );
    }
    function init() {
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;		
		if ( get_user_option('rich_editing') == 'true' ) {

			add_filter( 'mce_external_plugins', array(&$this, 'add_plugin') );
			add_filter( 'mce_buttons', array(&$this,'register_button') );

		}  
    }  

	function add_plugin($plugin_array) {
		global $wp_version;
		$args = array(
			'post_type' => 'blocks',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		);

		$query = new WP_Query();
		$custom_query = $query->query($args);

		$blocks = '';

		if ( is_array($custom_query) ) {
			$first = true;
			foreach ( $custom_query as $post ){
				$block_title = $post->post_title;
				$block = $post->post_name;
				if(!$first) $blocks .= ',';
				if ( version_compare( $wp_version, "3.9" ) >= 0 ) {
					$blocks .= "{text: \"" . addslashes($block_title) . "\", value: '[block id=\"".$block."\"]'}";
				} else {
					$blocks .= "'[block id=\"" . $block . "\"]'";
				}
				$first = false;
			}
		}?>
		<script type="text/javascript">
			var block_shortcodes = [<?php echo $blocks; ?>];
		</script>
		<?php
		if ( version_compare( $wp_version, "3.9" ) >= 0 ) {
			$plugin_array['shortcodes'] = get_template_directory_uri() .'/inc/shortcodes/inserter/js/tinymce4.js';
		} else {
			$plugin_array['shortcodes'] = get_template_directory_uri() .'/inc/shortcodes/inserter/js/tinymce.js';
		}
		return $plugin_array;
	}

	function register_button($buttons) {
		array_push($buttons, "shortcodes", "blocks");
		return $buttons;
	}
}

$shortcode = new TinyMCE_Buttons;