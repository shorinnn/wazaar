// JavaScript Document
$(document).ready(function(){
    $(".profile-name > li").removeClass("activate-dropdown");
    // attach event to body, this allows the function to run when dynamically loaded (ajax) btns are clicked
    $('body').delegate('.delete-button', 'click', confirmDelete);
    // listen for validated fields
    $.listen('parsley:field:success', form_valid_callback);
    // listen for instant validation events
    $('body').delegate('.instant-valid', 'keyup', field_instant_valid_callback);
    
    $('body').delegate('.has-slug', 'keyup', update_slug);
});


function update_slug(e){
    target = $(e.target).attr('data-slug-target');
    $(target).val( convertToSlug( $(e.target).val() ) );
}

function convertToSlug(text){
     return text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
}