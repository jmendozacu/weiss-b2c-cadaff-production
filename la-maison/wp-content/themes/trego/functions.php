<?php
/**
 * Trego functions and definitions
 *
 * @package Trego
 * @since Trego 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) $content_width = 860; /* pixels */

/* Add theme option panel */
require_once('admin/index.php');

global $trego_vars;
$trego_vars = $smof_data;

/** Load selected google fonts */
include_once('inc/google-fonts.php');

require_once('inc/metaboxes.php');
require_once('inc/menus.php');

/************ Plugin recommendations **********/
require_once ('inc/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'trego_register_required_plugins' );
function trego_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'     				=> 'WooCommerce', // The plugin name
			'slug'     				=> 'woocommerce', // The plugin slug (typically the folder name)
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),

		array(
			'name'     				=> 'Contact Form 7',
			'slug'     				=> 'contact-form-7',
			'required' 				=> false,
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		array(
			'name'     				=> 'Revolution Slider',
			'slug'     				=> 'revslider',
			'source'   				=> get_stylesheet_directory() . '/inc/plugins/revslider.zip',
			'required' 				=> false,
			'version' 				=> '4.6.0',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

		array(
			'name'     				=> 'YITH WooCommerce Wishlist',
			'slug'     				=> 'yith-woocommerce-wishlist',
			'required' 				=> false,
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),

	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'trego',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', '' ),
			'menu_title'                       			=> __( 'Install Plugins', 'trego' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'trego' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'trego' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'trego' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'trego' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'trego' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}


/**
 * Trego setup.
 * @since Trego 1.0
 * @return void
 */
function trego_setup() {

	load_theme_textdomain( 'trego', get_template_directory() . '/languages' );

	require( get_template_directory() . '/inc/custom-css.php' );

	/* INCLUDES Woocommerce theme */
	add_theme_support( 'woocommerce' );

	if (class_exists('Woocommerce')) {
		if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );
		} else {
			define( 'WOOCOMMERCE_USE_CSS', false );
		}
	}
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor.css', 'css/fonts.css' ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	/*
	 * This theme supports all available post formats by default.
	 */
	add_theme_support( 'post-formats', array(
		'gallery', 'image', 'video', 'quote'
	));

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Main Menu', 'trego' ),
		'secondary' => __( 'One Page Template', 'trego' ),
		'magento' => __( 'One Page magneto', 'trego' ),
		'useful_links' => __( 'Useful Links', 'trego' ),
		'footer' => __( 'Footer Menu', 'trego' ),
		'menu_les_ateliers' => __( 'Menu Les ateliers', 'trego' )
	));

	add_theme_support( 'post-thumbnails' );

	update_option('thumbnail_size_w', 175);
	update_option('thumbnail_size_h', 219);
	update_option('medium_size_w', 344);
	update_option('medium_size_h', 430);
	update_option('large_size_w', 860);
	update_option('large_size_h', 1076);

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'trego_setup' );

/************ Get The First Image From a Post ************/
function trego_catch_that_image($content) {
	$first_img = '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
	$first_img = $matches[1][0];

	if(empty($first_img)) {
		return false;
	}
	return $first_img;
}

/************ Get video url ************/
function trego_catch_video_url($content) {
	$video = '';

	$output = preg_match_all('/<iframe.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
	$video = $matches[1][0];

	if(empty($video)) {
		return false;
	}

	if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $video, $match)) {
	  $url = 'http://www.youtube.com/watch?v='.$match[1];
	}

	if (empty($url) && preg_match('/vimeo\.com\/video\/([0-9]*)/', $video, $match)) {
	  $url = 'http://vimeo.com/' . $match[1];
	}

	if(empty($url)) {
		return false;
	}

	return $url;
}

/******************* trego geto video ********************/
function trego_get_video($content) {

	$pattern = get_shortcode_regex();
	$matches = array();
	preg_match_all("/$pattern/s", $content, $matches);
	$shortcodes = $matches[2];

	if(in_array('youtube', $shortcodes)){

		$idx = array_search('youtube', $shortcodes);
		return preg_replace_callback( "/$pattern/s", 'do_shortcode_tag', $matches[0][$idx] );

	} elseif(in_array('vimeo', $shortcodes)) {

		$idx = array_search('vimeo', $shortcodes);
		return preg_replace_callback( "/$pattern/s", 'do_shortcode_tag', $matches[0][$idx] );

	} elseif(in_array('video', $shortcodes)){

		$idx = array_search('video', $shortcodes);
		return preg_replace_callback( "/$pattern/s", 'do_shortcode_tag', $matches[0][$idx] );

	} else {
		$reg_exUrl = "/((((http|https):\/\/)|www.)[a-zA-Z0-9-.]+.[a-zA-Z]{2,4}(\/?[a-zA-Z0-9;:\?\+\-&@#\/%=~_|\.]*))/";

		if(preg_match_all($reg_exUrl, $content, $url)) {

			foreach ($url[0] as $value) {

				if(wp_oembed_get($value)){
					return wp_oembed_get($value);
				}
			}
		}

		return false;
	}

	return false;
}

function trego_get_youtube_id($link){

	$reg_yt = "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/";

	preg_match_all($reg_yt, $link, $tmp);

	if(!empty($tmp[1])){

		return $tmp[1][0];
	}

	return false;
}

function trego_get_vimeo_id($link){
	$reg_vm = '/https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/';

	preg_match_all($reg_vm, $link, $tmp);

	if(!empty($tmp[3])){

		return $tmp[3][0];
	}

	return false;
}

/********* The quote post format ***************/
function trego_get_quote_content( $content ) {
	preg_match("/<blockquote[^>]*>(.*?)<\\/blockquote>/", $content, $matches);

	if ( empty( $matches[1] ) ) return false;

	return $matches[1];
}

function is_blog_page() {

	global $post;

	//Post type must be 'post'.
	$post_type = get_post_type($post);

	//Check all blog-related conditional tags, as well as the current post type, 
	//to determine if we're viewing a blog page.
	return (
		( is_home() || is_archive() || is_single() )
		&& ($post_type == 'post')
	);

}

/******************* add gallery option************************/
$trego_gallery_type = "echo \"<script type='text/html' id='tmpl-custom-gallery-setting'>
		<label class='setting'>
			<span>" . __('Gallery Type', 'trego') . "</span>
			<select data-setting='type'>
				<option value='default'> Default </option>
				<option value='slider'> Slider </option>
				<option value='tile'> Tile </option>
				<option value='home-slider'> Home Slider </option>
			</select>
		</label>
		</script>

		<script>
		jQuery(document).ready(function(){
			_.extend(wp.media.gallery.defaults, {
				type: 'default'
			});
			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
				template: function(view){
					return wp.media.template('gallery-settings')(view) + wp.media.template('custom-gallery-setting')(view);
				}
			});

		});
		</script>\";";
add_action('print_media_templates', create_function('', $trego_gallery_type));

/**
 * Enqueue scripts and styles for the front end.
 * @since Trego 1.0
 * @return void
 */


/************************ Javascript & CSS Setting ******************/
function trego_admin_scripts_styles() {
    wp_enqueue_style( 'trego', get_template_directory_uri() . '/css/admin.css', array( ), '1.0');
}
add_action( 'admin_enqueue_scripts', 'trego_admin_scripts_styles' );

function trego_scripts_styles() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ))
		wp_enqueue_script( 'comment-reply' );

	wp_enqueue_style('trego-fonts', get_template_directory_uri() . '/css/fonts.css', array());

	// Loads our main stylesheet.
	wp_enqueue_style('trego-style', get_stylesheet_uri(), array());

	wp_enqueue_style('trego-animate', get_template_directory_uri() . '/css/animate.css', array('trego-style'));

	// Add style, used in the responsive stylesheet.
	wp_enqueue_style('trego-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array('trego-style'));

	// Load Slider cloud-zoom
	wp_enqueue_style('supersized', get_template_directory_uri() . '/css/supersized.css', array('trego-style'));
	wp_enqueue_style('supersized-shutter', get_template_directory_uri() . '/css/supersized.shutter.css', array('trego-style'));
	wp_enqueue_script('jquery-easing', get_template_directory_uri() . '/js/jquery.easing.min.js', array('jquery'), '2014-01-20', true);
	wp_enqueue_script('supersized', get_template_directory_uri() . '/js/supersized.3.2.7.js', array('jquery'), '2014-01-20', true);
	wp_enqueue_script('supersized-shutter', get_template_directory_uri() . '/js/supersized.shutter.js', array('jquery'), '2014-01-20', true);

	// Loads nicescroll.js
	wp_enqueue_script('jquery-nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js', array('jquery'), '2014-01-20', true);
	wp_enqueue_script('jquery-hoverIntent-minified', get_template_directory_uri() . '/js/jquery.hoverIntent.minified.js', array('jquery'), '2014-01-20', true);

	wp_enqueue_script('twitterfetcher', get_template_directory_uri() . '/js/twitterfetcher.js', array());

	// Load bxslider
	wp_enqueue_style('jquery-bxslider', get_template_directory_uri() . '/css/jquery.bxslider.css', array());
	wp_enqueue_script('jquery-bxslider', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array('jquery'), '2014-01-20', true);

	wp_enqueue_script('jquery-waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array('jquery'), '2014-01-20', true);
	wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array('jquery'), '2014-01-20', true);
	wp_enqueue_script('jquery-isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array('jquery'), '2014-01-20', true);
	wp_enqueue_script('jquery-infinitescroll', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array('jquery'), '2014-01-20', true);
	wp_enqueue_script('imagesloaded', get_template_directory_uri() . '/js/imagesloaded.min.js', array('jquery'), '2014-01-20', true);

	wp_enqueue_script('jquery-stellar', get_template_directory_uri() . '/js/jquery.stellar.min.js', array('jquery'), '2014-01-20', true);

    wp_enqueue_script('jquery-prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'), '2014-01-20', true);
    wp_enqueue_style('jquery-prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css', array('trego-style'));

	if(is_page_template('page-home.php')) {
		wp_enqueue_script('jquery-videobackground', get_template_directory_uri() . '/js/jquery.videoBG.js', array('jquery'), '2014-01-20', true);
		wp_enqueue_script('jquery-ytplayer', get_template_directory_uri() . '/js/jquery.mb.YTPlayer.js', array('jquery'), '2014-01-20', true);
		wp_enqueue_style('jquery-ytplayer', get_template_directory_uri() . '/css/YTPlayer.css', array('trego-style'));

		wp_enqueue_script('jquery-modernizr', get_template_directory_uri() . '/js/jquery.modernizr.custom.js', array('jquery'), '2014-01-20', true);
		wp_enqueue_script('jquery-showcase', get_template_directory_uri() . '/js/jquery.showcase.slider.js', array('jquery'), '2014-01-20', true);
	    wp_enqueue_style('jquery-showcase', get_template_directory_uri() . '/css/jquery.showcase.slider.css', array('trego-style'));
	}

	// Load Slider cloud-zoom
	wp_enqueue_style('cloud-zoom', get_template_directory_uri() . '/css/cloud-zoom.css', array('trego-style'));
	wp_enqueue_script('cloud-zoom', get_template_directory_uri() . '/js/cloud-zoom.1.0.3.min.js', array('jquery'), '2014-01-20', true);

	wp_enqueue_style('trego-responsive', get_template_directory_uri() . '/css/responsive.css', array('trego-style'));
	wp_enqueue_style('remodal_css', get_template_directory_uri() . '/css/remodal.css', array('trego-style'));
	wp_enqueue_style('remodal_theme_css', get_template_directory_uri() . '/css/remodal-default-theme.css', array('trego-style'));

	wp_enqueue_script('jquery-scrollTo', get_template_directory_uri() . '/js/jquery.scrollTo.min.js', array('jquery'), '2014-01-20', true);
	wp_enqueue_script('jquery-localScroll', get_template_directory_uri() . '/js/jquery.localScroll.min.js', array('jquery'), '2014-01-20', true);

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style('trego-ie', get_template_directory_uri() . '/css/ie.css', array('trego-style'));
	wp_style_add_data('trego-ie', 'conditional', 'lt IE 9');

	wp_enqueue_script('jquery-placeholder', get_template_directory_uri() . '/js/jquery.placeholder.js', array('jquery'), '2014-01-20', true);

	// Loads JavaScript file with functionality specific to Trego.
	wp_enqueue_script('trego-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), '2014-01-20', true);
	wp_enqueue_script('remodal', get_template_directory_uri() . '/js/remodal.js', array('jquery'), '2014-01-20', true);
	wp_enqueue_script('trego-main', get_template_directory_uri() . '/js/main.js', array('trego-functions'), '2014-01-20', true);

}
add_action('wp_enqueue_scripts', 'trego_scripts_styles' );

/* ADD IE 8/9 FIX TO HEADER */
function add_ieFix () {
?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/css3-mediaqueries.js"></script>
	<![endif]-->
	<script type="text/javascript">
		var ajax_url = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
	</script>
<?php
}
add_action('wp_head', 'add_ieFix');


/**
 * Filter the page title.
 *
 * @since Trego 1.0
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function trego_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'trego' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'trego_wp_title', 10, 2 );

/**
 * Register two widget areas.
 * @since Trego 1.0
 * @return void
 */
function trego_widgets_init() {

	// The default sidebar visible on Blog and Pages with sidebar template
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'trego' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );

	// Sidebar for shop category pages. Visible if category with sidebar is selected in Theme Option Panel 
	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'trego' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );

	// Only visible if widget is added. Add a widget to create a column. 3 widgets = 3 columns. 
	register_sidebar( array(
		'name'          => __( 'Footer (3 columns)', 'trego' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<li id="%1$s" class="footer-widget-container %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<div class="footer-title">',
		'after_title'   => '</div>'
	) );

	// The default sidebar visible on About Us Page.
	register_sidebar( array(
		'name'          => __( 'About Us Sidebar', 'trego' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );

	// The default sidebar visible on Contact Us Page.
	register_sidebar( array(
		'name'          => __( 'Contact Us Sidebar', 'trego' ),
		'id'            => 'sidebar-5',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );
}
add_action( 'widgets_init', 'trego_widgets_init' );

if ( ! function_exists( 'trego_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 * @since Trego 1.0
 * @return void
 */
function trego_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="woocommerce-pagination">
		<?php echo paginate_links( apply_filters( 'pagination_args', array(
			'base' => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
			'format' => '',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages,
			'prev_text' => '',
			'next_text' => '',
			'type' => 'list',
			'end_size' => 0,
			'mid_size' => 1
		)));
		?>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'trego_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 * @since Trego 1.0
 * @return void
 */
function trego_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'trego' ); ?></h1>
		<div class="nav-previous">
			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&laquo;</span> Prev', 'Previous post link', 'trego' ) ); ?>
		</div>
		<div class="nav-next">
			<?php next_post_link( '%link', _x( 'Next <span class="meta-nav">&raquo;</span>', 'Next post link', 'trego' ) ); ?>
		</div>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'the_page_title' ) ) :
/********** page title ***************/
function the_page_title() {
	global $trego_vars;

	if(is_page()){
		if(class_exists('Woocommerce') && is_shop()){
			echo __('Shop', 'trego');
		} else {
			echo the_title();
		}

	} elseif (class_exists('Woocommerce') && apply_filters('woocommerce_show_page_title', true) && (is_product_category() || is_shop())) {
		woocommerce_page_title();

    } elseif (is_archive()) {
        $post_type = get_post_type();
        if($post_type == 'portfolio') {
            if(isset($trego_vars['portfolio_label'])){
				echo $trego_vars['portfolio_label'];
			} else {
				echo __( 'Portfolio', 'trego' );
			}
        }

	} elseif (is_search()) {
		$keyword = get_search_query();
		if(strlen($keyword) > 12) {
			$keyword = substr($keyword, 0, 12) . ' ...';
		}
		echo __( 'Search results for ', 'trego' ) . "\"" . $keyword . "\"";
	}
}
endif;

if ( ! function_exists( 'the_breadcrumbs' ) ) :
/********** breadcrumbs ***************/
function the_breadcrumbs() {
	global $post, $trego_vars;

	echo '<ul id="breadcrumbs">';
	echo '<li><a href="' . home_url() . '">' . __('Home', 'trego') . '</a></li><li class="separator"> > </li>';

	if (is_home()) {
		echo '<li>' . __('Blog', 'trego') . '</li>';

	} elseif (is_category()) {
		echo '<li>';
		$category = get_cat_id( single_cat_title("",false) );
		$sep = '</li><li class="separator"> > </li><li>';
		$len = '-' . (strlen($sep) - 5);
		echo substr(get_category_parents( $category, true, $sep ), 0, (int)$len);

	} elseif (is_single()) {
		$category = get_the_category(); 
		$sep = '</li><li class="separator"> > </li><li>';
		$post_type = get_post_type();
		if($category){
			echo '<li>' . get_category_parents( $category[0]->cat_ID, true, $sep );
			echo '</li>';
		}
        echo '<li>';
		the_title();
        echo '</li>';
	} elseif (is_page() && !is_front_page()) {
		if($post->post_parent){
			$anc = get_post_ancestors( $post->ID );
			foreach ( $anc as $ancestor ) {
				$output[] = '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li>';
			}
			echo implode('<li class="separator">></li>', $output);
			echo '<li class="separator"> > </li>';
			echo '<li> ' . the_title() . '</li>';
		} else {
			echo '<li> ';
			echo the_title();
			echo '</li>';
		}

	} elseif (is_tag()) {
		echo "<li>";
		printf( __( 'Tag Archives: %s', 'trego' ), single_tag_title( '', false ) );
		echo "</li>";

	} elseif (is_day()) {
		echo "<li>";
		printf( __( 'Daily Archives: %s', 'trego' ), get_the_date() );
		echo "</li>";

	} elseif (is_month()) {
		echo "<li>";
		printf( __( 'Monthly Archives: %s', 'trego' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'trego' ) ) );
		echo "</li>";

	} elseif (is_year()) {
		echo "<li>";
		printf( __( 'Yearly Archives: %s', 'trego' ), get_the_date( _x( 'Y', 'yearly archives date format', 'trego' ) ) );
		echo "</li>";

	} elseif (is_author()) {
		echo "<li>";
		printf( __( 'All posts by %s', 'trego' ), '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '">' . get_the_author() . '</a>' );
		echo "</li>";

	} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
		echo "<li>Blog Archives</li>";

	} elseif (is_search()) {
		echo "<li>" . __( 'Search Results for: ', 'trego' ) . "\"" . get_search_query() . "\"</li>";

	} elseif (is_archive()) {
		$post_type = get_post_type();
		if($post_type == 'portfolio') {
            if(isset($trego_vars['portfolio_label'])){
				$label = $trego_vars['portfolio_label'];
			} else {
				$label =  __( 'Portfolio', 'trego' );
			}
			echo "<li>" .$label . "</li>";
		}
	} else {
		echo '<li></li>';
	}

	echo '</ul>';
}
endif;

if ( ! function_exists( 'trego_entry_meta' ) ) :
/**
 * Print HTML with meta information for current post: categories, tags, permalink, author, and date.
 * Create your own trego_entry_meta() to override in a child theme.
 * @since Trego 1.0
 * @return void
 */
function trego_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'trego' ) . '</span>';

	if ( ! has_post_format( 'link' ) )
		trego_entry_date();

	printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'trego' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( ', ' );
	if ( $categories_list ) {
//		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	if ( comments_open() ) {
		echo '<span class="comments-link">';
			comments_popup_link( __( 'Leave a comment', 'trego' ), __( 'One comment so far', 'trego' ), __( '% Comments', 'trego' ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'trego_entry_date' ) ) :
/**
 * Print HTML with date information for current post.
 * Create your own trego_entry_date() to override in a child theme.
 * @since Trego 1.0
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function trego_entry_date( $echo = true ) {
	$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark">%3$s <br> %4$s</a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'trego' ), the_title_attribute( 'echo=0' ) ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date('j') ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date('M') ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'trego_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 * @since Trego 1.0
 * @return void
 */
function trego_the_attached_image() {
	/**
	 * Filter the image attachment size to use.
	 *
	 * @since Trego 1.0
	 *
	 * @param array $size {
	 *     @type int The attachment height in pixels.
	 *     @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'trego_attachment_size', array( 860, 1075 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 * @since Trego 1.0
 * @return string The Link format URL.
 */
function trego_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

function trego_get_background(){
	global $post;

	if(!is_page_template('page-home.php')) {
		if(is_page()){
			$page_id = $post->ID;

		} elseif(is_blog_page()) {
			$page_id = get_option('page_for_posts');

		} elseif(class_exists('Woocommerce') && is_woocommerce()) {
			$page_id = get_option('woocommerce_shop_page_id');

		} else {
			return false;
		}

		if(isset($page_id)){
			$background = get_post_meta($page_id, 'background');
			if(isset($background[0])){
				return $background[0];
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function trego_get_background_opacity(){
	global $post;

	if(!is_page_template('page-home.php')) {
		if(is_page()){
			$page_id = $post->ID;

		} elseif(is_blog_page()) {
			$page_id = get_option('page_for_posts');

		} elseif(class_exists('Woocommerce') && is_woocommerce()) {
			$page_id = get_option('woocommerce_shop_page_id');

		} else {
			return false;
		}

		if(isset($page_id)){
			$opacity = get_post_meta($page_id, 'background_opacity');
			if(!empty($opacity[0])){
				return $opacity[0];
			} else {
				return 0.5;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since Trego 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */

function trego_body_class( $classes ) {
	global $post;

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	if(is_page_template('page-home.php')) {
		$classes[] = 'fullscreen';
	}

	if(is_page_template('page-one-template.php')) {
		$classes[] = 'one-template';
	}

	if(is_page_template('page-portfolio-template.php')) {
		$classes[] = 'portfolio-template';
	}

	if(is_page_template('page-gallery-template.php')) {
		$classes[] = 'gallery-template';
	}
	if(is_page_template('page_les_ateliers_weiss_template.php')) {
		$classes[] = 'lesateliers-template';
	}

	return $classes;
}
add_filter( 'body_class', 'trego_body_class' );

// tags fontsize change
add_filter('widget_tag_cloud_args','trego_tag_cloud_sizes');
function trego_tag_cloud_sizes($args) {
	$args['smallest'] = 11;
	$args['largest'] = 14;
	$args['unit'] = 'px';
	return $args;
}

// comments list
function trego_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
                <div class="comment-box">
                	<?php echo get_avatar($comment, 80); ?>
                    <div class="comment-metadata">
                        <span class="author-name"><?php echo get_comment_author_link() ?></span>
                        <?php printf(__('%1$s', 'trego'), get_comment_date()) ?>
                        <span class="sep">|</span>
	                    <span class="reply">
	                        <?php
	                            comment_reply_link( array_merge( $args,array(
	                                'depth'     => $depth,
	                                'max_depth' => $args['max_depth']
	                            ) ) );
	                        ?>
	                    </span>
                    </div>
                    <div class="comment-content"><?php comment_text(); ?></div>
                </div>
            </article>
<?php 
}

function trego_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read More</a>';
}
add_filter( 'excerpt_more', 'trego_excerpt_more' );


function add_span_cat_count($links) {
	$links = str_replace('</a> (', '</a><span class="count">(', $links);
	$links = str_replace(')', ')</span>', $links);
	return $links;
}
add_filter('wp_list_categories', 'add_span_cat_count');

function add_span_archive_count($links) {
	$links = str_replace('</a>&nbsp;(', '</a><span class="count">(', $links);
	$links = str_replace(')', ')</span>', $links);
	return $links;
}
add_filter('get_archives_link', 'add_span_archive_count');


/* inject cpt archives meta box */
add_action( 'admin_head-nav-menus.php', 'inject_cpt_archives_menu_meta_box' );
function inject_cpt_archives_menu_meta_box($object) {
	add_meta_box( 'add-cpt', __( 'Archives', 'trego' ), 'wp_nav_menu_cpt_archives_meta_box', 'nav-menus', 'side', 'default' );
	return $object;
}

/* render custom post type archives meta box */
function wp_nav_menu_cpt_archives_meta_box() {
	/* get custom post types with archive support */
	$post_types = get_post_types( array( 'show_in_nav_menus' => true, 'has_archive' => true ), 'object' );

	/* hydrate the necessary object properties for the walker */
	foreach ( $post_types as &$post_type ) {

		$post_type->classes = array();
		$post_type->type = $post_type->name;
		$post_type->object_id = 1;
		$post_type->title = $post_type->labels->name;
		$post_type->object = 'cpt-archive';

		$post_type->menu_item_parent = null;
		$post_type->url = null;
		$post_type->xfn = null;
		$post_type->db_id = null;
		$post_type->target = null;
		$post_type->attr_title = null;
	}


	$walker = new Walker_Nav_Menu_Checklist( array() );

	?>
	<div id="cpt-archive" class="posttypediv">
		<div id="tabs-panel-cpt-archive" class="tabs-panel tabs-panel-active">
			<ul id="ctp-archive-checklist" class="categorychecklist form-no-clear">
				<?php
					echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $post_types), 0, (object) array( 'walker' => $walker) );
				?>
			</ul>
		</div><!-- /.tabs-panel -->
	</div>
	<p class="button-controls">
		<span class="add-to-menu">
			<input type="submit" class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-ctp-archive-menu-item" id="submit-cpt-archive" />
			<span class="spinner"></span>
		</span>
	</p>
	<?php
}

add_filter( 'wp_get_nav_menu_items', 'cpt_archive_menu_filter', 10, 3 );
function cpt_archive_menu_filter( $items, $menu, $args ) {

	/* alter the URL for cpt-archive objects */
	foreach ( $items as &$item ) {
		if ( $item->object != 'cpt-archive' ) continue;

		/* we stored the post type in the type property of the menu item */
		$item->url = get_post_type_archive_link( $item->type );

		if ( get_query_var( 'post_type' ) == $item->type ) {
			$item->classes []= 'current-menu-item';
			$item->current = true;
		}
	}

	return $items;
}



/********************* newsletter form ***************************/
function trego_newsletter_form(){
	global $trego_vars;

	$method = isset($trego_vars['newsletter_method']) ? $trego_vars['newsletter_method'] : '';
	$action = isset($trego_vars['newsletter_action']) ? $trego_vars['newsletter_action'] : '';
	$email = isset($trego_vars['newsletter_email_name']) ? $trego_vars['newsletter_email_name']: '';
	$email_label = isset($trego_vars['newsletter_email_label']) ? $trego_vars['newsletter_email_label'] : '';
	$hidden_fields = isset($trego_vars['newsletter_hidden']) ? $trego_vars['newsletter_hidden'] : '';
	$submit = isset($trego_vars['newsletter_submit_label']) ? $trego_vars['newsletter_submit_label']: __('Submit', 'trego');  

	$html = '';

	$html .= '<div class="newsletter">';
	$html .= '<form method="' . $method . '" action="' . $action . '">';
	$html .= '<label for="' . $email . '">' . $email_label . '</label>';
	$html .= '<input type="text" name="' . $email . '" id="' . $email . '" class="email-field" placeholder="' . __('Enter up for newsletter', 'trego') . '" />';
	// hidden fileds
	if ( $hidden_fields != '' ) {
		$hidden_fields = explode( '&', $hidden_fields );
		foreach ( $hidden_fields as $field ) {
			list( $id_field, $value_field ) = explode( '=', $field );
			$html .= '<input type="hidden" name="' . $id_field . '" value="' . $value_field . '" />';
		}
	}
	$html .= wp_nonce_field( 'mc_submit_signup_form', '_mc_submit_signup_form_nonce', false, false ); //MailChimp nonce
	$html .= wp_nonce_field( 'mymail_form_nonce', '_wpnonce', false, false ); //MyMail nonce
	$html .= '<input type="submit" value="' . $submit . '" class="submit-field" />';
	$html .= '</form>';
	$html .= '</div>';
	return $html;
}

/****************** special product ******************/
function trego_get_special_products(){
	if(!empty($_POST['chk'])) {
		switch ($_POST['chk']) {
			case '#latest_products_popup':
				$args = array(
					'post_type' => 'product',
					'post_status' => 'publish',
					'ignore_sticky_posts'   => 1,
					'posts_per_page' => 15
				);
				break;

			case '#sale_products_popup':
				$args = array(
				    'post_type' => 'product',
					'post_status' => 'publish',
					'ignore_sticky_posts'   => 1,
					'posts_per_page' => 15,
					'orderby' => 'date',
					'order' => 'desc',
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => '_sale_price',
							'value' =>  0,
							'compare' => '>',
							'type' => 'NUMERIC'
						),
						array(
							'key' => '_min_variation_sale_price',
							'value' => 0,
							'compare' => '>',
							'type' => 'NUMERIC'
						)
					)
				);
				break;

			case '#featured_products_popup':
				$args = array(
					'post_status' => 'publish',
					'post_type' => 'product',
					'ignore_sticky_posts'   => 1,
					'meta_key' => '_featured',
					'meta_value' => 'yes',
					'posts_per_page' => 15,
					'orderby' => 'date',
					'order' => 'desc'
				);
				break;
		}
	}

	$products = new WP_Query( $args );

	if ( $products->have_posts() ) {
		echo '<ul class="products block-grid-3">';
		while ( $products->have_posts() ) {
			$products->the_post();
			woocommerce_get_template_part( 'content', 'product' );
		}
		echo '</ul>';
	} else {
		echo '<p class="woocommerce-info">';
		echo __('No products found which match your selection.', 'trego');
		echo '</p>';
	}

	wp_reset_query();

	die();
}

add_action( 'wp_ajax_special_products', 'trego_get_special_products' );
add_action( 'wp_ajax_nopriv_special_products', 'trego_get_special_products' );

function trego_get_portfolio(){
	if(!isset($_POST['pid'])) {
		die('failure');
	}
	$date_format = get_option( 'date_format' );
	$time_format = get_option( 'time_format' );

	$portfolio = get_post($_POST['pid']);
	$title = $portfolio->post_title;
	$content = wpautop(do_shortcode($portfolio->post_content));
	$date = get_the_time($date_format, $_POST['pid']);
	$categories = strip_tags(get_the_term_list($_POST['pid'], 'portfolio_category', '', ', ', ''));
	?>
	<div class="portfolio-desc-wrapper">
	<div class="portfolio-close"></div>
	<div class="port-thumb">
	<?php
		$thumb = get_post_meta($_POST['pid'], 'portfolio_thumb');
		if ( $thumb && has_shortcode($thumb[0], 'gallery') ) :
		    if (has_post_thumbnail($_POST['pid'])) {
		        $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($_POST['pid']), 'full');
		        $thumb_image = wp_get_attachment_image_src(get_post_thumbnail_id($_POST['pid']), 'full');
		        echo '<a href="' . get_permalink($_POST['pid']) . '" ><img src="' . $full_image[0] . '" alt="" /></a>';
		    } else {
		        echo '<img src="' . get_template_directory_uri().'/images/no-photo.png" alt="" />';
		    }
		elseif ( $thumb && trego_get_video($thumb[0]) ) :
			echo trego_get_video($thumb[0]);
		elseif ( $thumb && trego_catch_that_image($thumb[0]) ) :
			echo '<a rel="prettyPhoto" href="' . trego_catch_that_image($thumb[0]) . '" ><img src="' . trego_catch_that_image($thumb[0]) . '" alt="" /></a>';
		else :
		    if (has_post_thumbnail($_POST['pid'])) {
		        $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($_POST['pid']), 'full');
		        $thumb_image = wp_get_attachment_image_src(get_post_thumbnail_id($_POST['pid']), 'full');
		        echo '<a rel="prettyPhoto" href="' . $full_image[0] . '" ><img src="' . $full_image[0] . '" alt="" /></a>';
		    } else {
		        echo '<img src="' . get_template_directory_uri().'/images/no-photo.png" alt="" />';
		    }
		endif;
	?>
	</div>
	<div class="port-info">
		<h4 class="entry-title"><?php echo $title; ?></h4>
		<div class="entry-content">
			<?php echo $content; ?>
			<div class="portfolio-meta">
				<p><span><?php echo __('Date', 'trego');?>: </span><?php echo $date; ?></p>
				<p><span><?php echo __('Categories', 'trego');?>: </span><?php echo $categories; ?></p>
			</div>
			<span class="share-label"><?php echo __('Share This', 'trego');?>: </span>
			<?php echo do_shortcode('[share post_id="'.$_POST['pid'].'"]'); ?>
		</div>
	</div>
	</div>
	<?php
	die();
}

add_action( 'wp_ajax_load_portfolio', 'trego_get_portfolio' );
add_action( 'wp_ajax_nopriv_load_portfolio', 'trego_get_portfolio' );

/**
 * Woocommerce Setting
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
if ( class_exists('Woocommerce') && version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

add_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 15);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 25);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 35);
add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 40);
add_action('woocommerce_single_product_summary', 'woocommerce_upsell_display', 50);

/************************** product new badge *****************************/
include_once('woocommerce/loop/new-badge.php');

/******************* Change Woocommerce Sort By Text  ******************/
add_filter( 'gettext', 'trego_change_sortby', 20, 3 );
function trego_change_sortby( $translated_text, $text, $domain ) {

	if (class_exists('Woocommerce') && is_woocommerce()) {
		switch ( $translated_text ) {
			case 'Default sorting' :
				$translated_text = __( 'Default', 'trego' );
				break;
			case 'Sort by newness' :
				$translated_text = __( 'Newest', 'trego' );
				break;
			case 'Sort by popularity' :
				$translated_text = __( 'Popularity', 'trego' );
				break;
			case 'Sort by average rating' :
				$translated_text = __( 'Average rating', 'trego' );
				break;
			case 'Sort by price: low to high' :
				$translated_text = __( 'Price: ASC', 'trego' );
				break;
			case 'Sort by price: high to low' :
				$translated_text = __( 'Price: DESC', 'trego' );
				break;
		}
	}

	return $translated_text;
}

// Ensure cart contents update when products are added to the cart via AJAX
function trego_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<div class="cart-box">
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'trego'); ?>">
			<?php
				if($woocommerce->cart->cart_contents_count == 1){
					echo sprintf(__('%d item', 'trego'), $woocommerce->cart->cart_contents_count);
				} else {
					echo sprintf(__('%d item(s)', 'trego'), $woocommerce->cart->cart_contents_count);
				}
			?>
			<span> - </span>
			<?php echo $woocommerce->cart->get_cart_total(); ?>
		</a>
		<div class="menu-cart">
		<?php woocommerce_mini_cart(); ?>
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('.cart-box .cart-contents').click(function(e){
				e.preventDefault();
				e.stopPropagation();
				$('.menu-cart').slideToggle();
			});
			$('.cart-product-list').niceScroll({horizrailenabled: false, zindex: 99999, cursorwidth:'5px', cursorborderradius:'5px', mousescrollstep:"60"});
		});
		</script>
	</div>
	<?php
	$fragments['div.cart-box'] = ob_get_clean();
	return $fragments;
}
add_filter('add_to_cart_fragments', 'trego_header_add_to_cart_fragment');

// breadcrumb setting
function trego_woo_breadcrumb_defaults($defaults) {
	$defaults['delimiter'] = '<span> &gt; </span>';	//whatever delimiter you want
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'trego_woo_breadcrumb_defaults');

/**************** grid / list view*********************/
function gridlist_toggle_button() {
	?>
		<div class="gridlist-toggle">
			<a href="#" id="grid" title="<?php _e('View as Grid', 'trego'); ?>"><?php _e('View as Grid', 'trego'); ?></a>
			<a href="#" id="list" title="<?php _e('View as List', 'trego'); ?>"><?php _e('View as List', 'trego'); ?></a>
		</div>
	<?php
}
add_action( 'woocommerce_before_shop_loop', 'gridlist_toggle_button', 30);



/************* product page setting ***************/
function trego_single_product_tags() {
	woocommerce_get_template( 'single-product/tags.php' );
    return;
}
add_action('woocommerce_single_product_summary', 'trego_single_product_tags', 45);

function trego_product_star_rating() {
	woocommerce_get_template( 'single-product/star-rating.php' );
    return;
}
add_action('woocommerce_single_product_summary', 'trego_product_star_rating', 15);

function trego_single_product_summary_start() {
	echo '<div class="accordion">';
    return;
}
add_action('woocommerce_single_product_summary', 'trego_single_product_summary_start', 30);

function trego_single_product_summary_end() {
	echo '</div>';
    return;
}
add_action('woocommerce_single_product_summary', 'trego_single_product_summary_end', 50);

function wc_change_product_description_tab_title( $tabs ) {
	global $post;
	if (isset($tabs['description']['title'])) $tabs['description']['title'] = __( 'Details', 'trego' );
	if (isset($tabs['reviews']['title'])) $tabs['reviews']['title'] = __( 'Comments', 'trego' );
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'wc_change_product_description_tab_title', 10, 1 );

/*********************** checkout ***************************/

function trego_override_checkout_fields( $fields ) {
	$fields['billing']['billing_first_name']['placeholder'] = __( 'First Name', 'woocommerce' );
	$fields['billing']['billing_last_name']['placeholder'] = __( 'Last Name', 'woocommerce' );
	$fields['billing']['billing_company']['placeholder'] = __( 'Company Name', 'woocommerce' );
	$fields['billing']['billing_email']['placeholder'] = __( 'Email Address', 'woocommerce' );
	$fields['billing']['billing_phone']['placeholder'] = __( 'Phone', 'woocommerce' );
	$fields['shipping']['shipping_first_name']['placeholder'] = __( 'First Name', 'woocommerce' );
	$fields['shipping']['shipping_last_name']['placeholder'] = __( 'Last Name', 'woocommerce' );
	$fields['shipping']['shipping_company']['placeholder'] = __( 'Company Name', 'woocommerce' );
	return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'trego_override_checkout_fields' );

/********************* widget ***********************/
include_once('inc/widgets/contact_info.php');
include_once('inc/widgets/recent-posts.php');
include_once('inc/widgets/advertise.php');
include_once('inc/widgets/tweets.php');
include_once('inc/widgets/testimonials.php');
include_once('inc/widgets/flickr.php');

/* SHORTCODES */
include_once('inc/shortcodes/accordion.php');
include_once('inc/shortcodes/tabs.php');
include_once('inc/shortcodes/button.php');
include_once('inc/shortcodes/grid.php');
include_once('inc/shortcodes/home_slider.php');
include_once('inc/shortcodes/bxslider.php');
include_once('inc/shortcodes/title.php');
include_once('inc/shortcodes/testimonial.php');
include_once('inc/shortcodes/banners.php');
include_once('inc/shortcodes/gmap.php');
include_once('inc/shortcodes/product_sliders.php');
include_once('inc/shortcodes/team_members.php');
include_once('inc/shortcodes/social_link.php');
include_once('inc/shortcodes/videos.php');
include_once('inc/shortcodes/gallery.php');
include_once('inc/shortcodes/portfolio.php');
include_once('inc/shortcodes/share.php');
include_once('inc/shortcodes/section.php');

include_once('inc/shortcodes/blocks.php');
include_once('inc/shortcodes/inserter/tinymce.php');


/****** Testimonial Post-type********/
include_once('inc/classes/testimonials.php');

/****** Portfolio Post-type********/
include_once('inc/classes/portfolio.php');

//JL
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
add_action('pre_get_posts','magento_home');

function magento_home($query){
	if(curPageUrl() == "http://127.0.0.1" && $query->is_main_query()){
        $query->set( 'page_id', '2705' );
	}
}



//add_action('init','set_wp_cookie');
//function set_wp_cookie(){
//     setcookie('count_wp', isset($_COOKIE['count_wp']) ? ++$_COOKIE['count_wp'] : 1);
//    
//}