(function($){
	"use strict";

		if (typeof(OVAEM) == "undefined")  var OVAEM = {};

		OVAEM.init = function(){
				this.Meta_Boxes.init();
				this.Settings.init();
		}
		
		/* Metabox */
		OVAEM.Meta_Boxes = {
			init: function(){
				this.tab();
				this.map();
				this.datetime();
				this.pay_method();
				this.show_map();
				

				/* Schedule */
				this.load_schedules();
				this.add_schedule();
				this.delete_schedule();
				this.sortable_schedule();
				this.toggle_schedule();
				this.schedule_title_change();

				/* Plan in schedule*/
				this.add_plan();
				this.toggle_plan();
				this.delete_plan();
				this.plan_title_change();

				/* Modal Speakers */
				this.dialog_speakers();
				this.add_speaker();
				this.pagination_speaker();

				/* Social Speaker */
				this.load_social();
				this.add_social();
				this.delete_social();

				/* Sponsor Level */
				this.load_sponsors();
				this.add_sponsor();
				this.sponsor_title_change();
				this.delete_sponsor();
				this.toggle_sponsor();
				this.sortable_sponsor();
				/* Sponsor Info */
				
				this.add_sponsor_info();
				this.sponsor_info_title_change();
				this.delete_sponsor_info();

				/* Ticket */
				this.avaiable_date_selling();
				this.add_ticket();
				this.load_tickets();
				this.delete_ticket();
				this.toggle_ticket();
				this.ticket_title_change();
				this.sortable_ticket();
				this.add_cer_ticket();
				/* Resend pdf Ticket */
				this.resend_pdf_ticket();

				/* Add FAQ */
				this.add_faq();
				this.load_faqs();
				this.faq_title_change();
				this.delete_faq();
				this.toggle_faq();
				this.sortable_faq();
				this.repair_key_faq();

			
			},
			tab: function(){
				$( "#tabs" ).tabs();
				var $hash = window.location.hash;
	            if ( $hash != '' ) {
	                if ( $(document).find('#ovaem-event-setting').length ) {
	                    $(document).find('#ovaem-event-setting').attr('action','options.php'+$hash);
	                }
	            }
	            $(document).find( "#tabs" ).on( "tabsactivate", function( event, ui ) {
	                var $id = ui.newPanel[0].id;
	                if ( $(document).find('#ovaem-event-setting').length ) {
	                    $(document).find('#ovaem-event-setting').attr('action','options.php'+'#'+$id);
	                }
	            } );
			},
			datetime: function(){
				var date_start_time = $('#date_start_time'), 
					date_end_time = $('#date_end_time');
				var schedule_date = $('.schedule_date');

				var date_format = date_start_time.data('date_format');
				var time_format = date_start_time.data('time_format');
				var step  = date_start_time.data('step');
	            var firstDay = date_start_time.data('first-day');

				date_start_time.datetimepicker({
					dayOfWeekStart: firstDay,
					format: date_format+' '+time_format,
					scrollMonth : false,
					scrollInput : false,
					step:step
					
				});
				date_end_time.datetimepicker({
					dayOfWeekStart: firstDay,
					format: date_format+' '+time_format,
					scrollMonth : false,
					scrollInput : false,
					step:step
					
				});
				
				$(document).on('click', '.ovaem_datetime_picker', function(){
					
					var date_format = $(this).data('date_format');
					var time_format = $(this).data('time_format');
					var step = $(this).data('step');
		            var firstDay = $(this).data('first-day');

					$(this).datetimepicker({
						 dayOfWeekStart: firstDay,
						 format: date_format+' '+time_format,
						 scrollMonth : false,
						 scrollInput : false,
						 step:step
					});
				});
				
			},
			show_map: function(){

				$('select.ovaem_show_map').off('change').on('change', function(){
					var parent = $(this).parent().parent().parent();
					
					if( $(this).val() == 'yes' ){
						parent.find('.ovaevent_map').css('display', 'block');
					}else if( $(this).val() == 'no' ){
						parent.find('.ovaevent_map').css('display', 'none');
					}
				});

				$("#basic_event_metabox").each(function(){

					$(this).bind("toggle_showhide",function(){

						var pay_method_seleted = $(this).find('select.ovaem_show_map :selected').val();

						if( pay_method_seleted == 'yes' ){
							$(this).find('.ovaevent_map').css('display', 'block');
						}else if( pay_method_seleted == 'no' ){
							$(this).find('.ovaevent_map').css('display', 'none');
						}
							
						});

						$(this).trigger("toggle_showhide");
						$(this).find('select.ovaem_show_map').change(function(){
							$(this).trigger("toggle_showhide");
						});

				});
			},
			avaiable_date_selling: function(){

				$('select.avaiable_date_selling').off('change').on('change', function(){

					var parent = $(this).parent();

					if( $(this).val() == 'open_ended' ){
						parent.find('.avaiable_date_selling_date_range').css('display','none');

					}else if( $(this).val()== 'date_range' ) {
						parent.find('.avaiable_date_selling_date_range').css('display','inline-block');

					}

				});

				$(".ticket_item").each(function(){

					$(this).bind("avaiable_date_sell_showhide",function(){


						var avaiable_date_selling = $(this).find('select.avaiable_date_selling :selected').val();

						if( avaiable_date_selling == 'open_ended' ){
							$(this).find('.avaiable_date_selling_date_range').css('display','none');

						}else if( avaiable_date_selling == 'date_range' ) {
							$(this).find('.avaiable_date_selling_date_range').css('display','inline-block');

						}

						
					});

					$(this).trigger("avaiable_date_sell_showhide");
					
					$(this).find('select.avaiable_date_selling').change(function(){
						$(this).trigger("avaiable_date_sell_showhide");
					});

				});


			},
			pay_method: function(){

				/* Price */
				$('select.ovaem_pay_method').off('change').on('change', function(){

					var parent = $(this).parent().parent();

					if( $(this).val() == 'free' ){

						parent.find('.ova_quatity').css('display','none');
						parent.find('.ova_outside').css('display','none');
						parent.find('.ova_price').css('display','none');
						parent.find('.ova_currency').css('display','none');
						parent.find('.ova_woo_id').css('display','none');
						parent.find('.ova_number_ticket').css('display','block');
						

					}else if( $(this).val() == 'paid_woo' ){

						parent.find('.ova_price').css('display','block');
						parent.find('.ova_currency').css('display','block');
						parent.find('.ova_woo_id').css('display','block');

						parent.find('.ova_quatity').css('display','none');
						parent.find('.ova_outside').css('display','none');
						parent.find('.ova_number_ticket').css('display','none');
					
					}else if( $(this).val() == 'outside' ){

						parent.find('.ova_outside').css('display','block');
						parent.find('.ova_price').css('display','block');
						parent.find('.ova_currency').css('display','block');
						parent.find('.ova_number_ticket').css('display','block');

						parent.find('.ova_quatity').css('display','none');
						parent.find('.ova_woo_id').css('display','none');

					}else if( $(this).val() == 'other_pay_gateway' ){

						parent.find('.ova_price').css('display','block');
						parent.find('.ova_currency').css('display','block');
						parent.find('.ova_number_ticket').css('display','block');

						parent.find('.ova_woo_id').css('display','none');
						parent.find('.ova_quatity').css('display','none');
						parent.find('.ova_outside').css('display','none');
					
					} else if( $(this).val() == 'woo_modern' ){
						parent.find('.ova_price').css('display','block');
						parent.find('.ova_currency').css('display','block');
						parent.find('.ova_woo_id').css('display','none');

						parent.find('.ova_quatity').css('display','none');
						parent.find('.ova_outside').css('display','none');
						parent.find('.ova_number_ticket').css('display','block');
					}
				});

				/* For First Load Ticket Item */
				$(".ticket_item").each(function(){

					$(this).bind("toggle_showhide",function(){

						var pay_method_seleted = $(this).find('select.ovaem_pay_method :selected').val();

						if( pay_method_seleted == 'free' ){
							
							$(this).find('.ova_quatity').css('display','none');
							$(this).find('.ova_outside').css('display','none');
							$(this).find('.ova_price').css('display','none');
							$(this).find('.ova_currency').css('display','none');
							$(this).find('.ova_woo_id').css('display','none');
							$(this).find('.ova_number_ticket').css('display','block');
							

						}else if( pay_method_seleted == 'paid_woo' ) {

							$(this).find('.ova_price').css('display','block');
							$(this).find('.ova_currency').css('display','block');
							$(this).find('.ova_woo_id').css('display','block');

							$(this).find('.ova_quatity').css('display','none');
							$(this).find('.ova_outside').css('display','none');
							$(this).find('.ova_number_ticket').css('display','none');


						}else if( pay_method_seleted == 'outside' ){

							$(this).find('.ova_outside').css('display','block');
							$(this).find('.ova_price').css('display','block');
							$(this).find('.ova_currency').css('display','block');
							$(this).find('.ova_number_ticket').css('display','block');

							$(this).find('.ova_quatity').css('display','none');
							$(this).find('.ova_woo_id').css('display','none');

							
						}else if( pay_method_seleted == 'other_pay_gateway' ){

							$(this).find('.ova_price').css('display','block');
							$(this).find('.ova_currency').css('display','block');
							$(this).find('.ova_number_ticket').css('display','block');
							
							$(this).find('.ova_woo_id').css('display','none');
							$(this).find('.ova_quatity').css('display','none');
							$(this).find('.ova_outside').css('display','none');
						
						}else if( pay_method_seleted == 'woo_modern' ){

							$(this).find('.ova_price').css('display','block');
							$(this).find('.ova_currency').css('display','block');
							$(this).find('.ova_woo_id').css('display','none');

							$(this).find('.ova_quatity').css('display','none');
							$(this).find('.ova_outside').css('display','none');
							$(this).find('.ova_number_ticket').css('display','block');
						
						}
						
					});

					$(this).trigger("toggle_showhide");

					$(this).find('select.ovaem_pay_method').change(function(){
						$(this).trigger("toggle_showhide");
					});

					

				});

				

				
			},
			map: function(){
				
				if( $("#map").length > 0 && typeof google !== 'undefined' ){
					var map_lat = parseFloat( $('input#map_lat').val() );
					var map_lng = parseFloat( $('input#map_lng').val() );

					$("#map").ovaevent_map({ lat: map_lat, lng: map_lng, zoom: 17 });	
				}
			},

			add_ticket: function(){
				$('#ticket_event_metabox .add_ticket').off('click').on('click', function(){
					
					var count_tickets = OVAEM.Meta_Boxes.count_tickets();

					var data = {
						'action': 'generate_metabox_event_ticket',
						'add_ticket': 'yes',
						'count_tickets': count_tickets+1
					}

					$.post( ajaxurl, data, function( response ) {
						$('#ticket_event_metabox .tickets').append(response);
						OVAEM.Meta_Boxes.pay_method();
						OVAEM.Meta_Boxes.avaiable_date_selling();
						OVAEM.Meta_Boxes.add_cer_ticket();
					});

				});
			},
			count_tickets: function(){
				var count = $('#ticket_event_metabox .tickets .ticket_item').length;
				return count-1;
			},
			load_tickets: function(){

					var event_id = $('#ticket_event_metabox .add_ticket').data('event-id');

					var data = {
						'action': 'generate_metabox_event_ticket',
						'event_id': event_id
					}

					$.post( ajaxurl, data, function( response ) {
						$('#ticket_event_metabox .tickets').append(response);
						$('#ticket_event_metabox .tickets .ticket_content').css('display','none');
						OVAEM.Meta_Boxes.pay_method();
						OVAEM.Meta_Boxes.avaiable_date_selling();
						OVAEM.Meta_Boxes.add_cer_ticket();
					});
					

				
			},
			toggle_ticket: function(){
				$(document).on( "click", '#ticket_event_metabox .head', function(e){
						$(this).parent().find(".ticket_content").toggle();
						return false;
					
				});
				
			},
			ticket_title_change: function(){
				$(document).on( "change", '#ticket_event_metabox input.ticket_name', function(e){
						var title = $(this).val();

						$(this).parent().parent().parent().find(".head .date_label .label_title").html('').append(title);
						return false;
					
				});
			},

			delete_ticket: function(){

				$(document).on("click", "#ticket_event_metabox .ticket_item .head .delete_ticket", function(e) {
			        $(this).parent().parent().parent().remove();
			        OVAEM.Meta_Boxes.repair_key_ticket();
			        return false;
			    });
				
			},
			sortable_ticket: function(){
				$( "#ticket_event_metabox .tickets" ).sortable({
					update: function( event, ui ) {
						OVAEM.Meta_Boxes.repair_key_ticket();
					}
					
				});
    			$( "#ticket_event_metabox .tickets" ).disableSelection();
    			
	    		return false;
			},
			repair_key_ticket: function(){

				
				var count_tickets = OVAEM.Meta_Boxes.count_tickets();

				var i = 0;

				$('#ticket_event_metabox .tickets .ticket_item').each(function(){

					var prefix = $(this).data('prefix');
					
					var d = 0;
					/* Change date key */
					$(this).attr('class','ticket_item ticket_item_'+i+'');

					/* Change plan key */
					$(this).find('.ticket_content').each(function(){
						
						$(this).find('.package_id').attr('name', prefix+'_ticket['+i+'][package_id]');		
						$(this).find('.ticket_name').attr('name', prefix+'_ticket['+i+'][ticket_name]');
						$(this).find('.ovaem_pay_method').attr('name', prefix+'_ticket['+i+'][pay_method]');
						$(this).find('.quatity').attr('name', prefix+'_ticket['+i+'][quatity]');
						$(this).find('.outside').attr('name', prefix+'_ticket['+i+'][outside]');
						$(this).find('.ticket_price').attr('name', prefix+'_ticket['+i+'][ticket_price]');
						$(this).find('.ticket_cur').attr('name', prefix+'_ticket['+i+'][ticket_cur]');
						$(this).find('.ticket_feature').attr('name', prefix+'_ticket['+i+'][ticket_feature]');
						$(this).find('.ticket_desc').attr('name', prefix+'_ticket['+i+'][ticket_desc]');
						$(this).find('.ticket_woo_id').attr('name', prefix+'_ticket['+i+'][ticket_woo_id]');
						$(this).find('.number_ticket').attr('name', prefix+'_ticket['+i+'][number_ticket]');
						$(this).find('.avaiable_date_selling').attr('name', prefix+'_ticket['+i+'][avaiable_date_selling]');
						$(this).find('.sell_date_start').attr('name', prefix+'_ticket['+i+'][sell_date_start]');
						$(this).find('.sell_date_end').attr('name', prefix+'_ticket['+i+'][sell_date_end]');

						d++;
					});

					
					
					i++;
				});

				
				
			},
			add_cer_ticket: function(){
				// PDF Attach
			  $('.upload_pdf_button').off('click').on('click', function() {

			      var send_attachment_bkp = wp.media.editor.send.attachment;
			      var button = $(this);
			      wp.media.editor.send.attachment = function(props, attachment) {

			      	if(attachment.type == 'image'){
			      		$(button).parent().parent().find('.file_ticket').hide();
			      		$(button).parent().parent().find('.img_ticket').hide();
			      		$(button).parent().parent().find('.file_ticket_2').hide();
			      		$(button).parent().parent().find('.img_ticket_2').show();
			      		$(button).parent().parent().find('.img_ticket_2').attr('src', attachment.url);

			      	};


			      	 if(attachment.type == 'text' || attachment.type == 'application'){

			      	 	$(button).parent().parent().find('.file_ticket').hide();
			      	 	$(button).parent().parent().find('.img_ticket').hide();
			      	 	$(button).parent().parent().find('.img_ticket_2').hide();
			      	 	$(button).parent().parent().find('.file_ticket_2').show();
			      	 	$(button).parent().parent().find('.file_ticket_2').html(attachment.filename);
			      	 };

			          $(button).prev().val(attachment.id);
			          wp.media.editor.send.attachment = send_attachment_bkp;
			      }
			      wp.media.editor.open(button);
			    
			      return false;
			  });

			  // The "Remove" button (remove the value from input type='hidden')
			  $('.remove_pdf_button').click(function() {
			      var answer = confirm('Are you sure?');
			      if (answer == true) {
			          var src = $(this).parent().prev().attr('data-src');
			          $(this).parent().prev().attr('src', src);
			          $(this).prev().prev().val('');
			          $(this).parent().parent().find('img').hide();
			          $(this).parent().parent().find('a').hide();
			      }
			      return false;
			  });
			},

			
			add_schedule: function(){
				$('#schedule_event_metabox .add_schedule').off('click').on('click', function(){
					
					var count_schedules = OVAEM.Meta_Boxes.count_schedules();

					var data = {
						'action': 'generate_metabox_event_schedule',
						'add_schedule': 'yes',
						'count_schedules': count_schedules+1
					}

					$.post( ajaxurl, data, function( response ) {
						$('#schedule_event_metabox .schedules').append(response);
					});

				});
			},
			load_schedules: function(){

					var event_id = $('#schedule_event_metabox .add_schedule').data('event-id');

					var data = {
						'action': 'generate_metabox_event_schedule',
						'event_id': event_id
					}

					$.post( ajaxurl, data, function( response ) {
						$('#schedule_event_metabox .schedules').append(response);
						OVAEM.Meta_Boxes.load_plans();
					});
					
				
			},
			count_schedules: function(){
				var count = $('#schedule_event_metabox .schedules .schedule_item').length;
				return count-1;
			},
			
			delete_schedule: function(){

				$(document).on("click", "#schedule_event_metabox .schedule_item .head .delete_schedule", function(e) {
			        $(this).parent().parent().parent().remove();
			        OVAEM.Meta_Boxes.repair_key_schedules();
			        return false;
			    });
				
			},
			
			sortable_schedule: function(){
				$( "#schedule_event_metabox .schedules" ).sortable({
					update: function( event, ui ) {
						OVAEM.Meta_Boxes.repair_key_schedules();
					}
					
				});
    			$( "#schedule_event_metabox .schedules" ).disableSelection();
    			
	    		return false;
			},
			toggle_schedule: function(){
				$(document).on( "click", '#schedule_event_metabox .head', function(e){
						$(this).parent().find(".schedule_content").toggle();
						return false;
					
				});
				
			},
			schedule_title_change: function(){
				$(document).on( "change", '#schedule_event_metabox input.schedule_name', function(e){
						var title = $(this).val();

						$(this).parent().parent().parent().find(".head .date_label .label_title").html('').append(title);
						return false;
					
				});
			},
			repair_key_schedules: function(){

				
				var count_schedules = OVAEM.Meta_Boxes.count_schedules();

				var i = 0;

				$('#schedule_event_metabox .schedules .schedule_item').each(function(){

					var prefix = $(this).data('prefix');
					
					var d = 0;
					/* Change date key */	
					$(this).find('.schedule_date').attr('name',prefix+'_schedule_date['+i+'][date]');
					$(this).find('.schedule_name').attr('name',prefix+'_schedule_date['+i+'][name]');
					$(this).find('.schedule_plans').attr('class','schedule_plans schedule_plans'+i+'');
					

					/* Change plan key */
					$(this).find('.plan_item').each(function(){
								
						$(this).find('.schedule_speaker').attr('name', prefix+'_schedule_plan['+i+']['+d+'][speakers]');
						$(this).find('.schedule_title').attr('name', prefix+'_schedule_plan['+i+']['+d+'][title]');
						$(this).find('.schedule_desc').attr('name', prefix+'_schedule_plan['+i+']['+d+'][desc]');
						
						d++;
					});

					
					
					i++;
				});

				
				
			},
			load_plans: function(){
				
					$('.schedule_item .head').each(function(){
						var event_id 	= $(this).parent().parent().parent().find('.add_schedule').data('event-id'),
						schedule_id = $(this).parent().data('schedule-id'),
						html_append = $(this).parent().find('.schedule_plans');
					
						var data = {
							'action': 'generate_metabox_event_plan',
							'event_id': event_id,
							'schedule_id': schedule_id
						}

						$.post( ajaxurl, data, function( response ) {
							html_append.html('').append(response);

							/* Load image speakers */
							$('.schedule_speaker').each(function(){
								var speaker_arr = $(this).val();
								OVAEM.Meta_Boxes.dis_speaker( speaker_arr, this );

							});
							$('#schedule_event_metabox .schedules .plan_data').css('display','none');
						});
					});
					OVAEM.Meta_Boxes.sortable_plan();
				
			},
			add_plan: function(){
				
					$(document).on('click', '#schedule_event_metabox .add_schedule_plan', function(){
					
						var schedule_id = $(this).parent().parent().data('schedule-id');
						var count_plans 	= OVAEM.Meta_Boxes.count_plans(schedule_id);

						var append_place = $(this).parent().find('.schedule_plans'+schedule_id);
						
							var data = {
								'action': 'generate_metabox_event_plan',
								'add_schedule_plan': 'yes',
								'schedule_id': schedule_id,
								'count_plans': count_plans+1
							}

							$.post( ajaxurl, data, function( response ) {
								append_place.append(response);
							});
					});
				
			},

			count_plans: function(schedule_id){
				var count_cur_plans = $('#schedule_event_metabox .schedule_plans'+schedule_id+' .plan_item').length;
				return count_cur_plans-1;
			},

			
			sortable_plan: function(){
				$( "#schedule_event_metabox .schedule_item .schedule_plans" ).sortable({

					update: function( event, ui ) {
						var schedule_id = $(this).parent().parent().data('schedule-id');
						OVAEM.Meta_Boxes.repair_key_schedules();
					}
					
				});
    			$( ".schedule_item .schedule_plans" ).disableSelection();
    			
    			return false;
			},
			toggle_plan: function(){
				$(document).on( "click", '#schedule_event_metabox .content_plan .head', function(e){
						$(this).parent().find(".plan_data").toggle();
						return false;
					
				});
				
			},
			delete_plan: function(){

				$(document).on("click", "#schedule_event_metabox .schedule_item .head .delete_plan", function(e) {
			        $(this).parent().parent().parent().parent().remove();
			        OVAEM.Meta_Boxes.repair_key_schedules();
			        return false;
			    });
				
			},
			plan_title_change: function(){
				$(document).on( "change", '.plan_data input.schedule_title', function(e){
						var title = $(this).val();

						$(this).parent().parent().parent().find(".head .date_label .label_title").html('').append(title);
						return false;
					
				});
			},



			add_sponsor: function(){
				$('#sponsor_event_metabox .add_sponsor').off('click').on('click', function(){
					
					var count_sponsors = OVAEM.Meta_Boxes.count_sponsors();

					var data = {
						'action': 'generate_metabox_event_sponsor',
						'add_sponsor': 'yes',
						'count_sponsors': count_sponsors+1
					}

					$.post( ajaxurl, data, function( response ) {
						$('#sponsor_event_metabox .sponsors').append(response);
					});

				});
			},
			count_sponsors: function(){
				var count = $('#sponsor_event_metabox .sponsors .sponsor_item').length;
				return count-1;
			},
			sponsor_title_change: function(){
				$(document).on( "change", '#sponsor_event_metabox input.sponsor', function(e){
						var title = $(this).val();

						$(this).parent().parent().parent().find(".head .date_label .label_title").html('').append(title);
						return false;
					
				});
			},
			load_sponsors: function(){

					var event_id = $('#sponsor_event_metabox .add_sponsor').data('event-id');

					var data = {
						'action': 'generate_metabox_event_sponsor',
						'event_id': event_id
					}

					$.post( ajaxurl, data, function( response ) {
						$('#sponsor_event_metabox .sponsors').append(response);
						$('#sponsor_event_metabox .sponsors .sponsor_content').css('display','none');
						OVAEM.Meta_Boxes.load_sponsors_info();
					});

				
			},
			delete_sponsor: function(){

				$(document).on("click", "#sponsor_event_metabox .sponsor_item .head .delete_sponsor", function(e) {
			        $(this).parent().parent().parent().remove();
			        OVAEM.Meta_Boxes.repair_key_sponsor();
			        return false;
			    });
				
			},
			toggle_sponsor: function(){
				$(document).on( "click", '#sponsor_event_metabox .head', function(e){
						$(this).parent().find(".sponsor_content").toggle();
						return false;
					
				});
				
			},
			sortable_sponsor: function(){
				$( "#sponsor_event_metabox .sponsors" ).sortable({
					update: function( event, ui ) {
						OVAEM.Meta_Boxes.repair_key_sponsor();
					}
					
				});
    			$( "#sponsor_event_metabox .sponsors" ).disableSelection();
    			
	    		return false;
			},
			repair_key_sponsor: function(){

				
				var count_sponsors = OVAEM.Meta_Boxes.count_sponsors();

				var i = 0;

				$('#sponsor_event_metabox .sponsors .sponsor_item').each(function(){

					var prefix = $(this).data('prefix');
					
					var d = 0;
					/* Change date key */	
					$(this).find('.sponsor_level').attr('name',prefix+'_sponsor_level['+i+']');
					$(this).find('.sponsor_list').attr('class','sponsor_list sponsor_list'+i+'');
					

					/* Change plan key */
					$(this).find('.sponsor_item_info').each(function(){
								
						$(this).find('.sponsor_item_link').attr('name', prefix+'_sponsor_info['+i+']['+d+'][link]');
						$(this).find('.sponsor_info_logo').attr('name', prefix+'_sponsor_info['+i+']['+d+'][logo]');
						
						d++;
					});

					
					
					i++;
				});

				
				
			},

			load_sponsors_info: function(){


					$('.sponsor_item .head').each(function(){
						var event_id 	= $(this).parent().parent().parent().find('.add_sponsor').data('event-id'),
						sponsor_id = $(this).parent().data('sponsor-id'),
						html_append = $(this).parent().find('.sponsor_list');
					
						var data = {
							'action': 'generate_metabox_event_sponsor_info',
							'event_id': event_id,
							'sponsor_id': sponsor_id
						}

						$.post( ajaxurl, data, function( response ) {
							html_append.html('').append(response);

							
						});

					
						

				});
				
			},
			add_sponsor_info: function(){
				
					$(document).on('click', '#sponsor_event_metabox .add_sponsor_info', function(){
					
						var sponsor_id = $(this).parent().parent().data('sponsor-id');
						var count_sponsors_info 	= OVAEM.Meta_Boxes.count_sponsors_info(sponsor_id);

						var append_place = $(this).parent().find('.sponsor_list'+sponsor_id);
						
							var data = {
								'action': 'generate_metabox_event_sponsor_info',
								'add_sponsor_info': 'yes',
								'sponsor_id': sponsor_id,
								'count_sponsors_info': count_sponsors_info+1
							}

							$.post( ajaxurl, data, function( response ) {
								append_place.append(response);
							});
					});
				
			},
			count_sponsors_info: function(sponsor_id){
				var count_cur_sponsors = $('#sponsor_event_metabox .sponsor_list'+sponsor_id+' .sponsor_item_info').length;
				return count_cur_sponsors-1;
			},
			sponsor_info_title_change:function(){
				$(document).on( "change", '.plan_data input.sponsor_item_link', function(e){
						var title = $(this).val();

						$(this).parent().parent().parent().find(".head .date_label .label_title").html('').append(title);
						return false;
					
				});
			},
			delete_sponsor_info:function(){
				$(document).on("click", "#sponsor_event_metabox .sponsor_item_info .head .delete_sponsor_item_info", function(e) {
			        $(this).parent().parent().parent().parent().remove();
			        OVAEM.Meta_Boxes.repair_key_sponsor();
			        return false;
			    });
			},

			
			

			/* Social Speaker */
			add_social: function(){
				$('#speaker-metabox-settings .add_social').off('click').on('click', function(){
					
					var count_social = OVAEM.Meta_Boxes.count_social();

					var data = {
						'action': 'generate_metabox_speaker_social',
						'add_social': 'yes',
						'count_social': count_social+1
					}

					$.post( ajaxurl, data, function( response ) {
						$('#speaker-metabox-settings .content_social').append(response);
					});

				});
			},
			count_social: function(){
				var count = $('#speaker-metabox-settings .content_social .social_item').length;
				return count-1;
			},
			load_social: function(){

					var speaker_id = $('#speaker-metabox-settings .add_social').data('speaker-id');

					var data = {
						'action': 'generate_metabox_speaker_social',
						'speaker_id': speaker_id
					}

					$.post( ajaxurl, data, function( response ) {
						$('#speaker-metabox-settings .content_social').append(response);
					});

				
			},
			delete_social: function(){
				$(document).on("click", ".remove_social", function(e) {
			        $(this).parent().remove();
			        OVAEM.Meta_Boxes.repair_key_social();
			        return false;
			    });
			},
			repair_key_social: function(){

				var count_schedules = OVAEM.Meta_Boxes.count_social();

				var i = 0;

				$('.content_social .social_item').each(function(){

					var prefix = $(this).data('prefix');
				
					/* Change key */	
					$(this).find('.social_fontclass').attr('name', prefix+'_speaker_social['+i+'][fontclass]');
					$(this).find('.social_link').attr('name', prefix+'_speaker_social['+i+'][link]');

					i++;

				});

			},
			load_speakers_popup: function(pos_append, pos_speaker, speaker_choosed_arr){

				var data = {
					'action': 'generate_metabox_speakers',
					'pos_speaker': pos_speaker,
					'speaker_choosed_arr': speaker_choosed_arr
				}

				$.post( ajaxurl, data, function( response ) {
					$(pos_append).html('').append(response);
					/* Pagination for speaker */
					OVAEM.Meta_Boxes.pagination_speaker();
				});

				

			},
			dialog: function(pos, title){
				$(pos).dialog({
				  title: title,	
			      autoOpen: true,
			      height: 400,
			      width: 500,
			      modal: true,

			    });
			},
			dialog_speakers: function(){
				$(document).on('click', '.choose_speakers', function(e){
					OVAEM.Meta_Boxes.dialog('#dialogs', 'All Speakers');

					var pos_speaker = $(this).data('pos-speaker');
					/* Get all speaker choosed */
					var speaker_choosed_arr = $(this).parent().find('.schedule_speaker').val();
					OVAEM.Meta_Boxes.load_speakers_popup("#dialogs", pos_speaker, speaker_choosed_arr);
					e.preventDefault();

				});

				
			},
			add_speaker: function(){
				$(document).on('click','.add_speaker', function(e){
					var speaker_arr = '';
					$('table.speakers_list input:checkbox:checked').each(function(){
						speaker_arr += $(this).val()+',';
					});

					/* set value for speaker hidden field */
					var pos_speaker = $(this).data('pos-speaker');
					$('.'+pos_speaker).val(speaker_arr);
					OVAEM.Meta_Boxes.dis_speaker(speaker_arr, '.'+pos_speaker);
					$("#dialogs").dialog("close");
					e.preventDefault();

				});
			},
			dis_speaker: function(speaker_arr, pos_dis){

				var data = {
					'action': 'generate_metabox_dis_speakers',
					'speaker_arr': speaker_arr
				}
				

				$.post( ajaxurl, data, function( response ) {
					$(pos_dis).parent().find('.spekers_img').html('').append(response);
				});
				
			},
			showPage: function(page){
				var pageSize = 10;
				$("#list_speakers .content").hide();
			    $("#list_speakers .content").each(function(n) {
			        if (n >= pageSize * (page - 1) && n < pageSize * page)
			            $(this).show();
			    });        
			},
			pagination_speaker: function(){

				OVAEM.Meta_Boxes.showPage(1);

				$("#ovaem_pagin li a").click(function(e) {
					e.preventDefault();
				    $("#ovaem_pagin li a").removeClass("current");
				    $(this).addClass("current");
				    OVAEM.Meta_Boxes.showPage(parseInt($(this).text())) 
				});
				    

			},
			resend_pdf_ticket: function(){
				$('#resend_ticket .resend_ticket').off('click').on('click', function( e ){

					e.preventDefault();

					var parent = $(this).parent();

					var ticket_id = parent.find('.ticket_id').val();
					var buyer_email = parent.find('.buyer_email').val();
					var name_event = parent.find('.name_event').val();
					var verify_ticket = parent.find('.verify_ticket').val();

					var data = {
						'action': 'resend_pdf_ticket',
						'method': 'POST',
						'ticket_id': ticket_id,
						'buyer_email': buyer_email,
						'name_event': name_event,
						'verify_ticket': verify_ticket
					}
					

					$.post( ajaxurl, data, function( response ) {
						var alert_result = '<span style="color:red">'+response+'</span>';

						$('#resend_ticket .alert_result').html('').append(alert_result);
					});

				});
			},

			/* FAQ */
			add_faq: function(){
				$('#faq_event_metabox .add_faq').off('click').on('click', function(){
					
					var count_faqs = OVAEM.Meta_Boxes.count_faqs();

					var data = {
						'action': 'generate_metabox_event_faq',
						'add_faq': 'yes',
						'count_faqs': count_faqs+1
					}

					$.post( ajaxurl, data, function( response ) {
						$('#faq_event_metabox .faqs').append(response);
					});

				});
			},
			count_faqs: function(){
				var count = $('#faq_event_metabox .faqs .faq_item').length;
				return count-1;
			},
			faq_title_change: function(){
				$(document).on( "change", '#faq_event_metabox input.faq_title', function(e){

						var title = $(this).val();

						$(this).closest('.faq_item').find(".head .label_title").html('').append(title);
						return false;
					
				});
			},
			load_faqs: function(){

					var event_id = $('#faq_event_metabox .add_faq').data('event-id');

					var data = {
						'action': 'generate_metabox_event_faq',
						'event_id': event_id
					}

					$.post( ajaxurl, data, function( response ) {
						$('#faq_event_metabox .faqs').append(response);
						$('#faq_event_metabox .faqs .faq_content').css('display','none');
						
					});

				
			},
			delete_faq: function(){

				$(document).on("click", "#faq_event_metabox .faq_item .head .delete_faq", function(e) {
			        $(this).parent().parent().parent().remove();
			        OVAEM.Meta_Boxes.repair_key_faq();
			        return false;
			    });
				
			},
			toggle_faq: function(){
				$(document).on( "click", '#faq_event_metabox .head', function(e){
						$(this).parent().find(".faq_content").toggle();
						return false;
					
				});
				
			},
			sortable_faq: function(){
				$( "#faq_event_metabox .faqs" ).sortable({
					update: function( event, ui ) {
						OVAEM.Meta_Boxes.repair_key_faq();
					}
					
				});
				$( "#faq_event_metabox .faqs" ).disableSelection();
				
				return false;
			},
			repair_key_faq: function(){

				
				var count_faqs = OVAEM.Meta_Boxes.count_faqs();

				var i = 0;

				$('#faq_event_metabox .faqs .faq_item').each(function(){

					var prefix = $(this).data('prefix');
					
					var d = 0;
					/* Change date key */	
					$(this).find('.faq_level').attr('name',prefix+'_faq_level['+i+']');
					$(this).find('.faq_list').attr('class','faq_list faq_list'+i+'');
					

					/* Change plan key */
					$(this).find('.faq_item_info').each(function(){
								
						$(this).find('.faq_item_link').attr('name', prefix+'_faq_info['+i+']['+d+'][link]');
						$(this).find('.faq_info_logo').attr('name', prefix+'_faq_info['+i+']['+d+'][logo]');
						
						d++;
					});

					
					
					i++;
				});

				
				
			},

		}

		OVAEM.Settings = {
			init: function(){
				this.ovaem_custom_field_checkout();
			},
			ovaem_custom_field_checkout: function() {
	            // Sortable
	            $('.el-sortable').sortable();
	            $('.ovaem-sortable').sortable({
	                update: function( event, ui ) {
	                    $(".ova-list-checkout-field .wrap_loader").show();
	                    const ova_post_name = $(".ova-list-checkout-field .ova_pos_name");
	                    var pos = {};
	                    ova_post_name.each(function(i,el){
	                        
	                        $(el).each(function(){
	                            pos[$(this).data("name")] = i;
	                        });                        
	                        
	                    });
	                    var data = {
	                        'action': 'ovaem_sortable_checkout_field',
	                        'pos': pos,
	                    };

	                    $.post(ajax_object.ajax_url, data, function(response) {
	                        $(".ova-list-checkout-field .ovaem-sortable").html(response);
	                        $(".ova-list-checkout-field .wrap_loader").hide();
	                    });
	                }
	            });

	            // Select
	            var OVA_OPTION_ROW_HTML  = '';
	                OVA_OPTION_ROW_HTML += '<tr>';
	                OVA_OPTION_ROW_HTML += '<td><input type="text" name="ova_options_key[]" placeholder="Option Value" /></td>';
	                OVA_OPTION_ROW_HTML += '<td><input type="text" name="ova_options_text[]" placeholder="Option Text" /></td>';
	                OVA_OPTION_ROW_HTML += '<td class="ova-box"><a href="javascript:void(0)" class="ovalg_addfield btn btn-blue" title="Add new option">+</a></td>';
	                OVA_OPTION_ROW_HTML += '<td class="ova-box"><a href="javascript:void(0)" class="ovalg_remove_row btn btn-red" title="Remove option">x</a></td>';
	                OVA_OPTION_ROW_HTML += '<td class="ova-box sort"><span class="dashicons dashicons-menu" title="Drag & Drop"></span></td>';
	                OVA_OPTION_ROW_HTML += '</tr>';

	            $(document).on('click', '.ova-wrap-popup-checkout-field .ovalg_addfield', function(e) {
	                var table       = $(this).closest('table');
	                var optionsSize = table.find('tbody tr').size();
	                var height      = $('.ova-wrap-popup-checkout-field').attr('height');

	                if ( height ) {
	                    height = parseInt(height) + 5;
	                } else {
	                    height = 110;
	                }
	                 
	                $('.ova-wrap-popup-checkout-field').attr('height', height);
	                $('.ova-wrap-popup-checkout-field').css('height', height + 'vh');

	                if ( optionsSize > 0 ) {
	                    table.find('tbody tr:last').after(OVA_OPTION_ROW_HTML);
	                } else {
	                    table.find('tbody').append(OVA_OPTION_ROW_HTML);        
	                }
	            });
	             
	            $(document).on('click','.ova-wrap-popup-checkout-field .ovalg_remove_row', function(e) {
	                var table = $(this).closest('table');
	                $(this).closest('tr').remove();
	                var optionsSize = table.find('tbody tr').size();
	                     
	                if (optionsSize == 0) {
	                    table.find('tbody').append(OVA_OPTION_ROW_HTML);
	                }
	            });
	            // End

	            // Radio
	            var OVA_RADIO_ROW_HTML  = '';
	                OVA_RADIO_ROW_HTML += '<tr>';
	                OVA_RADIO_ROW_HTML += '<td><input type="text" name="ova_radio_key[]" placeholder="Option Value" /></td>';
	                OVA_RADIO_ROW_HTML += '<td><input type="text" name="ova_radio_text[]" placeholder="Option Text" /></td>';
	                OVA_RADIO_ROW_HTML += '<td class="ova-box"><a href="javascript:void(0)" class="el_lg_add_radio btn btn-blue" title="Add new option">+</a></td>';
	                OVA_RADIO_ROW_HTML += '<td class="ova-box"><a href="javascript:void(0)" class="el_lg_remove_radio btn btn-red" title="Remove option">x</a></td>';
	                OVA_RADIO_ROW_HTML += '<td class="ova-box sort"><span class="dashicons dashicons-menu" title="Drag & Drop"></span></td>';
	                OVA_RADIO_ROW_HTML += '</tr>';

	            $(document).on('click', '.ova-wrap-popup-checkout-field .el_lg_add_radio', function(e) {
	                var table       = $(this).closest('table');
	                var optionsSize = table.find('tbody tr').size();
	                var height      = $('.ova-wrap-popup-checkout-field').attr('height');

	                if ( height ) {
	                    height = parseInt(height) + 5;
	                } else {
	                    height = 110;
	                }
	                 
	                $('.ova-wrap-popup-checkout-field').attr('height', height);
	                $('.ova-wrap-popup-checkout-field').css('height', height + 'vh');

	                if ( optionsSize > 0 ) {
	                    table.find('tbody tr:last').after(OVA_RADIO_ROW_HTML);
	                } else {
	                    table.find('tbody').append(OVA_RADIO_ROW_HTML);        
	                }
	            });
	             
	            $(document).on('click','.ova-wrap-popup-checkout-field .el_lg_remove_radio', function(e) {
	                var table = $(this).closest('table');
	                $(this).closest('tr').remove();
	                var optionsSize = table.find('tbody tr').size();
	                     
	                if (optionsSize == 0) {
	                    table.find('tbody').append(OVA_RADIO_ROW_HTML);
	                }
	            });
	            // End
	            
	            // Checkbox
	            var OVA_CHECKBOX_ROW_HTML  = '';
	                OVA_CHECKBOX_ROW_HTML += '<tr>';
	                OVA_CHECKBOX_ROW_HTML += '<td><input type="text" name="ova_checkbox_key[]" placeholder="Option Value" /></td>';
	                OVA_CHECKBOX_ROW_HTML += '<td><input type="text" name="ova_checkbox_text[]" placeholder="Option Text" /></td>';
	                OVA_CHECKBOX_ROW_HTML += '<td class="ova-box"><a href="javascript:void(0)" class="el_lg_add_checkbox btn btn-blue" title="Add new option">+</a></td>';
	                OVA_CHECKBOX_ROW_HTML += '<td class="ova-box"><a href="javascript:void(0)" class="el_lg_remove_checkbox btn btn-red" title="Remove option">x</a></td>';
	                OVA_CHECKBOX_ROW_HTML += '<td class="ova-box sort"><span class="dashicons dashicons-menu" title="Drag & Drop"></span></td>';
	                OVA_CHECKBOX_ROW_HTML += '</tr>';

	            $(document).on('click', '.ova-wrap-popup-checkout-field .el_lg_add_checkbox', function(e) {
	                var table       = $(this).closest('table');
	                var optionsSize = table.find('tbody tr').size();
	                var height      = $('.ova-wrap-popup-checkout-field').attr('height');

	                if ( height ) {
	                    height = parseInt(height) + 5;
	                } else {
	                    height = 110;
	                }
	                 
	                $('.ova-wrap-popup-checkout-field').attr('height', height);
	                $('.ova-wrap-popup-checkout-field').css('height', height + 'vh');

	                if ( optionsSize > 0 ) {
	                    table.find('tbody tr:last').after(OVA_CHECKBOX_ROW_HTML);
	                } else {
	                    table.find('tbody').append(OVA_CHECKBOX_ROW_HTML);        
	                }
	            });
	             
	            $(document).on('click','.ova-wrap-popup-checkout-field .el_lg_remove_checkbox', function(e) {
	                var table = $(this).closest('table');
	                $(this).closest('tr').remove();
	                var optionsSize = table.find('tbody tr').size();
	                     
	                if (optionsSize == 0) {
	                    table.find('tbody').append(OVA_CHECKBOX_ROW_HTML);
	                }
	            });
	            // End

	            $(document).on('click','.ovalg_edit_field_form', function(e) {
	                var data            = $(this).data('data_edit');
	                var name            = data.name;
	                var type            = data.type ? data.type : 'text';
	                var label           = data.label;
	                var description     = data.description;
	                var placeholder     = data.placeholder;

	                var ova_class       = data.class;
	                var position        = data.position;
	                var max_file_size   = data.max_file_size;
	                var required        = data.required;

	                var ova_options_key     = data.ova_options_key;
	                var ova_options_text    = data.ova_options_text;

	                var ova_radio_key     = data.ova_radio_key;
	                var ova_radio_text    = data.ova_radio_text;

	                var ova_checkbox_key    = data.ova_checkbox_key;
	                var ova_checkbox_text   = data.ova_checkbox_text;

	                // Placeholder

	                if ( type == 'radio' || type == 'checkbox' ) {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'none');
	                } else {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'table-row');
	                }

	                // Select
	                var option_html_edit = '';
	                 
	                if ( type === 'select' ) {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-options table.ova-sub-table tbody').empty();
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-options').css('display', 'table-row');

	                    ova_options_key.forEach(function(item, key) {
	                        option_html_edit += '<tr>';
	                        option_html_edit += '<td><input type="text" name="ova_options_key[]" placeholder="Option Value" value="'+item+'" /></td>';
	                        option_html_edit += '<td><input type="text" name="ova_options_text[]" placeholder="Option Text" value="'+ova_options_text[key]+'" /></td>';
	                        option_html_edit += '<td class="ova-box"><a href="javascript:void(0)"  class="ovalg_addfield btn btn-blue" title="Add new option">+</a></td>';
	                        option_html_edit += '<td class="ova-box"><a href="javascript:void(0)" class="ovalg_remove_row btn btn-red" title="Remove option">x</a></td>';
	                        option_html_edit += '<td class="ova-box sort"><span class="dashicons dashicons-menu" title="Drag & Drop"></span></td>';
	                        option_html_edit += '</tr>';
	                    });

	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-options table.ova-sub-table tbody').append(option_html_edit)
	                } else {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-options').css('display', 'none');
	                }
	                // End
	                
	                // Radio
	                var radio_html_edit = '';
	                 
	                if ( type === 'radio' ) {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-radio table.ova-sub-table tbody').empty();
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-radio').css('display', 'table-row');

	                    ova_radio_key.forEach(function(item, key) {
	                        radio_html_edit += '<tr>';
	                        radio_html_edit += '<td><input type="text" name="ova_radio_key[]" placeholder="Option Value" value="'+item+'" /></td>';
	                        radio_html_edit += '<td><input type="text" name="ova_radio_text[]" placeholder="Option Text" value="'+ova_radio_text[key]+'" /></td>';
	                        radio_html_edit += '<td class="ova-box"><a href="javascript:void(0)" class="el_lg_add_radio btn btn-blue" title="Add new option">+</a></td>';
	                        radio_html_edit += '<td class="ova-box"><a href="javascript:void(0)" class="el_lg_remove_radio btn btn-red" title="Remove option">x</a></td>';
	                        radio_html_edit += '<td class="ova-box sort"><span class="dashicons dashicons-menu" title="Drag & Drop"></span></td>';
	                        radio_html_edit += '</tr>';
	                    });

	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-radio table.ova-sub-table tbody').append(radio_html_edit)
	                } else {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-radio').css('display', 'none');
	                }
	                // End
	                
	                // Checkbox
	                var checkbox_html_edit = '';
	                 
	                if ( type === 'checkbox' ) {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-checkbox table.ova-sub-table tbody').empty();
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-checkbox').css('display', 'table-row');

	                    ova_checkbox_key.forEach(function(item, key) {
	                        checkbox_html_edit += '<tr>';
	                        checkbox_html_edit += '<td><input type="text" name="ova_checkbox_key[]" placeholder="Option Value" value="'+item+'" /></td>';
	                        checkbox_html_edit += '<td><input type="text" name="ova_checkbox_text[]" placeholder="Option Text" value="'+ova_checkbox_text[key]+'" /></td>';
	                        checkbox_html_edit += '<td class="ova-box"><a href="javascript:void(0)" class="el_lg_add_checkbox btn btn-blue" title="Add new option">+</a></td>';
	                        checkbox_html_edit += '<td class="ova-box"><a href="javascript:void(0)" class="el_lg_remove_checkbox btn btn-red" title="Remove option">x</a></td>';
	                        checkbox_html_edit += '<td class="ova-box sort"><span class="dashicons dashicons-menu" title="Drag & Drop"></span></td>';
	                        checkbox_html_edit += '</tr>';
	                    });

	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-checkbox table.ova-sub-table tbody').append(checkbox_html_edit)
	                } else {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-checkbox').css('display', 'none');
	                }
	                // End
	                
	                // File
	                if ( type === 'file' ) {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-type .file-format').css('display', 'inline-block');
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.max-file-size').css('display', 'table-row');
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'none');

	                } else {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-type .file-format').css('display', 'none');
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.max-file-size').css('display', 'none');
	                }
	                // End
	                
	                if ( required == 'on' ) {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-required input[name="required"]').prop('checked');
	                } else {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-required input[name="required"]').prop('checked', false);
	                }

	                $('#ova_popup_field_form input[name="ova_action"]').val('edit');
	                $('#ova_popup_field_form input[name="ova_old_name"]').val(name);
	                $('#ova_popup_field_form input[name="position"]').val(position);
	                $('#ova_type').val(type);
	                $('#ova_popup_field_form .ova-row-name input').val(name);
	                $('#ova_popup_field_form .ova-row-label input').val(label);
	                $('#ova_popup_field_form .ova-row-description textarea').val(description);
	                $('#ova_popup_field_form .ova-row-placeholder input').val(placeholder);

	                $('#ova_popup_field_form .ova-row-class input').val(ova_class);
	                $('#ova_popup_field_form input[name="max_file_size"]').val(max_file_size);
	                $('.ova-wrap-popup-checkout-field').css('display', 'block');
	            });

	            $('#ovaem_openform').on('click', function(e) {
	                var ova_count_field = $(".ova-list-checkout-field").data("field");

	                $('#ova_popup_field_form input[name="ova_action"]').val('new');
	                $('#ova_popup_field_form input[name="ova_old_name"]').val('');
	                $('#ova_popup_field_form input[name="position"]').val(ova_count_field);
	                $('.ova-wrap-popup-checkout-field').css('display', 'block');
	                $('#ova_type').val('text');
	                $('.ova-wrap-popup-checkout-field input[name="name"]').val('');
	                $('.ova-wrap-popup-checkout-field input[name="label"]').val('');
	                $('#ova_popup_field_form .ova-row-description textarea').val('');
	                $('.ova-wrap-popup-checkout-field input[name="placeholder"]').val('');
	                // Remove old option
	                $('.ova-wrap-popup-checkout-field .row-checkbox .el-sortable').html(`
	                    <tr>
	                        <td><input type="text" name="ova_checkbox_key[]" placeholder="Option Value" /></td>
	                        <td><input type="text" name="ova_checkbox_text[]" placeholder="Option Text" /></td>
	                        <td class="ova-box"><a href="javascript:void(0)" class="el_lg_add_checkbox btn btn-blue" title="Add new option">+</a></td>
	                        <td class="ova-box"><a href="javascript:void(0)" class="el_lg_remove_checkbox btn btn-red" title="Remove option">x</a></td>
	                        <td class="ova-box sort">
	                            <span class="dashicons dashicons-menu" title="Drag & Drop"></span>
	                        </td>
	                    </tr>`);
	                $('.ova-wrap-popup-checkout-field .row-radio .el-sortable').html(`
	                    <tr>
	                        <td><input type="text" name="ova_radio_key[]" placeholder="Option Value" /></td>
	                        <td><input type="text" name="ova_radio_text[]" placeholder="Option Text" /></td>
	                        <td class="ova-box"><a href="javascript:void(0)" class="el_lg_add_radio btn btn-blue" title="Add new option">+</a></td>
	                        <td class="ova-box"><a href="javascript:void(0)" class="el_lg_remove_radio btn btn-red" title="Remove option">x</a></td>
	                        <td class="ova-box sort">
	                            <span class="dashicons dashicons-menu" title="Drag & Drop"></span>
	                        </td>
	                    </tr>`);
	                $('.ova-wrap-popup-checkout-field .row-options .el-sortable').html(`
	                    <tr>
	                        <td><input type="text" name="ova_options_key[]" placeholder="Option Value" /></td>
	                        <td><input type="text" name="ova_options_text[]" placeholder="Option Text" /></td>
	                        <td class="ova-box"><a href="javascript:void(0)" class="ovalg_addfield btn btn-blue" title="Add new option">+</a></td>
	                        <td class="ova-box"><a href="javascript:void(0)" class="ovalg_remove_row btn btn-red" title="Remove option">x</a></td>
	                        <td class="ova-box sort">
	                            <span class="dashicons dashicons-menu" title="Drag & Drop"></span>
	                        </td>
	                    </tr>`);

	                $('.ova-wrap-popup-checkout-field input[name="class"]').val('');
	                $('.ova-wrap-popup-checkout-field .row-options').css('display', 'none');
	                $('.ova-wrap-popup-checkout-field .row-radio').css('display', 'none');
	                $('.ova-wrap-popup-checkout-field tr.ova-row-placeholder').css('display', 'table-row');

	                $('.ova-wrap-popup-checkout-field .row-checkbox').css('display', 'none');
	                $('.ova-wrap-popup-checkout-field .ova-row-type .file-format').css('display', 'none');
	                $('.ova-wrap-popup-checkout-field .max-file-size').css('display', 'none');
	            });

	            $('#ovabrw_manage_custom_checkout_field').on('change', function() {
	                $('.ovabrw_product_custom_checkout_field_field').css('display', 'block');

	                if ( $(this).val() == 'all' ) {
	                    $('.ovabrw_product_custom_checkout_field_field').css('display', 'none');
	                }
	            });

	            $('#ova_type').on('change', function() {
	                $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-options').css('display', 'none');
	                $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-radio').css('display', 'none');
	                $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-checkbox').css('display', 'none');
	                $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'table-row');

	                if ( $(this).val() == 'select' ) {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-options').css('display', 'table-row');
	                }

	                if ( $(this).val() == 'radio' ) {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-radio').css('display', 'table-row');
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'none');
	                }

	                if ( $(this).val() == 'checkbox' ) {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.row-checkbox').css('display', 'table-row');
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'none');
	                }

	                // File
	                if ( $(this).val() == 'file' ) {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-type .file-format').css('display', 'inline-block');
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.max-file-size').css('display', 'table-row');
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-placeholder').css('display', 'none');

	                } else {
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.ova-row-type .file-format').css('display', 'none');
	                    $('.ova-wrap-popup-checkout-field .ova-popup-wrapper tr.max-file-size').css('display', 'none');

	                }
	                // End
	            });

	            $('.ova-list-checkout-field #ovabrw_select_all_field').on('click', function(e) {
	                var checkAll = jQuery(this).prop('checked');
	                $( '.ova-list-checkout-field table tbody tr td.ova-checkbox input' ).prop( 'checked', checkAll );
	            });

	            $('#ovaem_close_popup').on('click', function(e) {
	                $('.ova-wrap-popup-checkout-field').css('display', 'none');
	            });

	            $('.ova-list-checkout-field .ova_remove').on('click', function(e) {
	                if ( ! confirm('Are you sure?') ) {
	                    e.preventDefault();
	                }
	            });
	        },
		}
		

		

	$(document).ready(function(){
		OVAEM.init();
		
	});

})(jQuery);