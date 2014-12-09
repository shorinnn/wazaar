@extends('layouts.default')
@section('content')	

{{trans('acl.google_email_already_registered')}}
@if (Session::get('error'))
    <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
@endif

@if (Session::get('notice'))
    <div class="alert">{{{ Session::get('notice') }}}</div>
@endif

<form role="form" method="POST" action="{{{ action('UsersController@doLinkGooglePlus') }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group">
        <label for="password">
            {{{ Lang::get('confide::confide.password') }}}
        </label>
        <input class="form-control" tabindex="2" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
       
        <div class="form-group">
            <button tabindex="3" type="submit" class="btn btn-default">{{{ Lang::get('acl.link') }}}</button>
        </div>
    </fieldset>
</form>
{{ trans('acl.forgot_password') }}
<form role="form" method="POST" action="{{{ action('UsersController@confirmationCode') }}}" accept-charset="UTF-8">
    <fieldset>
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <div class="form-group">
        <input type="hidden" name="social_network" value="google" />
        <button tabindex="3" type="submit" class="btn btn-default">{{{ trans('acl.send') }}}</button>
    </div>
    </fieldset>
</form>
@stop