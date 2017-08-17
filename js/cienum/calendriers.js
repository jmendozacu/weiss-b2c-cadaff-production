jQuery(document).ready(function(){
	var params;
	jQuery.ajax({
		url: "/checkout/onepage/getCalendriers/",
		method: "POST",
		dataType: "json",
		success: function(result){
			params = result;
		}
	});

	jQuery(document).on('click', '#addFerie', function(){
		if(jQuery(this).prev('div').children().last().find('input').val() !==  '')
			jQuery('.jours-feries').append('<div style="width:100%"><input type="text" name="feries[]" value="" style="margin-bottom:5px"/>&nbsp;<button style="padding:0!important" class="scalable delete deleteFerie" onclick="jQuery(this).closest(\'div\').remove();" type="button"><span></span></button></div>');
	});
	jQuery(document).on('click', '.addExceptionnel', function(){
		if(jQuery(this).prev('div').children().last().find('input').val() !==  '' || jQuery(this).prev('div').children().length == 0)
			jQuery(this).prev('div').append('<div style="width:100%"><input type="text" name="modes['+jQuery(this).data('code')+'][exceptionnels][]" value="" style="margin-bottom:5px"/>&nbsp;<button style="padding:0!important" class="scalable delete deleteFerie" onclick="jQuery(this).closest(\'div\').remove();" type="button"><span></span></button></div>');
	});

	jQuery(document).on('click', 'input[name="shipping_method"]', function(){
		jQuery('.datepicker-global').parent().remove();
		jQuery('.active').removeClass('active');
		jQuery(this).closest('li').addClass('active').after(['<li class="subactive"><div class="datepicker-global"><input class="shipping_datepicker" data-code="',jQuery(this).val(),'" name="datepicker" type="text" readonly/></div></li>'].join(''));
		if(jQuery(this).val().indexOf('owebiashipping3') === 0) {
			jQuery('.shipping_datepicker').after(['<div class="datepicker-container"><span class="datepicker-col-title">Adresse</span><p>',params.modes[jQuery(this).val()].adresse,'</p></div><div class="datepicker-container"><span class="datepicker-col-title">Horaires</span><p>',params.modes[jQuery(this).val()].horaires,'</p></div>'].join(''));
		}
				
		var today = new Date();

		var mind = params.modes[jQuery('.shipping_datepicker').data('code')]['delai'];

		if(today.getHours() >= params.modes[jQuery('.shipping_datepicker').data('code')]['hlimite'])
			mind += 1;
		jQuery('.shipping_datepicker').datepicker({
			altField: ".shipping_datepicker",
			altFormat: "dd/mm/yy",
			showOn: "both",
			buttonImage: "/skin/frontend/base/default/images/calendar.gif",
			closeText: 'Fermer',
			prevText: 'Précédent',
			nextText: 'Suivant',
			currentText: 'Aujourd\'hui',
			monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
			monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
			dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
			dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
			dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
			weekHeader: 'Sem.',
			dateFormat: 'dd-mm-yy',
			minDate: +mind,
			firstDay: 1,
			beforeShowDay: estOuvre,
			defaultDate: getDefaultDate(mind)
		});

		jQuery('.shipping_datepicker').wrap('<div class="datepicker-container"/>');
		jQuery('.shipping_datepicker').before('<span class="datepicker-col-title">Date de retrait</span><span class="datepicker-input-container">Votre colis sera livré le </span>');
		jQuery('.shipping_datepicker').after('<span class="datepicker-button-container">Si cette date ne vous convient pas, choisissez un autre jour : </span>');
		jQuery('.ui-datepicker-trigger').appendTo('.datepicker-button-container');
		jQuery('.shipping_datepicker').appendTo('.datepicker-input-container');
	});

	/* Adresses List Checkout */
	jQuery(document).on('change', '.addresses-list .block-check input', function(){
		//jQuery('.addresses-list .block-check input').each(function(i) {

		//});
		jQuery(this).parent().parent().parent().find('li').removeClass('active');
		jQuery(this).parent().parent().addClass('active');
	});

	/* Function Detect Touch Devices */
	function isMobile() {
		try{ document.createEvent("TouchEvent"); return true; }
		catch(e){ return false; }
	}

	jQuery('.address-select' ).each(function(i) {
		var nbrOptions = jQuery(this).find('option').length;
		var finalHeight = nbrOptions * 40;

		if(isMobile()){
			/* Disable Multiple attribute for Touch Devices */
			jQuery(this).addClass('touch');
			jQuery(this).removeAttr('multiple');
		}else{
			/* Specific Height for No Touch Devices */
			jQuery(this).css('height', finalHeight);
		}

	});

	function estOuvre(date){
		var type = jQuery('.shipping_datepicker').data('code');
		var composite = twoDigits(date.getMonth()+1)+'-'+twoDigits(date.getDate());
		//check feries
		if(jQuery.inArray(composite, params.feries) >= 0)
			return [false];
		if(!params.modes[type].ouvres[date.getDay()])
			return [false];
		if(params.modes[type].exceptionnels && params.modes[type].exceptionnels.length > 0 && jQuery.inArray(composite, params.modes[type].exceptionnels) >= 0)
			return false;
		return [true];
	}

	function getDefaultDate(delai){

		var date = new Date();
		date.setDate(date.getDate()+delai);

		for (var i = 1; i<= 90; i++) {
            date.setDate(date.getDate()+1);
            $otevet = estOuvre(date)[0];
            if ($otevet) {
            	return;
			}
		}
		if (!$otevet) {
            date = new Date();
            date.setDate(date.getDate()+delai-1);
		}
		/*while(!estOuvre(date)[0]) {
			date.setDate(date.getDate()+1);
		}*/
		jQuery('.shipping_datepicker').val(twoDigits(date.getDate())+'/'+twoDigits(date.getMonth()+1)+'/'+date.getFullYear());
		return date;
	}

	function twoDigits(entity){
		return ("0" + entity).slice(-2);
	}



});
