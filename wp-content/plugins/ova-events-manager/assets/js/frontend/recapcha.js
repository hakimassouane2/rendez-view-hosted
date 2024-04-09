"use strict";
function ovaem_recapcha_v2() {
    
    const recaptcha = document.getElementsByClassName('ovaem-recaptcha-wrapper');
    if ( recaptcha.length ) {
        for (let i = 0; i < recaptcha.length; i++) {
            let $options = {
                'sitekey': recapcha_object.site_key,
                'callback': ovaem_recapcha_callback,
                'expired-callback': ovaem_recapcha_expired_callback,
            };
            grecaptcha.ready(function(){
                grecaptcha.render(recaptcha.item(i), $options);
            });
        }
    }
}
function ovaem_recapcha_v3() {

    grecaptcha.ready(function(){
        grecaptcha.execute(recapcha_object.site_key, {
            action: 'validate_recaptchav3'
        }).then(function (token) {
            if ( document.querySelectorAll('.g-recaptcha-response').length ) {
                document.querySelectorAll('.g-recaptcha-response').forEach(function (elem) {
                    elem.value = token;
                });
            }
        });
    });
}
function ovaem_recapcha_callback(token){
    const recapcha_wrapper = document.getElementsByClassName('ovaem-recaptcha-wrapper');
    if ( recapcha_wrapper.length ) {
        for (var i = 0; i < recapcha_wrapper.length; i++) {
            recapcha_wrapper[i].classList.add('checked');
        }
    }
}
function ovaem_recapcha_expired_callback(){
    const recapcha_wrapper = document.getElementsByClassName('ovaem-recaptcha-wrapper');
    if ( recapcha_wrapper.length ) {
        for (var i = 0; i < recapcha_wrapper.length; i++) {
            recapcha_wrapper[i].classList.remove('checked');
        }
    }
    grecaptcha.reset();
}