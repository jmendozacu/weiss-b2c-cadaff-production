/**
 * Functionality specific to Trego.
 *
 * Provides helper functions to enhance the theme experience.
 */
function isEmpty(value){
	return (typeof value === "undefined" || value === null);
}

function getDocWidth() {
	if (self.innerWidth) {
	   return self.innerWidth;
	} else if (document.documentElement && document.documentElement.clientHeight){
	    return document.documentElement.clientWidth;
	} else if (document.body) {
	    return document.body.clientWidth;
	}
	return 0;
}

function sliderAutoStart(obj, pause){
    obj.stopAuto();
	setTimeout(function(){
		obj.startAuto();
	}, pause);
}

function resizeFunction(obj, container, cnt, opts) {
	reloadBxSlider(obj, container, cnt, opts);
};

function getSlideWidth(container, cnt){
	return Math.round(container.width() / cnt);
}

function reloadBxSlider(obj, container, cnt, opts){
	var slide_cnt;
	var doc_w = getDocWidth();
	if(isEmpty(opts.responsive)){
		slide_cnt = cnt;
	} else {
		for(var k in opts.responsive) {
			if((opts.responsive[k].min <= doc_w) && (opts.responsive[k].max >= doc_w)){
				slide_cnt = opts.responsive[k].cnt;
				break;
			}
		}
	}

	if(isEmpty(slide_cnt)){
		slide_cnt = cnt;
	}

	opts.slideWidth = getSlideWidth(container, slide_cnt);
	opts.maxSlides = slide_cnt;
	opts.minSlides = slide_cnt;
	obj.reloadSlider(opts);
}

function arrowIconsAlign(container){
	var h = container.find('.bx-wrapper .description').height();
	var offset;
	offset = container.hasClass('small-ctrls') ? 12 : 20;
	h = ( h==null ) ? ('-' + offset + 'px') : ('-' + ( ( h/2 ) + offset ) + 'px');
	container.find('.bx-wrapper .bx-controls-direction a').css('margin-top', h);
}

jQuery(document).ready(function($) {
	var sliderResizeTimer;

	$('.section-block.primary').height($(window).height());

    $(window).resize(function() {
        clearTimeout(sliderResizeTimer);
        sliderResizeTimer = setTimeout(
            function(){
                $('.section-block.primary').height($(window).height());
            }, 250);
    });

    $(window).scroll(function(){
        if ($(this).scrollTop() > $(window).height()) {
            $('.scroll-top').fadeIn('slow');
        } else {
            $('.scroll-top').fadeOut('slow');
        }
    });

	$('.scroll-top').click(function(e){
		e.preventDefault();
		$.scrollTo('#masthead', {axis:'y', duration: 800});
	});

	$(window).load(function(){
		// scrollbar setting
		$('html').niceScroll({horizrailenabled: false, zindex: 99999, cursorwidth:'7px', cursorborderradius:'7px', mousescrollstep:"40"});
		$('body').css('overflow', 'visible');
		$('input, textarea').placeholder();

        $("a[rel^='prettyPhoto']").prettyPhoto({social_tools: ''});

		if($(".parallax").get(0)) {
			$.stellar({
				responsive: true,
				horizontalScrolling: false
			});
		}

		jQuery('ul.products + div.slider-loading').hide();
		jQuery('.row-container div.slider-loading').hide();

		if(!!$('.one-template').length){
			$.localScroll({axis:'y', duration: 800});
			setTimeout(function(){
				$.scrollTo(window.location.hash, {axis:'y', duration: 800});
			}, 500);
		}

		/**
		 * Enables menu toggle for small screens.
		 */
		(function(){
			var nav = $( '#site-navigation' ), button, menu;
			if(!nav) return;

			button = nav.find('.menu-toggle');
			if(!button) return;

			// Hide button if menu is missing or empty.
			menu = nav.find('#main-menu');
			if(!menu || !menu.children().length){
				button.hide();
				return;
			}
			$('.menu-toggle').on('click.trego', function(e){
				e.stopPropagation();
				nav.toggleClass('toggled-on');
			});
		})();

		$('.menu-cart, .cart-product-list, .products-popup').click(function(e){
			e.stopPropagation();
		});

		var products_latest = "";
		var products_featured = "";
		var products_sale = "";
		var scrolled = 0;

		$('ul.special-menu-items li a, div.show-popup a, div.title-tabs a').click(function(e){
			e.stopPropagation();
			var product_popup = $(this).attr('href') + '_popup';
			var label = $(this).attr('data-name');

			$('.special-products-overlay').addClass('active');
			$('.special-products-overlay .popup-label .title').text(label);
			$(".products-content-area").animate({scrollTop: 0}, 0);
			$('.products-popup .slider-loading').show();
			$('.title-tabs a').removeClass('selected');

			$('ul.special-menu-items li a').removeClass('selected');
			$(this).addClass('selected');

			scrolled = 0;

			var products_html = "";
			if($(this).attr('href') == "#latest_products"){
				products_html = products_latest;
				$('.title-tabs .tab-latest').addClass('selected');

			} else if ($(this).attr('href') == "#featured_products") {
				products_html = products_featured;
				$('.title-tabs .tab-featured').addClass('selected');

			} else if ($(this).attr('href') == "#sale_products") {
				products_html = products_sale;
				$('.title-tabs .tab-sale').addClass('selected');
			}

			if(products_html == ""){
				var data = {
					action: 'special_products',
					chk: product_popup
				};

				$.post(ajax_url, data, function(response) {
					if(product_popup == "#latest_products_popup"){
						products_latest = response;

					} else if (product_popup == "#featured_products_popup") {
						products_featured = response;

					} else if (product_popup == "#sale_products_popup") {
						products_sale = response;
					}

					$('.products-popup .products-content-area').html(response);
					$('.products-popup .slider-loading').fadeOut(1000);
				});
			} else {
				$('.products-popup .products-content-area').html(products_html);
				$('.products-popup .slider-loading').fadeOut(1000);
			}
		});

		$('#prev-btn').click(function (e) {
			scrolled = scrolled - $(".popup-content").height();
			if(scrolled < 0) {
				scrolled = 0;
			}
			$(".products-content-area").animate({
			    scrollTop: scrolled
			}, 500);
		});

		$('#next-btn').on('click', function (e) {
			if(($(".popup-content ul.products").height() - scrolled) < ($(".popup-content").height()+100)){
				return;
			}

			scrolled = scrolled + $(".popup-content").height();

		    $(".products-content-area").animate({
		        scrollTop: scrolled
		    }, 500);
		});

		$('.products-popup .close').click(function(e){
			$('.special-products-overlay').removeClass('active');
			$('ul.special-menu-items li a').removeClass('selected');
		});

		$('html').click(function(){
			$('.menu-cart').hide();
			$('.special-products-overlay').removeClass('active');
			$('ul.special-menu-items li a').removeClass('selected');
		});

		/* add animations to banners in view */
        $('.banner .inner-box.animated').waypoint(function() {
            if(!$(this).parent().parent().parent().hasClass('bxslider')){
                var animation = $(this).attr("data-animate");
                $(this).addClass(animation);
            }
        }, { offset: '80%' });

        $('div.progress-bar .progress-value').waypoint(function() {
			$(this).css('width', $(this).attr('data-progress-animate')+'%');
        }, { offset: '80%' });

        $('.ico-block.animated').waypoint(function() {
            $(this).addClass($(this).attr("data-icon-animate"));
        }, { offset: '80%' });

        $('.banner .inner-box.animation-group').waypoint(function() {
            if(!$(this).parent().parent().parent().hasClass('bxslider')){
                var group = $(this);

                group.find('.animation').each(function(){
                    var animation = $(this).attr("data-easing");
                    var delay = 'delay-' + $(this).attr("data-start");
                    if(animation !== undefined){
                        group.css('overflow', 'visible');
                    }
                    $(this).addClass(animation);
                    $(this).addClass(delay);
                });
            }
        }, { offset: '80%' });
	});



/******************************  Add links to the header of the icons blocks  **********************************/
       
        var ico_links_columns = $('.weiss-wp-four-icon-blocks .column');
        ico_links_columns.each(function(i, val){
            $(val).find('.ico-block-desc a').on('click',function(e){
                e.preventDefault();
            });
           var ico_links = $(val).find('.ico-block-desc a').attr('href');
           $(val).find('.ico-block-title').wrap('<a clss="icon-link-src" href="' + ico_links + '" />');
        });    
/******************************  toggle top menu  **********************************/
	var topMenu = $(".menu-weiss .discover");
	$(".menu-weiss .discover ").find('.discover-menu-trigger').on('click',function(e){
		$(topMenu).find('ul').toggle();
	});
/******************************  Sidebar accordion menu  **********************************/
// .append('<span class="mega-menu-arrow"></span>');


    $(".mega-menu").find("li.menu-item-has-children h5").append('<span class="mega-menu-arrow"></span>');
//  display the first element
    var firstMenuHeader = $(".mega-menu .menu-item-has-children h5:first");
	$(firstMenuHeader).parent().find('> ul.sub-menu').show();
// Create accordion
	$(".mega-menu").find("li.menu-item-has-children h5").on('click',function(e) {
		var $this = $(this);
                $this.find('span').toggleClass('mega-menu-arrow').toggleClass('mega-menu-arrow-switch');
		if ($this.next().next().hasClass('show')) {
			$this.next().next().removeClass('show');
			$this.next().next().slideUp(350);
		} else {
			$this.parent().parent().find('li .sub-menu').removeClass('show');
			$this.parent().parent().find('li .sub-menu').slideUp(350);
			$this.next().next().toggleClass('show');
			$this.next().next().slideToggle(350);
		}
	});

    $('#menu-menu_magento li.menu-item-has-children ul').hover(function(){
        $('#menu-menu_magento').find('h5').css({'color' : '#4e4d49', 'background' : '#fff'});
    });
    $('#menu-menu_magento-french li.menu-item-has-children ul').hover(function(){
        $('#menu-menu_magento-french').find('h5').css({'color' : '#4e4d49', 'background' : '#fff'});
    });
    
    // Language selector:
    var LangSelector = $('.widget_icl_lang_sel_widget');
    $('#colophon .widget-bottom ul li:first').next().next().find('.textwidget').append(LangSelector);
    
/******************************  Site switcher link and redirections  **********************************/ 
            
            if(window.location.href.indexOf("livraison-chocolats-weiss/#tarifs-de-livraison") > -1){
                $('.accordion').find('.accordion-group:first').find('.collapse').removeClass('in');
                $('.accordion').find('.accordion-group:first').next().find('.collapse').addClass('in');   
                $('.accordion').find('.accordion-group:first').next().next().find('.collapse').removeClass('in'); 
                $("html, body").animate({ scrollTop: 0 });
                $('.menu-weiss-content').find('.delivery-48 a').on('click',function(e){                            
                    $('.accordion').find('.accordion-group:first').find('.collapse').removeClass('in');
                    $('.accordion').find('.accordion-group:first').next().find('.collapse').removeClass('in');                
                    $('.accordion').find('.accordion-group:first').next().next().find('.collapse').addClass('in');  
                    $("html, body").animate({ scrollTop: 0 });
                });
                $('.menu-weiss-content').find('.delivery-offers a').on('click',function(e){                              
                    $('.accordion').find('.accordion-group:first').find('.collapse').removeClass('in');
                    $('.accordion').find('.accordion-group:first').next().find('.collapse').addClass('in');                
                    $('.accordion').find('.accordion-group:first').next().next().find('.collapse').removeClass('in');  
                    $("html, body").animate({ scrollTop: 0 });
                }); 
            } 
            if(window.location.href.indexOf("livraison-chocolats-weiss/#details") > -1){
                $('.accordion').find('.accordion-group:first').find('.collapse').removeClass('in');
                $('.accordion').find('.accordion-group:first').next().find('.collapse').removeClass('in');                
                $('.accordion').find('.accordion-group:first').next().next().find('.collapse').addClass('in');   
                $("html, body").animate({ scrollTop: 0 });
                $('.menu-weiss-content').find('.delivery-offers a').on('click',function(e){                              
                    $('.accordion').find('.accordion-group:first').find('.collapse').removeClass('in');
                    $('.accordion').find('.accordion-group:first').next().find('.collapse').addClass('in');                
                    $('.accordion').find('.accordion-group:first').next().next().find('.collapse').removeClass('in');  
                    $("html, body").animate({ scrollTop: 0 });
                });  
                $('.menu-weiss-content').find('.delivery-48 a').on('click',function(e){                            
                    $('.accordion').find('.accordion-group:first').find('.collapse').removeClass('in');
                    $('.accordion').find('.accordion-group:first').next().find('.collapse').removeClass('in');                
                    $('.accordion').find('.accordion-group:first').next().next().find('.collapse').addClass('in');  
                    $("html, body").animate({ scrollTop: 0 });
                });
               
            } 
/******************************  Middle Screens  **********************************/

		if(window.innerWidth <= 1024  ) {
			$('#main-menu .social-md-sm').append($('.header-bottom .social-links'));
			$(".site-header .header-sidebar #main-menu > ul").slideToggle();
			$('#navbar').find('.trigger').on('click',function(){
                            $('.header-sidebar').find('#search').hide();
				$(".site-header .header-sidebar #main-menu > ul").slideToggle();
				$('#main-menu .social-md-sm').toggle();
				$(this).find('.menu-sm-open').toggle();
				$(this).find('.menu-sm-close').toggle();
			});
                        
                        
                        // Toggle the search icon with the text input field
                        
                        $('.header-sidebar').find('#search').hide();
                        $('.header-sidebar').find('.magsearch').on('click',function(eve){
                            eve.preventDefault();
//                            $(this).hide();
                            $(this).prev().show();   
                            $(this).prev().on('click',function(){
                               $(this).prev().unbind(eve); 
                            });
                        });
        
//			$('#weiss-primarily div').toggleClass('span-m-6').toggleClass('span-m-3');
//			$('.home-6-block  div').toggleClass('span-m-6').toggleClass('span-m-4');
			$('.home-6-block  div').toggleClass('span-s-12').toggleClass('span-s-6');
		}
                
                
/******************************  Mobile Screens  **********************************/

                if(window.innerWidth <= 767 ){
                    
                        $('.header-sidebar').find('.magsearch').on('click',function(eve){
                            eve.preventDefault();
                            $('#main-menu').hide();
//                            $(this).hide();
                            $(this).prev().show();   
                            $(this).prev().on('click',function(){
                               $(this).prev().unbind(eve); 
                            });
                        });
                    
                    
                        $('#navbar').find('.trigger').on('click',function(){
                                $('#main-menu').show();
                                $(this).find('.menu-sm-close').hide();
                                $(this).find('.menu-mob-close').toggle();
                        });
                        $('#navbar .trigger .menu-sm-open').attr('src', window.location.origin + '/la-maison/wp-content/themes/trego/images/mob-menu.png');
                        $('#main .woocommerce-icons .basket-sm').attr('src', window.location.origin + '/la-maison/wp-content/themes/trego/images/cart-mob.png');
                        $('#main .woocommerce-icons .user-sm').attr('src', window.location.origin + '/la-maison/wp-content/themes/trego/images/user-mob.png');
                        
                        
                        
                        
                        $('#colophon .widget-bottom ul li .footer-title').append('<span class="arrow-down"></span>');
                        // Footer accordion
                        $('#colophon ul li > div').on('click',function(){
//                                $(this).find('.arrow-down').toggle();
//                                $(this).find('.arrow-up').toggle();
                                $(this).next().slideToggle();
                                $(this).parent().siblings().find('div:first').next().slideUp();                           
                        });
                }
                
                
                    if ( $(window).width() > 767 && $(window).width() <= 1024) {
                        var nuggetHieght = $('.newsletter-wrapper').find('.nugget').height();
                        $('.newsletter-wrapper').find('.newsletter').css('height',nuggetHieght );
                    } 
               if(window.innerWidth <= 425 ){
                   var LangSelector = $('.widget-bottom').find('.widget_icl_lang_sel_widget');
                   $('.widget-bottom').append("<div class='lang-selector-wrapper'></div>");
                   $('.widget-bottom .lang-selector-wrapper').append(LangSelector);
               }

                


	
        
      

});




$( window ).resize(function() {
    if ( $(window).width() > 767 && $(window).width() <= 1224) {
        var nuggetHieght = $('.newsletter-wrapper').find('.nugget').height();
        $('.newsletter-wrapper').find('.newsletter').css('height',nuggetHieght );
    } 
    
});





