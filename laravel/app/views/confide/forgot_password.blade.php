@extends('layouts.default')
@section('content')	


@if (Session::get('notice'))
    <div class="alert">{{{ Session::get('notice') }}}</div>
@endif
<form method="POST" action="{{ action('UsersController@forgotPassword') }}" accept-charset="UTF-8" id="forgot-form" class="clearfix">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

    <div class="form-group clearfix">
    	<p>Please Enter your Email to reset your password. Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
        <label for="email">{{{ Lang::get('confide::confide.e_mail') }}}</label>
        <div class="input-append input-group">
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
            <span class="input-group-btn">
                <input class="btn btn-default" type="submit" value="{{{ Lang::get('confide::confide.forgot.submit') }}}">
            </span>
        </div>
    </div>
    @if (Session::get('error'))
        <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
    @endif

</form>
@stop
forgot-password-page clearfix