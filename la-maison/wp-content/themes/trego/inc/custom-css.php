<?php
function trego_custom_css() {
global $trego_vars;
?>

<!-- Custom CSS Codes -->
<style type="text/css">
<?php if(!empty($trego_vars['font_primary'])) { ?>
	body {
		font-family: <?php echo $trego_vars['font_primary']; ?>, Verdana, Arial, Helvetica, sans-serif;
	}
	article blockquote,
	article blockquote:before,
	.form-search input.input-text,
	.site-header div.copyrights,
	.widget-area ul li,
	.shop-sidebar ul li,
	.checkout-login-form h3 a,
	.checkout-coupon-form h3 a,
	.footer-widget-container.widget_pages li a,
	.footer-widget-container.widget_categories li a,
	.footer-widget-container.widget_archive li a,
	.footer-widget-container.widget_meta li a,
	.footer-widget-container.widget_product_categories li a,
	.footer-widget-container.widget_layered_nav li a,
	.footer-widget-container.widget_nav_menu li a,
	.footer-widget-container.widget_tag_cloud a,
	.footer-widget-container.widget_product_tag_cloud a,
	.widget.trego_recent_posts li .post-date,
	.widget.trego_recent_posts li .post_comments,
	.footer-widget-container.trego_recent_posts li .post-date,
	.footer-widget-container.trego_recent_posts li .post_comments,
	#colophon .site-info .copyrights,
	.slide-wrapper .content-box p,
	article.post header .entry-meta span,
	article.page header .entry-meta span,
	article.product header .entry-meta span,
	article.post .entry-summary a.read-more,
	article.page .entry-summary a.read-more,
	article.product .entry-summary a.read-more,
	.product-desc .desc,
	#comments ul.comment-list .comment-metadata,
	.widget_shopping_cart_content a.checkout,
	.bxslider-container.testimonial_slider li,
	.gridlist-toggle a,
	.widget.trego_recent_posts li .post-title a,
	.footer-widget-container.trego_recent_posts li .post-title a,
	td.product-name dl.variation,
	table.cart td.product-sku,
	ul.cart_list li dl,
	ul.product_list_widget li dl,
	#payment ul.payment_methods li p,
	.wishlist_table .add_to_cart, .yith-wcwl-add-button > a.button.alt,
	a.single_add_to_cart_button.button.alt,
	.portfolio .portfolio-category a,
	div.product form.cart .variations label {
		font-family: <?php echo $trego_vars['font_primary']; ?>, Verdana;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_head'])) { ?>
	h1, h2, h3, h4, h5, h6 {
		font-family: <?php echo $trego_vars['font_head']; ?>, Arial, Helvetica, sans-serif;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_menu'])) { ?>
	ul.special-menu-items li a,
	.mega-menu a,
    .mega-menu h5,
	.accordion-menu a,
	.accordion-menu h5,
    .mega-menu .popup ul li a,
    .mega-menu .popup ul li h5,
	#main-mobile-toggle {
	    font-family: <?php echo $trego_vars['font_menu']; ?>, "PTSans_Caption";
	}
<?php } ?>
<?php if (!empty($trego_vars['font_button'])) { ?>
	button,
	a.btn-type,
	a.btn-type.gray,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.quick-access .menu-cart .checkout,
	ul.products.list li.product .add-cart-bar a.added_to_cart,
	.widget .tagcloud a,
	div.product span.tagged_as a,
	ul.products.list li.product .add-cart-bar a.button {
	    font-family:<?php echo $trego_vars['font_button']; ?>, Verdana,Arial,Helvetica,sans-serif;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_price_1'])) { ?>

	.quick-access .menu-cart p.total span.amount,
	ul.products li.product .price,
	ul.product_list_widget li .amount,
	td.product-subtotal,
	td.product-remove,
	.cart-collaterals .cart_totals table .total .amount,
	table.order_list td span.amount,
	#order_review table.order-review-table tr.total td .amount,
	#order_review table.shop_table td.product-total,
	div.product p.price,
	.bxslider-container .product-info .price,
	div.product span.price {
		font-family: <?php echo $trego_vars['font_price_1']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_price_2'])) { ?>

	div.product p.price del,
	div.product p.price .from,
	div.product span.price del,
	div.product span.price .from,
	ul.product_list_widget li .from,
	ul.products li.product .price del,
	ul.products li.product .price .from,
	.cart-collaterals .cart_totals table td .amount,
	.bxslider-container .product-info .price del,
	.bxslider-container .product-info .price .from,
	td.product-price {
		font-family: <?php echo $trego_vars['font_price_2']; ?>, 'Lato_Regular';
	}
<?php } ?>
<?php if (!empty($trego_vars['font_widget_title'])) { ?>

	.shop-sidebar .widget-title,
	.footer-widget-container h3,
	.widget-area .widget-title,
	#order_review table.order-review-table tr.total th strong,
	.cart-collaterals .cart_totals table .total th,
	h3.title-section,
	table.order_list tfoot tr:last-child th,
	.widget_calendar caption {
		font-family: <?php echo $trego_vars['font_widget_title']; ?>, 'Raleway_Medium',Arial,Helvetica,sans-serif;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_title_1'])) { ?>

	ul.product_list_widget li a,
	.bxslider-container .product-info h3,
	td.product-name a,
	#order_review table.shop_table td.product-name,
	ul.products li.product h3 {
		font-family: <?php echo $trego_vars['font_title_1']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_title_2'])) { ?>

	h2.title-section,
	.checkout .col-1 h3,
	.checkout .col-2 h3,
	.checkout-login-form h3,
	.checkout-coupon-form h3 {
		font-family: <?php echo $trego_vars['font_title_2']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_other_1'])) { ?>
	ul.cart_list li a,
	td.product-thumbnail,
	td.product-sku,
	td.product-price,
	td.product-quantity,
	ul.products.list div.list-view h3,
	ul.products.list div.list-view h3 a,
	.special-products-popup .bxslider-title,
	.products-popup .popup-label .title,
	.products-popup .title-tabs a,
	div.team-member h4.member-name,
	.bxslider-container .product-info h3,
	.bxslider-title {
		font-family: <?php echo $trego_vars['font_other_1']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_other_2'])) { ?>
	article.post header .entry-meta span.date,
	article.page header .entry-meta span.date,
	article.product header .entry-meta span.date,
	#respond .comment-reply-title,
	ul.products.list li.product .add-cart-bar .yith-wcwl-add-to-wishlist a,
	#order_review table.order-review-table tr.shipping .amount,
	#order_review table.order-review-table tr.cart-subtotal .amount,
	ul.cart_list li a.remove,
	widget_shopping_cart_content p.total span.amount,
	.bxslider-container.member-slider .bxslider-title,
	article.post header .entry-title a,
	article.page header .entry-title a,
	table.order_list td.product-name strong,
	.bxslider-container.testimonial_slider .bxslider-title,
	.post-portfolio h3.entry-title,
	.post-portfolio .portfolio-content h3 a,
	.portfolio .portfolio-content h3 a,
	article.product header .entry-title a {
		font-family: <?php echo $trego_vars['font_other_2']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_other_3'])) { ?>
	.bxslider-container span.onsale,
	.accordion-inner h1,
	.accordion-inner h2,
	.accordion-inner h3,
	.accordion-inner h4,
	.accordion-inner h5,
	.accordion-inner h6,
	span.onsale,
	table.shop_table th,
	#payment ul.payment_methods li,
	table.order_list th,
	table.order_list tfoot th,
	table.order_list tfoot td,
	#order_review table.order-review-table tfoot th,
	#order_review table.shop_table th,
	.cart-collaterals .cart_totals table td,
	.cart-collaterals .cart_totals table th,
	.header-topbar h1.page-title {
		font-family: <?php echo $trego_vars['font_other_3']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['bg_pattern'])) { ?>
<?php $bg_color = (!empty($trego_vars['bg_color_1'])) ? $trego_vars['bg_color_1'] : '#F1F1F1'; ?>
	body {
		background: url("<?php echo get_template_directory_uri(). '/images/pattern/' . $trego_vars['bg_pattern']; ?>") repeat scroll 0 0 <?php echo $bg_color; ?>;
	}
	.header-topblock {
		background: url("<?php echo get_template_directory_uri(). '/images/pattern/' . $trego_vars['bg_pattern']; ?>") repeat scroll 0 0 <?php echo $bg_color; ?>;
	}
	@media only screen and (min-width: 768px) and (max-width: 1024px) {
		.site-header .header-sidebar {
			background-color: transparent;
		}
		.header-sidebar-bg {
			display: block;
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			height: 190px;
			background: url("<?php echo get_template_directory_uri(). '/images/pattern/' . $trego_vars['bg_pattern']; ?>") repeat scroll 0 0 <?php echo $bg_color; ?>;
			z-index: 105;
		}
		.one-template .header-sidebar-bg,
		.fullscreen .header-sidebar-bg {
			display: none
		}
	}
<?php } ?>
<?php if (!empty($trego_vars['bg_color_1'])) { ?>
	body,
	.header-topblock,
	/*.ico-block.vertical .ico-mark,*/
	ul.cart_list li {
		background-color: <?php echo $trego_vars['bg_color_1']; ?>;
}
<?php } ?>
<?php if (!empty($trego_vars['bg_color_2'])) { ?>
	.checkout .col-1 h3,
	.checkout .col-2 h3,
	.checkout-login-form h3,
	.checkout-coupon-form h3,
	.shop-sidebar .widget-title,
	.widget-area .widget-title,
	h2.title-section,
	.section-title,
	#order_review table.order-review-table tr.total {
		background-color: <?php echo $trego_vars['bg_color_2']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['bg_color_3'])) { ?>
	h3.title-section,
	table.order_list th,
	table.shop_table th,
	table.shop_table tfoot td,
	table.shop_table tfoot th,
	nav.post-navigation,
	nav.image-navigation,
	.quick-access .menu-cart,
	nav.comment-navigation,
	.cart-collaterals .cart_totals table .total {
		background-color: <?php echo $trego_vars['bg_color_3']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['bg_color_4'])) { ?>
	select,
	textarea,
	input[type="text"],
	input[type="email"],
	input[type="url"],
	.input-text,
	.quantity .minus,
	.quantity .plus,
	.quantity .plus:hover,
	.quantity .minus:hover {
		background-color: <?php echo $trego_vars['bg_color_4']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['btn_color_1'])) { ?>
	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.quick-access .menu-cart .checkout,
	ul.products.list li.product .add-cart-bar a.added_to_cart,
	ul.products.list li.product .add-cart-bar a.button,
	.products-popup .title-tabs a:hover,
	.products-popup .title-tabs a.selected,
	article.post header .entry-meta span.date,
	article.page header .entry-meta span.date,
	article.product header .entry-meta span.date,
	a.btn-type,
	ul.products li.product .add-cart-bar {
		background-color: <?php echo $trego_vars['btn_color_1']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['btn_hover_color_1'])) { ?>
	a.btn-type:hover,
	.quick-access .menu-cart .checkout:hover,
	ul.products.list li.product .add-cart-bar a.added_to_cart:hover,
	ul.products.list li.product .add-cart-bar a.button:hover,
	button:hover,
	input[type="button"]:hover,
	input[type="reset"]:hover,
	.portfolio .portfolio-category a.active,
	.portfolio .portfolio-category a:hover,
	input[type="submit"]:hover {
		background-color: <?php echo $trego_vars['btn_hover_color_1']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['btn_color_2'])) { ?>
	.widget .tagcloud a,
	div.product span.tagged_as a,
	.nav-panel > li > a,
	.portfolio .portfolio-category a,
	a.btn-type.gray {
		background-color: <?php echo $trego_vars['btn_color_2']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['btn_hover_color_2'])) { ?>
	a.btn-type.gray:hover,
	.nav-tabs > .active > a,
	.nav-tabs > .active > a:hover,
	.nav-tabs > li > a:hover,
	.widget .tagcloud a:hover,
	div.product span.tagged_as a:hover {
		background-color: <?php echo $trego_vars['btn_hover_color_2']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['border_color_1'])) { ?>
	textarea,
	input[type="text"],
	input[type="email"],
	input[type="url"],
	.input-text,
	select,
	.widget_calendar td#today,
	nav.woocommerce-pagination ul li span.current,
	nav.woocommerce-pagination ul li a.prev,
	nav.woocommerce-pagination ul li a.next,
	nav.woocommerce-pagination ul li a:hover,
	nav.woocommerce-pagination ul li a:focus,
	.ico-block.vertical .ico-block-content,
	/*.ico-block.vertical .ico-mark,*/
	.ico-block.single .ico-mark,
	.ico-block .ico-mark,
	.newsletter .email-field,
	.quantity input.qty,
	.form-search input.input-text {
		border: 1px solid <?php echo $trego_vars['border_color_1']; ?>;
	}
	.chzn-container-single .chzn-single {
		border: 1px solid <?php echo $trego_vars['border_color_1']; ?> !important;
	}
	.quantity input.qty {
		border-right: 0;
	}
	.tabs-below .tab-content,
	.tabs-left .tab-content,
	.tabs-right .tab-content,
	.tabs-below > .nav-tabs,
	.quantity .plus,
	.page-nav {
		border-top: 1px solid <?php echo $trego_vars['border_color_1']; ?>;
	}
	.tabs-right .tab-content,
	.quantity .plus,
	.quantity .minus {
		border-right: 1px solid <?php echo $trego_vars['border_color_1']; ?>;
	}
	.tabs-left .tab-content {
		border-left: 1px solid <?php echo $trego_vars['border_color_1']; ?>;
	}
	.nav-tabs,
	.quantity .minus {
		border-bottom: 1px solid <?php echo $trego_vars['border_color_1']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['border_color_2'])) { ?>
	.cart-collaterals .calc-shipping .tab-content {
		border: 1px solid <?php echo $trego_vars['border_color_2']; ?> !important;
	}
	.cart-collaterals .cart_totals table,
	table.shop_table,
	.quick-access .menu-cart,
	ul.cart_list li,
	#order_review table.order-review-table,
	table.order_list {
		border: 1px solid <?php echo $trego_vars['border_color_2']; ?>;
	}
	.bxslider-title,
	.header-topbar,
	.cart-collaterals .cart_totals table td,
	.cart-collaterals .cart_totals table th,
	#order_review table.order-review-table tr,
	table.order_list td,
	table.order_list th,
	table.shop_table td,
	table.shop_table th {
		border-bottom: 1px solid <?php echo $trego_vars['border_color_2']; ?>;
	}
	#colophon .site-info {
		border-top: 1px solid <?php echo $trego_vars['border_color_2']; ?>;
	}
	table.order_list th,
	table.shop_table td,
	table.shop_table th {
		border-right: 1px solid <?php echo $trego_vars['border_color_2']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['border_color_3'])) { ?>
	.mega-menu > ul > li > a, .mega-menu > ul > li > h5,
	ul.special-menu-items li a,
	#order_review table.shop_table th,
	.widget-area ul li,
	table.order_list tfoot th,
	table.order_list tfoot td,
	.footer-widget-container.widget_pages li a,
	.footer-widget-container.widget_categories li a,
	.footer-widget-container.widget_archive li a,
	.footer-widget-container.widget_meta li a,
	.footer-widget-container.widget_product_categories li a,
	.footer-widget-container.widget_layered_nav li a,
	.footer-widget-container.widget_nav_menu li a,
	.shop-sidebar ul li {
		border-bottom: 1px solid <?php echo $trego_vars['border_color_3']; ?>;
	}
	table.order_list tfoot th,
	table.order_list tfoot td {
		border-right: 1px solid <?php echo $trego_vars['border_color_3']; ?>;
	}
	.footer-widget-container.widget_pages > ul,
	.footer-widget-container.widget_archive > ul,
	.footer-widget-container.widget_categories > ul,
	.footer-widget-container.widget_meta > ul,
	.footer-widget-container.widget_product_categories > ul,
	.footer-widget-container.widget_layered_nav > ul,
	.footer-widget-container.widget_nav_menu div > ul {
		border-top: 1px solid <?php echo $trego_vars['border_color_3']; ?>;
	}
	div.team-member .member-divider,
	.section-divider {
		background-color: <?php echo $trego_vars['border_color_3']; ?>;
	}
	@media only screen and (min-width: 768px) and (max-width: 1024px) {
		.mega-menu > ul > li > a,
		.mega-menu > ul > li > h5 {
		    border: none;
		}
	}
<?php } ?>
<?php if (!empty($trego_vars['link_color'])) { ?>
	a {
		color: <?php echo $trego_vars['link_color']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['link_hover_color'])) { ?>
	a:hover,
	a:focus {
		color: <?php echo $trego_vars['link_hover_color']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_color_1'])) { ?>
	body,
	mark,
	article .entry-content,
	textarea,
	input[type="text"],
	input[type="email"],
	input[type="url"],
	.input-text,
	select,
	.breadcrumb-container,
	#breadcrumbs li.strong,
	#breadcrumbs li:last-child a,
	.shop-sidebar ul li span.count,
	.widget-area ul li span.count,
	td.product-name a,
	ul.product_list_widget li a,
	ul.cart_list li a,
	.widget_layered_nav ul small.count,
	.post-portfolio .entry-content,
	table.order_list td,
	.wishlist_table tr td.product-stock-status span.wishlist-in-stock,
	.woocommerce-breadcrumb,
	ul.products li.product h3,
	.gridlist-toggle a.active,
	ul.products.list div.list-view h3,
	ul.products.list div.list-view h3 a,
	ul.products.list li.product .add-cart-bar .yith-wcwl-add-to-wishlist a:hover,
	.one-template .contact-block .site-content, .portfolio-template .contact-block .site-content,
	.bxslider-container.section-testimonial .testimonial_author,
	.bxslider-container.section-testimonial .testimonial-text,
	.bxslider-container.section-tweets p.tweet,
	.bxslider-container.section-tweets p.timePosted,
	nav.woocommerce-pagination ul li span.current,
	nav.woocommerce-pagination ul li a.prev,
	div.team-member p.member-title,
	nav.woocommerce-pagination ul li a.next,
	nav.woocommerce-pagination ul li a:hover,
	nav.woocommerce-pagination ul li a:focus,
	.post-portfolio .entry-content, .port-info .entry-content,
	div.team-member p.member-desc,
	.ico-block .ico-block-desc,
	td.product-name a,
	ul.product_list_widget li a,
	ul.cart_list li a,
	.widget_layered_nav ul small.count,
	table.order_list td,
	.wishlist_table tr td.product-stock-status span.wishlist-in-stock,
	#payment ul.payment_methods li p,
	#comments ul.comment-list .comment-metadata .author-name,
	.one-template .section-desc, .portfolio-template .section-desc,
	td.product-name dl.variation {
		color: <?php echo $trego_vars['font_color_1']; ?>;
	}
	@media only screen and (max-width: 767px) {
		table.shop_table.cart td span.attr-label {
			color: <?php echo $trego_vars['font_color_1']; ?>;
		}
	}
<?php } ?>
<?php if (!empty($trego_vars['button_color_1'])) { ?>
	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],
	.quick-access .menu-cart .checkout,
	ul.products li.product .add-cart-bar,
	ul.products li.product .add-cart-bar a,
	article.post header .entry-meta span.date a,
	article.page header .entry-meta span.date a,
	article.product header .entry-meta span.date a,
	.portfolio .portfolio-category a,
	a.btn-type,
	ul.products.list li.product .add-cart-bar a.added_to_cart,
	ul.products.list li.product .add-cart-bar a.button {
		color: <?php echo $trego_vars['button_color_1']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['button_hover_color_1'])) { ?>
	button:hover,
	input[type="button"]:hover,
	input[type="reset"]:hover,
	input[type="submit"]:hover,
	ul.products.list li.product .add-cart-bar a.added_to_cart:hover,
	ul.products.list li.product .add-cart-bar a.button:hover,
	.quick-access .menu-cart .checkout:hover,
	ul.products li.product .add-cart-bar a:hover,
	a.btn-type:hover {
		color: <?php echo $trego_vars['button_hover_color_1']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['button_color_2'])) { ?>
	.widget .tagcloud a,
	div.product span.tagged_as a,
	.nav-tabs > li > a,
	a.btn-type.gray,
	.products-popup .title-tabs a {
		color: <?php echo $trego_vars['button_color_2']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['button_hover_color_2'])) { ?>
	.widget .tagcloud a:hover,
	div.product span.tagged_as a:hover,
	.nav-tabs > li > a:hover,
	.nav-tabs > .active > a,
	.nav-tabs > .active > a:hover,
	a.btn-type.gray:hover,
	.products-popup .title-tabs a:hover,
	.products-popup .title-tabs a.selected {
		color: <?php echo $trego_vars['button_hover_color_2']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['menu_color'])) { ?>
	.mega-menu > ul > li > a,
	.mega-menu > ul > li > h5,
	ul.special-menu-items li a {
		color: <?php echo $trego_vars['menu_color']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['submenu_color'])) { ?>
	.mega-menu .popup ul li a,
	.mega-menu .popup ul li h5,
	.accordion-menu > ul > li > a,
	.accordion-menu > ul > li > h5,
	.accordion-menu a,
	.accordion-menu h5 {
		color: <?php echo $trego_vars['submenu_color']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['menu_hover_color'])) { ?>
	.mega-menu > ul > li > a:hover,
	.mega-menu > ul > li > a:focus,
	.mega-menu > ul > li:hover > a,
	.mega-menu > ul > li:hover > h5,
	.mega-menu .popup ul li a:hover,
	.mega-menu .popup ul li a:focus,
	ul.special-menu-items li a:hover,
	.accordion-menu ul a:hover,
	.accordion-menu ul a:focus {
		color: <?php echo $trego_vars['menu_hover_color']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['font_color_2'])) { ?>
	ul.products li.product a,
	.section-name,
	.ico-block .ico-block-title,
	.ico-block.vertical .ico-block-title,
	.ico-block .ico-mark > span,
	.ico-block.single .ico-mark > span,
	.ico-block.single .ico-block-title,
	.widget.trego_recent_posts li .post-title a,
	.footer-widget-container.trego_recent_posts li .post-title a,
	article.post header .entry-title a,
	.post-portfolio h3.entry-title, .port-info h3.entry-title,
	article.page header .entry-title a,
	article.product header .entry-title a,
	.post-portfolio h3.entry-title,
	.post-portfolio p.entry-category,
	article.post .entry-summary a.read-more,
	article.page .entry-summary a.read-more,
	article.product .entry-summary a.read-more,
	div.team-member h4.member-name,
	#comments .comments-title,
	#respond .comment-reply-title,
	#comments ul.comment-list .comment-metadata .reply a,
	ul.products.list li.product .add-cart-bar .yith-wcwl-add-to-wishlist a,
	#order_review table.order-review-table tfoot th {
		color: <?php echo $trego_vars['font_color_2']; ?>;
	}
	.cart-collaterals .cart_totals table .cart-total-title th {
		color: <?php echo $trego_vars['font_color_2']; ?> !important;
	}
<?php } ?>
<?php if (!empty($trego_vars['placeholder_color'])) { ?>
	::-webkit-input-placeholder {
		color: <?php echo $trego_vars['placeholder_color']; ?> !important;
	}
	:-moz-placeholder {
		color: <?php echo $trego_vars['placeholder_color']; ?> !important;
	}
	::-moz-placeholder {
		color: <?php echo $trego_vars['placeholder_color']; ?> !important;
	}
	:-ms-input-placeholder {
		color: <?php echo $trego_vars['placeholder_color']; ?> !important;
	}
	::-moz-placeholder {
		color: <?php echo $trego_vars['placeholder_color']; ?> !important;
	}
	.placeholder {
		color: <?php echo $trego_vars['placeholder_color']; ?> !important;
	}
	.widget.trego_recent_posts li .post-date,
	.widget.trego_recent_posts li .post_comments,
	.footer-widget-container.trego_recent_posts li .post-date,
	.footer-widget-container.trego_recent_posts li .post_comments,
	#comments ul.comment-list .comment-metadata {
		color: <?php echo $trego_vars['placeholder_color']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['price_color_1'])) { ?>
	ul.products li.product .price,
	ul.product_list_widget li ins,
	ul.product_list_widget li > span.amount,
	div.product p.price,
	.bxslider-container .product-info .price,
	table.order_list tfoot tr:last-child td span.amount,
	table.order_list td.order-total span.amount,
	td.product-subtotal,
	.cart-collaterals .cart_totals table .total .amount,
	#order_review table.shop_table td.product-total,
	#order_review table.order-review-table tr.total td .amount,
	ul.cart_list li .amount,
	.quick-access .menu-cart p.total span.amount,
	div.product span.price {
		color: <?php echo $trego_vars['price_color_1']; ?>;
	}
<?php } ?>
<?php if (!empty($trego_vars['price_color_2'])) { ?>
	ul.products li.product .price del,
	ul.products li.product .price .from,
	div.product p.price del,
	div.product p.price .from,
	ul.product_list_widget li del,
	ul.product_list_widget li .from,
	.bxslider-container .product-info .price del,
	.bxslider-container .product-info .price .from {
		color: <?php echo $trego_vars['price_color_2']; ?>;
	}
<?php } ?>
<?php if (isset($trego_vars['mini_menu']) && $trego_vars['mini_menu'] == 1) { ?>
	@media only screen and (min-width: 1025px) and (max-height:800px) {
		.menu-toggle {
			display: none;
		}
		.toggled-on #main-menu {
			display: none;
		}
		nav #main-menu {
			display: block;
		}
		.box-scroll {
			position: static;
			margin-bottom: 45px;
		}
		.site-header div.social-icons {
			position: static;
		}
		.site-header div.copyrights {
			position: static;
		}
	}
<?php } ?>
<?php if (isset($trego_vars['disable_special_product_menu']) && $trego_vars['disable_special_product_menu'] == 1) { ?>
	@media only screen and (min-width: 1025px) {
		.site-header div.special-menu {
			display: none;
		}
	}
	@media only screen and (min-width: 768px) and (max-width: 1024px) {
		.site-header div.show-popup {
			display: none;
		}
	}
<?php } ?>
<?php if (isset($trego_vars['disable_search_form']) && $trego_vars['disable_search_form'] == 1) { ?>
	.site-header form.searchform {
		display: none;
	}
<?php } ?>
<?php if(is_user_logged_in()): ?>
    @media only screen and (min-width: 768px) and (max-width: 1024px) {
        .site-header .header-sidebar {
            top: 15px;
        }
    }
    @media only screen and (min-width: 768px) {
        html {
            margin-top: 0 !important;
        }
    }
	@media only screen and (max-width: 767px) {
		.one-template .header-sidebar {
			top: 40px;
		}
	}
<?php endif; ?>
<?php if(!empty($trego_vars['header_bg_color'])) { ?>
	.header-sidebar,
	.fullscreen .header-sidebar {
		background-color: <?php echo $trego_vars['header_bg_color']; ?>;
	}
	@media only screen and (min-width: 768px) and (max-width: 1024px) {
		.site-header .header-sidebar {
			background-color: <?php echo $trego_vars['header_bg_color']; ?>;
		}
	}
	@media only screen and (max-width: 767px) {
		.site-header .header-sidebar {
			background-color: <?php echo $trego_vars['header_bg_color']; ?>;
		}
	}
<?php } ?>
<?php if(trego_get_background()) { ?>
	.page-background {
		background: url("<?php echo trego_get_background(); ?>") repeat scroll 0 0;
		background-position: center center;
		background-repeat: no-repeat;
		background-size: cover;
		bottom: 0;
		left: 0;
		position: fixed;
		opacity: <?php echo trego_get_background_opacity(); ?>;
	    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo trego_get_background_opacity() * 100; ?>)";
		right: 0;
		top: 0;
		z-index: -1;
	}
	.header-topblock {
		background: none;
		position: relative;
	}
	.site-main {
		padding-top: 0;
	}
	@media only screen and (min-width: 768px) and (max-width: 1024px) {
		.site-header .header-sidebar {
			position: relative;
			<?php if(empty($trego_vars['header_bg_color'])) { ?>
			background-color: transparent;
			<?php } ?>
		}
		.header-topblock {
			top: 0;
		}
		.header-sidebar-bg {
			display: none;
		}
		.site-main {
			padding-top: 0;
		}
	}
<?php } ?>
<?php if(is_page_template('page-gallery-template.php')) { ?>
::-webkit-input-placeholder {
	color: #cfcfcf;
	opacity: 1 !important;
}

:-moz-placeholder {
	color: #cfcfcf;
	opacity: 1 !important;
}

::-moz-placeholder {
	color: #cfcfcf;
	opacity: 1 !important;
}

:-ms-input-placeholder {
	color: #cfcfcf;
	opacity: 1 !important;
}

.placeholder {
	color: #cfcfcf !important;
}
<?php } ?>
<?php
	if (!empty($trego_vars['custom_css'])) {
		echo $trego_vars['custom_css'];
	}
?>
</style>
<!--[if lte IE 9]>
<style type="text/css">
.animation-group .animation,
.bxslide .inner-box.animated,
.banner .inner-box.animated {
	opacity: 1;
}
.slide-wrapper .content-box.animated {
	opacity: 1;
}
</style>
<![endif]-->
<?php
}
add_action( 'wp_head', 'trego_custom_css', 100 );
?>