@extends('layouts.login_default')
@section('content')

@if (Session::get('notice'))
    <div class="alert">{{ Session::get('notice') }}</div>
@endif

<section class="container-fluid login-wrapper dedicated-login-page">
	<div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4">
        	<a href="" class="modal-box-logo clearfix">
            	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive" alt="">
            </a>
            <div class="login-form-container clearfix">
            	<h1 class="clearfix">{{ trans('site/register.register-new-account') }}</h1>
                <div class="login-social-buttons clearfix">
                	<a href="{{ url('login-with-facebook') }}" class="login-facebook">{{ trans('general.register-with-facebook') }}</a>
                    <!--<a href="{{url('login-with-google') }}" class="login-google">{{ trans('general.google') }}</a>-->
                </div>
                <div class="or"><span class="left-line"></span>{{ trans('general.or') }}<span class="right-line"></span></div>
                <p class="intro-paragraph text-center">{{ trans('general.enter-new-email-and-password') }}</p>
                <div class="login-form clearfix">
                    <form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8" id="register-form"
                         
                          data-parsley-validate>
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                        <fieldset>
                        
				        <div class="form-group email-field">
                            <input class="form-control instant-valid delayed-valid" placeholder="{{ trans('general.email-placeholder') }}" 
                               type="email" name="email" id="email" value="{{{ Input::old('email') }}}" 
                               data-toggle="tooltip" data-placement="right" title="Did you mean...?"
                               required  data-parsley-trigger="change" data-instant-valid-callback="appendGreenBorder" 
                               data-instant-invalid-callback="appendRedBorder" data-delayed-invalid-callback="invalidSubtleHint" />
						</div>
                        <p class="js-error-message"></p>
                        @if (Session::has('error'))
                            <div class="alert alert-error alert-danger">
                                <span>ERROR</span>
                                {{Session::get('error')}}
                            </div>
                        @endif
                        
				        <div class="form-group password-field">
                            <input class="form-control delayed-valid instant-valid" placeholder="{{ trans('general.password-placeholder') }}" 
                                   type="password" name="password" id="password" 
                                   required  data-parsley-trigger="change" data-parsley-minlength="6" data-instant-valid-callback="appendGreenBorder" 
                                   data-delayed-invalid-callback="invalidSubtleHint" data-instant-invalid-callback="appendRedBorder" />
                            <a href="#" class="show-password">{{ trans('site/register.show-password') }}</a>
                        </div>
                        <!--<div class="form-group">
                            <input class="form-control instant-valid" placeholder="{{ trans('general.password-confirmation-placeholder') }}" 
                                   type="password" name="password_confirmation" id="password_confirmation" 
                                   data-parsley-equalto="#password" required  data-parsley-trigger="change" data-parsley-minlength="6" 
                                   data-instant-valid-callback="appendGreenBorder" />
                        </div>-->
                        <div class="form-actions form-group">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" class="hide" alt="">
                          <button type="submit" id="submit-button" class="large-blue-button blue-button deactivate-button">
                          	{{ trans('site/register.create-account') }}
                          </button>
                        </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="login-form-footer text-center">
                <span class="margin-right-15">{{ trans('site/register.already-have-an-account') }}</span>
                <a href="{{ action('UsersController@login') }}">Login</a>
            </div>
        </div>
    </div>
</section>


<!--<section class="container-fluid register-page top-blue-section">
	<div class="row">
    	<div class="col-md-12">
        	<h1>{{ trans('general.register') }}</h1>
            <span>{{ trans('site/register.and-earn') }}</span>
            <em>500¥</em>
            <p>{{ trans('site/register.credit') }}</p>
        </div>
    </div>
</section>-->

<!--@if (Session::get('notice'))
    <div class="alert">{{ Session::get('notice') }}</div>
@endif
<div class="container register-page">
	<div class="row">
    	<div class="col-md-12">
        	<a href="{{ url('login-with-facebook') }}" class="fb-button social-button">{{ trans('site/login.sign-in-with-fb') }}</a>
                <a href="{{url('login-with-google') }}" class="google-button social-button">{{ trans('site/login.sign-in-with-google') }}</a>
                <p class="or"></p>

        </div>
    </div>
</div>-->
 <!-- data-form-valid-callback="activateSubmitButton" data-form-invalid-callback="remove_some_cool_animation"-->
<!--<form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8" id="register-form"
     
      data-parsley-validate>
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group email-input-container">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
                <input class="form-control instant-valid delayed-valid" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" 
                   type="email" name="email" id="email" value="{{{ Input::old('email') }}}" 
                   required  data-parsley-trigger="change" data-instant-valid-callback="appendGreenBorder" 
                   data-instant-invalid-callback="appendRedBorder" data-delayed-invalid-callback="invalidSubtleHint" />
	        <p class="clearfix character-tip"><em class="left"></em><span class="block">You're almost there...</span></p>
        </div>
        <p class="js-error-message"></p>
        @if (Session::has('error'))
            <div class="alert alert-error alert-danger">
            	<span>ERROR</span>
                {{Session::get('error')}}
            </div>
        @endif
        <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
            <input class="form-control delayed-valid instant-valid" placeholder="{{{ Lang::get('confide::confide.password')}}}" 
                   type="password" name="password" id="password" 
                   required  data-parsley-trigger="change" data-parsley-minlength="6" data-instant-valid-callback="appendGreenBorder" 
                   data-delayed-invalid-callback="invalidSubtleHint" data-instant-invalid-callback="appendRedBorder" />
	        <p class="clearfix character-tip"><span class="block">At least 6 characters</span></p>
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input class="form-control instant-valid" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" 
                   type="password" name="password_confirmation" id="password_confirmation" 
                   data-parsley-equalto="#password" required  data-parsley-trigger="change" data-parsley-minlength="6" 
                   data-instant-valid-callback="appendGreenBorder" />
	        <p class="clearfix character-tip"><span class="block">Type in the password again</span></p>
        </div>

        

        <div class="form-actions form-group">
        	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" class="hide" alt="">
          <button type="submit" id="submit-button" class="btn btn-primary deactivate-button">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>-->
@stop