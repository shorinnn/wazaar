@extends('layouts.default')
@section('content')	


@if (Session::get('notice'))
    <div class="alert">{{{ Session::get('notice') }}}</div>
@endif
<form method="POST" action="{{ action('UsersController@forgotPassword') }}" accept-charset="UTF-8" id="forgot-form" class="clearfix">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
	<div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-offset-2 col-md-offset-3 col-lg-offset-3">
                <div class="form-group clearfix" id="reset-password">
                    <p>Please Enter your Email to reset your password. Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                    <!--<label for="email">{{{ Lang::get('confide::confide.e_mail') }}}</label>-->
                    <div class="input-append input-group">
                        <input class="form-control no-float" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
                        <span class="block text-center margin-top-20">
                            <input class="blue-button extra-large-button" type="submit" value="{{{ Lang::get('confide::confide.forgot.submit') }}}">
                        </span>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
    @if (Session::get('error'))
        <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
    @endif

</form>
@stop
