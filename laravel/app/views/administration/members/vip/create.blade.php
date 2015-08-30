@extends('layouts.default')
@section('content')	
    
@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif
<style>
     .overlay-loading{
        position:absolute;
        margin-left:auto;
        margin-right:auto;
        left:0;
        right:0;
        z-index: 10;
        width:32px;
        height:32px;
        background-image:url('http://www.mytreedb.com/uploads/mytreedb/loader/ajax_loader_blue_32.gif');
    }
</style>
<div class='row'>
    <div class='col-lg-6'>
        <h1>Create Super VIP account </h1>
        @if(isset($err))
            <div class='alert alert-warning alert-danger'>
                {{$err}}
            </div>
        @endif
        @if(isset($success))
            <div class='alert alert-success'>
                {{$success}}
            </div>
        @endif
<form method="POST" action="{{ action('MembersController@storeVip') }}" accept-charset="UTF-8">
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                        <input type="hidden" name="register_affiliate" value="1" />
                        <fieldset>
                            <div class="form-group ">
                                <input class="form-control" 
                                       placeholder="{{ trans('site/register.last-name-placeholder') }}" 
                                       type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name') }}}" required/>
                            </div>
                            <div class="form-group ">
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

@stop