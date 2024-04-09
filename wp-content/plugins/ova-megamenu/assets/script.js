(function($){
    "use strict";

        if (typeof(OVA_MegaMenu) == "undefined")  var OVA_MegaMenu = {}; 

        OVA_MegaMenu.init = function(){
                this.FrontEnd.init();

        }
        
        /* Metabox */
        OVA_MegaMenu.FrontEnd = {

            init: function(){
                this.megamenu();

                
            },

            megamenu: function(){

                $('body').append( '<div class="container container_default"></div>');
                
                var w_container = $('.container_default').width();

                $('ul.ova-mega-menu').each(function() {

                    var megamenu_w = $(this).width();

                    $(this).css('width', w_container);
                    $(this).css({ "right":"0", "left":"0" });

                    

                });

            }
            
            

        }

        

    $(document).ready(function(){
        OVA_MegaMenu.init();
        
    });
    $(window).resize(function(){
        OVA_MegaMenu.FrontEnd.megamenu();
        
    });

})(jQuery);




