<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Wazaar | Home</title>    
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{url('style.css')}}">
    <link rel="stylesheet" href="{{url('css/video-player.css')}}">
    @yield('extra_css')
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <html class="ie8">
    <![endif]-->
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
                  &copy; 2014
                </div>              
              </div>
            </div>
          </section>          
        </footer>
    </div>    
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/js/parsley.min.js"></script>-->
    <script src="{{url("js/jquery.min.js")}}"></script>
    <script src="{{url("js/bootstrap.min.js")}}"></script>
    <script src="{{url("js/parsley.min.js")}}"></script>
    <script src="{{url("js/main.js")}}"></script>
    <script src="{{url("js/forms.js")}}"></script>
    <script src="{{url("js/validations.js")}}"></script>
    <script src="{{url("js/courses.js")}}"></script>
    <script src="{{url("js/cocoriumTracker.js")}}"></script>
    <script src="{{url("js/tweenmax.min.js")}}"></script>
    <script src="{{url("js/Sortable.min.js")}}"></script>
    <!--<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>-->
    @yield('extra_js')
	</body>
</html>
