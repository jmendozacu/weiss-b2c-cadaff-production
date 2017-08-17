<?php
/**
 * The template for displaying search forms in trego
 *
 * @package trego
 */
global $trego_vars;
?>

<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<div class="form-search">
		<input type="search" class="input-text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'trego' ); ?>" />
		<button class="btn-submit" title="<?php _e('Search', 'trego');?>"></button>
		<?php if (class_exists('Woocommerce')) { ?>
			<?php if ( isset($trego_vars['product_search']) && ($trego_vars['product_search'] == 1) ) { ?>
				<input type="hidden" name="post_type" value="product">
			<?php } ?>
		<?php } ?>
	</div>
</form>