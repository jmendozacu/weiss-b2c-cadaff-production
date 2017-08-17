<?php
if (!class_exists('Testimonial')) {
	class Testimonial {
		static function on_load() {
			add_action('init',array(__CLASS__,'init'));
			add_action('wp_insert_post_data',array(__CLASS__,'wp_insert_post_data'),10,2);
			add_action("manage_testimonial_posts_custom_column",  array(__CLASS__,"custom_columns"));
			add_filter("manage_edit-testimonial_columns", array(__CLASS__,"edit_columns"));
		}
		static function init() {
		  
			$labels = array(
				'name' => _x('Testimonials', 'post type general name', 'trego'),
				'all_items' => __( 'All Testimonials', 'trego' ),
				'singular_name' => _x('Testimonial', 'post type singular name', 'trego'),
				'add_new' => _x('Add New', 'Testimonial', 'trego'),
				'add_new_item' => __('Add New Testimonial', 'trego'),
				'edit_item' => __('Edit Testimonial', 'trego'),
				'new_item' => __('New Testimonial', 'trego'),
				'view_item' => __('View Testimonial', 'trego'),
				'search_items' => __('Search Testimonials', 'trego'),
				'not_found' =>  __('No case testimonials found', 'trego'),
				'not_found_in_trash' => __('No testimonials found in Trash', 'trego'),
				'parent_item_colon' => ''
			);
			  
			register_post_type( 'testimonial',array(
				'labels' => $labels,
				'singular_label' => __('Testimonial', 'trego'),
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true, 
				'query_var' => true,
				'menu_position' => 6,
				'capability_type' => 'page',
				'hierarchical' => false,
				'rewrite' => true,
				'show_in_nav_menus' => false,
				'supports' => array('title',  'page-attributes', 'thumbnail', 'editor', 'author'),
				'has_archive' => true
			));
	    }
	    
		static function wp_insert_post_data($data,$postarr) {
			if ($postarr['post_type'] == 'testimonial') {

			}
			return $data;
		}
		
		static function edit_columns($columns){
			$new_columns = array(
				"cb" => "<input type=\"checkbox\" />",
				"thumbnail" => "Thumbnail",
				"title" => "Name",
				"role" => "Role",
				"author" => "Author",
				"date" => "Date",
			);

			$columns = array_merge($new_columns, $columns);
			return $columns;
		}

		static function custom_columns($column){
			global $post;
			if($column == 'thumbnail') {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail() . '</a>';
			} elseif ($column == 'role') {
				$role = get_post_meta($post->ID, 'role');
				echo $role[0];
			}
		}
	}
	Testimonial::on_load();
}
?>
