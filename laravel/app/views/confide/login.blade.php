    @extends('layouts.login_default')
    @section('content')
    <!--<img id="user-data-bckgrd-img" class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/background-images/background-image.jpg">
    <span class="background-image-overlay"></span>-->
    <section class="container-fluid user-data-modal-wrapper dedicated-login-page">
        <div class="row no-margin">
            <div class="login-page">
                <a href="" class="modal-box-logo clearfix">
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive" alt="">
                </a>
                <div class="user-data-modal clearfix">
                	<div class="user-data-modal-header">
                    	<h1 class="clearfix">{{ trans('general.login') }}</h1>
                        <div class="login-social-buttons clearfix">
                            <a href="{{ url('login-with-facebook') }}" class="login-facebook"><span>{{ trans('site/login.sign-in-with-fb') }}</span></a>
                            <!--<a href="{{url('login-with-google') }}" class="login-google">{{ trans('general.google') }}</a>-->
                        </div>
                    </div>
                    <div class="orr"><span class="left-line"></span>{{ trans('site/login.or') }}<span class="right-line"></span></div>
                    <div class="user-data-modal-body">
                        <p class="regular-paragraph text-center light-gray-text">{{ trans('general.enter-email-and-password') }}</p>
                        <div class="form-container clearfix">
                            @if(Session::has('error'))
                                <p class='alert alert-danger'> {{Session::get('error')}}</p>
                            @endif
                        <form  role="form" method="POST" action="{{{ action('UsersController@login') }}}" accept-charset="UTF-8">
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                            <fieldset>
                                <div class="form-group email-field">
                                    <input class="form-control" tabindex="1" placeholder="{{ trans('site/register.email-placeholder') }}" 
                                        data-placement="right"
                                        type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
                                </div>
                                <div class="form-group password-field">
                                    <input class="form-control" tabindex="2" pplaceholder="{{ trans('site/register.password-placeholder') }}" 
                                        type="password" name="password" id="password">
                                    <a href="{{{ action('UsersController@forgotPassword') }}}" 
                                    class="left forgot">{{ trans('site/login.forgot') }}</a>
                                </div>
                                @if (Session::get('notice'))
                                    <div class="alert">{{{ Session::get('notice') }}}</div>
                                @endif
                                <div class="form-group no-margin">
                                    <button tabindex="3" type="submit" class="blue-button large-button">
                                        {{ trans('site/login.sign-in') }}
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="user-data-modal-footer text-center">
                    <span class="margin-right-15">{{ trans('site/login.dont-have-an-account') }}</span>
                    <a href="register" class='showRegister'>{{ trans('site/login.register') }}</a>
                </div>
            </div>
        </div>
    </section>
@stop

@section('extra_js')
    <script>
        $(function(){
                $('[data-target="#loginModal"]').click();
        });
    </script>
@stop