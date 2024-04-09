(function($) {
   "use strict";

   $(window).on('load', function() {
      $(".loader").delay(100).fadeOut();
      $(".animationload").delay(100).fadeOut("fast");
   });


   if (typeof(OVA_em4u) == "undefined") var OVA_em4u = {};

   OVA_em4u.init = function() {
      this.FrontEnd.init();

   }

   /* Metabox */
   OVA_em4u.FrontEnd = {

      init: function() {

         this.mainslider();
         this.heightslider();
         this.bootstrap_select();
         this.blog();
         this.gallery();
         this.event_testimonial();
         this.event_gallery_v1();
         this.BehaviorEmptyLinks();
         this.shrink_header();
         this.onepagemenu();
         this.scrollUp();
         this.menu_mobile();
         this.mobile_header();
         this.ova_countdown_event();
         if (($('.event-google-map').length > 0) && (typeof google !== 'undefined')) {
            this.googlemap();
         }

      },

      blog: function() {

         $('.ova_blog').each(function() {
            var auto_slider = $(this).data('auto_slider');
            var duration = $(this).data('duration');
            var dots = $(this).data('dots');
            var loop = $(this).data('loop');

            $(this).owlCarousel({
               autoplay: auto_slider,
               autoplayHoverPause: true,
               loop: loop,
               margin: 15,
               dots: dots,
               autoplayTimeout: duration,
               navText: [
                  "<i class='fa fa-angle-left'></i>",
                  "<i class='fa fa-angle-right'></i>"
               ],
               responsiveRefreshRate: 100,
               responsive: {
                  0: {
                     items: 1
                  },
                  479: {
                     items: 1
                  },
                  768: {
                     items: 2
                  },
                  991: {
                     items: 2
                  },
                  1024: {
                     items: 3
                  }
               }
            });
         });
      },

      mainslider: function() {

         setTimeout(function() {

            $('.main_slider').each(function() {

               var auto_slider = $(this).data('auto_slider');
               var duration = $(this).data('duration');
               var navigation = $(this).data('navigation');
               var loop = $(this).data('loop');

               $(this).owlCarousel({
                  autoplay: auto_slider,
                  autoplayHoverPause: true,
                  loop: loop,
                  margin: 0,
                  dots: false,
                  autoplayTimeout: duration,
                  nav: navigation,
                  navText: [
                     "<i class='fa fa-angle-left'></i>",
                     "<i class='fa fa-angle-right'></i>"
                  ],
                  responsiveRefreshRate: 100,
                  responsive: {
                     0: {
                        items: 1
                     },
                     479: {
                        items: 1
                     },
                     768: {
                        items: 1
                     },
                     991: {
                        items: 1
                     },
                     1024: {
                        items: 1
                     }
                  }
               });
            });

         }, 500);
      },

      /* Fix full-height for slider */
      heightslider: function() {
         var height_desk = $('.main_slider').data('height_desk');
         var height_ipad = $('.main_slider').data('height_ipad');
         var height_mobile = $('.main_slider').data('height_mobile');

         var padding_top_desk = $('.main_slider').data('padding_top_desk');
         var padding_top_ipad = $('.main_slider').data('padding_top_ipad');
         var padding_top_mobile = $('.main_slider').data('padding_top_mobile');

         var win_w = $(window).width();
         var win_h = $(window).height();



         if (win_w < 768) {


            if (height_mobile == 'full-height') {
               $('.main_slider .item').css('height', win_h + 85);
            } else {
               $('.main_slider .item').css('height', height_mobile);
            }

            $('.main_slider_v1 .item .caption > .container').css('padding-top', padding_top_mobile);

         } else if (win_w >= 768 && win_w <= 991) {

            if (height_ipad == 'full-height') {
               $('.main_slider .item').css('height', win_h + 85);
            } else {
               $('.main_slider .item').css('height', height_ipad);
            }

            $('.main_slider_v1 .item .caption > .container').css('padding-top', padding_top_ipad);

         } else {

            if (height_desk == 'full-height') {
               $('.main_slider .item').css('height', win_h + 85);
            } else {
               $('.main_slider .item').css('height', height_desk);
            }

            $('.main_slider_v1 .item .caption > .container').css('padding-top', padding_top_desk);


         }



         var ismobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
         if (ismobile != false) {
            $(".navbar-collapse").css({
               maxHeight: $(window).height() - $(".navbar-header").height() + "px"
            });
         }
      },

      bootstrap_select: function() {
         $('select.selectpicker').selectpicker();
      },

      gallery: function() {
         if ($("a[data-gal^='prettyPhoto']").length) {
            $("a[data-gal^='prettyPhoto']").prettyPhoto({
               hook: 'data-gal',
               theme: 'facebook',
               slideshow: 5000,
               autoplay_slideshow: true
            });
         }
         if ($("a[data-gal^='gallery_v1']").length) {
            $("a[data-gal^='gallery_v1']").prettyPhoto({
               hook: 'data-gal',
               theme: 'facebook',
               slideshow: 5000,
               autoplay_slideshow: true
            });
         }
         if ($("a[data-gal^='product']").length) {
            $("a[data-gal^='product']").prettyPhoto({
               hook: 'data-gal',
               theme: 'facebook',
               slideshow: 5000,
               autoplay_slideshow: true
            });
         }
      },

      ova_countdown_event: function() {

         $('.ova_countdown_event').each(function() {

            var austDay = new Date();
            var day = $(this).data('day');
            var month = $(this).data('month');
            var year = $(this).data('year');
            var hour = $(this).data('hour');
            var minute = $(this).data('minute');
            var timezone = $(this).data('timezone');

            austDay = new Date(year, month - 1, day, hour, minute);

            $(this).countdown({
               until: austDay,
               timezone: timezone
            });


         });
      },

      event_testimonial: function() {

         $('.event_testimonial').each(function() {

            var auto_slider = $(this).data('auto_slider');
            var duration = $(this).data('duration');
            var pagination = $(this).data('pagination');
            var loop = $(this).data('loop');
            var count = $(this).data('count');

            $(this).owlCarousel({
               autoplay: auto_slider,
               autoplayHoverPause: true,
               loop: loop,
               margin: 30,
               dots: pagination,
               autoplayTimeout: duration,
               responsiveRefreshRate: 100,
               responsive: {
                  0: {
                     items: 1
                  },
                  479: {
                     items: 1
                  },
                  768: {
                     items: 1
                  },
                  991: {
                     items: count
                  },
                  1024: {
                     items: count
                  }
               }
            });
         });
      },

      event_gallery_v1: function() {
         $('.event_gallery_v1').each(function() {

            var auto_slider = $(this).data('auto_slider');
            var duration = $(this).data('duration');
            var pagination = $(this).data('pagination');
            var navigation = $(this).data('navigation');
            var loop = $(this).data('loop');
            var count = $(this).data('count');

            $(this).owlCarousel({
               autoplay: auto_slider,
               autoplayHoverPause: true,
               loop: loop,
               margin: 30,
               dots: pagination,
               nav: navigation,
               navText: [
                  "<i class='fa fa-angle-left'></i>",
                  "<i class='fa fa-angle-right'></i>"
               ],
               autoplayTimeout: duration,
               responsiveRefreshRate: 100,
               responsive: {
                  0: {
                     items: 1
                  },
                  479: {
                     items: 1
                  },
                  768: {
                     items: 1
                  },
                  991: {
                     items: count
                  },
                  1024: {
                     items: count
                  }
               }
            });
         });
      },

      refresh: function() {
         var header = $('header.ova_header');
         var scroll = $(window).scrollTop();
         if (header.hasClass('fixed')) {

            if (scroll >= 80) {
               header.addClass('shrink');
            } else if (scroll == 0) {
               header.removeClass('shrink');
            }
         }
      },
      
      shrink_header: function() {
         $(window).load(function() {
            OVA_em4u.FrontEnd.refresh();
         });
         $(window).scroll(function() {
            OVA_em4u.FrontEnd.refresh();
         });
         $(window).on('touchstart', function() {
            OVA_em4u.FrontEnd.refresh();
         });
         $(window).on('scrollstart', function() {
            OVA_em4u.FrontEnd.refresh();
         });
         $(window).on('scrollstop', function() {
            OVA_em4u.FrontEnd.refresh();
         });
         $(window).on('touchmove', function() {
            OVA_em4u.FrontEnd.refresh();
         });
      },

      /* Onepgae menu */
      onepagemenu: function() {
         $('.ova_header #menu-landing-menu').onePageNav({
            currentClass: 'ova_current',
            changeHash: true,
            begin: function() {
               $('.ova_current').each(function() {
                  $(this).removeClass('ova_current');
               });
            },
            end: function() {
               $(this).addClass('ova_current');
            }

         });

         $('body').onePageNav({
            currentClass: 'ova_current',
            changeHash: true,
            filter: '.scroll',

            begin: function() {
               $('.ova_current').each(function() {
                  $(this).removeClass('ova_current');
               });
            },
            end: function() {
               $(this).addClass('ova_current');
            }
         });
      },

      BehaviorEmptyLinks: function() {
         $('a[href="#"]').on('click', function(event) {
            event.preventDefault();
         });
      },

      /*----------------------------------------------------*/
      /* ScrollUp
       /*----------------------------------------------------*/
      scrollUp: function(options) {

         var defaults = {
            scrollName: 'scrollUp',
            topDistance: 600,
            topSpeed: 800,
            animation: 'fade',
            animationInSpeed: 200,
            animationOutSpeed: 200,
            scrollText: '<i class="arrow_carrot-up"></i>',
            scrollImg: false,
            activeOverlay: false
         };

         var o = $.extend({}, defaults, options),
            scrollId = '#' + o.scrollName;


         $('<a/>', {
            id: o.scrollName,
            href: '#top',
            title: o.scrollText
         }).appendTo('body');


         if (!o.scrollImg) {

            $(scrollId).html(o.scrollText);
         }


         $(scrollId).css({
            'display': 'none',
            'position': 'fixed',
            'z-index': '2147483647'
         });


         if (o.activeOverlay) {
            $("body").append("<div id='" + o.scrollName + "-active'></div>");
            $(scrollId + "-active").css({
               'position': 'absolute',
               'top': o.topDistance + 'px',
               'width': '100%',
               'border-top': '1px dotted ' + o.activeOverlay,
               'z-index': '2147483647'
            });
         }


         $(window).scroll(function() {
            switch (o.animation) {
               case "fade":
                  $(($(window).scrollTop() > o.topDistance) ? $(scrollId).fadeIn(o.animationInSpeed) : $(scrollId).fadeOut(o.animationOutSpeed));
                  break;
               case "slide":
                  $(($(window).scrollTop() > o.topDistance) ? $(scrollId).slideDown(o.animationInSpeed) : $(scrollId).slideUp(o.animationOutSpeed));
                  break;
               default:
                  $(($(window).scrollTop() > o.topDistance) ? $(scrollId).show(0) : $(scrollId).hide(0));
            }
         });


         $(scrollId).click(function(event) {
            $('html, body').animate({
               scrollTop: 0
            }, o.topSpeed);
            event.preventDefault();
         });
      },

      googlemap: function() {

         $('.event-google-map').each(function() {

            var idmap = $(this).data('idmap');
            var zoom = $(this).data('zoom');
            var icon = $(this).data('icon');
            var title = $(this).data('title').split("|");
            var location = $(this).data('location').split("|");

            var location_obj = [];
            var title_obj = [];

            for (var i = 0; i < location.length; i++) {
               location_obj[i] = location[i].replace(" ", "");
            }

            for (var k = 0; k < title.length; k++) {
               title_obj[k] = "<span class='title_marker'>" + title[k] + '</div>';
            }



            function initialize() {
               var map;
               var bounds = new google.maps.LatLngBounds();
               var mapOptions = {
                  mapTypeId: 'roadmap',
                  scrollwheel: false
               };

               /* Display a map on the page */
               map = new google.maps.Map(document.getElementById(idmap), mapOptions);
               map.setTilt(45);

               /* Display multiple markers on a map */
               var infoWindow = new google.maps.InfoWindow(),
                  marker, i;

               /* Loop through our array of markers & place each one on the map */
               for (var d = 0; d < location_obj.length; d++) {
                  var localtion_lg = location_obj[d].split(",");
                  var position = new google.maps.LatLng(localtion_lg[0], localtion_lg[1]);
                  bounds.extend(position);
                  marker = new google.maps.Marker({
                     position: position,
                     map: map,
                     icon: icon
                  });

                  /* Allow each marker to have an info window */
                  google.maps.event.addListener(marker, 'click', (function(marker, d) {
                     return function() {
                        infoWindow.setContent(title_obj[d]);
                        infoWindow.open(map, marker);
                     }
                  })(marker, d));

                  /* Automatically center the map fitting all markers on the screen */
                  map.fitBounds(bounds);
               }

               /* Override our map zoom level once our fitBounds function runs (Make sure it only runs once) */
               var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                  this.setZoom(zoom);
                  google.maps.event.removeListener(boundsListener);
               });

            }

            google.maps.event.addDomListener(window, "load", initialize);


         });
      },

      menu_mobile: function() {
         $('ul.nav button.dropdown-toggle').on('click', function() {
            $(this).parent().toggleClass('active_sub');
         });
      },

      mobile_header: function() {
         var window_w = $(window).width();
         if (window_w < 992) {
            var ova_logo_h = $('header .ova-logo').height();
            $('header .ova-menu button.navbar-toggle').css('margin-top', ova_logo_h / 2 - 17);
            $('header.ovatheme_header_v1 .ova-menu .ova-account ').css('margin-top', ova_logo_h / 2 - 20);
            $('header.ovatheme_header_v2 .ova-menu .ova-account ').css('margin-top', ova_logo_h / 2 - 20);

         } else {
            $('header .ova-menu button.navbar-toggle').css('margin-top', '0');
            $('header.ovatheme_header_v1 .ova-menu .ova-account ').css('margin-top', '0');
            $('header.ovatheme_header_v2 .ova-menu .ova-account ').css('margin-top', '0');

         }
      }



   }


   $(document).ready(function() {
      OVA_em4u.init();
   });


   $(window).resize(function() {
      OVA_em4u.FrontEnd.heightslider();
      OVA_em4u.FrontEnd.refresh();
      OVA_em4u.FrontEnd.mobile_header();
   });

})(jQuery);