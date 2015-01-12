/**
 * Contains form related reusable functions and event listeners
 * @class Forms 
 */
$(document).ready(function(){
    $('body').delegate('form', 'submit', submittedFormButton);    
    $('body').delegate('.delete-button', 'click', confirmDelete);
    $('body').delegate('.has-slug', 'keyup', updateSlug);
    $('body').delegate('.ajax-form', 'submit', formAjaxSubmit);
    $('body').delegate('input.clonable', 'keydown', cloneInput);
    $('body').delegate('.delete-clonable', 'click', deleteClonable);
    $('body').delegate('.ajax-updatable', 'change', updateFieldRemote);
});

/**
 * Event handler for .ajax-form<br />
 * Submits forms with .ajax-form class via ajax and fires the data-callback function if specified
 * @method formAjaxSubmit
 * @param {type} e Submit event
 * @returns {Boolean} False
 */
function formAjaxSubmit(e){
    form = $(e.target);
    form.find('.ajax-errors').remove();
    $.post(form.attr('action'), form.serialize(), function(result){
        result = JSON.parse(result);
        if(result.status=='error'){
            console.log(result.errors);
            form.append('<p class="alert alert-danger ajax-errors">'+result.errors+'</p>');
            restoreSubmitLabel(form);
            return false;
        }
        restoreSubmitLabel(form);
        if( typeof(form.attr('data-callback'))!='undefined' ){
            window[form.attr('data-callback')](result, e);
        }
    });
    return false;
}


/**
 * Event handler for forms.<br />
 * Called on all forms when they're submitted. It replaces the submit button label with "Processing...[loader icon]" 
 * and stores the old value in data-old-label attribute.
 * @method submittedFormButton
 * @param {Event} e
 */
function submittedFormButton(e){
    $(e.target).find('[type=submit]').attr('data-old-label', $(e.target).find('[type=submit]').html());
    $(e.target).find('[type=submit]').html('Processing...<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
}

/**
 * Restores the form's submit button original label
 * @method restoreSubmitLabel
 * @param {jQuery form} $form
 */
function restoreSubmitLabel($form){
    $form.find('[type=submit]').html( $form.find('[type=submit]').attr('data-old-label') );
}

/**
 * Event handler for  .delete-button.<br />
 * Fired by click on .delete-button and asks for confirmation
 * @method confirmDelete
 * @param {event} e
 * @returns {bool} True if confirmed, false otherwise
 */
function confirmDelete(e){
    // get the message from the clicked button, don't hard code it (so we can use localization)
    msg = $(e.target).attr('data-message');
    return confirm(msg);
}

/**
 * Event handler for .has-slug<br />
 * Is called on keyup event for elements with .has-slug class. It takes the elements value 
 * and populates another field specified by the elements data-slug-target attribute with
 * the slug version of the value
 * @method updateSlug
 * @param {Event} e
 * @return {null} null
 */
function updateSlug(e){
    target = $(e.target).attr('data-slug-target');
    $(target).val( convertToSlug( $(e.target).val() ) );
    return null;
}

/**
 * Populates a second dropdown specified by 'data-target' with the values 
 * returned by the get call to the resource at data-url
 * @method populateDropdown
 * @param {object} elem HTML dropdown
 */
function populateDropdown(elem){
    target = $(elem).attr('data-target');
    target = $(target);
    target.empty();
    var o = new Option( 'loading...', 'loading...' );
    $(o).html( 'loading...' );
    target.append(o);
    target.attr('disabled', true);
    $.get( $(elem).attr('data-url'),{id:$(elem).val()}, function(result){
        target.empty();
        for(i=0; i<result.length; ++i){
            var o = new Option( result[i].name, result[i].id );
            $(o).html( result[i].name );
            target.append(o);
        }
        target.attr('disabled', false);
    });
}

/**
 * Event handler for .clonable inputs.<br />
 * Fired on keyup on an empty clonable input - it creates a set of 
 * input+delete button after the calling element
 * @param {event} e keyup event
 */
function cloneInput(e){
    var keynum;
    var keychar;
    var charcheck;
    if(window.event) // IE
    keynum = e.keyCode;
    else if(e.which) // Netscape/Firefox/Opera
    keynum = e.which;
    keychar = String.fromCharCode(keynum);
    charcheck = /[a-zA-Z0-9]/;

    if( !charcheck.test(keychar) ) return;   
    $elem = $(e.target);
    if( $.trim($elem.val()) == '' && $elem.next('.clonable').length==0 ){
        var $destination = $elem.parent();
        var clone = $elem.clone();
        clone.removeAttr('id');
        clone.removeAttr('required');
        clone.removeClass();
        id = uniqueId();
        clone.addClass('clonable clonable-'+id);
        $destination.after('<div class="clonable clonable-'+id+'"><span>1</span><a href="#" tabindex="-1" class="style-one delete-clonable clonable-'+id+'"></a></div>');
        $('a.clonable-'+id).before(clone);
        reorderClonable($elem.attr('name'));
    }
}

/**
 * Renumbers the position label under clonable inputs
 * @method reorderClonable
 * @param {string} name The name of the clonable inputs
 */
function reorderClonable(name){
    var i = 1;
    $('[name="'+name+'"]').each(function(){
        $(this).prev('span').html(i);
        ++i;
    });
}

/**
 * Event handler for click on .delete-clonable buttons<br />
 * Deletes the clonable input and associated delete button
 * @param {event} e Click event
 */
function deleteClonable(e){
    e.preventDefault();
    name = $(e.target).parent().find('input').attr('name');
    $(e.target).parent().remove();
    reorderClonable( name );
    return false;
}

/**
 * Called after an AJAX delete call, removes the specified HTML element
 * @method deleteItem
 * @param {json} result The ajax call json response
 * @param {event} event The original submit event
 */
function deleteItem(result, event){
    identifier = $(event.target).attr('data-delete');
    $(identifier).remove();
}
var saving_animation = 0;
function updateFieldRemote(e){
    
    url = $(e.target).attr('data-url');
    name = $(e.target).attr('data-name');
    value = $(e.target).val();
    token = $('[name="_token"]').first().val();
    savingAnimation(0);
    $.ajax({
        url: url,
        type: 'PUT',
        data: {name:name, value:value, _token:token},
        success: savingAnimation(1)
    });
}

/**
 * Displays a saving animation when called with a 0 param, ends it when called with a 1 param 
 * @param {Number} stop zero to start the animation, 1 to end it
 * @method savingAnimation
 */
function savingAnimation(stop) {
    if(stop==1){
        setTimeout(function(){
            saving_animation = 0;
            $('#save-indicator').animate({
                left: '-100px'
            }, 300);
        }, 700);
        return false;
    }
    
    if (saving_animation == 1) return false;
    saving_animation = 1;
    $('body').remove('#save-indicator');
    $('body').append('<div id="save-indicator">Saving <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /></div>');
    $('#save-indicator').animate({
        left: '0px'
    }, 300);
};