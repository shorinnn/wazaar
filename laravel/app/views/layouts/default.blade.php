<!doctype html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title') Wazaar</title>    
    
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    
    @if( App::environment() == 'PPProduction' || Input::has('use-gulp') )
        <link rel="stylesheet" href="{{ url('css-assets/'. asset_path('all.min.css') ) }}" />
    @else
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">-->
        <!--<link href='//fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>-->
        <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{url('css/video-player.css')}}">
        <link rel="stylesheet" href="{{url('css/style.css')}}">
        <link rel="stylesheet" href="{{url('css/dashboard.css')}}">
        <link rel="stylesheet" href="{{url('css/generic.css')}}">
        <link rel="stylesheet" href="{{url('css/select-style.css')}}">
        <link rel="stylesheet" href="{{url('css/ui-components.css')}}">
        <link rel="stylesheet" href="{{url('css/jquery.jscrollpane.css')}}">
        <link rel="stylesheet" href="{{url('css/jquery.custom-scrollbar.css')}}">
        <link rel="stylesheet" href="{{url('plugins/slider/css/slider.css')}}">
        <link rel="stylesheet" href="{{url('css/jquery.videobackground.css')}}">
        <link rel="stylesheet" href="{{url('css/slick.css')}}">
        <link rel="stylesheet" href="{{url('css/slick-theme.css')}}">
        <link rel="stylesheet" href="{{url('css/datepicker.css')}}">
        <link rel="stylesheet" href="{{url('css/bootstrap-datetimepicker.css')}}">
        <link rel="Stylesheet" type="text/css" href="{{ url('css/smoothDivScroll.css') }}" />
    @endif

    @yield('extra_css')
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <html class="ie8">
    <![endif]-->
    

    
</head>
<body>    
    @yield('affiliate-toolbar')

    <div id="wrapper">
    	<header class="container-fluid">
           
        		{{ View::make('layouts.shared.header') }}
        </header>
        @yield('content')

        <footer>
          <section class="footer-container">
            <div class="container">
              <div class="row no-margin">
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center-mobile">
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/footer-logo.png" alt="Wazaar" />
                  <p>&copy; Wazaar {{ date('Y') }}</p>
                </div>
                <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 margin-bottom-20">
					<?php echo Flatten::section('footer-categories-link', 10, function ()  { ?>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <h5>{{ trans('general.courses') }}</h5>
                            <ul>
                                @foreach( CourseCategory::has('allCourses')->whereRaw('id % 2 = 0')->get() as $cat)
                                    <li>
                                            <a href="{{ action('CoursesController@category', $cat->slug) }}">{{ $cat->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <h5>&nbsp;</h5>
                            <ul>
                                @foreach( CourseCategory::has('allCourses')->whereRaw('id % 2 != 0')->get() as $cat)
                                    <li>
                                            <a href="{{ action('CoursesController@category', $cat->slug)  }}">{{ $cat->name }}</a>
                                    </li>
                                @endforeach
                            </ul>                    
                        </div>
                    <?php });?>
                
                </div>
                <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 margin-bottom-20">
                    <h5>{{ trans('footer.about') }}</h5>
                    <ul>
 						<!--<li>
                            <a href="#">{{ trans('footer.company') }}</a>
                        </li>-->
                        <li>
                            <a href="{{ action('SiteController@about') }}">特定商取引法に関する表示 </a>
                        </li>
                        <li>
                            <a href="{{ action('SiteController@privacyPolicy') }}">{{ trans('general.privacy-policy') }}</a>
                        </li>
                    </ul>                        
        
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 margin-bottom-20 text-center-mobile">
                    <h5>{{ trans('footer.get-in-touch') }}</h5>
                    <p><!--電話番号：-->03-6206-8396　</p>
                    <a href="//wazaar.co.jp/contact/">お問い合わせ</a>
                    <p><!--{{trans('site/footer.mail')}}:info@wazaar.comメールアドレス：-->contact@minkare.jp</p>  
                    <div class="social-icons">
                        <a href="#" class="inline-block"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="inline-block"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="inline-block"><i class="fa fa-rss"></i></a>
                    </div>                      
        
                </div>
                <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2 margin-bottom-20 text-center-mobile">
                        <h5>アフィリエイター向け</h5>
                        <a href="{{action('AffiliateController@create')}}">新規登録</a>
                        <a href="{{ action('AffiliateController@login') }}">ログイン</a>  
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
                <div class="row no-margin">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                        <a href="" class="modal-box-logo clearfix">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive" alt="">
                        </a>
                        <div class="user-data-modal clearfix">
                        	<div class="user-data-modal-header">
                                <h1 class="clearfix">{{ trans('site/login.login-to-account') }}</h1>
                                <div class="login-social-buttons clearfix">
                                    <a href="{{ url('login-with-facebook') }}" class="login-facebook">{{ trans('general.login-with-facebook') }}</a>
                                    <!--<a href="{{url('login-with-google') }}" class="login-google">{{ trans('general.google') }}</a>-->
                                </div>
                            </div>
                            <div class="orr"><span class="left-line"></span>{{ trans('general.or') }}<span class="right-line"></span></div>
                            <div class="user-data-modal-body">
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
                                        <div class="form-group no-margin">
                                            <button  type="submit" class="blue-button large-button">
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
                <div class="row no-margin">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                        <a href="" class="modal-box-logo clearfix">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive" alt="">
                        </a>
                        <div class="user-data-modal clearfix">
                        	<div class="user-data-modal-header">
                                <h1 class="clearfix">{{ trans('site/register.register-new-account') }}</h1>
                                <div class="login-social-buttons clearfix">
                                    <a href="{{ url('login-with-facebook') }}" class="login-facebook">{{ trans('general.register-with-facebook') }}</a>
                                    <!--<a href="{{url('login-with-google') }}" class="login-google">{{ trans('general.google') }}</a>-->
                                </div>
                            </div>
                            <div class="orr"><span class="left-line"></span>{{ trans('general.or') }}<span class="right-line"></span></div>
                            <div class="user-data-modal-body">
                                <p class="intro-paragraph text-center">{{ trans('general.enter-new-email-and-password') }}</p>
                                <div class="form-container clearfix">
                                    <form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8" id="register-form"
                                         data-no-processing="1"  class="ajax-formxxx" data-callback="registerValidator.callback" 
                                         
                                         data-fail-callback="registerValidator.failCallback"  onsubmit="return registerValidator.validate(event);" />
                                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                                        <fieldset>
                                            
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="Last Name" type="text" name="last_name" id="last_name" value="" required>
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="First Name" type="text" name="first_name" id="first_name" value="" required>
                                                </div>
                                        
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
                                        <div class="form-actions form-group no-margin">
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" class="hide" alt="">
                                          <button type="submit" id="submit-button" class="large-button blue-button deactivate-button">
                                            {{ trans('site/register.create-account') }}
                                          </button>
                                        </div>
                                        </fieldset>
                                    </form>
                                </div>
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


    @include('payment.paymentModal')

    @if( App::environment() == 'PPProduction' || Input::has('use-gulp') )
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
        <script src="//www.localeplanet.com/api/translate.js" /></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
        <script src="{{url("js-assets/" . asset_path('core.min.js') ) }}"></script>
        <script src="{{url("js/jquery.mousewheel.js")}}"></script>
        <script src="{{url("js/jquery.jscrollpane.min.js")}}"></script>
    @else
        <!--<script src="{{ url("assets/js/". asset_path('core.min.js') )}}"></script>-->
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
        <script src="//www.localeplanet.com/api/translate.js" /></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
        
        
        <script src="{{url("js/jquery.bootstrap-growl.min.js")}}"></script>
        <script src="{{url("js/lang/parsley/".Config::get('app.locale').".js")}}" /></script>
        <script src="{{url("js/parsley.min.js")}}"></script>
        <script src="{{url("js/forms.js")}}"></script>
        <script src="{{url("js/responsive-paginate.js")}}"></script>
        <script src="{{url("js/validations.js")}}"></script>
        <script src="{{url("js/courses.js")}}"></script>
        <script src="{{url("js/cocoriumTracker.js")}}"></script>
        <script src="{{url("js/Sortable.min.js")}}"></script>
        <script src="{{url("js/pluralize.js")}}"></script>
        <script src="{{url("js/jquery.mousewheel.js")}}"></script>
        <script src="{{url("js/jquery.jscrollpane.min.js")}}"></script>
        <!-- <script src="{{url("js/jquery.custom-scrollbar.js")}}"></script> -->
        <script src="{{url("js/autogrow.min.js")}}"></script>
        <script src="{{url("js/jquery.autogrowtextarea.js")}}"></script>
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
        <script type="text/javascript" src="{{url('js/jquery.maskedinput.min.js')}}"></script>
        <script type="text/javascript" src="{{url('js/moment.min.js')}}"></script>


    @endif


    {{-- Payment Scripts --}}
    {{--<script type="text/javascript" src="https://js.stripe.com/v2/"></script>--}}
    <script type="text/javascript" src="{{url('js/cocorium.payment-max.js')}}"></script>

    @yield('extra_js')
		<script type="text/javascript">
                window.reloadConfirm = false;

                         window.ParsleyValidator.setLocale("{{ Config::get('app.locale') }}");
                         _.setTranslation( js_translation_map_{{ Config::get('app.locale') }} );
			$(document).ready(function() {
                //$('video,audio').mediaelementplayer();
				$('.popular-courses-carousel').show();
                jQuery(window).bind('beforeunload', function(e) {

                    var message =  _("If you leave this page, you'll miss uploading file, do you wanna leave now?");
                    e.returnValue = message;
                    if (window.reloadConfirm){
                        //window.reloadConfirm = false;
                        return message;
                    }
					
					           
			});
								 
				$('[data-toggle="popover"]').popover();

				$('.showRegister').click(function(){
					$('.modal').modal('hide');
					$('[data-target="#registerModal"]').first().click();
					return false;
				});
				$('.showLogin').click(function(){
					$('.modal').modal('hide');
					$('[data-target="#loginModal"]').first().click();
					return false;
				});

				$('#video-container').prepend('<div id="video-background" class="full-screen"></div>');
				$('#video-background').videobackground({
					videoSource: [['//vjs.zencdn.net/v/oceans.mp4', 'video/mp4'],
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
				
				$('.table-pagination > div').removeClass('pagination-container');
				
				$('#video-grid').on('slide.bs.carousel', function () {
				})		
				
				$('.datepicker').datepicker();
				$('[data-toggle="tooltip"]').tooltip();
				$('#newModal').modal({
					keyboard: true,
					show: false	
				}); 
				
				$(".pagination-container").rPage();

				/*$('body').on('click','textarea',function(){
					var opts = {
						animate: true
						, cloneClass: 'faketextarea'
					};
					$('textarea').autogrow(opts);
					});
				})*/
					
				$("textarea").autoGrow();
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
