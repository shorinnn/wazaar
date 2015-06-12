<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('page_title')
            Wazaar</title>    
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <!--<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{url('style.css')}}">
    <link rel="stylesheet" href="{{url('css/video-player.css')}}">
    <link rel="stylesheet" href="{{url('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{url('css/generic.css')}}">
    <link rel="stylesheet" href="{{url('css/select-style.css')}}">
    <link rel="stylesheet" href="{{url('css/ui-components.css')}}">
    <link rel="stylesheet" href="{{url('css/jquery.jscrollpane.css')}}">
    <link rel="stylesheet" href="{{url('plugins/slider/css/slider.css')}}">
    <link rel="stylesheet" href="{{url('css/jquery.videobackground.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{url('css/slick.css')}}">
    <link rel="stylesheet" href="{{url('css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{url('css/datepicker.css')}}">

    @yield('extra_css')
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <html class="ie8">
    <![endif]-->
    
    
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
    	<header class="container-fluid">
        		{{ View::make('layouts.shared.header') }}
        </header>
        
        @yield('content')

        <footer>
          <section class="footer-container">
            <div class="container">
              <div class="row">
                <div class="col-md-4 col-sm-12 first-col">
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/footer-logo.png" alt="Wazaar" />
                </div>
                <div class="col-md-4 col-sm-12 second-col">
                  <strong>{{trans('site/footer.phone')}}:</strong> 000 000 000 000<br/>
                  <strong>{{trans('site/footer.mail')}}:</strong> info@wazaar.com
                </div>
                <div class="col-md-4 col-sm-12 third-col">
                  <strong>Wazaar</strong><br/>
                  {{trans('site/footer.all-rights-reserved')}}<br/>
                  &copy; {{ date('Y') }}
                </div>              
              </div>
            </div>
          </section>          
        </footer>
    </div>    

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <section class="container-fluid user-data-modal-wrapper">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                            <form id='login-form' role="form" method="POST" onsubmit="return loginValidator.validate(event);"
                                  data-no-processing="1" class="ajax-formxxx" data-callback="loginValidator.callback" 
                                  data-fail-callback="loginValidator.failCallback"
                                  action="{{{ action('UsersController@login') }}}" accept-charset="UTF-8">
                            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                                <fieldset>
                                    <div class="form-group email-field">
                                        <input class="form-control"  placeholder="{{ trans('general.email-placeholder') }}" 
                                            data-placement="right" data-trigger="manual"
                                            onblur="loginValidator.emailValidate()" data-check-url="{{ action('UsersController@emailCheck') }}"
                                            type="text" name="email" id="email" value="{{{ Input::old('email') }}}" />
                                        
                                    </div>
                                    <div class="form-group password-field">
                                        <input class="form-control" placeholder="{{ trans('general.password-placeholder') }}" 
                                               data-placement="right"
                                               onblur="loginValidator.passwordValidate()" type="password" name="password" id="password" />
                                        <a href="{{{ action('UsersController@forgotPassword') }}}" 
                                        class="left forgot">{{ trans('site/login.forgot') }}</a>
                                    </div>
                                    @if (Session::get('notice'))
                                        <div class="alert">{{{ Session::get('notice') }}}</div>
                                    @endif
                                    <div class="form-group">
                                        <button  type="submit" class="blue-button large-blue-button">
                                            {{ trans('site/login.sign-in') }}
                                        </button>
                                    </div>
                                </fieldset>
                            </form>
                            </div>
                        </div>
                        <div class="user-data-modal-footer text-center">
                            <span class="margin-right-15">{{ trans('site/login.dont-have-an-account') }}</span>
                            <a href="{{action('UsersController@create')}}" class='showRegister'>Register</a>
                        </div>
                    </div>
                </div>
            </section>
          </div>
        </div>
      </div>
    </div>   
    <!-- Login Modal ends -->
 
    <!-- Register form Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-dialog">
        <div class="modal-content">
      	<div class="modal-body">
            <section class="container-fluid user-data-modal-wrapper">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <a href="" class="modal-box-logo clearfix">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive" alt="">
                        </a>
                        <div class="user-data-modal clearfix">
                            <h1 class="clearfix">{{ trans('site/register.register-new-account') }}</h1>
                            <div class="login-social-buttons clearfix">
                                <a href="{{ url('login-with-facebook') }}" class="login-facebook">{{ trans('general.register-with-facebook') }}</a>
                                <!--<a href="{{url('login-with-google') }}" class="login-google">{{ trans('general.google') }}</a>-->
                            </div>
                            <div class="or"><span class="left-line"></span>{{ trans('general.or') }}<span class="right-line"></span></div>
                            <p class="intro-paragraph text-center">{{ trans('general.enter-new-email-and-password') }}</p>
                            <div class="form-container clearfix">
                                <form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8" id="register-form"
                                     data-no-processing="1"  class="ajax-formxxx" data-callback="registerValidator.callback" 
                                     
                                     data-fail-callback="registerValidator.failCallback"  onsubmit="return registerValidator.validate(event);" />
                                    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                                    <fieldset>
                                    
                                    <div class="form-group email-field">
                                        <input class="form-control" placeholder="{{ trans('general.email-placeholder') }}" 
                                           type="email" name="email" id="email" value="{{{ Input::old('email') }}}" 
                                           data-placement="right"
                                           onblur="registerValidator.emailValidate()" data-check-url="{{ action('UsersController@emailCheck') }}"/>
                                    </div>
                                    <p class="js-error-message"></p>
                                    @if (Session::has('error'))
                                        <div class="alert alert-error alert-danger">
                                            <span>ERROR</span>
                                            {{Session::get('error')}}
                                        </div>
                                    @endif
                                    
                                    <div class="form-group password-field">
                                        <input class="form-control" placeholder="{{ trans('general.password-placeholder') }}" 
                                               type="password" name="password" id="password"
                                               onblur="registerValidator.passwordValidate()"  />
                                        <a href="#" class="show-password">{{ trans('site/register.show-password') }}</a>
                                    </div>
                                    <div class="form-actions form-group">
                                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" class="hide" alt="">
                                      <button type="submit" id="submit-button" class="large-blue-button blue-button deactivate-button">
                                        {{ trans('site/register.create-account') }}
                                      </button>
                                    </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="user-data-modal-footer text-center">
                            <span class="margin-right-15">{{ trans('site/register.already-have-an-account') }}</span>
                            <a href="{{ action('UsersController@login') }}" class='showLogin'>Login</a>
                        </div>
                    </div>
                </div>
            </section>
          </div>
        </div>
      </div>
    </div>    
    <!-- Register Modal ends -->
	@if( getenv('USE_COMMENTABLE_RESOURCES')==true )
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/js/parsley.min.js"></script>-->
        <script src="{{url("js/jquery.min.js")}}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
        <script src="{{url("js/bootstrap.min.js")}}"></script>
        <script src="{{url("js/jquery.bootstrap-growl.min.js")}}"></script>
        <script src="{{url("js/lang/parsley/".Config::get('app.locale').".js")}}" /></script>
        <script src="{{url("js/parsley.min.js")}}"></script>
        <script src="{{url("js/forms.js")}}"></script>
        <script src="{{url("js/validations.js")}}"></script>
        <script src="{{url("js/courses.js")}}"></script>
        <script src="{{url("js/cocoriumTracker.js")}}"></script>
        <script src="{{url("js/tweenmax.min.js")}}"></script>
        <script src="{{url("js/Sortable.min.js")}}"></script>
        <script src="{{url("js/pluralize.js")}}"></script>
        <script src="{{url("js/jquery.mousewheel.js")}}"></script>
        <script src="{{url("js/jquery.jscrollpane.min.js")}}"></script>
        <script src="{{url("js/main.js")}}"></script>
        <script src="{{url("js/messages.js")}}"></script>
        <script src="{{url("js/slick.js")}}"></script>
        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
        <script src="http://www.localeplanet.com/api/translate.js" /></script>
        <script src="{{url("js/lang/".Config::get('app.locale').".js")}}" /></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>
		<script src="{{url("js/jquery.tinycarousel.js")}}"></script>
        
        <script src="{{url("js/jquery.videobackground.js")}}"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
        <script src="{{url("plugins/zero-clipboard/ZeroClipboard.min.js")}}"></script>
        <script src="{{url("js/select.js")}}"></script>
        <script src="{{url("js/bootstrap-datepicker.js")}}"></script>

    @else
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="{{url("js/jquery.bootstrap-growl.min.js")}}"></script>
        <script src="{{url("js/lang/parsley/".Config::get('app.locale').".js")}}" /></script>
        <script src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/js/parsley.min.js"></script>
        <script src="{{url("js/forms.js")}}"></script>
        <script src="{{url("js/validations.js")}}"></script>
        <script src="{{url("js/courses.js")}}"></script>
        <script src="{{url("js/cocoriumTracker.js")}}"></script>
        <script src="{{url("js/Sortable.min.js")}}"></script>
        <script src="{{url("js/pluralize.js")}}"></script>
        <script src="{{url("js/jquery.mousewheel.js")}}"></script>
        <script src="{{url("js/jquery.jscrollpane.min.js")}}"></script>
        <script src="{{url("js/main.js")}}"></script>
        <script src="{{url("js/messages.js")}}"></script>
        <script src="{{url("js/slick.js")}}"></script>
        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
        <script src="http://www.localeplanet.com/api/translate.js" /></script>
        <script src="{{url("js/lang/".Config::get('app.locale').".js")}}" /></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>
		<script src="{{url("js/jquery.tinycarousel.js")}}"></script>

        <script src="{{url("js/jquery.videobackground.js")}}"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
        <script src="{{url("plugins/zero-clipboard/ZeroClipboard.min.js")}}"></script>
        <script src="{{url("js/select.js")}}"></script>
        <script src="{{url("js/bootstrap-datepicker.js")}}"></script>
        <script src="{{url("js/mailcheck.min.js")}}"></script>
        

    @endif
        <script>
             window.ParsleyValidator.setLocale("{{ Config::get('app.locale') }}");
        </script>
    @yield('extra_js')
		<script>
			$(document).ready(function() {
                            $('.showRegister').click(function(){
                                $('.modal').modal('hide');
                                $('[data-target="#registerModal"]').click();
                                return false;
                            });
                            $('.showLogin').click(function(){
                                $('.modal').modal('hide');
                                $('[data-target="#loginModal"]').click();
                                return false;
                            });

				$('#video-container').prepend('<div id="video-background" class="full-screen"></div>');
				$('#video-background').videobackground({
					videoSource: [['http://vjs.zencdn.net/v/oceans.mp4', 'video/mp4'],
						['', 'video/webm'], 
						['', 'video/ogg']], 
						controlPosition: '#bckgrd-video-overlay',
						poster: '',
						loadedCallback: function(){
						$(this).videobackground('');
					}
				});
				
				$('#instructor-editor a').click(function(e) {
				  e.preventDefault();
				  history.pushState( null, null, $(this).attr('href') );
				  $(this).tab('show')
				});
				
				
				$('#video-grid').carousel({
					interval: false,
					wrap: false
				});	
						
				$('#video-grid').on('slide.bs.carousel', function () {
				})		
				 
				$('.top-categories-slider').show().slick({
		     	  dots: false,
				  arrows: false,
				  infinite: true,
				  autoplay: true,
				  fade: false,
				  speed: 1000,
				  pauseOnHover: true,
				  autoplaySpeed: 5000,
				  slidesToShow: 3,
				  slidesToScroll: 3,
				  responsive: [
					{
					  breakpoint: 1024,
					  settings: {
						slidesToShow: 3,
						slidesToScroll: 3,
						infinite: true,
						dots: false
					  }
					},
					{
					  breakpoint: 600,
					  settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					  }
					},
					{
					  breakpoint: 480,
					  settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					  }
					}
					// You can unslick at a given breakpoint now by adding:
					// settings: "unslick"
					// instead of a settings object
				  ]		
				});		

				$('.scrollable-course-listings').show().slick({
		     	  dots: true,
				  arrows: true,
				  infinite: false,
				  autoplay: false,
				  fade: false,
				  speed: 1000,
				  pauseOnHover: true,
				  autoplaySpeed: 1000,
				  slidesToShow: 3,
				  slidesToScroll: 3,
				  responsive: [
					{
					  breakpoint: 1024,
					  settings: {
						slidesToShow: 3,
						slidesToScroll: 3,
						infinite: false,
						dots: false
					  }
					},
					{
					  breakpoint: 600,
					  settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					  }
					},
					{
					  breakpoint: 480,
					  settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					  }
					}
					// You can unslick at a given breakpoint now by adding:
					// settings: "unslick"
					// instead of a settings object
				  ]		
				});		
				
				$('.datepicker').datepicker();
				$('[data-toggle="tooltip"]').tooltip();
				$('#newModal').modal({
					keyboard: true,
					show: false	
				}); 
			});
		</script>
    	<script type="text/javascript" src="{{url('js/bootbox.js')}}"></script>

	</body>
</html>
