/**
 * Fires valid/invalid events and callbacks for elements with the .instant-valid class
 * @param event e
 * @returns bool - True if the element was valid, false otherwise
 */
function field_instant_valid_callback(e){
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
        form_invalid_callback(e);
   
        if( typeof($(e.target).attr('data-instant-invalid-callback')) !='undefined') {
            window[$(e.target).attr('data-instant-invalid-callback')]( $(e.target) );
        }
    }
    return false;
}

/**
 * Fires a form callback (data-form-valid-callback) if all elements within the form are valid
 * @param event e
 * @returns bool - True on fired, false otherwise
 */
function form_valid_callback(e){
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
 * Fires the invalid form callback (data-form-valid-callback) if specified
 * @param {type} e
 * @returns {undefined}
 */
function form_invalid_callback(e){
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

function confirmDelete(e){
    // get the message from the clicked button, don't hard code it (so we can use localization)
    msg = $(e.target).attr('data-message');
    return confirm(msg);
}

/******* Example Form/field callbacks *******/


/** this function is defined as the email field valid callback
 *  data-instant-valid-callback="append_check_mark" 
 *  This will append an icon to the email area if valid
 * @param object $element
 */

function append_green_border($element){
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
        $element = $('#email');
        $element.parent("div.form-group").nextAll('div.form-group').first().find("input").addClass("active-input");
    }
}

/** this function is defined as the email field invalid callback
 *  data-instant-invalid-callback="remove_check_mark" 
 *  This will remove the check icon if the value becomes invalid
 * @param object $element
 */
function append_red_border($element){
    // Adds the red border when validation fails
    $element.addClass("invalid-input");

    // Removes the green border
    $element.removeClass("valid-input");

    // Removes the green tick icon
    $element.parent("div.form-group").removeClass("input-container");

}

/** this function is defined as the form valid callback
 *  data-form-valid-callback="some_cool_animation"
 * Just put some text before the form. Can do anything: make the submit btn glow, the form shake, etc
 * @param object $form
 */
function activate_submit_button(){
    animateBoxShadow();
}

/** this function is defined as the form invalid callback
 *  data-form-invalid-callback="remove_some_cool_animation"
 * Remove the text included by some_cool_animation so the user knows the form is no longer valid
 * @param object $form
 */
function remove_some_cool_animation($form){
    $(".register-form-success").remove();
}

    anim_count = 0;
    required_anim_count = 2;
    function animateBoxShadow() {
        // this fails because jqueryUI is not included
//        $('#submit-button').switchClass('deactivate-button', 'activate-button', 200, function(){
//            if (anim_count < required_anim_count) {
//                // call the animation again in 2 seconds
//                anim_count++;
//                setTimeout(animateBoxShadow, 2000);
//            }
//            else {
//                // reset the counter
//                anim_count = 0;
//            }
//        });
    }
/* end example instant valid callbacks */

/** Adds a green shadow and border to the active form field
* and highlights the next form field on validation
**/
function highlightInput(e){
    $(e.target).addClass("active-input");
}