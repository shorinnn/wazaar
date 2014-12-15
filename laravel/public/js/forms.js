/**
 * Fires valid/invalid events and callbacks for elements with the .instant-valid class
 * @param event e
 * @returns bool - True if the element was valid, false otherwise
 */
function instant_valid(e){
    // fire the instant valid callback
    if( $(e.target).parsley().isValid() ){
        $.emit('parsley:field:success');
        if( typeof($(e.target).attr('data-instant-valid-callback')) !='undefined') {
            window[$(e.target).attr('data-instant-valid-callback')]( $(e.target) );
            return true;
        }        
    }
    // fire the instant invalid callback
    else{
        $.emit('parsley:field:error');
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
    if( typeof($element)=='undefined' ){
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
    if( typeof($element)=='undefined' ){
        e = {};
        e.$element = $(event.srcElement);
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
function append_check_mark($element){
    id = $element.attr('data-parsley-id');
    $('.check-'+id).remove();
    $element.after("<i class='check-"+id+" glyphicon glyphicon-ok'></i>");
}

/** this function is defined as the email field invalid callback
 *  data-instant-invalid-callback="remove_check_mark" 
 *  This will remove the check icon if the value becomes invalid
 * @param object $element
 */
function remove_check_mark($element){
    id = $element.attr('data-parsley-id');
    $('.check-'+id).remove();
}

/** this function is defined as the form valid callback
 *  data-form-valid-callback="some_cool_animation"
 * Just put some text before the form. Can do anything: make the submit btn glow, the form shake, etc
 * @param object $form
 */
function some_cool_animation($form){
    $form.before("<p class='form-success alert alert-success register-form-success'>FORM IS VALID! This can also be anything else: animation, dom change, etc</p>");
}

/** this function is defined as the form invalid callback
 *  data-form-invalid-callback="remove_some_cool_animation"
 * Remove the text included by some_cool_animation so the user knows the form is no longer valid
 * @param object $form
 */
function remove_some_cool_animation($form){
    $(".register-form-success").remove();
}
/* end example instant valid callbacks */