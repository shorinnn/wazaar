// JavaScript Document
$(document).ready(function(){
    $(".profile-name > li").removeClass("activate-dropdown");
    // attach event to body, this allows the function to run when dynamically loaded (ajax) btns are clicked
    $('body').on('click', '.delete-button', confirmDelete);
    $('body').on('focus', '#register-form .form-group input', slideDownText);
});

function confirmDelete(e){
    // get the message from the clicked button, don't hard code it (so we can use localization)
    msg = $(e.target).attr('data-message');
    return confirm(msg);
}

function slideDownText(e){
   $(e.target).focus(function(){
       $(this).next().addClass('slide-down');
   });
   $(e.target).blur(function(){
       $(this).next().removeClass('slide-down');
    });
    return;
}

$(function() {

    // Setup form validation on the #register-form element
    $("#register-form").validate({

        // Specify the validation rules
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8
            },
            agree: "required"
        },

        // Specify the validation error messages
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address",
            agree: "Please accept our policy"
        },

        submitHandler: function (form) {
            form.submit();
        }
    })
})