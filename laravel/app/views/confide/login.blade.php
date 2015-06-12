    @extends('layouts.login_default')
    @section('content')
    
    <section class="container-fluid user-data-modal-wrapper dedicated-login-page">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4">
                <a href="" class="modal-box-logo clearfix">
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive" alt="">
                </a>
                <div class="user-data-modal clearfix">
                    <h1 class="clearfix">{{ trans('site/login.login-to-account') }}</h1>
                    <div class="login-social-buttons clearfix">
                        <a href="{{ url('login-with-facebook') }}" class="login-facebook">{{ trans('general.login-with-facebook') }}</a>
                        <!--<a href="{{url('login-with-google') }}" class="login-google">{{ trans('general.google') }}</a>-->
                    </div>
                    <div class="or"><span class="left-line"></span>{{ trans('general.or') }}<span class="right-line"></span></div>
                    <p class="intro-paragraph text-center">{{ trans('general.enter-email-and-password') }}</p>
                    <div class="form-container clearfix">
                        @if(Session::has('error'))
                            <p class='alert alert-danger'> {{Session::get('error')}}</p>
                        @endif
                    <form  role="form" method="POST" action="{{{ action('UsersController@login') }}}" accept-charset="UTF-8">
                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                    	<fieldset>
                            <div class="form-group email-field">
                                <input class="form-control" tabindex="1" placeholder="{{ trans('general.email-placeholder') }}" 
                                    data-placement="right"
                                    type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
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
                <div class="user-data-modal-footer text-center">
                    <span class="margin-right-15">{{ trans('site/login.dont-have-an-account') }}</span>
                    <a href="register" class='showRegister'>Register</a>
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