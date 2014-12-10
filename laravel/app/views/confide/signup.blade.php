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
@if (Session::get('error'))
    <div class="alert alert-error alert-danger">
        @if (is_array(Session::get('error')))
            {{ head(Session::get('error')) }}
        @endif
    </div>
@endif

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
<form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8" id="register-form">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <p class="clearfix"><em class="left">Almost there!</em> <span class="block right">8 to 20 characters</span></p>
        <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>
        <input class="form-control" type="hidden" name="teacher" id="teacher" value="{{{ $teacher }}}">

        

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>
@stop