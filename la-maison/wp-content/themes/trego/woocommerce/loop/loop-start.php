<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

global $trego_vars;

if(isset($_GET['left-sidebar'])) {
    $trego_vars['category_sidebar'] = 'left-sidebar';
} elseif(isset($_GET['right-sidebar'])) {
    $trego_vars['category_sidebar'] = 'right-sidebar';
} elseif(isset($_GET['no-sidebar'])) {
    $trego_vars['category_sidebar'] = 'none';
}
if(empty($trego_vars['category_sidebar'])) $trego_vars['category_sidebar'] = "";
?>
<div class="row-container">
<?php if(is_shop() || is_product_category()) { ?>

	<?php $align = ($trego_vars['category_sidebar'] == 'left-sidebar') ? "right" : "left"; ?>
	<?php if(is_active_sidebar('sidebar-2') && ($trego_vars['category_sidebar'] != 'none')) { ?>

		<div class="category-container span-8 span-m-12 span-s-12 <?php echo $align; ?>">
		<ul class="products block-grid-2 block-grid-m-2 block-grid-s-1">

	<?php } else { ?>
		<div class="category-container span-12">
		<ul class="products block-grid-3 block-grid-m-2 block-grid-s-1">
	<?php } ?>

<?php } else { ?>
	<div class="category-container span-12">
	<ul class="products block-grid-4 block-grid-m-2 block-grid-s-1">
<?php } ?>