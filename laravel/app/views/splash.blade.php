
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Wazaar</title>    
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
    	<div id="container">
        	<div class="top-buttons">
            	<a href="{{ action('UsersController@login') }}" class="login button large-button">ログイン</a>
                <a href="{{ action('UsersController@create') }}" class="blue-button button large-button register">サインアップ</a>
            </div>
        	<div id="logo">
            	<img src="splash/logo.png" alt="">
            </div>
            <!--<h1>Coming this July!</h1>-->
            <h1>2015年7月下旬OPEN</h1>
            <!--<p>We will help you learn new amazing things! Our learning platform will be so simple and accessible to everyone!</p>-->
            <p>技の動画フリーマーケット、ワザールでは、あなたの技を動画にして、500円から販売することができます！あなたの技が日本を変える！ワザールまもなく始まります！</p>
<!--            <div class="publisher-login">
            	<a href="{{ action('CoursesController@myCourses') }}">Publisher Login</a>
            </div>-->
        </div>         	
    </div>    
</body>
</html>
