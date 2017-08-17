<?php
	
	/*
	*
	*	Trego Functions - Child Theme
	*	------------------------------------------------
	*	These functions will override the parent theme
	*	functions. We have provided some examples below.
	*
	*
	*/

add_action('wp_enqueue_scripts', 'trego_child_css', 100);
 
// Load CSS
function trego_child_css() {
    // trego child theme styles
    wp_deregister_style( 'styles-child' );
    wp_register_style( 'styles-child', get_bloginfo('stylesheet_directory') . '/style.css' );
    wp_enqueue_style( 'styles-child' );
}

function theme_js() {
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'theme_js', get_template_directory_uri() . '-child/js/custom.js', array( 'jquery' ), '1.0', true );
}

add_action('wp_enqueue_scripts', 'theme_js', 100);


/*
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
*/




