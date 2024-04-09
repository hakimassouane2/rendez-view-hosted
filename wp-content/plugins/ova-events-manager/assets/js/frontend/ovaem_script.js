(function($){
	"use strict";

   if (typeof(OVAEM) == "undefined")  var OVAEM = {}; 

   OVAEM.init = function(){
      this.FrontEnd.init();

   }

   /* Metabox */
   OVAEM.FrontEnd = {

      init: function(){
         this.slideshow();
         if( $('#ovaem_map').length &&  ( typeof google !== 'undefined' )  ){
            this.map();	
         }

         this.datepicker();
         this.register_event();
         this.ovaem_datetime_submit();
         this.ovaem_frontend_submit();
         this.ovaem_isotope();
         this.gallery_modern();
         this.slider_carouse();
         this.venue_slider();
         this.related_events();
         this.speaker_joined_event();
         this.ovaem_simple_event_info();
         this.ovaem_slider_events_two();
         this.toggle_mobile_filter();
         this.active_event_tab();
         this.payment_info();
         this.event_calendar();
         this.active_price_tab();
         this.share_toggle();
         this.schedule_tab();
         this.ovaem_events_filter_ajax();
         this.download_ticket();
         this.pagination_manage_booking();
         this.ovaem_custom_faq();
         this.ovaem_recapcha_validate();
         this.ovaem_checkout_woo();

         if( $('#events_map').length  && ( typeof google !== 'undefined' )  ){
            this.events_map();
         }
      },

      event_calendar: function(){

         $('.event_calendar').each(function(){
            var data_js     = $(this).data('listevent');
            var local       = $(this).data('local');
            var time_zone   = $(this).data('time_zone');
            var first_day   = $(this).data('first-day');
            var headerLeft  = $(this).data('header-left');
            var headerCenter = $(this).data('header-center');
            var headerRight = $(this).data('header-right');
            var events      = window[data_js];

            $(this).fullCalendar({
               header: {
                  left: headerLeft,
                  center: headerCenter,
                  right: headerRight,
               },
               navLinks: true,
               eventLimit: true,
               editable: true,
               locale: local,
               timezone: time_zone,
               firstDay: first_day,
               default:false,
               events: events
            });
         });
      },

      slideshow: function(){
         if( $(".ovaem-slideshow.carousel").length > 0 ){
            $(".ovaem-slideshow.carousel").each(function(){
               var interval = $(this).data('interval');
               $(this).carousel({
                  interval: interval,
                  pause: 'hover'
               });		
            })

         }
      },

      map:function(){

         function initialize() {
            var lat = parseFloat( $("#ovaem_map").data('lat') );
            var lng = parseFloat( $("#ovaem_map").data('lng') );
            var address = $("#ovaem_map").data('address');
            var zoom = parseInt( $("#ovaem_map").data('zoom') );

            var infoWindow = new google.maps.InfoWindow();

            var loc = {lat: lat, lng: lng};

            var map = new google.maps.Map(document.getElementById('ovaem_map'), {
               zoom: zoom,
               center: loc,
               scrollwheel: false 
            });

            var marker = new google.maps.Marker({
               position: loc,
               map: map
            });	

            google.maps.event.addListener(marker, 'click', (function(marker) {
               return function() {
                  infoWindow.setContent(address);
                  infoWindow.open(map, marker);
               }
            })(marker));

         }
         if( typeof google !== 'undefined' ){
            //google.maps.event.addDomListener(window, "load", initialize);
            window.addEventListener('load', initialize)
         }
      },

      datepicker: function(){


         $('.ovaem_select_date').each(function(){

            var lang = $(this).data('lang');
            var firstDay = $(this).data('first-day');
            $.datetimepicker.setLocale(lang);

            var date_format = $(this).data('date_format');

            $(this).datetimepicker({
               timepicker:false,
               format: date_format,
               dayOfWeekStart: firstDay,
               scrollMonth : false,
               scrollInput : false,
               onChangeDateTime:function(dp,$input){
                  $('.select_alltime').val(" ");
                  var $option_default = $('.select_alltime option').first().html();
                  $('.select_alltime span.filter-option').html($option_default);
               }
            });

         });

         $('.select_alltime').on('change', function(){
            $('.ovaem_date #from').val("");
            $('.ovaem_date #to').val("");
         });
      },

      register_event: function(){

         $(document).on( 'click', '#register_free_event_btn', function(e){

            $("#ova_register_event").validate();
            $(this).attr('disabled', true);
            $(this).css('opacity','0.3');
            var isFormValid      = jQuery("#ova_register_event").valid();
            
            $('#ova_register_event input[type="tel"]').each( function(i,el){
               $(el).rules('add',{
                  digits: true,
               });
            } );

            if ( $(this).closest('form').find('.ovaem-recaptcha-wrapper').length ) {
               var recapcha = $(this).closest('form').find('.ovaem-recaptcha-wrapper');
               if ( ! recapcha.hasClass('checked') ) {
                  let mess = '';
                  mess = recapcha.data('mess');
                  if ( mess ) {
                     alert(mess);
                  }
                  $(this).attr('disabled', false);
                  $(this).css('opacity','1');
                  return false;
                  e.preventDefault();
               }
            }
            if ( isFormValid ) {
                $("#ova_register_event").submit();
            } else {
               $(this).attr('disabled', false);
               $(this).css('opacity','1');
               return false;
               e.preventDefault();
            }

         });
         
      },

      ovaem_frontend_submit:function(){
         $('#ovaem_frontend_submit').validate();
      },

      ovaem_datetime_submit: function(){
         $('.ovaem_datetime_submit').each(function(){
            var date_format = $(this).data('date_format');
            var time_format = $(this).data('time_format');
            $(this).datetimepicker({
               format: date_format+' '+time_format,
               scrollMonth : false,
               scrollInput : false
            });
         });
      },

      ovaem_isotope: function(){

         if ($().isotope) {

            var tab_active = $('.ovaem_events_filter_nav').data('tab_active');
            if( $('.ovaem_events_filter ').data('order') == 'ASC' ){
               var sortAscending =  true;
            }else{
               var sortAscending = false;
            }


            if(tab_active != ''){
               var $ova_iso = $('.ovaem_events_filter_content').isotope({
                  filter: '.'+tab_active,
                  itemSelector: '.isotope-item',
                  layoutMode: 'fitRows',
                  getSortData: {
                     number: '.number parseInt'
                  },
                  sortBy: [ 'number' ],
                  sortAscending: sortAscending

               });
            }else{
               var $ova_iso =  $('.ovaem_events_filter_content').isotope({
                  itemSelector: '.isotope-item',
                  layoutMode: 'fitRows',
                  getSortData: {
                     number: '.number parseInt'
                  },
                  sortBy: [ 'number' ],
                  sortAscending: sortAscending
               });
            }

            $('.ovaem_events_filter_nav a').click(function () {
               var selector = $(this).attr('data-filter');
               $('.ovaem_events_filter_nav a').parent().removeClass('current');
               $(this).parent().addClass('current');
               var $ova_iso =  $('.ovaem_events_filter_content').isotope({filter: selector, layoutMode: 'fitRows', getSortData: { number: '.number parseInt' }});

               return false;
            });
            $ova_iso.isotope();
            $(window).on('resize', function(){
               $ova_iso.isotope();
            });


         }
      },

      slider_carouse: function(){ 
         $('.ovaem-slider-events').each(function(){

            var number_item_slide = parseInt( $(this).data( 'number_item_slide' ) );

            var that = $(this);

            var slider_event = $(this).slick({
               centerMode: true,
               centerPadding: '60px',
               slidesToShow: number_item_slide,
               arrows: false,
               nextArrow: '<button type="button" class="slick-next"><i class="arrow_carrot-right"></i></button>',
               prevArrow: '<button type="button" class="slick-prev"><i class="arrow_carrot-left"></i></button>',
               responsive: [
               {
                  breakpoint: 991,
                  settings: {
                     arrows: false,
                     centerMode: true,
                     centerPadding: '40px',
                     slidesToShow: 3
                  }
               },
               {
                  breakpoint: 768,
                  settings: {
                     arrows: false,
                     centerMode: true,
                     centerPadding: '40px',
                     slidesToShow: 1
                  }
               },
               {
                  breakpoint: 480,
                  settings: {
                     arrows: false,
                     centerMode: true,
                     centerPadding: '40px',
                     slidesToShow: 1
                  }
               }
               ]
            });

            $('.ova-slick-next').on('click', function(event){
               var count = $(this).data('count');

               that.each(function(){
                  if( $(this).hasClass( count ) ){
                     var current_index = $(this).slick( 'slickCurrentSlide' );
                     $(this).slick('slickGoTo', current_index + 1);
                  }
               });
               


            });
            $('.ova-slick-prev').on('click', function(){
               var count = $(this).data('count');
               that.each(function(){
                  if( $(this).hasClass( count ) ){
                     var current_index = $(this).slick( 'slickCurrentSlide' );
                     $(this).slick('slickGoTo', current_index - 1);
                  }
               });
               

            });


         });
      },

      venue_slider: function(){
         $('.carousel_venues_slider').owlCarousel({
            autoplay: true,
            loop: true,
            margin: 30,
            nav: false,
            dots: true,
            center: false,
            items: 2,
            responsive:{
               0:{
                  items:1
               },
               600:{
                  items:2
               },
               1000:{
                  items:2
               }
            }
         });
      },

      related_events: function(){
         $('.related_events').owlCarousel({
            autoplay: true,
            loop: true,
            margin: 30,
            nav: false,
            dots: true,
            items: 3,
            center: true,
            lazyLoad:true,
            responsive:{
               0:{
                  items:1
               },
               600:{
                  items:2
               },
               1000:{
                  items:3
               }
            }
         });
      },

      gallery_modern: function(){
         $('.gallery_modern').owlCarousel({
            autoplay: true,
            loop: true,
            margin: 0,
            nav: false,
            dots: false,
            center: true,
            items: 3,
            lazyLoad:true,
            responsive:{
               0:{
                  items:1
               },
               600:{
                  items:2
               },
               1000:{
                  items: 3
               }
            }
         });
      },

      speaker_joined_event: function(){
         $('.speaker_joined_event').owlCarousel({
            autoplay: true,
            loop: false,
            margin: 30,
            nav: false,
            dots: true,
            items: 3,
            responsive:{
               0:{
                  items:1
               },
               600:{
                  items:2
               },
               1000:{
                  items:3
               }
            }
         });
      },

      ovaem_simple_event_info: function(){
         $('.ovaem_simple_event_info').owlCarousel({
            autoplay: true,
            loop: false,
            margin: 30,
            nav: true,
            dots: false,
            items: 4,
            navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>'],
            responsive:{
               0:{
                  items:1
               },
               600:{
                  items:2
               },
               1000:{
                  items:3
               },
               1200:{
                  items:4
               }
            }
         });
      },

      ovaem_slider_events_two: function(){

         setTimeout(function(){
         
            $('.ovaem_slider_events_two').owlCarousel({
               
               autoplay: true,
               loop: true,
               margin: 30,
               nav: true,
               dots: false,
               items: 1,
               navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>'],
               responsive:{
                  0:{
                     items:1
                  },
                  600:{
                     items:1
                  },
                  1000:{
                     items:1
                  },
                  1200:{
                     items:1
                  }
               }

            });

         },   500)

         
      },

      share_toggle:function(){
         if( $('.ova_share .share').length >0 ){
            var flip = 0;
            $('.ova_share .share').off().on('click', function(){

               $( ".ova_share .social" ).toggle( flip++ % 2 === 0 );
            });
         }

         if( $('.ova_share .my_calendar').length >0 ){
            var flipx = 0;
            $('.ova_share .my_calendar').off().on('click', function(){

               $( ".ova_share .event-calendar-sync" ).toggle( flipx++ % 2 === 0 );
            });	
         }
      },

      toggle_mobile_filter:function(){


         $('.select_cat_mobile_btn .btn_filter').on('click', function(){
            $(this).parent().find('.ovaem_events_filter_nav').toggle( "medium" );
         });

         var win_w = $(window).width();
         if( win_w <= 767 ){
            $('.ovaem_events_filter_nav li a').on('click', function(){
               $(this).parent().parent().hide();
            });	
         }
      },

      active_event_tab:function(){
         if( $('.ova_single_event').length > 0 ){
            $('.ova_single_event .tab_content ul.nav li').first().addClass( 'active' );
            $('.ova_single_event .tab_content .tab-content .tab-pane').first().addClass( 'in active' );

         }
      },

      payment_info: function(){
         $( '.ovaem_checkout_page .method_payment .info' ).hide();
         $( '.ovaem_checkout_page .method_payment input:checked' ).parent().find('.info').show('slow');

         $( '.ovaem_checkout_page .method_payment input[type="radio"]' ).on( 'click', function(){
            $( '.ovaem_checkout_page .method_payment input' ).parent().find( '.info' ).hide('slow');
            $(this).parent().find('.info').show('slow');
         });
      },

      active_price_tab:function(){
         $( '.wrap_btn_book' ).not('.external_link').on( 'click', function(e){
            var $tab_active = $(this).attr('data-tab-active');

            $( '.ova_single_event .wrap_nav ul.nav li' ).removeClass( 'active' );
            $( `.ova_single_event .wrap_nav ul.nav li.${$tab_active}` ).addClass( 'active' );

            $( '.ova_single_event .tab-content .tab-pane' ).removeClass( 'active' );
            $( '.ova_single_event .tab-content .tab-pane' ).removeClass( 'in' );
            $( `.ova_single_event .tab-content #${$tab_active}` ).addClass( 'active in' );

            e.preventDefault();
            if ( $tab_active == 'schedule' ) {
               $(document).find( '#event_tab #schedule ul.nav li' ).removeClass( ' active ' );
               $(document).find( '#event_tab #schedule ul.nav li:first' ).addClass( ' active ' );

               $(document).find( '#event_tab #schedule .tab-content .tab-pane' ).removeClass( ' in active ' );
               $(document).find( '#event_tab #schedule #tab_0_event' ).addClass( ' in active ' );
            }

            goToByScroll('event_tab');

         });
      },

      schedule_tab: function(){
         $( '#event_tab ul li a[href="#schedule"]' ).on( 'click', function(e){
            $(this).closest( '#event_tab' ).find( '#schedule' ).addClass(' in active ');

            $(this).closest( '#event_tab' ).find( '#schedule ul.nav li' ).removeClass( ' active ' );
            $(this).closest( '#event_tab' ).find( '#schedule ul.nav li:first' ).addClass( ' active ' );

            $(this).closest( '#event_tab' ).find( '#schedule .tab-content .tab-pane' ).removeClass( ' in active ' );
            $(this).closest( '#event_tab' ).find( '#schedule #tab_0_event' ).addClass( ' in active ' );

         });
      },

      events_map: function(){

         if( typeof events_map != 'undefined' ){
            var map;
            var i = 0;
            var zoom_map = 14;
            var readmore_text = '';
            var icon1, icon2, icon3, icon4, icon5;

            if( typeof attr_map != 'undefined' ){
               
               var attr_map_val = attr_map;

               zoom_map = attr_map_val['zoom_map'];
               readmore_text = attr_map_val['readmore_text'];
               icon1 = attr_map_val['icon1'];
               icon2 = attr_map_val['icon2'];
               icon3 = attr_map_val['icon3'];
               icon4 = attr_map_val['icon4'];
               icon5 = attr_map_val['icon5'];
            }


            var marker, loc, Clusterer;
            var markers = [];
            var mapIWcontent = '';

		   	// Get Data Vehicle
            var obj_vehicles = events_map;



            var bounds = new google.maps.LatLngBounds();
            var mapOptionsFirst = {
               zoom: parseInt(zoom_map),
               minZoom: 3,
               center: new google.maps.LatLng(parseFloat(obj_vehicles[0]['lat']), parseFloat(obj_vehicles[0]['lon']) ),
               mapTypeId: google.maps.MapTypeId.ROADMAP,

               styles: [],
               scrollwheel: false,
            };

            var mapObject = new google.maps.Map(document.getElementById('events_map'), mapOptionsFirst);

            google.maps.event.addListener(mapObject, 'domready', function () {

            });
            google.maps.event.addListener(mapObject, 'click', function () {
               closeInfoBox();
            });


            var contentString = '' + '' +
            '<div class="iw-container"' +
            '<div class="iw-content">' +
            '' + mapIWcontent +
            '</div>' +
            '</div>' +
            '' +
            '';

            var infowindow = new google.maps.InfoWindow({
               content: mapIWcontent,
               maxWidth: 300
            });


            var oms = new OverlappingMarkerSpiderfier(mapObject, { 
              markersWontMove: true,   // we promise not to move any markers, allowing optimizations
              markersWontHide: true,   // we promise not to change visibility of any markers, allowing optimizations
              basicFormatEvents: true  // allow the library to skip calculating advanced formatting information
            });


            obj_vehicles.forEach(function (item) {

               marker = new google.maps.Marker({
                  position: new google.maps.LatLng(item.lat, item.lon),
                  map: mapObject
		                    // icon: item.fa_icon //,
               });
               loc = new google.maps.LatLng(item.lat, item.lon);
               bounds.extend(loc);

               if ('undefined' === typeof markers[i]) markers[i] = [];
               markers[i].push(marker);
               i++;



               google.maps.event.addListener(marker, 'spider_click', (function () {

                  closeInfoBox();
                  var mapIWcontent = '' +
                  '' +
                  '<div class="map-info-window">' +

                  '<img style="max-width: 280px; width: 280px;" src="' + item.img + '" alt=""/>' +

                  '<h2 class="caption-title"><a href="' +
                  item.url + '">' + item.title + '</a></h2>' +

                  '<div class="time"><i class="flaticon-alarm-clock"></i>' +
                  item.time+
                  '</div>' +

                  '<div class="address"><i class="flaticon-map-location"></i>' +
                  item.address +
                  '</div>' +







                  '<div style="border-top-width: 24px; position: absolute; ; margin-top: 0px; z-index: 0; left: 129px;"><div style="position: absolute; overflow: hidden; left: -6px; top: -1px; width: 16px; height: 30px;"><div style="position: absolute; left: 6px; transform: skewX(22.6deg); transform-origin: 0px 0px 0px; height: 24px; width: 10px; box-shadow: rgba(255, 255, 255, 0.0980392) 0px 1px 6px; z-index: 1; background-color: rgb(255, 255, 255);"></div></div><div style="position: absolute; overflow: hidden; top: -1px; left: 10px; width: 16px; height: 30px;"><div style="position: absolute; left: 0px; transform: skewX(-22.6deg); transform-origin: 10px 0px 0px; height: 24px; width: 10px; box-shadow: rgba(255, 255, 255, 0.0980392) 0px 1px 6px; z-index: 1; background-color: rgb(255, 255, 255);"></div></div></div>' +

                  '</div>' +

                  '';
                  var contentString = '' +
                  '' +
                  '<div class="iw-container">' +
                  '<div class="iw-content">' +
                  '' + mapIWcontent +
                  '</div>' +
                  '<div class="iw-bottom-gradient"></div>' +
                  '</div>' +
                  '' +
                  '';
                  infowindow.close();
                  infowindow = new google.maps.InfoWindow({
                     content: mapIWcontent,
                     title: item.title
                     , maxWidth: 300
                     , maxHeight: 300
                  });
                  infowindow.close();
                  infowindow.open(map, this);

               }));

               oms.addMarker(marker);

            });



	        		//options
            var mcOptions = {
               gridSize: 20,
               maxZoom: 20,
               styles: [{
                  height: 53,
                  url:icon1,
                  width: 52
               }, {
                  height: 56,
                  url:icon2,
                  width: 55
               }, {
                  height: 66,
                  url:icon3,
                  width: 65
               }, {
                  height: 78,
                  url:icon4,
                  width: 77
               }
               , {
                  height: 90,
                  url:icon5,
                  width: 89
               }
               ]

            };


				    // New markerCluster
            Clusterer = new MarkerClusterer(mapObject, [], mcOptions);

            for (var key in markers){
			            //add  markers to Clusterer
			            // obj_vehicles.forEach(function (item) {
               Clusterer.addMarkers(markers[key], true);
			        	// });
            }
         }
      },

      ovaem_events_filter_ajax: function(){
         $('.ovaem_events_filter_ajax .ovaem_events_filter_nav a.ova-btn').on('click', function(e){
            e.preventDefault();
            var that = $(this);

            that.parents('.ovaem_events_filter_nav').find('li').removeClass('current');
            that.parent().addClass('current');

            var category = that.data('filter');
            var data_event = that.parents('.ovaem_events_filter_ajax').find('.ovaem_events_filter_content').data('event');

            var h_filter = that.parents('.ovaem_events_filter_ajax').find('.events_filter_show_nav').height();

            that.parents('.ovaem_events_filter_ajax').find('.wrap_loader').fadeIn(500);
            that.parents('.ovaem_events_filter_ajax').find('.wrap_loader').css({
               'top': h_filter+'px',
               'height': 'calc(100% - '+h_filter+'px)'
            });;
            that.parents('.ovaem_events_filter_ajax').find('.loader').fadeIn(500);

            $.post( ajax_object.ajax_url, {
               action: 'events_filter_category',
               data: {
                  category: category,
                  data_event: data_event,

               },
            },function(response){
               that.parents('.ovaem_events_filter_ajax').find('.wrap_loader').fadeOut(0);
               that.parents('.ovaem_events_filter_ajax').find('.loader').fadeOut(0);
               that.parents('.ovaem_events_filter_ajax').find('.ovaem_events_filter_content').html(response).fadeOut(0).fadeIn(500);
            });
         });
      },

      download_ticket: function() {
         $(document).on('click', '.download-ticket', function(e) {
            e.preventDefault();
            var booking_id = $(this).attr("data-booking_id");
            var ovaem_download_ticket_nonce = $(this).attr('data-nonce');

            $(this).siblings(".submit-load-more.dowload-ticket").css({"z-index":"1"});
            $.ajax({
               url: ajax_object.ajax_url,
               type: 'POST',
               data: {
                  action: 'download_ticket',
                  ovaem_download_ticket_nonce: ovaem_download_ticket_nonce,
                  booking_id: booking_id,
               },
               success:function(response) {
                  if( !response ){
                     alert( 'error' );
                  }else{
                     var data_url = JSON.parse(response);

                     data_url.map(function(item) {
                        var link = document.createElement('a');
                        link.href = item;
                        let name_ticket = item.slice(item.lastIndexOf("/") + 1);

                        link.download = name_ticket;
                        link.dispatchEvent(new MouseEvent('click'));
                        $(".submit-load-more.dowload-ticket").css({"z-index":"-1"});
                     })

                     /* delete file */
                     $.ajax({
                        url: ajax_object.ajax_url,
                        type: 'POST',
                        data: {
                           action: 'unlink_download_ticket',
                           data_url: data_url,
                        },
                        success:function(response) {

                        },
                     })
                  }

               },
            })

         });
      },

      pagination_manage_booking: function() {
         $(document).on('click', '.ovaem-bookings .ovaem_pagination li a.page-numbers', function(e) {
            e.preventDefault();
            var that = $(this);

            var paged = that.attr('data-paged');

            that.parents('.ovaem-bookings').find('.wrap_loader').fadeIn(500);
            that.parents('.ovaem-bookings').find('.loader').fadeIn(500);

            $.post( ajax_object.ajax_url, {
               action: 'pagination_manage_booking',
               data: {
                  paged: paged,
               },
            },function(response){
               that.parents('.ovaem-bookings').find('.wrap_loader').fadeOut(0);
               that.parents('.ovaem-bookings').find('.loader').fadeOut(0);
               that.parents('.ovaem-bookings').html(response).fadeOut(0).fadeIn(500);
            });
         });
      },
      ovaem_custom_faq: function(){
         $('#event_faq .faqs .item .faq_title').each(function(i,el){
            $(el).on('click',function(){
               if ( $(el).find('i').hasClass('fa-plus') ) {
                  $(el).find('i').removeClass('fa-plus').addClass('fa-minus');
               } else {
                  $(el).find('i').removeClass('fa-minus').addClass('fa-plus');
               }
            });
         });
      },
      ovaem_recapcha_validate: function(){

         if ( $(document).find('.ovaem-recaptcha-wrapper').length ) {
            var recapcha   = $(document).find('.ovaem-recaptcha-wrapper');
            var form       = recapcha.closest('form');
            form.on('submit',function(e){
               if ( recapcha.hasClass('checked') ) {
                  return true;
               } else {
                  let mess = recapcha.data('mess');
                  if ( mess ) {
                     alert( mess );
                  }
                  return false;
               }
            });
         }
      },
      ovaem_checkout_woo: function(){
         $('.ova-select2 .select').select2();
      },
   }

   function closeInfoBox() {
      $('div.infoBox').remove();
   };

   function goToByScroll(id) {

      id = id.replace("link", "");

      $('html,body').animate({
         scrollTop: $("#" + id).offset().top-150
      }, 'slow');
   }






   $(window).load(function(){
      OVAEM.FrontEnd.ovaem_isotope();
   });

   $(document).ready(function(){
      OVAEM.init();
   });

   $(window).on('resize', function () {

      var win_w = $(window).width();
      if( win_w > 767 ){
         $('.ovaem_events_filter_nav').show();
         $('.ovaem_events_filter_nav li a').on('click', function(){
            $(this).parent().parent().show();
         });
      }else{
         $('.ovaem_events_filter_nav').hide();
         $('.ovaem_events_filter_nav li a').on('click', function(){
            $(this).parent().parent().hide();
         });
      }

   });

})(jQuery);