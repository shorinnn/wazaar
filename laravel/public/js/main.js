// JavaScript Document
$(document).ready(function(){
    $(".profile-name > li").removeClass("activate-dropdown");
    // attach event to body, this allows the function to run when dynamically loaded (ajax) btns are clicked
    $('body').delegate('.delete-button', 'click', confirmDelete);
    // listen for validated fields
    $.listen('parsley:field:success', form_valid_callback);
    // listen for instant validation events
    $('body').delegate('.instant-valid', 'keyup', instant_valid);
});
