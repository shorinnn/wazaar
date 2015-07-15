<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('page_title') Wazaar</title>    
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <!--<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{url('css/style.css')}}">
    <link rel="stylesheet" href="{{url('css/video-player.css')}}">
    <link rel="stylesheet" href="{{url('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{url('css/generic.css')}}">
    <link rel="stylesheet" href="{{url('css/select-style.css')}}">
    <link rel="stylesheet" href="{{url('css/ui-components.css')}}">
    <link rel="stylesheet" href="{{url('css/jquery.jscrollpane.css')}}">
    <link rel="stylesheet" href="{{url('plugins/slider/css/slider.css')}}">
    <link rel="stylesheet" href="{{url('css/jquery.videobackground.css')}}">
    <link rel="stylesheet" href="{{url('css/slick.css')}}">
    <link rel="stylesheet" href="{{url('css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{url('css/datepicker.css')}}">
    <link rel="stylesheet" href="{{url('css/bootstrap-datetimepicker.css')}}">
    <link rel="Stylesheet" type="text/css" href="{{ url('css/smoothDivScroll.css') }}" />

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
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/footer-logo.png" alt="Wazaar" />
                  <p>&copy; Wazaar {{ date('Y') }}</p>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                	<div class="row">
                    	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        	<!--<h5>Courses</h5>
                            <ul>
                            	<li>
                                	<a href="#">Data Science</a>
                                </li>
                            	<li>
                                	<a href="#">Development</a>
                                </li>
                            	<li>
                                	<a href="#">Business</a>
                                </li>
                            	<li>
                                	<a href="#">IT & Software</a>
                                </li>
                            	<li>
                                	<a href="#">Office Productivity</a>
                                </li>
                            </ul>-->
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        	<!--<h5>&nbsp;</h5>
                            <ul>
                            	<li>
                                	<a href="#">Design</a>
                                </li>
                            	<li>
                                	<a href="#">Marketing</a>
                                </li>
                            	<li>
                                	<a href="#">Lifestyle</a>
                                </li>
                            	<li>
                                	<a href="#">Photography</a>
                                </li>
                            	<li>
                                	<a href="#">Health & Fitness</a>
                                </li>
                            </ul>  -->                      
                        </div>
                    </div>
                  <!--{{trans('site/footer.all-rights-reserved')}}<br/>
                  &copy; {{ date('Y') }}-->
                </div>              
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                	<div class="row">
                    	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                        	<!--<h5>ABOUT</h5>
                            <ul>
                            	<li>
                                	<a href="#">Company</a>
                                </li>
                            	<li>
                                	<a href="#">Terms of Use</a>
                                </li>
                            	<li>
                                	<a href="#">Privacy Policy</a>
                                </li>
                            </ul>   -->                     
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-8 col-lg-8">
                        	<!--<h5>GET IN TOUCH</h5>-->
                            <p>電話番号：03-6206-8396　</p>
                            <p><!--{{trans('site/footer.mail')}}:info@wazaar.com-->メールアドレス：contact@wazaar.jp</p>                        
                        </div>
                    </div>
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
                                        <button  type="submit" class="blue-button large-button">
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
        <!--<script src="{{url("js/select.js")}}"></script>-->
        <script src="{{url("js/bootstrap-datepicker.js")}}"></script>
        <script type="text/javascript" src="{{url('js/bootbox.js')}}"></script>
        <script type="text/javascript" src="{{url('js/jquery.countdown.min.js')}}"></script>

    @else
        <!--<script src="{{ url("assets/js/". asset_path('core.min.js') )}}"></script>-->
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
        <script src="http://www.localeplanet.com/api/translate.js" /></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
        
        
        <script src="{{url("js/jquery.bootstrap-growl.min.js")}}"></script>
        <script src="{{url("js/lang/parsley/".Config::get('app.locale').".js")}}" /></script>
        <script src="{{url("js/parsley.min.js")}}"></script>
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
        <script src="{{url("js/lang/".Config::get('app.locale').".js")}}"></script>
        <script src="{{url("js/jquery.tinycarousel.js")}}"></script>
        <script src="{{url("js/jquery.videobackground.js")}}"></script>
        <script src="{{url("plugins/zero-clipboard/ZeroClipboard.min.js")}}"></script>
        <!--<script src="{{url("js/select.js")}}"></script>-->
        <script src="{{url("js/bootstrap-datepicker.js")}}"></script>
        <script src="{{url("js/mailcheck.min.js")}}"></script>
        <script type="text/javascript" src="{{url('js/bootbox.js')}}"></script>
        <script type="text/javascript" src="{{url('js/jquery.countdown.min.js')}}"></script>
        

    @endif
    
    @yield('extra_js')
		<script type="text/javascript">
            window.reloadConfirm = false;

                         window.ParsleyValidator.setLocale("{{ Config::get('app.locale') }}");
                         _.setTranslation( js_translation_map_{{ Config::get('app.locale') }} );
			$(document).ready(function() {
				$('.popular-courses-carousel').show();
                jQuery(window).bind('beforeunload', function(e) {

                    var message =  _("If you leave this page, you'll miss uploading file, do you wanna leave now?");
                    e.returnValue = message;
                    if (window.reloadConfirm){
                        //window.reloadConfirm = false;
                        return message;
                    }
                });


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
				 
			
				
				$('.datepicker').datepicker();
				$('[data-toggle="tooltip"]').tooltip();
				$('#newModal').modal({
					keyboard: true,
					show: false	
				}); 
			});
		</script>
    	
            <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/175711/delaunay.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/TweenMax.min.js"></script>
            
            @if( App::environment() == 'production' )
                <script>
                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                    ga('create', 'UA-65168894-1', 'auto');
                    ga('send', 'pageview');
                </script>
            @endif
	</body>
</html>
