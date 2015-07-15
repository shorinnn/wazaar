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
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{url('css/slick.css')}}">
    <link rel="stylesheet" href="{{url('css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{url('css/datepicker.css')}}">
	<style>
		html{
			height: 100%;
			background: url('https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/background-images/background-image.jpg') no-repeat center center;
			background-size: cover;	
		}
		
		body{
			min-height: 100%;
			background-color: rgba(24, 34, 43, 0.9);
			padding-bottom: 15%;
		}

		@media (max-width:402px){
			html{
				height: 100%;
				background: none;
			}
			
			body{
				min-height: 100%;
				background-color: transparent;
				padding-bottom: 15%;
			}

			.user-data-modal-wrapper{
				background: url('https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/background-images/background-image.jpg') no-repeat center center;
				background-size: cover;	
			}
			
			.user-data-modal-wrapper > .row{
				background-color: rgba(24, 34, 43, 0.9);
				padding-bottom: 15%;
			}
		}

	</style>
    @yield('extra_css')
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <html class="ie8">
    <![endif]-->
    
    
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper" class="clearfix user-authenticated-wrapper">
        
        @yield('content')

    </div>    

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
              _.setTranslation( js_translation_map_{{ Config::get('app.locale') }} );
        </script>
    @yield('extra_js')
    	<script type="text/javascript" src="{{url('js/bootbox.js')}}"></script>

	</body>
</html>
