<?php
if (!class_exists('Portfolio')) {
  class Portfolio {
    static function on_load() {
		add_action('init',array(__CLASS__,'init'));
		add_action('wp_insert_post_data',array(__CLASS__,'wp_insert_post_data'),10,2);
		add_action("manage_portfolio_posts_custom_column",  array(__CLASS__,"custom_columns"));
		add_filter("manage_portfolio_posts_columns", array(__CLASS__,"set_columns"));
    }
    static function init() {
	  
	  $labels = array(
		'name' => _x('Portfolios', 'post type general name', 'trego'),
        'all_items' => __( 'All Portfolios', 'trego' ),
		'singular_name' => _x('Portfolio', 'post type singular name', 'trego'),
		'add_new' => _x('Add New', 'Portfolio', 'trego'),
		'add_new_item' => __('Add New Portfolio', 'trego'),
		'edit_item' => __('Edit Portfolio', 'trego'),
		'new_item' => __('New Portfolio', 'trego'),
		'view_item' => __('View Portfolio', 'trego'),
		'search_items' => __('Search Portfolios', 'trego'),
		'not_found' =>  __('No portfolios found', 'trego'),
		'not_found_in_trash' => __('No portfolios found in Trash', 'trego'),
		'parent_item_colon' => ''
	  );
	  
      register_post_type( 'portfolio',array(
        'labels' => $labels,
        'singular_label' => __('Portfolio', 'trego'),
        'public' => true,
		'publicly_queryable' => true,
        'show_ui' => true,
		'show_in_menu' => true, 
		'query_var' => true,
        'menu_position' => 5,
        'capability_type' => 'page',
        'hierarchical' => true,
        'rewrite' => array("slug" => "portfolio"),
        'show_in_nav_menus' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'has_archive' => true
      ));
    }
    
    static function wp_insert_post_data($data,$postarr) {
      if ($postarr['post_type'] == 'portfolio') {
	  
      }
      return $data;
    }
	
	static function set_columns($columns){
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
            "thumbnail" => "Thumbnail",
			"title"=>"Title",
            "portfolio_category"=>"Categories",
			"author" => "Author",
			"date" => "Date",
		);
		return $columns;
	}

	static function custom_columns($column){
		global $post;
        if($column == 'thumbnail') {
            echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail() . '</a>';
        } elseif($column == 'portfolio_category') {
            echo strip_tags(get_the_term_list($post->ID, 'portfolio_category', '', ', ', ''));
        }
	}
  }
  Portfolio::on_load();
}

function category_portfolio() {
    register_taxonomy(
        'portfolio_category',
        'portfolio',
        array(
            'label' => __( 'Portfolio Categories', 'trego' ),
            'rewrite' => array( 'slug' => 'portfolio_category' ),
            'hierarchical' => true,
			'show_in_nav_menus' => false
        )
    );
}
add_action( 'init', 'category_portfolio' );
?>