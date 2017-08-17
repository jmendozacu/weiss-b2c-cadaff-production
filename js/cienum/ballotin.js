jQuery(document).ready(function(){
	jQuery('#tab-container').easytabs();
	
	jQuery('.closeIngr').on('click', function(){
		jQuery(this).closest('div.optionextended-narrow-note').slideUp().removeClass('active-ingr').addClass('inactive-ingr');
	});
	
	jQuery('.lienIngr').on('click', function(){
		jQuery('div.active-ingr').slideUp(function(){jQuery('div.active-ingr').removeClass('active-ingr').addClass('inactive-ingr')});
		jQuery('div#option_'+jQuery(this).data('opt')).slideDown(function(){jQuery(this).removeClass('inactive-ingr').addClass('active-ingr')});
	});
});