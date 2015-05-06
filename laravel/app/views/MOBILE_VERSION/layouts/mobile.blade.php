<!doctype html>
<html lang="en">
<!-- mobile layout -->
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('page_title')
            Wazaar</title>    
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
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
    <link rel="stylesheet" href="{{url('css/mobile.css')}}">

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
    @if( getenv('USE_COMMENTABLE_RESOURCES')==true )
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/js/parsley.min.js"></script>-->
        <script src="../../layouts/{{url("js/jquery.min.js")}}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
        <script src="../../layouts/{{url("js/bootstrap.min.js")}}"></script>
        <script src="../../layouts/{{url("js/jquery.bootstrap-growl.min.js")}}"></script>
        <script src="{{url("js/lang/parsley/".Config::get('app.locale').".js")}}" /></script>
        <script src="../../layouts/{{url("js/parsley.min.js")}}"></script>
        <script src="../../layouts/{{url("js/forms.js")}}"></script>
        <script src="../../layouts/{{url("js/validations.js")}}"></script>
        <script src="../../layouts/{{url("js/courses.js")}}"></script>
        <script src="../../layouts/{{url("js/cocoriumTracker.js")}}"></script>
        <script src="../../layouts/{{url("js/tweenmax.min.js")}}"></script>
        <script src="../../layouts/{{url("js/Sortable.min.js")}}"></script>
        <script src="../../layouts/{{url("js/pluralize.js")}}"></script>
        <script src="../../layouts/{{url("js/jquery.mousewheel.js")}}"></script>
        <script src="../../layouts/{{url("js/jquery.jscrollpane.min.js")}}"></script>
        <script src="../../layouts/{{url("js/main.js")}}"></script>
        <script src="../../layouts/{{url("js/messages.js")}}"></script>
        <script src="../../layouts/{{url("js/slick.js")}}"></script>
        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
        <script src="http://www.localeplanet.com/api/translate.js" /></script>
        <script src="{{url("js/lang/".Config::get('app.locale').".js")}}" /></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>
		<script src="../../layouts/{{url("js/jquery.tinycarousel.js")}}"></script>
        
        <script src="../../layouts/{{url("js/jquery.videobackground.js")}}"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
        <script src="../../layouts/{{url("plugins/zero-clipboard/ZeroClipboard.min.js")}}"></script>
        <script src="../../layouts/{{url("js/select.js")}}"></script>
        <script src="../../layouts/{{url("js/bootstrap-datepicker.js")}}"></script>

    @else
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="../../layouts/{{url("js/jquery.bootstrap-growl.min.js")}}"></script>
        <script src="{{url("js/lang/parsley/".Config::get('app.locale').".js")}}" /></script>
        <script src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/js/parsley.min.js"></script>
        <script src="../../layouts/{{url("js/forms.js")}}"></script>
        <script src="../../layouts/{{url("js/validations.js")}}"></script>
        <script src="../../layouts/{{url("js/courses.js")}}"></script>
        <script src="../../layouts/{{url("js/cocoriumTracker.js")}}"></script>
        <script src="../../layouts/{{url("js/Sortable.min.js")}}"></script>
        <script src="../../layouts/{{url("js/pluralize.js")}}"></script>
        <script src="../../layouts/{{url("js/jquery.mousewheel.js")}}"></script>
        <script src="../../layouts/{{url("js/jquery.jscrollpane.min.js")}}"></script>
        <script src="../../layouts/{{url("js/main.js")}}"></script>
        <script src="../../layouts/{{url("js/messages.js")}}"></script>
        <script src="../../layouts/{{url("js/slick.js")}}"></script>
        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
        <script src="http://www.localeplanet.com/api/translate.js" /></script>
        <script src="{{url("js/lang/".Config::get('app.locale').".js")}}" /></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>
		<script src="../../layouts/{{url("js/jquery.tinycarousel.js")}}"></script>

        <script src="../../layouts/{{url("js/jquery.videobackground.js")}}"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
        <script src="../../layouts/{{url("plugins/zero-clipboard/ZeroClipboard.min.js")}}"></script>
        <script src="../../layouts/{{url("js/select.js")}}"></script>
        <script src="../../layouts/{{url("js/bootstrap-datepicker.js")}}"></script>
        

    @endif
        <script>
             window.ParsleyValidator.setLocale("{{ Config::get('app.locale') }}");
        </script>
    @yield('extra_js')
		<script>
			$(document).ready(function() {

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
				$('.collapse').collapse();
				
				$("[data-toggle='collapse']").click( function(e) {
				var next_of_kin = "[data-parent='" + e.target.id + "']";
					$(next_of_kin).toggleClass('close');
				});
			});
		</script>
	</body>
</html>
