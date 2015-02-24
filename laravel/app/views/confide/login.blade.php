    @extends('layouts.default')
    @section('content')
    <section class="container-fluid login-page top-blue-section">
        <div class="row">
            <div class="col-md-12">
                <h1>Login</h1>
            </div>
        </div>
	</section>
    <div class="container login-page">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url('login-with-facebook') }}" class="fb-button social-button">Sign in with Facebook</a>
                <a href="{{url('login-with-google') }}" class="google-button social-button">Sign in with Google</a>
                <p class="or">Or</p>
            </div>
        </div>
    </div>

    <form id='login-form' role="form" method="POST" action="{{{ action('UsersController@login') }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group email-input-container">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}}</label>
            <input class="form-control" tabindex="1" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-group password-input-container">
        <label for="password">
            {{{ Lang::get('confide::confide.password') }}}
        </label>
        <input class="form-control" tabindex="2" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        @if (Session::get('error'))
            <div class="alert alert-error alert-danger"><span>ERROR</span>{{{ Session::get('error') }}}</div>
        @endif

        <p class="help-block forgot-password">
            <a href="{{{ action('UsersController@forgotPassword') }}}">{{{ Lang::get('confide::confide.login.forgot_password') }}}</a>
        </p>
        </div>
        <div class="checkbox remember-me">
            <label for="remember">
                <input type="hidden" name="remember" value="0">
                <input tabindex="4" type="checkbox" name="remember" id="remember" value="1"> {{{ Lang::get('confide::confide.login.remember') }}}
            </label>
        </div>
        @if (Session::get('notice'))
            <div class="alert">{{{ Session::get('notice') }}}</div>
        @endif
        <div class="form-group login-button">
            <button tabindex="3" type="submit" class="btn btn-default">{{{ Lang::get('confide::confide.login.submit') }}}</button>
        </div>
    </fieldset>
</form>
@stop