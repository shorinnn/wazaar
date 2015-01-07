// JavaScript Document
$(document).ready(function(){
    // This listens for the parsley error on form fields and inserts the
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
    $('body').delegate('.instant-valid', 'focus', highlightInput);


});


function update_slug(e){
    target = $(e.target).attr('data-slug-target');
    $(target).val( convertToSlug( $(e.target).val() ) );
}

function convertToSlug(text){
     return text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
}

function validateOnDelay(e){
    if( typeof(e.target.timer) != 'undefined'){
        clearTimeout(e.target.timer);
    }
    
    e.target.timer = setTimeout(function () {
        if(! $(e.target).parsley().isValid() ){
            $(e.target).removeClass('delayed-valid');
            callback = $(e.target).attr('data-delayed-invalid-callback');
            window[callback]( $(e.target) );
        }
    }, 3000);
    
    $(e.target).on('blur', cancelDelayTimer);
}

function cancelDelayTimer(e){
    clearTimeout(e.target.timer);
}

function almost_there($element){
    $element.parent().find('.character-tip span').css('top','0px');
}

function submittedFormButton(e){
    $(e.target).find('[type=submit]').attr('data-old-label', $(e.target).find('[type=submit]').html());
    $(e.target).find('[type=submit]').html('Processing...<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
}

function restoreSubmitLabel($form){
    $form.find('[type=submit]').html( $form.find('[type=submit]').attr('data-old-label') );
}