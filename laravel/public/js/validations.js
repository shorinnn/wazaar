/**
 * Contains validation functions and event handlers
 * @class Validations 
 */
$(document).ready(function(){
    $('body').delegate('.instant-valid', 'keyup', fieldInstantValidCallback);
    $.listen('parsley:field:success', formValidCallback);
    $('body').delegate('.instant-valid', 'focus', highlightInput);
    $('body').delegate('.delayed-valid', 'keyup', validateOnDelay);
});

/**
 * Event Listener for .instant-valid class.<br />
 * Fired by keyup on elements with the .instant-valid class and triggers  valid/invalid 
 * parsley events and callbacks for current element
 * @method fieldInstantValidCallback
 * @param {event} e
 * @return {bool}  True if the element was valid, false otherwise
 */
function fieldInstantValidCallback(e){
    // fire the instant valid callback
    if( $(e.target).parsley().isValid() ){
        $(e.target).trigger('blur change');
        if( typeof($(e.target).attr('data-instant-valid-callback')) !='undefined') {
            window[$(e.target).attr('data-instant-valid-callback')]($(e.target));
            return true;
        }        
    }
    // fire the instant invalid callback
    else{
//        $(e.target).trigger('blur change');
        formInvalidCallback(e);
   
        if( typeof($(e.target).attr('data-instant-invalid-callback')) !='undefined') {
            window[$(e.target).attr('data-instant-invalid-callback')]( $(e.target) );
        }
    }
    return false;
}

/**
 * Event listener for parsley:field:success.<br />
 * Fires a form callback (data-form-valid-callback) if all elements within the form are valid
 * @method formValidCallback
 * @param event e
 * @returns bool - True on fired, false otherwise
 */
function formValidCallback(e){
    if( typeof(e.$element)=='undefined' ){
        e = {};
        e.$element = $(event.srcElement);
    }
    // get the parent form
    $form = e.$element.closest('form');
    // loop through elements and check if all valid
    all_valid = true;
    $form.find("[data-parsley-trigger]").each(
        function(){
            if($(this).hasClass() || $(this).attr('id')!=''){
                if(!$(this).parsley().isValid()) all_valid = false;
            }
        }
    );
    if( all_valid && typeof($form.attr('data-form-valid-callback')) !='undefined' && $form.attr('data-validation-callback-called')!=1 ){
        $form.attr('data-validation-callback-called', 1);
        window[$form.attr('data-form-valid-callback')]($form);
        return true;
    }
    return false;
}

/**
 * Called by fieldInstantValidCallback() - Fires the invalid form callback (specified by the data-form-valid-callback
 * attr of e.target) if specified
 * @method formInvalidCallback
 * @param {event} e
 */
function formInvalidCallback(e){
    if( typeof(e.$element)=='undefined' ){
        target = e.target;
        e = {};
        e.$element = $(target) ;// || $(event.srcElement);
    }
    $form = e.$element.closest('form');
    if($form.attr('data-validation-callback-called')==1){
        $form.attr('data-validation-callback-called', 0);
        window[$form.attr('data-form-invalid-callback')]($form);
    }
}

/** 
 * Adds a green border to an element
 * @method appendGreenBorder
 * @param {object} $element The html object to add the border
 */
function appendGreenBorder($element){
    // On successful validation appends a green border on the input
    $element.addClass("valid-input");

    // Removes the box shadow from successfully validated inputs
    $element.removeClass("active-input invalid-input");

    // Adds a class that displays the green tick icon
    $element.parent("div.form-group").addClass("input-container");

    // Slides up the character tip span when the field successfully validates
    $element.parent().find('.character-tip span').css('top','-47px');

    // Switches the green box shadow to the next input on a successful validation
    if($element.parsley().isValid()){
        $element.parent("div.form-group").nextAll('div.form-group').first().find("input").addClass("active-input");
    }
}

/** 
 * Adds a red border to the supplied element
 * @method appendRedBorder
 * @param {object} $element
 */
function appendRedBorder($element){
    // Adds the red border when validation fails
    $element.addClass("invalid-input");

    // Removes the green border
    $element.removeClass("valid-input");

    // Removes the green tick icon
    $element.parent("div.form-group").removeClass("input-container");

}

/**
* Event listener for .instant-valid .<br />. 
* Adds a green shadow and border to the active form field and highlights the next form field on validation
* @method highlightInput
* @param {event} e Focus event
*/
function highlightInput(e){
    $(e.target).addClass("active-input");
}

/**
 * Event listener for .delayed-valid class.<br />
 * Checks if the current input is valid and fires a callback specified by
 * data-delayed-invalid-callback if invalid
 * @method validateOnDelay
 * @param {event} e keyup event
 */
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

/**
 * Event listener for blur on .delayed-valid.<br />
 * Cancel the validateOnDelay if element is blured
 * @method cancelDelayTimer
 * @param {event} e Blur event
 */
function cancelDelayTimer(e){
    clearTimeout(e.target.timer);
}


/**
 * Slides down a subtle hint if the element supplied is not valid
 * @param {object} $element Form input
 */
function invalidSubtleHint($element){
    $element.parent().find('.character-tip span').css('top','0px');
}