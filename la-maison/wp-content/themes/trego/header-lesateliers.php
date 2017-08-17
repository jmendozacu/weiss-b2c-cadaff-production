<?php
/**
 * @package Trego
 * @since Trego 1.0
 */

global  $trego_vars;
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7ç" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="UTF-8">
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
<!-- BEGIN GOOGLE ANALYTICS CODEs -->
<script type="text/javascript">
//<![CDATA[
    var _gaq = _gaq || [];
    
_gaq.push(['_setAccount', 'UA-17548001-1']);

_gaq.push(['_trackPageview']);
    
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

//]]>
</script>
<!-- END GOOGLE ANALYTICS CODE -->
</head>

<body <?php body_class(); ?>>
	<div id="wrapper">
		<header id="masthead" class="site-header" role="banner">
			<div class="header-top-line"></div>
			<a class="scroll-top" href="#masthead" title="<?php echo __('Top', 'trego');?>"></a>
			<div class="header-sidebar"><!-- .header-sidebar -->
				<div class="header-topbox container">
					<a class="logo" href="/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home">
					<img src="http://www.chocolat-weiss.fr/la-maison/wp-content/themes/trego/images/logo-weiss-lesateliers.png" class="header_logo" alt="Ateliers Weiss">
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
									wp_nav_menu(array(
										'theme_location' => 'menu_les_ateliers',
										'container' => '',
										'menu_class' => '',
										'before' => '',
										'after' => '',
										'link_before' => '',
										'link_after' => '',
										'fallback_cb' => false,
										'walker' => new trego_top_navwalker
									));
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
									    wp_nav_menu(array(
									        'theme_location' => 'menu_les_ateliers',
									        'container' => '',
									        'menu_class' => '',
									        'before' => '',
									        'after' => '',
									        'link_before' => '',
									        'link_after' => '',
									        'fallback_cb' => false,
									        'walker' => new trego_accordion_navwalker
									    ));
								    ?></div>
								</div>
							</nav><!-- #site-navigation -->
						</div><!-- #navbar -->
                        <div class="search-form clear">
<form id="search_mini_form" action="http://www.chocolat-weiss.fr/catalogsearch/result/" method="get">
    <div class="form-search">
        <input id="search" type="text" name="q" value="" class="input-text" maxlength="128" autocomplete="off" style="display: block;" placeholder="Recherche...">
        <input type="submit" title="Chercher" class="magsearch" style="display: block;" value="" />
        <div id="search_autocomplete" class="search-autocomplete" style="display: none;"></div>
        <script type="text/javascript">
        //<![CDATA[
            var searchForm = new Varien.searchForm('search_mini_form', 'search', 'Recherche...');
            searchForm.initAutocomplete('http://www.chocolat-weiss.fr/catalogsearch/ajax/suggest/', 'search_autocomplete');
        //]]>
        </script>
    </div>
</form>						</div>
                        
																</div>
				</div>
			
				<div class="header-bottom">
					<div class="social-icons">
						<ul class="social-links">
						<?php if(!empty($trego_vars['facebook_link'])) :?>
							<li><a title="Facebook" href="<?php echo $trego_vars['facebook_link']; ?>" class="facebook" target="_blank"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['twitter_link'])) :?>
							<li><a title="Twitter" href="<?php echo $trego_vars['twitter_link']; ?>" class="twitter" target="_blank"></a></li>
						<?php endif; ?>
						
						
						<?php if(!empty($trego_vars['googleplus_link'])) :?>
							<li><a title="Google Plus" href="<?php echo $trego_vars['googleplus_link']; ?>" class="googleplus" target="_blank"> </a></li>
						<?php endif; ?>
						
						<?php if(!empty($trego_vars['youtube_link'])) :?>
							<li><a title="YouTube" href="<?php echo $trego_vars['youtube_link']; ?>" class="youtube" target="_blank"> </a></li>
						<?php endif; ?>
						<?php if(!empty($trego_vars['instagram_link'])) :?>
							<li><a title="Instagram" href="<?php echo $trego_vars['instagram_link']; ?>" class="instagram" target="_blank"> </a></li>
						<?php endif; ?>
						</ul>
					</div>
					<div class="copyrights"><?php if(isset($trego_vars['copyright'])) echo $trego_vars['copyright']; ?></div>
				</div>
			</div><!-- .header-sidebar -->
			
			<div class="menu-weiss"> <ul class="links">
<li class="first"><a title="Mon Compte" href="/customer/account/">Mon compte</a></li>
<li><a class="top-link-checkout" title="Commander" href="/checkout/">Commander</a></li>
<li><a class="top-link-blog" title="La Maison" href="/la-maison/chocolaterie-weiss/">La maison</a></li>
<li><a class="top-link-contact" title="Contact" href="/la-maison/nous-contacter">contact</a></li>
<li class=" last"><a title="Je me connecte" href="/customer/account/login/">Je me connecte</a></li>
</ul><!-- fermeture ul bandeau_haut-->
</div>
		</header><!-- #masthead -->
				
		<div id="main" class="site-main">
		
		<?php if ( is_page_template('page-gallery-template.php') ) : ?>
			<ul id="supersized"></ul>
		<?php endif; ?>
