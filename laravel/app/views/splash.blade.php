
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="GWDwOY6lIKjc0pV3Pk3uK9OlW8C-qsmfdHG8sziokhw" />
	<title>Wazaar</title>    
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="splash/style.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <html class="ie8">
    <![endif]-->
    
</head>
<body>
    <div id="wrapper">
        <a style='position:absolute; right:0px; color:white; padding:5px; font-size:10px' href="{{ action('SiteController@privacyPolicy') }}"> {{ trans('general.privacy-policy') }}</a>
    	<div id="container">
        	<div id="logo" class="clear">
                    <img src="splash/logo.png" alt="">
            </div>
<!--            <div class="row">
            	<div class="col-xs-10 col-sm-8 col-md-6 col-lg-4 col-xs-offset-1 col-sm-offset-2 col-md-offset-3 col-lg-offset-4">
                	<center>
                        <div class="video-container">
                            <iframe width="640" height="360" src="https://www.youtube.com/embed/FNeLYmf4drs?rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </center>
            	</div>
            </div>-->
            <!--<h1>Coming this July!</h1>-->
            <h1>2015年9月10日OPEN</h1>
            
            <!--<p>We will help you learn new amazing things! Our learning platform will be so simple and accessible to everyone!</p>-->
            <p>技の動画フリーマーケット、ワザールでは、あなたの技を動画にして、500円から販売することができます！あなたの技が日本を変える！ワザールまもなく始まります！</p>
<!--            <div class="publisher-login">
            	<a href="{{ action('CoursesController@myCourses') }}">Publisher Login</a>
            </div>-->
        	<div class="top-buttons">
                @if(Input::has('pub'))
                    <a href="{{ action('UsersController@create') }}/account/instructor" class="blue-button button large-button register">新規登録</a>
                @else
                    <a href="{{ action('UsersController@create') }}" class="blue-button button large-button register">新規登録</a>
                @endif
            </div>
        	<div class="top-buttons">
            	<a href="{{ action('UsersController@login') }}" class="login button large-button">ログイン</a>
            </div>
        	<div class="top-buttons">
            	<a href="http://affiliates.wazaar.jp/login" class="login button large-button" style="margin-bottom:130px">アフィリエイター用ログイン</a>
            </div>
        </div>         	
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
		/*var bodyHeight = $("body").height() + 20;
		var vwptHeight = $(window).height();
		var contentWrapper = $('#wrapper');
		contentWrapper.css('height', bodyHeight);
		console.log(bodyHeight);*/
	</script>  
        
         <script>
                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                    ga('create', 'UA-65168894-1', 'auto');
                    ga('send', 'pageview');
                </script>
  
</body>
</html>
