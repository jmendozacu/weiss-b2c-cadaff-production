<?php
include_once('classes/metabox.php');

$meta_boxes = array(
	array(
		'id' => 'page_sidebar',
		'title' => 'Page Sidebar',
		'post_types' => 'page',
		'context' => 'side',
		'priority' => 'low',
		'fields' => array(
			array(
				'name' => 'Sidebar',
				'id' => 'sidebar',
				'type' => 'select',
				'options' => array('Main Sidebar', 'Shop Sidebar', 'About Us Sidebar', 'Contact Us Sidebar'),
				'std' => 'Main'
			)
		)
	),
	array(
		'id' => 'page_banner',
		'title' => 'Page Banner Setting',
		'post_types' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => 'Page Banner',
				'id' => 'banner',
				'type' => 'htmleditor',
				'std' => ''
			)
		)
	),
	array(
		'id' => 'page_background',
		'title' => 'Page Background Setting',
		'post_types' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => 'Background Image Link',
				'id' => 'background',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => 'Background Opacity',
				'id' => 'background_opacity',
				'type' => 'text',
				'std' => '0.5'
			)
		)
	),
	array(
		'id' => 'post_banner',
		'title' => 'Post Banner Setting',
		'post_types' => 'post',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => 'Post Banner',
				'id' => 'post_thumb',
				'type' => 'htmleditor',
				'std' => ''
			)
		)
	),
	array(
		'id' => 'testimonial_role',
		'title' => 'Other info',
		'post_types' => 'testimonial',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => 'Role',
				'id' => 'role',
				'type' => 'text',
				'std' => ''
			)
		)
	),
	array(
		'id' => 'portfolio_thumbnail',
		'title' => 'Portfolio Thumbnail Setting',
		'post_types' => 'Portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => 'Portfolio Thumbnail',
				'id' => 'portfolio_thumb',
				'type' => 'htmleditor',
				'std' => ''
			)
		)
	),
);

foreach ($meta_boxes as $meta_box) {
    $my_box = new Ef_meta_box($meta_box);
}

