<?php
/**
 * Product Loop End
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

global $trego_vars;

if(empty($trego_vars['category_sidebar'])) $trego_vars['category_sidebar'] = "";
?>
</ul>
<div class="slider-loading"></div>
</div>

<?php if(is_active_sidebar('sidebar-2') && (is_shop() || is_product_category()) && ($trego_vars['category_sidebar'] != 'none')) { ?>
	<?php $align = ($trego_vars['category_sidebar'] == 'left-sidebar') ? "left" : "right"; ?>
	<div class="shop-sidebar span-4 span-m-12 span-2-12 column <?php echo $align; ?>">
	    <div class="side-padding">
	        <?php dynamic_sidebar('sidebar-2'); ?>
	    </div>
	</div>
<?php } ?>
</div>