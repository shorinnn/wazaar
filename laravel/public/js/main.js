// JavaScript Document
$(document).ready(function(){
    $(".profile-name > li").removeClass("activate-dropdown");
    // attach event to body, this allows the function to run when dynamically loaded (ajax) btns are clicked
    $('body').delegate('.delete-button', 'click', confirmDelete);
    // listen for validated fields
    $.listen('parsley:field:success', field_validated);
});

function field_validated(e){
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
    if(all_valid){
        alert('Doing some success animation here here - this is triggered by successfully filling out the entire form')
    }
}

function confirmDelete(e){
    // get the message from the clicked button, don't hard code it (so we can use localization)
    msg = $(e.target).attr('data-message');
    return confirm(msg);
}

//function slideDownText(e){
//   $(e.target).focus(function(){
//       $(this).next().addClass('slide-down');
//   });
//   $(e.target).blur(function(){
//       $(this).next().removeClass('slide-down');
//    });
//    return;
//}