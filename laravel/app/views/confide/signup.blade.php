@extends('layouts.login_default')
@section('content')

@if (Session::get('notice'))
    <div class="alert">{{ Session::get('notice') }}</div>
@endif
    <img id="user-data-bckgrd-img" class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/background-images/background-image.jpg">
    <span class="background-image-overlay"></span>
<section class="container-fluid user-data-modal-wrapper dedicated-login-page">
	<div class="row">
    	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4">
        	<a href="" class="modal-box-logo clearfix">
            	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive" alt="">
            </a>
            <div class="user-data-modal clearfix">
            	<h1 class="clearfix">{{ trans('site/register.register-new-account') }}</h1>
                @if(isset($extraText))
                    <p class='text-center regular-paragraph light-gray-text'>{{ $extraText }}</p>
                @endif
                <div class="login-social-buttons clearfix">
                	<a href="{{ url('login-with-facebook') }}" class="login-facebook">{{ trans ('site/register.register-with-facebook') }}</a>
                    <!--<a href="{{url('login-with-google') }}" class="login-google">{{ trans('general.google') }}</a>-->
                </div>
                <div class="or"><span class="left-line"></span>{{ trans('general.or') }}<span class="right-line"></span></div>
                <p class="regular-paragraph text-center light-gray-text">{{ trans('site/register.enter-new-email-and-password') }}</p>
                <div class="form-container clearfix">
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{Session::get('error')}}
                        </div>
                    @endif
                    <form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8">
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                        <fieldset>
                            
                            @if(isset($secondTierRegister))
                                <div class="form-group">
                                    <input class="form-control" 
                                       placeholder="{{ trans('site/register.name-placeholder') }}" 
                                   type="text" name="name" id="name" value="{{{ Input::old('name') }}}" required/>
                                </div>
                            @endif
                        
                            <div class="form-group email-field">
                                <input class="form-control instant-valid delayed-valid" 
                                   placeholder="{{ trans('site/register.email-placeholder') }}" 
                               type="email" name="email" id="email" value="{{{ Input::old('email') }}}" required/>
                            </div>
                        
                        
				        <div class="form-group password-field">
                            <input class="form-control delayed-valid instant-valid" placeholder="{{ trans('site/register.password-placeholder') }}" 
                                   type="password" name="password" id="password" required  />
                            <a href="#" class="show-password">{{ trans('site/register.show-password') }}</a>
                        </div>

                        <div class="form-actions form-group">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" class="hide" alt="">
                          <button type="submit" id="submit-button" class="large-button blue-button deactivate-button">
                          	{{ trans('site/register.create-account') }}
                          </button>
                        </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="user-data-modal-footer text-center">
                <span class="margin-right-15">{{ trans('site/register.already-have-an-account') }}</span>
                <a href="{{ action('UsersController@login') }}" class='showLogin'>{{ trans('site/register.login') }}</a>
            </div>
        </div>
    </div>
</section>

@stop