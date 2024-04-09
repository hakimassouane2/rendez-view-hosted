(function($) {

   'use strict';

   $(document).ready(function() {


      if (typeof Stripe !== 'undefined') {
         if (document.getElementById("card-element")) {

            var pubkey = stripe_pub_key.pub_key;
            var stripe = Stripe(pubkey);
            var elements = stripe.elements();

            /* Custom styling can be passed to options when creating an Element. */
            var style = {
               base: {
                  /* Add your base input styles here. For example: */
                  fontSize: '16px',
                  color: "#32325d",
               }
            };

            /* Create an instance of the card Element */
            var card = elements.create('card', {
               style: style
            });

            /* Add an instance of the card Element into the `card-element` <div> */
            card.mount('#card-element');

            card.addEventListener('change', function(event) {
               var displayError = document.getElementById('card-errors');
               if (event.error) {
                  displayError.textContent = event.error.message;
               } else {
                  displayError.textContent = '';
               }
            });


            /* Create a token or display an error when the form is submitted. */
            var form = document.getElementById('ova_register_paid_event');
            form.addEventListener('submit', function(event) {
               event.preventDefault();


               var validator = $("#ova_register_paid_event").validate();
               if (validator.form()) {
                  stripe.createToken(card).then(function(result) {
                     if (result.error) {
                        /* Inform the customer that there was an error*/
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                     } else {
                        /* Send the token to your server*/
                        stripeTokenHandler(result.token);
                     }
                  });
               }


            });


            function stripeTokenHandler(token) {

               /* Insert the token ID into the form so it gets submitted to the server*/
               var form = document.getElementById('ova_register_paid_event');
               var hiddenInput = document.createElement('input');
               hiddenInput.setAttribute('type', 'hidden');
               hiddenInput.setAttribute('name', 'stripeToken');
               hiddenInput.setAttribute('value', token.id);
               form.appendChild(hiddenInput);

               var iduniform = $("#ova_register_paid_event");
               var method_payment = iduniform.find("input[name=method_payment]:checked").val();
               if (method_payment == 'offline') {
                  form.submit();
                  return false;
               }

               var ajax_nonce = iduniform.find("input[name=ajax_nonce]").val();

               var ovaem_name = iduniform.find(".ovaem_name").val();
               var ovaem_phone = iduniform.find("input[name=ovaem_phone]").val();
               var ovaem_email = iduniform.find("input[name=ovaem_email]").val();
               var ovaem_address = iduniform.find("input[name=ovaem_address]").val();
               var ovaem_company = iduniform.find("input[name=ovaem_company]").val();
               var ovaem_desc = iduniform.find('textarea[name="ovaem_desc"]').val();


               $.post(ajax_object.ajax_url, {
                  action: 'ova_add_order_info',
                  security: ajax_nonce,
                  data: {
                     ovaem_name: ovaem_name,
                     ovaem_phone: ovaem_phone,
                     ovaem_email: ovaem_email,
                     ovaem_address: ovaem_address,
                     ovaem_company: ovaem_company,
                     ovaem_desc: ovaem_desc,
                     method_payment: method_payment
                  },
                  beforeSend: function() {
                     $("body").show();
                  },
                  complete: function() {
                     $("body").hide();
                  }

               }, function(response) {
                  if (response != 'false') {
                     iduniform.find("input[name=id]").val(response);
                     form.submit();
                     return false;

                  } else {
                     iduniform.find('.form-alert').append('' +
                        '<div class=\"alert alert-error registration-form-alert\">' +
                        '<button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>' +
                        '<strong>Registering is error!</strong>.' +
                        '</div>' +
                        '');
                     return false;
                  }
               });

            }


         }
      }





      $('#ova_register_paid_event .submit-checkout-form').off('click').on('click', function(e) {
         var idform = $(this).data('idform');
         var iduniform = $("#" + idform);

         if ( iduniform.find('.ovaem-recaptcha-wrapper').length ) {
            var recapcha   = iduniform.find('.ovaem-recaptcha-wrapper');

            if ( ! recapcha.hasClass('checked') ) {
               let mess = recapcha.data('mess');
               if ( mess ) {
                  alert( mess );
               }
               return false;
            }
         }
         


         $(iduniform).validate({
            submitHandler: function(form) {

               var method_payment = iduniform.find("input[name=method_payment]:checked").val();

               if (method_payment == 'offline') {
                  form.submit();
                  return false;
               }

               if (method_payment == 'paypal') {

                  var ajax_nonce = iduniform.find("input[name=ajax_nonce]").val();

                  var ovaem_name = iduniform.find(".ovaem_name").val();
                  var ovaem_phone = iduniform.find("input[name=ovaem_phone]").val();
                  var ovaem_email = iduniform.find("input[name=ovaem_email]").val();
                  var ovaem_address = iduniform.find("input[name=ovaem_address]").val();
                  var ovaem_company = iduniform.find("input[name=ovaem_company]").val();
                  var ovaem_terms = iduniform.find("input[name=ovaem_terms]").is(':checked');
                  var ovaem_desc = iduniform.find('textarea[name="ovaem_desc"]').val();

                  $.post(ajax_object.ajax_url, {
                     action: 'ova_add_order_info',
                     security: ajax_nonce,
                     data: {
                        ovaem_name: ovaem_name,
                        ovaem_phone: ovaem_phone,
                        ovaem_email: ovaem_email,
                        ovaem_address: ovaem_address,
                        ovaem_company: ovaem_company,
                        ovaem_terms: ovaem_terms,
                        ovaem_desc: ovaem_desc,
                        method_payment: method_payment
                     },
                     beforeSend: function() {
                        $("body").show();
                     },
                     complete: function() {
                        $("body").hide();
                     }

                  }, function(response) {
                     if (response != 'false') {
                        iduniform.find("input[name=id]").val(response);
                        form.submit();
                        return false;

                     } else {
                        iduniform.find('.form-alert').append('' +
                           '<div class=\"alert alert-error registration-form-alert\">' +
                           '<button class=\"close\" data-dismiss=\"alert\" type=\"button\">&times;</button>' +
                           '<strong>Registering is error!</strong>.' +
                           '</div>' +
                           '');
                        return false;
                     }
                  });

               }
            }
         });

         $('#ova_register_paid_event input[type="tel"]').each( function(i,el){
            $(el).rules('add',{
               digits: true,
            });
         } );

      });

      $('.ovaem_search_state_city   .ovaem_country select').change(function(e) {
         var country = $(this).val();
         var $this = $(this).closest('.ovaem_search_state_city');

         $this.find('#name_city').attr('disabled', true).selectpicker('refresh');

         $.post(ajax_object.ajax_url, {
            action: 'ova_load_city',
            data: {
               country: country
            },
         }, function(response) {
            $this.find('#name_city').html(response);
            $this.find('#name_city').selectpicker('refresh');
            $this.find('#name_city').attr('disabled', false).selectpicker('refresh');
            return false;
         });

      });

   });

})(jQuery);