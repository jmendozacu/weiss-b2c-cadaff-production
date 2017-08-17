<?php
/**
 * @package Trego
 * @since Trego 1.0
 */

global $woo_options, $woocommerce, $trego_vars;
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
		if(!empty($trego_vars['site_favicon'])){
			$favicon = $trego_vars['site_favicon'];
		} else {
			$favicon = get_template_directory_uri() . '/favicon.ico';
		}
	?>
	<link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="wrapper">
		<header id="masthead" class="site-header" role="banner">
<div class="header-links">
<ul>
<li class="first"><a href="http://entreprise.chocolat-Weiss.fr" title="zum fashion e-Shop">Boutique Cadeaux D'Affaires >></a></li>
<li><a href="http://www.chocolat-weiss.fr/" title="Boutique Particuliers">Boutique >></a></li>
<li class="last"><a href="http://www.chocolat-weiss.fr/news" title="Entreprise">Entreprise >></a></li>
</ul>
</div>
			<div class="header-top-line">
   </div>
			<a class="scroll-top" href="#masthead" title="<?php echo __('Top', 'trego');?>"></a>
			<div class="header-sidebar"><!-- .header-sidebar -->
				<div class="header-topbox container">
					<a class="logo" href="/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home">
					<?php
						$site_title = esc_attr( get_bloginfo( 'name', 'display' ) );

						if(is_page_template('page-gallery-template.php')) {
							if(!empty($trego_vars['site_logo2'])){
								echo '<img src="'.$trego_vars['site_logo2'].'" class="header_logo" alt="'.$site_title.'"/>';
							} else {
								echo '<img src="'.get_template_directory_uri().'/images/logo.png" class="header_logo" alt="'.$site_title.'"/>';
							}
						} else {
							if(!empty($trego_vars['site_logo'])){
								echo '<img src="'.$trego_vars['site_logo'].'" class="header_logo" alt="'.$site_title.'"/>';
							} else {
								echo '<img src="'.get_template_directory_uri().'/images/logo.png" class="header_logo" alt="'.$site_title.'"/>';
							}
						}
					?>
					</a>
					<div class="box-scroll">
						<div id="navbar" class="navbar">
							<nav id="site-navigation" class="navigation main-navigation" role="navigation">
								<div class="menu-toggle">
								    <?php echo __('Menu', 'trego') ?>
								    <span class="btn btn-inverse">
								        <span class="icon-bar"></span>
								        <span class="icon-bar"></span>
								        <span class="icon-bar"></span>
								    </span>
								</div>
								<div id="main-menu" class="mega-menu">
								<?php
								if(is_page_template('page-one-template.php') && has_nav_menu('secondary') && !is_page('homemagento')){
									wp_nav_menu(array(
										'theme_location' => 'secondary',
										'container' => '',
										'menu_class' => '',
										'before' => '',
										'after' => '',
										'link_before' => '',
										'link_after' => '',
										'fallback_cb' => false,
										'walker' => new trego_top_navwalker
									));
								} elseif(is_page('homemagento')){
									wp_nav_menu(array(
										'theme_location' => 'magento',
										'container' => '',
										'menu_class' => '',
										'before' => '',
										'after' => '',
										'link_before' => '',
										'link_after' => '',
										'fallback_cb' => false,
										'walker' => new trego_top_navwalker
									));
								}else {
									wp_nav_menu(array(
										'theme_location' => 'primary',
										'container' => '',
										'menu_class' => '',
										'before' => '',
										'after' => '',
										'link_before' => '',
										'link_after' => '',
										'fallback_cb' => false,
										'walker' => new trego_top_navwalker
									));
								}
								?>
								</div>

								<div id="main-mobile-menu">
								    <div id="main-mobile-toggle" class="mobile-menu-toggle">
								        <?php echo __('Menu', 'trego') ?>
								        <span class="btn btn-inverse">
								            <span class="icon-bar"></span>
								            <span class="icon-bar"></span>
								            <span class="icon-bar"></span>
								        </span>
								    </div>
								    <div class="accordion-menu">
								    <?php
								    if(is_page_template('page-one-template.php') && has_nav_menu('secondary')){
									    wp_nav_menu(array(
									        'theme_location' => 'secondary',
									        'container' => '',
									        'menu_class' => '',
									        'before' => '',
									        'after' => '',
									        'link_before' => '',
									        'link_after' => '',
									        'fallback_cb' => false,
									        'walker' => new trego_accordion_navwalker
									    ));
									} else {
									    wp_nav_menu(array(
									        'theme_location' => 'primary',
									        'container' => '',
									        'menu_class' => '',
									        'before' => '',
									        'after' => '',
									        'link_before' => '',
									        'link_after' => '',
									        'fallback_cb' => false,
									        'walker' => new trego_accordion_navwalker
									    ));
									}
								    ?></div>
								</div>
							</nav><!-- #site-navigation -->
						</div><!-- #navbar -->
						<div class="search-form clear">
<form id="search_mini_form" action="http://weissnew.ntic.fr/catalogsearch/result/" method="get">
    <div class="form-search">
        <input id="search" type="text" name="q" value="" class="input-text" maxlength="128" autocomplete="off" style="display: block;" placeholder="Recherche...">
        <input type="submit" title="Chercher" class="magsearch" style="display: block;" value="" />
        <div id="search_autocomplete" class="search-autocomplete" style="display: none;"></div>
        <script type="text/javascript">
        //<![CDATA[
            var searchForm = new Varien.searchForm('search_mini_form', 'search', 'Recherche...');
            searchForm.initAutocomplete('http://weissnew.ntic.fr/catalogsearch/ajax/suggest/', 'search_autocomplete');
        //]]>
        </script>
    </div>
</form>						</div>
						<?php if (class_exists('Woocommerce') && !is_page_template('page-one-template.php')) { ?>
						<div class="special-menu clear">
						<ul class="special-menu-items">
							<li><a href="#latest_products" data-name="<?php echo __('Latest Products', 'trego');?>"><?php echo __('Latest', 'trego');?><span></span></a></li>
							<li><a href="#featured_products" data-name="<?php echo __('Featured Products', 'trego');?>"><?php echo __('Featured', 'trego');?><span></span></a></li>
							<li><a href="#sale_products" data-name="<?php echo __('Special Products', 'trego');?>"><?php echo __('Specials', 'trego');?><span></span></a></li>
						</ul>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="show-popup"><a href="#latest_products" data-name="<?php echo __('Latest Products', 'trego');?>"></a></div>
				<div class="header-bottom">
					<div class="social-icons">
						<ul class="social-links">
						<?php if(!empty($trego_vars['facebook_link'])) :?>
							<li><a title="Facebook" href="<?php echo $trego_vars['facebook_link']; ?>" class="facebook" target="_blank"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['twitter_link'])) :?>
							<li><a title="Twitter" href="<?php echo $trego_vars['twitter_link']; ?>" class="twitter"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['linkedin_link'])) :?>
							<li><a title="Linkedin" href="<?php echo $trego_vars['linkedin_link']; ?>" class="linkedin"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['flickr_link'])) :?>
							<li><a title="Flickr" href="<?php echo $trego_vars['flickr_link']; ?>" class="flickr"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['googleplus_link'])) :?>
							<li><a title="Google Plus" href="<?php echo $trego_vars['googleplus_link']; ?>" class="googleplus"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['pinterest_link'])) :?>
							<li><a title="Pinterest" href="<?php echo $trego_vars['pinterest_link']; ?>" class="pinterest"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['youtube_link'])) :?>
							<li><a title="YouTube" href="<?php echo $trego_vars['youtube_link']; ?>" class="youtube"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['instagram_link'])) :?>
							<li><a title="Instagram" href="<?php echo $trego_vars['instagram_link']; ?>" class="instagram"> </a></li>
						<?php endif; ?>
						</ul>
					</div>
					<div class="copyrights"><?php if(isset($trego_vars['copyright'])) echo $trego_vars['copyright']; ?></div>
				</div>
			</div><!-- .header-sidebar -->
			<div class="header-sidebar-bg"></div>
			<div class="header-topblock"><!-- .header-topblock -->
				<div class="header-topbar">
					<div class="quick-access">
						<!--
						<div class="language-box">
							<select class="language  border-none">
								<option>English</option>
								<option>German</option>
							</select>
						</div>
						-->
						<?php if (class_exists('Woocommerce')) { ?>
						<!--
						<div class="currency-box">
							<select class="currency  border-none">
								<option value="1">USD</option>
								<option value="9">EUR</option>
							</select>
						</div>
						-->
						<div class="cart-box">
							<?php global $woocommerce; ?>
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
							});
							</script>
						</div>
						<?php } ?>
					</div>
					<h1 class="page-title"><?php the_page_title(); ?></h1>
				</div>
			</div><!-- .header-topblock -->
		</header><!-- #masthead -->
		<?php if (class_exists('Woocommerce')) { ?>
		<div class="special-products-overlay">
			<div class="products-popup">
				<div class="popup-label">
					<div class="title"></div>
					<div class="title-tabs">
						<a class="tab-latest" href="#latest_products" data-name="<?php echo __('Latest Products', 'trego');?>">Latest</a>
						<a class="tab-featured" href="#featured_products" data-name="<?php echo __('Featured Products', 'trego');?>">Featured</a>
						<a class="tab-sale" href="#sale_products" data-name="<?php echo __('Special Products', 'trego');?>">Specials</a>
					</div>
					<div class="special-nav">
						<a id="prev-btn"></a>
						<a id="next-btn"></a>
					</div>
					<div class="close"></div>
				</div>
				<div class="popup-content">
					<div class="products-content-area"></div>
					<div class="slider-loading"></div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div id="main" class="site-main">
		<?php if ( is_page_template('page-gallery-template.php') ) : ?>
			<ul id="supersized"></ul>
		<?php endif; ?>
