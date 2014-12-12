// JavaScript Document
$(document).ready(function(){
    $(".profile-name > li").removeClass("activate-dropdown");
    // attach event to body, this allows the function to run when dynamically loaded (ajax) btns are clicked
    $('body').delegate('.delete-button', 'click', confirmDelete);
    $('body').delegate('#register-form .form-group input', 'focus', slideDownText);
    $('body').delegate('#register-form [name="email"]', 'blur', validateEmail);
    $('body').delegate('#register-form [name="password"]', 'blur', validatePassword);
    $('body').delegate('#register-form [name="password_confirmation"]', 'blur', confirmPassword);
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

function validateEmail(e){
    // Get the email value
    var email = $(e.target);
    $(this).focus().addClass("active-input");
    // Email validation Regex
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    //Compare Email with input value
     if(email.val().match(re)){
         $('#password').focus().addClass("active-input");
         email.removeClass("active-input");
         $(".js-error-message").css("display", "none");
         return;
     }

    // Handle any error display message or pop up here
    $(".js-error-message").append("<span>ERROR</span>Please enter a valid Email Address.").css("display", "block");
     return false;
}

function validatePassword(e){
    // Get the password
    var password = $(e.target);
    $(this).focus().addClass("active-input");
    //Check length of password and ensure its not less than 6
    if(password.val().length >= 6){
        $('#password').removeClass("active-input");
        $("#password_confirmation").focus().addClass("active-input");
        $(".js-error-message").css("display", "none");
        return;
    }

    //Handle any error message and retain focus on the input box
    $(".js-error-message").html("");
    $(".js-error-message").append("<span>ERROR</span>Enter a minimum of 6 characters.").css({"display":"block", "top":"72px"});
    return;
}
function confirmPassword(e){
    // Get the first password entered.
    var firstPassword = $("#password");
    $(this).focus().addClass("active-input");
    //Get the second password entered
    var secondPassword = $(e.target);

    //Check that second password matches first password
    if(secondPassword.val() == firstPassword.val()){
        $("#password_confirmation").removeClass("active-input");
        $("#register-form .btn.btn-primary").addClass("active-button");
        $(".js-error-message").css("display", "none");
        return;
    }

    //Display some error message.
    $(".js-error-message").html("");
    $(".js-error-message").append("<span>ERROR</span>Password does not match.").css({"display":"block", "top":"157px"});
    return;
}
