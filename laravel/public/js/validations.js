function validateEmail(email) {
var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
        }

var loginValidator = {
emailAssist:function(){
    var domains = ['gmail.com', 'aol.com'];
    $('#login-form [name=email]').mailcheck({
        domains: domains,                       // optional
        suggested: function(element, suggestion) {
          $('#login-form [name=email]').tooltip('hide')
            .attr('title', 'Did you mean '+suggestion.full+'?')
            .tooltip('fixTitle')
            .tooltip('show');
        },
        empty: function(element) {
        }
    });
},
emailValidate:function(){
        $('#login-form [name=email]').tooltip('destroy');
        $('#login-form [name=email]').closest('.form-group').removeClass('input-error');
        $('#login-form [name=email]').closest('.form-group').removeClass('valid-input');
        $('#login-form [name=email]').next('.hide').remove();
        
        if ( !validateEmail($('#login-form [name=email]').val()) ){
            $('#login-form [name=email]').closest('.form-group').addClass('input-error');
            $('#login-form [name=email]').after('<p class="hide">' + _('Invalid email address') + '</p>');
            this.emailAssist();
            return false;
        }

        checkURL = $('#login-form [name=email]').attr('data-check-url');
        self = this;
        $.get(checkURL, {email: $('#login-form [name=email]').val()}, function(result){
            if (result === '0'){
            $('#login-form [name=email]').closest('.form-group').addClass('input-error');
                    $('#login-form [name=email]').after('<p class="hide">' + _('Email not registered') + '</p>');
                    self.emailAssist();
                    return false;
            }
            else{
                    $('#login-form [name=email]').tooltip('destroy');
                    $('#login-form [name=email]').closest('.form-group').addClass('valid-input');
                    return true;
                }
        });
},
        passwordValidate:function(){
            $('#login-form [name=password]').tooltip('destroy');
            $('#login-form [name=password]').closest('.form-group').removeClass('input-error');
            $('#login-form [name=password]').closest('.form-group').removeClass('valid-input');
            $('#login-form [name=password]').next('.hide').remove();
            if ($.trim($('#login-form [name=password]').val()) == ''){
                $('#login-form [name=password]').closest('.form-group').addClass('input-error');
                $('#login-form [name=password]').after('<p class="hide">Password can\'t be blank</p>'); 
                return false;
            }
            if ( typeof( $('#login-form [name=password]').attr('data-fail') ) !='undefined' ){
                $('#login-form [name=password]').closest('.form-group').addClass('input-error');
                $('#login-form [name=password]').after('<p class="hide">Incorrect password</p>');
                $('#login-form [name=password]').removeAttr('data-fail');
                return false;
            }
            $('#login-form [name=password]').tooltip('destroy');
            $('#login-form [name=password]').closest('.form-group').addClass('valid-input');
            return true;
        },
        validate : function(){
            if ( this.emailValidate()==false ) return false;
            if ( this.passwordValidate()==false ) return false;
        
            var e = {};
            $('#login-form').removeAttr('data-no-processing');
            e.target = document.getElementById('login-form');
        },
        callback: function(result, e){
            $('#login-form [type="submit"]').attr('disabled', 'disabled');
            $('#login-form [type="submit"]').html( _( 'Logging in - Please wait' ) );
            window.location = window.location;
        },
        failCallback: function(result, e){
            console.log('fail called!');
            $('#login-form [name=password]').attr('data-fail',1);
            this.passwordValidate();
        }
};
