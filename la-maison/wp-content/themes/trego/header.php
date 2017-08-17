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
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <link rel="icon" href="/la-maison/wp-content/themes/trego/favicon.ico" type="image/x-icon" />
        <link rel="profile" href="//gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>
        
    <!-- START GOOGLE TAG MANAGER -->
    <!--<script>-->
        /*
       var tagmanager_event=function(event_name,event_data){
            try{
                for(parameter in event_data) {
                    var eventParam ={};
                    eventParam[event_name + '_' + parameter]=event_data[parameter];
                    window.dataLayer.push(eventParam);
                }
                window.dataLayer.push({event:event_name});
    //Pour l'espace de recette : console.log({eventData:event_data,event:event_name});
    //            console.log({eventData:event_data,event:event_name});
            }catch(e){
            }};
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MCJ26C');
*/
    <!--</script>-->
    <!-- END GOOGLE TAG MANAGER -->

</head>

<body <?php body_class(); ?>>
    <!-- IMPLEMENTATION OF GOOGLE TAG MANAGER PLUGIN -->
    <?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
    <!--Start Google Tag Manager-->
    <!--<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MCJ26C"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>-->
    <!--End Google Tag Manager-->
    <div id="wrapper">
        <header id="masthead" class="site-header" role="banner">

            <div class="header-top-line"></div>
            <a class="scroll-top" href="#masthead" title="<?php echo __('Top', 'trego'); ?>"></a>
            <div class="header-sidebar"><!-- .header-sidebar -->
                <div class="header-topbox container">
                    <a class="logo" href="/la-maison" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?> - <?php bloginfo('description'); ?>" rel="home">
                        <?php
                        $site_title = esc_attr(get_bloginfo('name', 'display'));

                        if (is_page_template('page-gallery-template.php')) {
                            if (!empty($trego_vars['site_logo2'])) {
                                echo '<img src="/la-maison/wp-content/uploads/2015/06/logo1.png" class="header_logo" alt="' . $site_title . '"/>';
                            } else {
                                echo '<img src="/la-maison/wp-content/uploads/2015/06/logo1.png" class="header_logo" alt="' . $site_title . '"/>';
                            }
                        } else {
                            if (!empty($trego_vars['site_logo'])) {
                                echo '<img src="/la-maison/wp-content/uploads/2015/06/new-logo.png" class="header_logo" alt="' . $site_title . '"/>';
                                echo '<img src="/la-maison/wp-content/uploads/2015/06/logo-sm.png" class="header_logo logo_sm" alt="' . $site_title . '"/>';
                            } else {
                                echo '<img src="/la-maison/wp-content/uploads/2015/06/new-logo.png" class="header_logo" alt="' . $site_title . '"/>';
                                echo '<img src="/la-maison/wp-content/uploads/2015/06/logo-sm.png" class="header_logo logo_sm" alt="' . $site_title . '"/>';
                            }
                        }
                        ?>
                    </a>
                    <div class="box-scroll">
                        <div id="navbar" class="navbar">
                            <!-- accordion menu trigger -->
                            <div class="accorion-menu-trigger">
                                <div class="trigger">
                                    <img class="menu-sm-open" src=<?php bloginfo('template_directory'); ?>/images/menu-sm-open.jpg />
                                         <img class="menu-sm-close" src=<?php bloginfo('template_directory'); ?>/images/menu-sm-close.jpg />
                                         <img class="menu-mob-close" src=<?php bloginfo('template_directory'); ?>/images/menu-mob-close.png />
<!--									<span>Menu</span>-->
                                </div>
                            </div>

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
                                    if (is_page_template('page-one-template.php') && has_nav_menu('secondary') && !is_page('homemagento')) {
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
                                    } elseif (is_page('homemagento')) {
                                        wp_nav_menu(array(
                                            'theme_location' => 'magento',
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
                                    ?>
                                    <!-- social icons in sm-md -->
                                    <div class="social-md-sm"></div>
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
                                        if (is_page_template('page-one-template.php') && has_nav_menu('secondary')) {
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
                                                'walker' => new trego_top_navwalker
                                            ));
                                        }
                                        ?></div>
                                </div>
                            </nav><!-- #site-navigation -->
                        </div><!-- #navbar -->
                        <div class="search-form clear">
                            <form id="search_mini_form" action="/catalogsearch/result/" method="get">
                                <div class="form-search">
                                    <input id="search" type="text" name="q" value="" class="input-text" maxlength="128" autocomplete="off" style="display: block;" >
                                    <input type="submit" title="Chercher" class="magsearch" style="display: block;" value="" />
                                    <div id="search_autocomplete" class="search-autocomplete" style="display: none;"></div>
                                    <script type="text/javascript">
                                        //<![CDATA[
//                                        var searchForm = new Varien.searchForm('search_mini_form', 'search', 'Recherche...');
//                                        searchForm.initAutocomplete('/catalogsearch/ajax/suggest/', 'search_autocomplete');
                                        //]]>
                                    </script>
                                </div>
                            </form>						</div>

                        <?php if (class_exists('Woocommerce') && !is_page_template('page-one-template.php')) { ?>
                            <div class="special-menu clear">
                                <ul class="special-menu-items">
                                    <li><a href="#latest_products" data-name="<?php echo __('Latest Products', 'trego'); ?>"><?php echo __('Latest', 'trego'); ?><span></span></a></li>
                                    <li><a href="#featured_products" data-name="<?php echo __('Featured Products', 'trego'); ?>"><?php echo __('Featured', 'trego'); ?><span></span></a></li>
                                    <li><a href="#sale_products" data-name="<?php echo __('Special Products', 'trego'); ?>"><?php echo __('Specials', 'trego'); ?><span></span></a></li>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="header-bottom">
                    <div class="social-icons">
                        <ul class="social-links">
                            <?php if (!empty($trego_vars['facebook_link'])) : ?>
                                <li><a title="Facebook" href="<?php echo $trego_vars['facebook_link']; ?>" class="facebook" target="_blank"> </a></li>
                            <?php endif; ?>
                            <?php if (!empty($trego_vars['twitter_link'])) : ?>
                                <li><a title="Twitter" href="<?php echo $trego_vars['twitter_link']; ?>" class="twitter" target="_blank"></a></li>
                            <?php endif; ?>
                            <?php if (!empty($trego_vars['linkedin_link'])) : ?>
                                <li><a title="Linkedin" href="<?php echo $trego_vars['linkedin_link']; ?>" class="linkedin" target="_blank"> </a></li>
                            <?php endif; ?>
                            <?php if (!empty($trego_vars['flickr_link'])) : ?>
                                <li><a title="Flickr" href="<?php echo $trego_vars['flickr_link']; ?>" class="flickr" target="_blank"> </a></li>
                            <?php endif; ?>
                            <?php if (!empty($trego_vars['googleplus_link'])) : ?>
                                <li><a title="Google Plus" href="<?php echo $trego_vars['googleplus_link']; ?>" class="googleplus" target="_blank"> </a></li>
                            <?php endif; ?>
                            <?php if (!empty($trego_vars['pinterest_link'])) : ?>
                                <li><a title="Pinterest" href="<?php echo $trego_vars['pinterest_link']; ?>" class="pinterest" target="_blank"> </a></li>
                            <?php endif; ?>
                            <?php if (!empty($trego_vars['youtube_link'])) : ?>
                                <li><a title="YouTube" href="<?php echo $trego_vars['youtube_link']; ?>" class="youtube" target="_blank"> </a></li>
                            <?php endif; ?>
                            <?php if (!empty($trego_vars['instagram_link'])) : ?>
                                <li><a title="Instagram" href="<?php echo $trego_vars['instagram_link']; ?>" class="instagram" target="_blank"> </a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="copyrights"><?php if (isset($trego_vars['copyright'])) echo $trego_vars['copyright']; ?></div>
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
                                    if ($woocommerce->cart->cart_contents_count == 1) {
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
                                    $(document).ready(function ($) {
                                        $('.cart-box .cart-contents').click(function (e) {
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
            <div class="menu-weiss">
                <div class="section-block">
                    <div class="section-content">
                        <div class="site-content">
                            <div class="menu-weiss-content">
                                <ul class="links">                                    
                                    <li class="first delivery-offers"><span class="delivery-offers-icon"></span><a title="" href="/la-maison/livraison-chocolats-weiss/#tarifs-de-livraison"><?php echo __('Free delivery in France','trego'); ?><br class="break-line" /> <?php echo __("when you spend over €35","trego"); ?> </a></li>                                    
                                    <li class="delivery-48"><span class="delivery-48-icon"></span><a class="" title="" href="/la-maison/livraison-chocolats-weiss/#details"><?php echo __('Delivery in 48h','trego'); ?></a></li>
                                    <li class="fabrication"><span class="fabrication-icon"></span><a class="" title="" href="/la-maison/la-maison-weiss/"><?php echo __('Made in France','trego'); ?></a></li>
                                </ul><!-- fermeture ul bandeau_haut-->
                            </div>
                            <div class="discover last">
                                <span class="discover-menu-trigger"><?php echo __('Discover our sites','trego'); ?> <span class="discover-menu-trigger-icon"></span></span>
                                <ul>
                                    <li><a href="https://entreprise.chocolat-weiss.fr/"><span class="caret"></span><span class="link"><?php echo __('Eshop Company Gifts','trego'); ?></span></a></li>
                                    <li><a href="http://www.chocolat-weiss-professionnel.fr/"><span class="caret"></span><span class="link"><?php echo __('Eshop Professionals','trego'); ?></span></a></li>
                                    <li><a href="http://www.weiss.fr/"><span class="caret"></span><span class="link"><?php echo __('La Maison Weiss','trego'); ?></span></a></li><li><a href="http://www.weiss.fr/ateliers-weiss/"><span class="caret"></span><span class="link"><?php echo __('Les Ateliers','trego'); ?></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header><!-- #masthead -->
        <!--  Display Newsletter modal at the third visit  -->
        <?php 

        ?>
   
            <div data-remodal-id="test" class="newsletter-modal">
                <div class="top span-12">
                    <button data-remodal-action="close" class="remodal-close"><img src="<?php bloginfo('template_directory'); ?>/images/pupin-close.jpg" alt=""></button>
                </div>
                <div class="span-12  span-m-12 span-s-12 column newsletter">
                    <div class="block block-subscribe">
                        <h2 class="newsletter-title">Newsletter</h2>
                        <?php $site = "http://" . $_SERVER['HTTP_HOST']; ?>
                        <form action="<?php echo $site ?>/newsletter/subscriber/new/" method="post" id="newsletter-validate-detail">                        
                            <div class="block-content">
                                <div class="form-subscribe-header span-12">
                                    <label for="newsletter"><?php echo __('Enter your email address to be informed of the latest news Weiss chocolate.','trego'); ?><br /><span><?php echo __('100 chip offered, or 2 € discount on your next order!','trego'); ?></span></label>
                                </div>
                                <div class="span-5 span-m-5 span-s-12 input-fields-container">
                                    <div class="input-box span-9 span-m-9 span-s-9">
                                        <input type="email" name="email" id="newsletter" title="Inscrivez-vous à notre newsletter" class="input-text required-entry validate-email" placeholder="">
                                    </div>
                                    <div class="actions span-3">
                                        <button type="submit" name='submit'class="button"><span><span></span><?php echo __('Ok','trego'); ?></span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                //<![CDATA[
                    

                //]]>
            </script>
        <?php if (class_exists('Woocommerce')) { ?>
            <div class="special-products-overlay">
                <div class="products-popup">
                    <div class="popup-label">
                        <div class="title"></div>
                        <div class="title-tabs">
                            <a class="tab-latest" href="#latest_products" data-name="<?php echo __('Latest Products', 'trego'); ?>">Latest</a>
                            <a class="tab-featured" href="#featured_products" data-name="<?php echo __('Featured Products', 'trego'); ?>">Featured</a>
                            <a class="tab-sale" href="#sale_products" data-name="<?php echo __('Special Products', 'trego'); ?>">Specials</a>
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

            <div class="woocommerce-icons">
                <div class="section-block">
                    <div class="section-content">
                        <div class="site-content">
                            <div class="span-1.5 span-m-6 span-s-6 column basket">
                                <a href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/checkout/cart/"><img class="basket-lg" src=<?php bloginfo('template_directory'); ?>/images/cart.png /><span><?php echo __('my cart','trego') ?></span></a>
                                <a href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/checkout/cart/"><img class="basket-sm" src=<?php bloginfo('template_directory'); ?>/images/cart-sm.png /></a>
                                
                            </div>
                            <div class="span-2  span-m-6 span-s-6 column user">
                                <a href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/customer/account/"><img class="user-lg" src=<?php bloginfo('template_directory'); ?>/images/account.png /><span><?php echo __('my account','trego') ?></span></a>
                                <a href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/customer/account/"><img class="user-sm" src=<?php bloginfo('template_directory'); ?>/images/user-sm.png /></a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php if (is_page_template('page-gallery-template.php')) : ?>
                <ul id="supersized"></ul>
            <?php endif; ?>

    <script type="text/javascript">
  //<![CDATA[
    jQuery(document).ready(function () {        
            function setCookie(c_name,value)
            {                
                document.cookie=c_name + "=" + value + '; path=/';
            }
            function getCookie(c_name)
            {
                var c_value = document.cookie;
                var c_start = c_value.indexOf(" " + c_name + "=");
                if (c_start == -1) {
                    c_start = c_value.indexOf(c_name + "=");
                }
                if (c_start == -1) {
                    c_value = null;
                } else {
                    c_start = c_value.indexOf("=", c_start) + 1;
                    var c_end = c_value.indexOf(";", c_start);
                    if (c_end == -1) {
                        c_end = c_value.length;
                    }
                    c_value = unescape(c_value.substring(c_start,c_end));
                }
                return c_value;
            }  
            setCookie('count_wp', parseInt(getCookie('count_wp')) ? parseInt(getCookie('count_wp'))+1 : 1)            
            if(parseInt(jQuery.cookie("count_wp"))=== 3 && jQuery.cookie("hide_newsletter")!= 'noNewsletter' ){
                jQuery('.newsletter-modal').attr('data-remodal-id','modal');
                jQuery('[data-remodal-id=modal]').remodal().open();
                jQuery('.newsletter-modal .remodal-close').on('click',function(){
                    document.cookie = 'hide_newsletter=noNewsletter; path=/'; 
                });
            }

    
    });
//]]>
</script>                
                