@extends('layouts.login_default')
@section('content')
	<style>
		input[type="submit"]{
			background: #119bf8;
			height:auto;
			padding:10px 25px;
			border: solid #0089e5;
			border-width: 0 0 2px;
			font-size:13px;
			font-weight: 600;
		}
		input[type="submit"]:hover{
			background: #33adff;
			color: #fff !important;
			font-size:13px;
			font-weight: 600;
		}
		input[type="submit"]:active,
		input[type="submit"]:focus{
			background: #008eed;
			color: #fff !important;
			font-size:13px;
			font-weight: 600;
			border-color: #008eed;
		}
		#forgot-form .input-append.input-group{
			width: 100%;
			float: none;
		}
		input#email{
			margin-bottom: 12px;
		}
		.input-group{
		    width: 100%;
		    float: left;
		    margin-bottom: 12px;
		}
	</style>


    <section class="container-fluid user-data-modal-wrapper dedicated-login-page">
        <div class="row no-margin">
            <div class="login-page">
                <a href="{{action('SiteController@index') }}" class="modal-box-logo clearfix">
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive" alt="">
                </a>
                <div class="user-data-modal clearfix">
                	<div class="user-data-modal-header">
                    	<h1 class="clearfix">Choose new password</h1>
                    </div>
                    <div class="user-data-modal-body">
                        <div class="form-container clearfix">

                            <form method="POST" action="{{{ action('UsersController@doResetPassword') }}}" accept-charset="UTF-8">
                                <input type="hidden" name="token" value="{{{ $token }}}">
                                <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

                                <div class="input-append input-group">
                                    <!--<label for="password">{{{ Lang::get('confide::confide.password') }}}</label>-->
                                    <input class="form-control no-float" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
                                </div>
                                <div class="input-append input-group">
                                    <!--<label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>-->
                                    <input class="form-control no-float" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
                                </div>

                                @if (Session::get('error'))
                                    <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
                                @endif

                                @if (Session::get('notice'))
                                    <div class="alert">{{{ Session::get('notice') }}}</div>
                                @endif

                                <div class="form-actions form-group text-center">
                                    <button type="submit" class="blue-button large-button">{{{ Lang::get('confide::confide.forgot.submit') }}}</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop