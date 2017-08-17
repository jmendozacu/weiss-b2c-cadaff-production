<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $trego_vars;

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

<?php foreach ( $tabs as $key => $tab ) : ?>
<?php
	if(($key == 'reviews') && isset($trego_vars['disable_comments']) && ($trego_vars['disable_comments'] == 1)) continue;
?>
<div class="accordion-group">
	<div class="accordion-heading">
		<a href="#item_<?php echo $key ?>" class="accordion-toggle collapsed" data-toggle="collapse">
			<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?>
			<span class="icon-toggle"></span>
		</a>
	</div>
	<div id="item_<?php echo $key ?>" class="collapse">
		<div class="accordion-inner">
		<?php call_user_func( $tab['callback'], $key, $tab ) ?>
		</div>
	</div>
</div>
<?php endforeach; ?>

<?php endif; ?>