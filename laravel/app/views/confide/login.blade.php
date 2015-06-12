    @extends('layouts.login_default')
    @section('content')
    
    <section class="container-fluid login-wrapper dedicated-login-page">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4">
                <a href="" class="modal-box-logo clearfix">
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive" alt="">
                </a>
                <div class="login-form-container clearfix">
                    <h1 class="clearfix">{{ trans('site/login.login-to-account') }}</h1>
                    <div class="login-social-buttons clearfix">
                        <a href="{{ url('login-with-facebook') }}" class="login-facebook">{{ trans('general.login-with-facebook') }}</a>
                        <!--<a href="{{url('login-with-google') }}" class="login-google">{{ trans('general.google') }}</a>-->
                    </div>
                    <div class="or"><span class="left-line"></span>{{ trans('general.or') }}<span class="right-line"></span></div>
                    <p class="intro-paragraph text-center">{{ trans('general.enter-email-and-password') }}</p>
                    <div class="login-form clearfix">
                    <form id='login-form' role="form" method="POST" action="{{{ action('UsersController@login') }}}" accept-charset="UTF-8">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                    	<fieldset>
                            <div class="form-group email-field input-error">
                                <input class="form-control" tabindex="1" placeholder="{{ trans('general.email-placeholder') }}" 
                                    data-toggle="tooltip" data-placement="right" title="Did you mean...?" 
                                    type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
                                <p class="hide">Some error messages here!</p>
                            </div>
                            <div class="form-group password-field">
                                <input class="form-control" tabindex="2" placeholder="{{ trans('general.password-placeholder') }}" 
                                    type="password" name="password" id="password">
			                	<a href="{{{ action('UsersController@forgotPassword') }}}" 
                                class="left forgot">{{ trans('site/login.forgot') }}</a>
                            </div>
                            @if (Session::get('notice'))
                                <div class="alert">{{{ Session::get('notice') }}}</div>
                            @endif
                            <div class="form-group">
                                <button tabindex="3" type="submit" class="blue-button large-blue-button">
                                	{{ trans('site/login.sign-in') }}
                                </button>
                            </div>
                        </fieldset>
                    </form>
                  	</div>
                </div>
                <div class="login-form-footer text-center">
                    <span class="margin-right-15">{{ trans('site/login.dont-have-an-account') }}</span>
                    <a href="#">Register</a>
                </div>
            </div>
        </div>
    </section>

    <!--<section class="container-fluid login-page top-blue-section">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ trans('general.login') }}</h1>
            </div>
        </div>
	</section>
    <div class="container login-page">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url('login-with-facebook') }}" class="fb-button social-button">{{ trans('site/login.sign-in-with-fb') }}</a>
                <a href="{{url('login-with-google') }}" class="google-button social-button">{{ trans('site/login.sign-in-with-google') }}</a>
                <p class="or">{{ trans('site/login.or') }}</p>
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
</form>-->
@stop