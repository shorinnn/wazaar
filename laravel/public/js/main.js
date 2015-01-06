// JavaScript Document
$(document).ready(function(){
    $(".profile-name > li").removeClass("activate-dropdown");
    // attach event to body, this allows the function to run when dynamically loaded (ajax) btns are clicked
    $('body').delegate('.delete-button', 'click', confirmDelete);
    // listen for validated fields
    $.listen('parsley:field:success', form_valid_callback);
    // listen for instant validation events
    $('body').delegate('.instant-valid', 'keyup', field_instant_valid_callback);
    $('body').delegate('.delayed-valid', 'keyup', validateOnDelay);
    $('body').delegate('form', 'submit', submittedFormButton);
    
    $('body').delegate('.has-slug', 'keyup', update_slug);
});


function update_slug(e){
    target = $(e.target).attr('data-slug-target');
    $(target).val( convertToSlug( $(e.target).val() ) );
}

function convertToSlug(text){
     return text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
}

function validateOnDelay(e){
    e.target.timer = setTimeout(function () {
        if(! $(e.target).parsley().isValid() ){
            callback = $(e.target).attr('data-delayed-invalid-callback');
            window[callback]( $(e.target) );
        }
    }, 3000);
    $(e.target).removeClass('delayed-valid');
    $(e.target).on('blur', cancelDelayTimer);
}

function cancelDelayTimer(e){
    clearTimeout(e.target.timer);
}

function almost_there($element){
    $element.after('almost there...');
}

function submittedFormButton(e){
    $(e.target).find('[type=submit]').html('Processing...<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
}