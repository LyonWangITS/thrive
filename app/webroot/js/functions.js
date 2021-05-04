
var current_form_stage = 0;

$(document).ready(function(){	
	
	// Open in a new window
	$('a.target_blank').click(function(){
		window.open( $(this).attr('href') );
		return false;
	});

	if ( $('.stage-form:not(.optional)').length > 0 ) {
		
		current_form_stage = $('input[name=survey-stage]').val();
		init_stage_form( current_form_stage );
		
		//Run validator once
		stage_form_complete( current_form_stage );
	}
	
	$('.accordian .heading').click(function(){
		if ($(this).parent().hasClass('active')) {
			$(this).next().slideUp(200);
			$(this).parent().removeClass('active');
		} else {
			$(this).next().slideDown(200);
			$(this).parent().addClass('active');
		}
	});

	footerLogo();

	initStepThree();

	initStepFour();

	initStepTen();

	modalBox();

	setTabularFixedHeader();

	$('.callback input').placeholder();

	$('form.callback').submit(function(){
		ajaxSubmitCallbackForm();
		return false;
	});
});


/*
	Initialize the validator behaviors
*/
function init_stage_form( form_stage ){
	
	
	//Allow submission
	$('.stage-form').submit(function(){
		return stage_form_complete( form_stage );
	});
	
	
	//Specific behaviors
	if ( form_stage == 0 ){
		
		$('label[for=name]').inFieldLabels();
		$('label[for=id_number]').inFieldLabels();
		
	} else if (form_stage == 1 ){

		//Toggle demographic questions based on if staff/student
		$('.stage-form input[name=staff_student]').bind('change', function(){
			
			if ( $('.stage-form input[name=staff_student]:checked').val() == 'student' ){

				$('#demographics-wrapper').slideDown( 400, function(){} );
				
			} else {
				
				$('#demographics-wrapper').slideUp( 400, function(){
					
					$('input[name=hours_per_week]').removeAttr('checked');
					
				});
				
			}
		} );
		
	} else if ( form_stage == 3 ){

		//#2 - standard drinks typical day
		buildSlider({
			id		: 'typical-day-slider',
			from	: 0,
			to		: 25,
			to_label: '25+',
			from_label: 'Select',
			field	: $('.stage-form input[name=how_many_on_typical_day]'),
			unit	: {
				singular 	: 'drink',
				plural		: 'drinks'
			}
		});

	} else if ( form_stage == 4 ){
		
		var weekdays = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
		$.each(weekdays, function(i, value) {
			buildSlider({
				id		: 'standard-drinks-slider_' + value,
				from	: ($('.stage-form input#past_4wk_drinks_'+ value + '-1').prop('checked') || $('.stage-form input#past_4wk_drinks_' + value + '-1').prop('checked')) ? -1 : 1,
				from_label: '1',
				to		: 25,
				to_label: '25+',
				field	: $('.stage-form input[name=past_4wk_std_drinks_' + value + ']'),
				unit	: {
					singular 	: 'drink',
					plural		: 'drinks'
				}
			});
		});

		// last four weeks, drinks consumed on a single occasion
		buildSlider({
			id		: 'standard-drinks-slider',
			from	: 0,
			from_label: 'Select',
			to		: 36,
			to_label: '36+',
			field	: $('.stage-form input[name=past_4wk_largest_number_single_occasion]'),
			unit	: {
				singular 	: 'drink',
				plural		: 'drinks'
			}
		});

		// how many hours drink was consumed in
		buildSlider({
			id		: 'drinking-hours-slider',
			from	: 0,
			from_label: 'Select',
			to		: 24,
			to_label: '24+',
			field	: $('.stage-form input[name=past_4wk_hours_amount_drank]'),
			unit	: {
				singular 	: 'hour',
				plural		: 'hours'
			}
		});

		$('.slider-wrapper').css('opacity', 0).css( 'visibility', 'visible' ).animate({
			'opacity'	: 1
		}, 400 );
		
		$('input[name=body_height-cm]').bind('keyup change', function(){
			if ( $(this).val() != '' ){
				$('input[name=body_height-feet], input[name=body_height-inches]').val('');
			}
		});

		$('input[name=body_height-feet], input[name=body_height-inches]').bind('keyup change', function(){
			
			if ( $(this).val() != '' ){
				$('input[name=body_height-cm]').val('');
			}
			
		});
		
	}


	//Render form status
	$('input, select').each(function(){
		$(this).bind('change', function(){
			stage_form_complete( form_stage );
		});
	});

	$('input').bind('keyup', function(){
		stage_form_complete( form_stage );
	});

}

/*
	Displays the all-questions-answered memo
*/
function stage_form_complete( form_stage ){
	
	var form_fields_checked = {};
	
	if ( form_stage == 0 ){
		
		form_fields_checked = {
			'participant_name' 		: { skip : false, valid : false },
			'participant_id' 		: { skip : true, valid : isPositiveNumber($('input[name="participant_id"]').val()) }
		};

	} else if ( form_stage == 1 ){

		var phone_digits = $('input[name="phone_digits"]').val();
		form_fields_checked = {
			'age'					: { skip : false, type: 'select', valid : false },
			'gender'				: { skip : false, type : 'radio', valid : false },
			'race'					: { skip : false, type : 'select', valid : false },
			'ethnicity'				: { skip : false, type : 'select', valid : false },
			'race'					: { skip : false, type : 'select', valid : false },
			'where' 				: { skip : false, type : 'select', valid : false },
			'first_pet'				: { skip : false, valid : false },
			'first_concert'			: { skip : false, valid : false },
			'mother_letters'		: { skip : true, valid : $('input[name="mother_letters"]').val().length === 2},
			'phone_digits'			: { skip : true, valid : isPositiveNumber(phone_digits) && phone_digits.length === 2 },
		};

	} else if ( form_stage == 2 ){
		var fields = [
			'see_things_through_to_the_end',
			'thinking_careful_purposeful',
			'great_mood_leading_to_problematic_situations',
			'unfinished_tasks_bother_me',
			'think_things_over_before_doing',
			'feeling_bad_leading_to_regretful_actions',
			'hate_to_stop_doing_things',
			'feeling_bad_difficult_to_stop',
			'enjoy_taking_risks',
			'good_mood_lose_control',
			'finish_when_start',
			'rational_sensible_approach',
			'upset_act_without_thinking',
			'welcome_new_exciting_experiences',
			'rejection_leading_to_say_regretful_things',
			'learn_fly_airplane',
			'others_shocked_about_my_excitement',
			'skiing_very_fast',
			'think_carefully_before_doing_anything',
			'act_withoug_thinking_when_excited',
		];

		$.each(fields, function(i, field) {
			form_fields_checked[field] = { skip : false, type : 'radio', valid : false };
		});

	} else if ( form_stage == 3 ){

		var tipical_day_val = $('input[name="how_many_on_typical_day"]').val();
		form_fields_checked = {
			'how_often_drink_alcohol'	: { type : 'select', skip : false, valid : false },
			'how_many_on_typical_day'	: { skip : true, valid : tipical_day_val > 0 || tipical_day_val === '25+' },
			'how_often_six_or_more'		: { type : 'select', skip : false, valid : false },
			'past_year_how_often_unable_to_stop' 		: { type : 'select', skip : false, valid : false },
			'past_year_how_often_failed_expectations'	: { type : 'select', skip : false, valid : false },
			'past_year_needed_morning_drink'			: { type : 'select', skip : false, valid : false },
			'past_year_how_often_remorseful'			: { type : 'select', skip : false, valid : false },
			'past_year_how_often_unable_to_remember'	: { type : 'select', skip : false, valid : false },
			'been_injured_or_injured_someone'			: { type : 'select', skip : false, valid : false },
			'others_concerned_about_my_drinking'		: { type : 'select', skip : false, valid : false }
		};
	} else if ( form_stage == 4 ){

		var single_oc_val = $('input[name="past_4wk_largest_number_single_occasion"]').val();
		var hours_val = $('input[name="past_4wk_hours_amount_drank"]').val();

		form_fields_checked = {
			'past_4wk_largest_number_single_occasion'	: { skip : true, valid : single_oc_val > 0 || single_oc_val === '36+' },
			'past_4wk_hours_amount_drank'				: { skip : true, valid : hours_val > 0 || hours_val === '24+' },
			'body_height-cm'							: { skip : true, accepts : 'number', valid : false },
			'body_height-feet'							: { skip : true, accepts : 'number', valid : false },
			'body_height-inches'						: { skip : true, accepts : 'number', valid : false },
			'body_weight-number'						: { skip : false, accepts : 'number', valid : false },
			'body_weight-unit'							: { type : 'select', skip : false, valid : false }
		};

		var weekdays = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
		$.each(weekdays, function(i, day) {
			var std_drinks_val = $('input[name="past_4wk_std_drinks_' + day + '"]').val();
			form_fields_checked['past_4wk_drinks_' + day] = { type: 'radio', skip : false, valid : false };
			form_fields_checked['past_4wk_std_drinks_' + day] = {  skip : true, valid : std_drinks_val >= 0 || std_drinks_val === '25+' };
		});

		//Manually validate height fields
		var height_cm_field = $('input[name=body_height-cm]');
		var height_feet_field = $('input[name=body_height-feet]');
		var height_inches_field = $('input[name=body_height-inches]');

		if ( isPositiveNumber( height_cm_field.val() ) || isPositiveNumber( height_feet_field.val() ) ){
			
			form_fields_checked[ 'body_height-cm' ].valid = { skip : true, valid : true };
			form_fields_checked[ 'body_height-feet' ] = { skip : true, valid : true };
			form_fields_checked[ 'body_height-inches' ] = { skip : true, valid : ( height_inches_field.val() == '' || isPositiveNumber( height_inches_field.val() ) ) };

		}

	} else if ( form_stage == 5 ) {
		var fields = [
			'tried_to_limit_amount_drank',
			'tried_to_resist_opportunity_to_start_drinking',
			'tried_to_slow_my_drinking',
			'tried_to_drink_less',
			'tried_to_stop_drinking',
			'difficult_to_limit',
			'start_drinking_after_deciding_not_to',
			'end_up_drinking_more',
			'cut_down_drinking',
			'drink_when_causing_problems',
			'stop_drinking_after_two_drinks',
			'stop_drinking_after_drunk',
			'irresistible_urge_continue_drinking',
			'difficult_to_resist_drinking',
			'able_to_slow_drinking'
		];

		$.each(fields, function(i, field) {
			form_fields_checked[field] = { skip : false, type : 'radio', valid : false };
		});

	} else if ( form_stage == 6 ) {

		var fields = [
			'embarassing_things',
			'hangover',
			'sick',
			'end_up_drinking_without_planning',
			'take_foolish_risks',
			'pass_out',
			'need_larger_amounts_to_feel_effect',
			'impulsive_things',
			'memory_loss',
			'drive_unsafely',
			'miss_work_or_class',
			'regretted_sexual_situations',
			'difficult_to_limit',
			'become_rude',
			'wake_up_unexpected_place',
			'feel_bad',
			'lack_of_energy',
			'suffered_work_quality',
			'spend_too_much_time_drinking',
			'neglect_obligations',
			'relationship_problems',
			'overweight',
			'harmed_physical_appearance',
			'need_drink_before_breakfast'
		];

		$.each(fields, function(i, field) {
			form_fields_checked[field] = { skip : false, type : 'radio', valid : false };
		});
	} else if ( form_stage == 7 ) {

		var fields = [
			'count_drinks',
			'set_number_drinks',
			'eat_before',
			'space_drinks_out',
			'alternate_drinks',
			'drink_for_quality',
			'avoid_drinking_games',
			'have_a_reliable_driver',
			'preplan_transportation',
			'dst_protection',
			'watch_out_for_each_other',
		];

		$.each(fields, function(i, field) {
			form_fields_checked[field] = { skip : false, type : 'radio', valid : false };
		});
	} else if ( form_stage == 8 ) {

		var fields = [
			'cut_down_drinking',
			'stop_drinking',
		];

		$.each(fields, function(i, field) {
			form_fields_checked[field] = { skip : false, type : 'radio', valid : false };
		});
	} else if ( form_stage == 9 ) {

		var fields = ['tobacco_use', 'tobacco_frequency', 'tobacco_init'];

		$.each(fields, function(i, field) {
			form_fields_checked[field] = { skip : false, type : 'select', valid : false };
		});
	}
	
	
	//Bulk checker
	for ( var field_name in form_fields_checked ){
		if ( !form_fields_checked[ field_name ].skip ){
			
			var target_field;
			
			if ( form_fields_checked[ field_name ].type == 'radio' ){
			 	target_field  = $('.stage-form input[name=' + field_name + ']:checked');
			} else if ( form_fields_checked[ field_name ].type == 'select' ){
				target_field  = $('.stage-form select[name=' + field_name + ']');
			} else {
				target_field  = $('.stage-form input[name=' + field_name + ']');
			}
			
			if ( ( target_field.length > 0 ) && ( target_field.val() != '' ) ){
				
				if ( form_fields_checked[field_name].accepts == 'number' ){
					if ( isPositiveNumber( target_field.val() ) ){
						form_fields_checked[field_name].valid = true;
					}
					
				} else {
					form_fields_checked[field_name].valid = true;
				}
				
			}
			
		}
	}
	
	//All completed?
	var form_completed = true;
	for( var field_name in form_fields_checked ){
		if ( form_fields_checked[ field_name ].valid == false ){
			form_completed = false;
			break;
		}
	}
	
	
	if ( form_completed ){
		$('div.submit p.incomplete').slideUp();
		$('div.submit p.complete').slideDown();
		$('.stage-form button[type=submit]').removeAttr('disabled');
	} else {
		$('div.submit p.incomplete').slideDown();
		$('div.submit p.complete').slideUp();
		$('.stage-form button[type=submit]').attr('disabled', 'disabled');
	}
	
	return form_completed;
}



/*
	opts = {
		id : ...
		from : ...
		to : ...
		field : ...
	}
*/
function buildSlider( opts ){
	
	var initial_value = opts.field.val();
	
	var sliderCB = function( x, y ){

		var val = Math.floor( x * ( opts.to - opts.from ) + opts.from );
		
		//Every slider but the age slider has a + at the end
		if ( val == opts.to ){
			if ( typeof( opts.to_label) !== 'undefined' ){
				val = opts.to_label;
			}
		}

		if ( val == opts.from ){
			if ( typeof( opts.from_label) !== 'undefined' ){
				val = opts.from_label;
			}
		}
		
		var suffix = '';
		if ( typeof( opts.unit ) !== 'undefined' ){
			suffix = ' ' + ( val == 1 ? opts.unit.singular : opts.unit.plural );
		}
		
		$( '#' + opts.id + ' .tooltip').text( val + suffix );
		opts.field.val( val );
		
		//Tooltip tracking
		var handle = $( '#' + opts.id + ' .handle');
		var handle_center = handle.position().left + (handle.width()/2);
		
		var tooltip = $( '#' + opts.id + ' .tooltip');
		if ( tooltip.length > 0 ) {

			var tooltip_center = tooltip.position().left + tooltip.width();

			tooltip.css({
				'left'	: ( -(tooltip.outerWidth()/2) + handle_center ) + 'px'
			});
		}

		//Background color
		var bg = $('#' + opts.id + ' .selected-area').css('width', handle_center );

		// Triggering change event.
		opts.field.change();
	};
	
	//Reset handle left first
	$( '#' + opts.id + ' .handle' ).css( 'left', 0 );
	
	var slider = new Dragdealer( opts.id, {
		steps				: ( opts.to - opts.from + 1 ),
		snap				: true,
		animationCallback 	: function( x, y){
			sliderCB( x, y );
		},
		callback			: function( x, y){
			sliderCB( x, y );
		}
	});
	
	
	var step = initial_value - opts.from + 1;
	
	slider.setStep( step );
	
	return slider;
	
}

/* Helpers */
function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}
function isPositiveNumber(n) {
	return ( isNumber(n) && ( parseFloat(n) >= 0 ) );
}

var start_animate_vessels = false;
var start_animate_firstaids = false;

function initStepThree() {

	if ($('.progress').hasClass('step-three')) {
	
		checkAnimationStepTwo();		
		$(window).scroll(function(){
			checkAnimationStepTwo();
		});
	
	}

}

function checkAnimationStepTwo() {
	
	var activation_limit = $(window).scrollTop() + ($(window).height() * 0.6);
	
	var vessels_top = $('.vessels').offset().top;
	if (vessels_top < activation_limit && !start_animate_vessels) {
		start_animate_vessels = true;
		animationBottles();
	}
	
	var firstaids_top = $('.first-aids').offset().top;
	if (firstaids_top < activation_limit && !start_animate_firstaids) {
		start_animate_firstaids = true;
		animationFirstaid();
	}
	
}

function animationBottles() {

	$('.vessel-img').css({'display': 'block'});
	
	$('.v-one').animate({'bottom': '0'}, 1000, 'easeOutQuart');
	$('.v-two').delay(200).animate({'bottom': '0'}, 1000, 'easeOutQuart');
	$('.v-three').delay(400).animate({'bottom': '0'}, 1000, 'easeOutQuart');
	$('.v-four').delay(600).animate({'bottom': '0'}, 1000, 'easeOutQuart');
	$('.v-five').delay(800).animate({'bottom': '0'}, 1000, 'easeOutQuart');
	$('.v-six').delay(1000).animate({'bottom': '-1px'}, 1000, 'easeOutQuart');
	$('.v-seven').delay(1200).animate({'bottom': '0'}, 1000, 'easeOutQuart');
	$('.v-eight').delay(1400).animate({'bottom': '0'}, 1000, 'easeOutQuart');
	$('.v-nine').delay(1600).animate({'bottom': '0'}, 1000, 'easeOutQuart');
	
}

function animationFirstaid() {

	$('.first-aid-img').css({'display': 'block'});
	
	$('.fa-one').animate({'bottom': '0'}, 1000, 'easeOutQuart');
	$('.fa-two').delay(200).animate({'bottom': '-8px'}, 1000, 'easeOutQuart');
	$('.fa-three').delay(400).animate({'bottom': '0'}, 1000, 'easeOutQuart');
	
}

function initStepFour() {

	if ($('.progress').hasClass('step-four')) {
	
		animationClock();
	
	}

}

function animationClock() {
	
	animationClockHour();
	animationClockMinute();
	animationClockSecond();
	
}

function animationClockHour() {
	$('.watch .hour')
		.css({'-webkit-tranform': 'rotate(0deg)'})
		.animate({ rotate: '+=360deg' }, 360000, 'linear', function(){
			animationClockHour();
		});
}

function animationClockMinute() {
	$('.watch .minute')
		.css({'-webkit-tranform': 'rotate(0deg)'})
		.animate({ rotate: '+=360deg' }, 60000, 'linear', function(){
			animationClockMinute();
		});
}

function animationClockSecond() {
	$('.watch .second')
		.css({'-webkit-tranform': 'rotate(0deg)'})
		.animate({ rotate: '+=360deg' }, 1000, 'linear', function(){
			animationClockSecond();
		});
}

var animate_on_scroll = true;

var start_audit_score,
	start_audit_scorerange,
	start_audit_compare,
	start_audit_bac,
	start_audit_spend = false;

function initStepTen() {
	
	if (!$('.progress').hasClass('step-ten')) {

		return;
	}
	
	if (animate_on_scroll) {

		checkAuditResultsPosition();
		$(window).scroll(function(){
			checkAuditResultsPosition();
		});

	} else {

		auditResults_Score();

	}

	// Optional feedback questions
	initFeedbackSlider('rating-important-reduce-drinking');
	initFeedbackSlider('rating-confident-reduce-drinking');
	initFeedbackSlider('rating-important-talk-professional');
	initFeedbackSlider('rating-ready-talk-professional');

	var expandFeedback = function() {
		if ($(window).scrollTop() + window.innerHeight !== $(document).height()) {
			return;
		}

		$('.accordian').each(function() {
			if (!$(this).hasClass('init-expand')) {
				// Expanding tabs when the user scrolls down to the bottom.
				$(this).addClass('init-expand').addClass('active').next().slideDown(200);
			}
		});
	}

	if ($(window).width() < 767) {
		$('body').on({'touchmove': expandFeedback});
	}
	else {
		$(window).scroll(expandFeedback);
	}
}

function initFeedbackSlider(id) {

	var field = id.replace( /-/g, '_' );

	var slider = new Dragdealer(id, {
		steps: 11,
		snap: true,
		animationCallback: function(x, y) {

			// Highlight numbers
			var value = Math.floor(x * 10);
			var lis = $(this.wrapper).siblings('ul.score').find('li');
			lis.removeClass('active');
			if (value == 0) {

				$(lis.get(0)).addClass('active');
			}
			for (var i = 1; i <= value; i++) {

				$(lis.get(i)).addClass('active');
			}

			// Draw the active bar
			var handle = $(this.wrapper).find('.handle');
			var handle_center = handle.position().left + (handle.width()/2);
			$(this.wrapper ).find('.selected-area').css('width', handle_center);
		},
		callback: function(x, y){

			var value = Math.floor(x * 10);
			saveFeedbackScore(this.wrapper.id, value);
		}
	});

	var $field = $('input[name="' + field + '"]' );
	if ($field.length > 0) {
		slider.setStep(parseInt($field.val()) + 1);
	}

	$('#' + id).siblings('ul.score').find('li').bind('click', function() {

		var value = parseInt($(this).text());
		slider.setStep(value + 1);
		saveFeedbackScore(id, value);
		return false;
	});
}

function saveFeedbackScore( id, score ) {

	// Convert id to field
	var field = id.replace( /-/g, '_' );

	// Parse URL to get token
	var token = getParameterByName( 't' );
	if ( token == null ) {

		token = '';
	}

	// Build request and send
	$.ajax( {
		url: 'save-feedback.php?id=' + field + '&score=' + score + '&t=' + token,
		cache: false,
		dataType: 'text'
	} )
	.done( function( response ) {

		// Do nothing. Just assume it worked.
	} );
}

function checkAuditResultsPosition() {
	
	var activation_limit = $(window).scrollTop() + ($(window).height() * 0.6);
	
	if ($('.score').length) {
		var audit_score_top = $('.score').offset().top;
		
		if ((audit_score_top < activation_limit || audit_score_top < $(window).height()) && !start_audit_score || $(window).width() < 767) {
			start_audit_score = true;
			auditResults_Score();
		}
	}
	
	if ($('.compare').length) {
		var audit_compare_top = $('.compare').offset().top;
		if (audit_compare_top < activation_limit && !start_audit_compare) {
			start_audit_compare = true;
			auditResults_Compare();
		}
	}
	
	if ($('.bac').length) {
		var audit_bac_top = $('.bac').offset().top;
		if (audit_bac_top < activation_limit && !start_audit_bac) {
			start_audit_bac = true;
			auditResults_BAC();
		}
	}
	
	if ($('.spend').length) {
		var audit_spend_top = $('.spend').offset().top;
		if (audit_spend_top < activation_limit && !start_audit_spend) {
			start_audit_spend = true;
			auditResults_Spend();
		}
	}
	
}

function auditResults_Score() {
	
	$('.score-text h2').delay(500).fadeIn(1000, function(){
	
		// To prevent width:auto causing div twitching 
		var header_width = $(this).width();
		$('.score-text .description').width(header_width);
		
		$('.score-text .description').fadeIn(500, 'easeOutQuart', function(){
			
			$('.donut').fadeIn(500, function(){
		
				auditResults_ScoreRange();
				
				if ($(this).hasClass('moderate')) {
					$(this).find('.top-left').animate({
						'top': '-12px',
						'left': '-12px'
					}, 500, 'easeOutQuart');
				}
				else if ($(this).hasClass('hazardous')) {
					$(this).find('.top-right').animate({
						'top': '-12px',
						'left': '53%'
					}, 500, 'easeOutQuart');
				}
				else if ($(this).hasClass('dependence')) {
					$(this).find('.bottom-left').animate({
						'top': '52%',
						'left': '-12px'
					}, 500, 'easeOutQuart');
				}
				else if ($(this).hasClass('harmful')) {
					$(this).find('.bottom-right').animate({
						'top': '52%',
						'left': '52%'
					}, 500, 'easeOutQuart');
				}
				
				$('.donut .text').fadeIn(800, function(){
				
					if (!animate_on_scroll) {
						auditResults_ScoreRange();
					}
				
				});
				
			});
			
		});
		
	});
	
}

function auditResults_ScoreRange() {
	
	var i = 0;
	
	$('.score-range .range').each(function(){
		
		var delay = i * 80;
		
		$(this).delay(delay).slideDown(500, 'easeOutQuart');
		
		if (i == 3 && !animate_on_scroll) {
		
			setTimeout(function(){		
				if ($('.bac').length > 0) {
					auditResults_BAC();
				} else {
					auditResults_Spend();
				}				
			}, delay + 500);
			
		}
		
		i++;			
		
	});	
	
}

function auditResults_Compare() {

	$('.compare .title, .compare .compare-wrap').fadeIn(1000, function(){
	
		$('.compare .compare-wrap .bar').each(function(){
			
			var width = $(this).attr('data-width');
			$(this).find('span').fadeIn(500);
			$(this).animate({
				'width': width + '%'
			}, 1000, 'easeOutQuart');
			
		});
	
	});

}

function auditResults_BAC() {

	$('.bac .text').fadeIn(1000, function(){
		
	});
	
	$('.bac .metre').delay(500).fadeIn(500, function(){
		
		var angle = '90';
		var bac_percentage = parseFloat( $('.bac .text p.title span').text() );
		
		if (bac_percentage <= 0.04) {
			angle = '45';
		} 
		else if (bac_percentage <= 0.09) {
			angle = '90';
		}
		else if (bac_percentage <= 0.14) {
			angle = '135';
		}
		else {
			angle = '180';
		}
		
		$('.bac .metre .hand')
			.css({'-webkit-tranform': 'rotate(-90deg)'})
			.animate({ rotate: '-=90deg' }, 0)
			.animate({ rotate: '+=' + angle + 'deg' }, 2000, 'easeOutElastic');
		
		
		if (!animate_on_scroll) {
			auditResults_Spend();
		}
		
	});

}

function auditResults_Spend() {
		
	$('.spend .cash-one').delay(500).animate({'left': '25px'}, 1000, 'easeOutQuart');
	$('.spend .cash-two').delay(800).animate({'left': '80px'}, 1000, 'easeOutQuart');
	$('.spend .cash-three').delay(1100).animate({'left': '0px'}, 1000, 'easeOutQuart');
	$('.spend .cash-four').delay(1400).animate({'left': '92px'}, 1000, 'easeOutQuart');
	$('.spend .cash-five').delay(1700).animate({'left': '64px'}, 1000, 'easeOutQuart', function(){
		
	});

	$('.spend .text').fadeIn(1000, function(){
	
		// $('.expenses-from, .expenses-to').shuffleLetters({ step: 20 });
		
	});

}


var xhr;
function ajaxSubmitCallbackForm(){
	var data = $( 'form.callback' ).serialize();
	var url = $( 'form.callback' ).attr('action');
	
	xhr = $.ajax({
		'url'		: url,
		'data'		: data,
		'type'		: 'post'
	}).done(function( data, status, xhr ){
		
		if ( xhr.status == 200 ){
		
			if ( data == 'ok' ){
				
				//ok
				$('form.callback')[0].reset();
				
				$('form.callback p.success').text( 'Callback request submitted' );
				
				setTimeout(function(){
					$('form.callback p.success').text('');
				}, 3000);

			} else {

				//nok
				$('form.callback p.error').text('There was a problem with your request, please check your form entry and try again');
				setTimeout(function(){
					$('form.callback p.error').text('');
				}, 5000);
				
				
			}
			
		}		

	});
}

/**
 * Returns a querystring value
 * @param name
 * @returns {string}
 */
function getParameterByName(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function modalBox(){
	
	$('p.confidential a').click(function(){
		
		var modalWidth = $('#confidentiality-statement').outerWidth();
		var modalPos = ($(window).width() - modalWidth) / 2;
		var modalHeight = $('#confidentiality-statement').outerHeight();
		var modalPosVert = ($(window).height() - modalHeight) / 2;
		$('#confidentiality-statement').css({'left' : modalPos });
		$('#confidentiality-statement').css({'top' : modalPosVert - 40 });
		
		
		$('.overlay').fadeIn(200);
		$('#confidentiality-statement').fadeIn(200);
		return false;
	});
	
	$('#confidentiality-statement a.close').click(function(){
		$('.overlay').fadeOut(200);
		$('#confidentiality-statement').fadeOut(200);
		return false;
	});
	
}

function setTabularFixedHeader() {
	if ($(window).width() < 767) {
		return;
	}

	var $tabularHeader = $('.tabular-intro .labels');
	if ($tabularHeader.length === 0) {
		return;
	}

	var $tabular = $('.radio-set.tabular').last();
	var $tabularHeaderWrapper = $tabularHeader.parent().parent();
	var yTabularHeaderPos = $tabularHeader.offset().top;

	$(window).scroll(function() {
		var scrollPos = $(window).scrollTop();

		if (scrollPos >= yTabularHeaderPos && scrollPos < $tabular.offset().top + $tabular.height()) {
		   $tabularHeaderWrapper.addClass('fixed');
		}
		else {
		   $tabularHeaderWrapper.removeClass('fixed');
		}
	});
}

function footerLogo() {
	var logoHeight = $('.footer-logo').outerHeight() / 2;
	$('.footer-logo').css({'margin-top': - logoHeight});
}
