@extends('layouts.login_default')
@section('content')

@if (Session::get('notice'))
    <div class="alert">{{ Session::get('notice') }}</div>
@endif
    <!--<img id="user-data-bckgrd-img" class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/background-images/background-image.jpg">
    <span class="background-image-overlay"></span>-->
<section class="container-fluid user-data-modal-wrapper dedicated-login-page">
	<div class="row">
    	<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-sm-offset-2 col-md-offset-3 col-lg-offset-4">
        	<a href="" class="modal-box-logo clearfix">
            	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive" alt="">
            </a>
            <div class="user-data-modal clearfix">
                    <h1 class="clearfix">{{ trans('general.register-affiliate') }}</h1>
                
                <p class="regular-paragraph text-center light-gray-text">
                    ワザールで１０年に一度の大チャンスを掴みたい人は今すぐご登録をお願いします！
                </p>
                <div class="form-container clearfix">
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{Session::get('error')}}
                        </div>
                    @endif
                    <form method="POST" action="{{ action('AffiliateController@store') }}" accept-charset="UTF-8">
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                        <input type="hidden" name="register_affiliate" value="1" />
                        <fieldset>
                            
                            
                                <div class="form-group last_name_input left">
                                    <input class="form-control" 
                                       placeholder="{{ trans('site/register.last-name-placeholder') }}" 
                                   type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name') }}}" required/>
                                </div>
                                <div class="form-group first_name_input left">
                                    <input class="form-control" 
                                       placeholder="{{ trans('site/register.first-name-placeholder') }}" 
                                   type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name') }}}" required/>
                                </div>
                        
                            
                        
                            <div class="form-group email-field clear">
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
                <a href="{{ action('AffiliateController@login') }}" class='showLogin'>{{ trans('site/register.login') }}</a>
            </div>
        </div>
    </div>
</section>

@stop