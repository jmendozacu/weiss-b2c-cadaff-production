<?php
/**
 * @package Trego
 * @since Trego 1.0
 */
global $post, $trego_vars;

if(empty($trego_vars['blog_layout'])){
	$trego_vars['blog_layout'] = "";
}

$sidebar = get_post_meta($post->ID, 'sidebar');

if (!$sidebar) {
	$sidebar = 'sidebar-1';

	if ( $trego_vars['blog_layout'] == 'left-sidebar' ) {
		$sidebar_pos = 'left';

	} elseif ( $trego_vars['blog_layout'] == 'right-sidebar' ) {
		$sidebar_pos = 'right';

	} else {
		return;
	}
} else {
	switch ($sidebar[0]) {
		case 'Shop Sidebar':
			$sidebar = 'sidebar-2';
			break;
		case 'About Us Sidebar':
			$sidebar = 'sidebar-4';
			break;
		case 'Contact Us Sidebar':
			$sidebar = 'sidebar-5';
			break;
		default:
			$sidebar = 'sidebar-1';
	}

	$sidebar_pos = (is_page_template('page-left-sidebar.php')) ? 'left' : 'right';
}
if(is_active_sidebar($sidebar)) : ?>
	<div role="complementary" class="sidebar-container span-4 span-m-12 span-2-12 column <?php echo $sidebar_pos; ?>">
		<div class="widget-area side-padding">
		<?php
		if(class_exists('Woocommerce') && !is_woocommerce()){
			dynamic_sidebar($sidebar);
		} else {
			dynamic_sidebar($sidebar);
		}
		?>
		</div><!-- .widget-area -->
	</div><!-- #secondary -->
<?php endif; ?>