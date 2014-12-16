@extends('layouts.default')
@section('content')
<section class="container-fluid register-page top-blue-section">
	<div class="row">
    	<div class="col-md-12">
        	<h1>Register</h1>
            <span>and earn</span>
            <em>500¥</em>
            <p>credit</p>
        </div>
    </div>
</section>

@if (Session::get('notice'))
    <div class="alert">{{ Session::get('notice') }}</div>
@endif
<div class="container register-page">
	<div class="row">
    	<div class="col-md-12">
        	<a href="#" class="fb-button social-button">Sign up with Facebook</a>
            <a href="#" class="google-button social-button">Sign up with Google</a>
            <p class="or">Or</p>
        </div>
    </div>
</div>
<form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8" id="register-form"
      data-form-valid-callback="activate_submit_button" data-form-invalid-callback="remove_some_cool_animation"
      data-parsley-validate>
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group email-input-container">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
            <input class="form-control instant-valid" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" 
                   type="email" name="email" id="email" value="{{{ Input::old('email') }}}" 
                   required  data-parsley-trigger="change" data-instant-valid-callback="append_green_border" 
                   data-instant-invalid-callback="append_red_border" />
	        <p class="clearfix character-tip"><em class="left"></em><span class="block right"></span></p>
        </div>
        <p class="js-error-message"></p>
        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
            	<span>ERROR</span>
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif
        <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password')}}}" 
                   type="password" name="password" id="password" 
                   required  data-parsley-trigger="change" data-parsley-minlength="6" data-instant-valid-callback="append_green_border" 
                    />
	        <p class="clearfix character-tip"><span class="block">At least 6 characters</span></p>
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input class="form-control instant-valid" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" 
                   type="password" name="password_confirmation" id="password_confirmation" 
                   data-parsley-equalto="#password" required  data-parsley-trigger="change" data-parsley-minlength="6" data-instant-valid-callback="append_green_border" 
                    />
	        <p class="clearfix character-tip"><span class="block">Type in the password again</span></p>
        </div>
        <input class="form-control" type="hidden" name="instructor" id="instructor" value="{{{ $instructor }}}">

        

        <div class="form-actions form-group">
          <button type="submit" id="submit-button" class="btn btn-primary deactivate-button">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>
@stop