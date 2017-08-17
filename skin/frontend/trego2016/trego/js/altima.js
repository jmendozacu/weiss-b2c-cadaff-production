
/* Product name ellipsis */
jQuery(window).load(function () {
    jQuery('.category-products .products-grid .item .product-name, .block-related .block-content .products-grid  .item .product-name').dotdotdot({
        ellipsis: '...',
        watch: true
    });
});



jQuery(document).ready(function () {

    // if(window.location.href.indexOf("/customer/account/index") > -1) {
    //     ga( 'send', 'pageview', '#virtual_ /checkout_identification');
    // }

    /*  Mini cart  */
    jQuery('.cart-user-links').find('.cart-link').mouseover(function(){
        jQuery('#mini-cart-wrapper-regular').show();
    });
      jQuery('#mini-cart-wrapper-regular').mouseover(function(){
        jQuery(this).show();
    });
    jQuery('#mini-cart-wrapper-regular').mouseout(function(){
        jQuery(this).hide();
    });


     /*  Add arrow to the menu  */
     jQuery("#nav.megamenu").find("li.parent > a span").append('<span class="mega-menu-arrow"></span>');

     /* append related blog box to the product description */
     var blogRelatedBox = jQuery('.box-related-posts');
     jQuery('.product-collateral .short-description').find('.akordeon-item-content').append(blogRelatedBox);

    /* Ballotin Product */
    // display warning message when no option selected
    jQuery('.ballotin-extra').find('.button.btn-cart').on('click',function(){
        if(!jQuery(this).hasClass('validation-passed')){
               jQuery('.ballotin-extra').find('.ballotin-add-to-cart-msg').show(300);
               jQuery(this).addClass('hide-ballotin-msg');
        }

    });

    // ballotin option checkbox functiuonality:
    jQuery('.ballotin-extra').find('.button.btn-cart').attr('onclick',false);
    jQuery('.optionextended-wide-grid .input-box .options-list .ballotin-img-wrappert .product-custom-option').on('change', function () {
        jQuery(this).parent().parent().toggleClass('ballotin-hover');
        if(jQuery(this).parent().parent().find('.added').text() == 'Ajouter'){
            jQuery(this).parent().parent().find('.added').text('Ajouté');
        }else{
             jQuery(this).parent().parent().find('.added').text('Ajouter')
        }
//        jQuery(this).parent().parent().find('.added').text('gdsgwfgd');
        if(jQuery(".optionextended-wide-grid .input-box .options-list .ballotin-img-wrappert .product-custom-option:checked").length === 1 ){
            jQuery('.ballotin-extra').find('.button.btn-cart').on('click',function(){
                productAddToCartForm.submit(this);
            });
        }
        // hide ballotin warning message when user select an option
        if(jQuery(".optionextended-wide-grid .input-box .options-list .ballotin-img-wrappert .product-custom-option:checked").length > 0 ){
            jQuery('.ballotin-extra').find('.ballotin-add-to-cart-msg').hide();
        }
        jQuery('.ballotin-extra').find('.button.btn-cart.hide-ballotin-msg').on('click',function(){
                jQuery('.ballotin-extra').find('.ballotin-add-to-cart-msg').hide();
        });

    });

    var lists = jQuery('.optionextended-wide-grid .input-box .options-list .ballotin-img-wrappert');
    lists.each(function (index) {
        var pupinHref = jQuery(this).find('.pupin-anchor').attr('href');
        jQuery(this).find('.img-wrapper a').on('click',function(){
           var dataLinkId = pupinHref.replace('#','');
           jQuery('[data-remodal-id= "' + dataLinkId + '" ]').remodal().open();
        });
        jQuery(this).find('.ballotin-qm .pupin-anchor').on('click',function(){
           var dataLinkId = pupinHref.replace('#','');
           jQuery('[data-remodal-id= "' + dataLinkId + '" ]').remodal().open();
        });
        jQuery(this).find('.img-wrapper a').attr('href', pupinHref);

    });

    /* Show more reviews */
    jQuery(".product-view").find('.reviews-button-1').on('click', function () {
        jQuery('#customer-reviews').find('.one-review-container:first').next().nextAll().toggleClass('hide-review');
    });
    /* Menu accordion (Left sidebar) */
    if (window.innerWidth > 1024) {
        createMageAccordion();
    }
    /* Product page accordion */
    jQuery('.product-view .product-collateral .akordeon-item-head').find('h2.akordeon-heading').on('click', function () {
           jQuery(this).parent().prev().find('span').toggleClass('span-open').toggleClass('span-close');
    });

    /* Switch review form */
    jQuery('.product-reviews-buttons-container .reviews-button-2').on('click', function () {
        jQuery('#reviewform .reviews-form-container').toggle();
        jQuery(this).text(function (i, text) {
            return text === "laisser un avis" ? "Masquer le formulaire d'avis" : "laisser un avis";
        });
    });

    jQuery('.product-reviews-buttons-container .reviews-button-3').on('click', function () {
        jQuery('#reviewform .reviews-form-container').toggle();
        jQuery(this).text(function (i, text) {
            return text === "laisser un avis" ? "Masquer le formulaire d'avis" : "laisser un avis";
        });

    });


    // put the link to form reviews in the rating box:
    var linkToReviewsForm = jQuery('.link-to-review-form');
    jQuery('#product_addtocart_form .product-essential .product-shop').find('.rating-box').after(linkToReviewsForm);


    // Social Share Icons
    /*
    var SocialShareIcons = jQuery('.product-essential').find('.addthis_toolbox');
    jQuery('.add-to-cart').find('.product-socials').append(SocialShareIcons);
    jQuery(SocialShareIcons).append('<a href="https://www.instagram.com/chocolatweiss/" class="in"></a>');
    */


    /******************************  Middle Screens  **********************************/

    if (window.innerWidth <= 1024) {
        jQuery("#nav.megamenu").find("li.parent > a").on('click', function (e) {
            e.preventDefault();
            return false;
        });

        createMageAccordion();

        /* Toggle search icon with input text field */

        jQuery('#search_mini_form').find('#search').hide();

        jQuery('#search_mini_form button:first').on('click', function (eve) {
            eve.preventDefault();
//            jQuery(this).hide();
            jQuery(this).prev().show();
            jQuery(this).prev().on('click', function () {
                jQuery(this).prev().unbind(eve);
            });
        });

        /* Accordion menu toggle */
        var socialIcons = jQuery('.header-sidebar').find('.social-icons');
        jQuery('.header-sidebar').find('.nav-container').append(socialIcons);
        socialIcons.show();
        jQuery('.accordion-menu-trigger').on('click',function(e){
            jQuery('#search_mini_form').find('#search').hide();
            jQuery(this).find('img').toggle();
            (jQuery(".trigger-text").text() === "Menu") ? jQuery(".trigger-text").text("menu") : jQuery(".trigger-text").text("Menu");
            jQuery(this).next().toggle();
        });


    }

    /******************************  Mobile Screens  **********************************/
    if (window.innerWidth <= 767) {
        //$('#colophon .widget-bottom ul li .footer-title').append('<span class="arrow-down"></span>');
        // Footer accordio
        jQuery('.footer .col4-set > div').find('.footer-title').append('<span class="footer-nav-arrow-close"></span>');
        jQuery('.footer .col4-set > div').find('.footer-title').on('click',function(){
            jQuery(this).find('span').toggleClass('footer-nav-arrow-close').toggleClass('footer-nav-arrow-open');
//            $(this).find('.arrow-up').toggle();
            jQuery(this).next().slideToggle();
            jQuery(this).parent().siblings().find('div:first').next().slideUp();
        });

        jQuery('dd.optionextended-narrow-grid ul.options-list input.checkbox').on('change', function () {
            jQuery(this).parent().parent().toggleClass('ballotin-hover');
                    if(jQuery(this).parent().parent().find('.added').text() == 'Ajouter'){
            jQuery(this).parent().parent().find('.added').text('Ajouté');
        }else{
             jQuery(this).parent().parent().find('.added').text('Ajouter')
        }


        });


        /* Ballotin product select list */
        jQuery('.ballotin-tabs ul.etabs').prepend('<span class="tab ballotin-options-trigger"></span>');
        jQuery('.ballotin-tabs ul.etabs .ballotin-options-trigger').on('click',function(){
            jQuery('.ballotin-tabs ul.etabs li.tab').siblings('li.tab:not(.active)').slideToggle(50);
            jQuery('.ballotin-tabs ul.etabs li.tab:not(.active)').on('click',function(){
                jQuery(this).addClass('active');
                jQuery(this).siblings('li.tab').hide();
            });
        });


        /* Menu and search icon */
        jQuery('#search_mini_form button:first').on('click',function(){
          jQuery('.nav-container').hide();
        });




    }




    function createMageAccordion() {

        //li.parent > a span
        jQuery("#nav.megamenu").find("li.parent > a").on('click', function (e) {
            e.preventDefault();
            var $this = jQuery(this);
            $this.find('span span').toggleClass('mega-menu-arrow').toggleClass('mega-menu-arrow-switch');
            if ($this.next().hasClass('show')) {
                $this.next().removeClass('show');
                $this.next().slideUp(350);
            } else {
                $this.parent().parent().find('li ul').removeClass('show');
                $this.parent().parent().find('li ul').slideUp(350);
                $this.next().toggleClass('show');
                $this.next().slideToggle(350);
            }
        });
    }



    /* open category menu item throgh navigation */
   var menuItems =  jQuery('.megamenu').find('span');
    menuItems.each(function(){
        var currentCatName = jQuery('.current-category-name').text().toLowerCase().trim();
        var catItem = jQuery(this).text().toLowerCase().trim();
        if(currentCatName ===  catItem){
         jQuery(this).parents('ul').addClass('current-category');
         jQuery(this).addClass('current-category-item');
        }
    });
    jQuery('.megamenu > li > ul:first').slideUp(100);
    jQuery('.current-category').slideDown(100);



    if(window.innerWidth  <= 425) {

        jQuery('.ballotin-extra').find('.button.btn-cart').on('click',function(){
            if(jQuery('.ballotin-hover')[0]){
                jQuery('.ballotin-add-to-cart-msg').hide();
                 productAddToCartForm.submit(this);
            }

         });


    }
});




