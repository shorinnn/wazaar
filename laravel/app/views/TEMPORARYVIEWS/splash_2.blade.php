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

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <html class="ie8">
    <![endif]-->


    <style>
        body{
            background-color: #ffbe15;
        }
        .splash_2_header{
            width: 100%;
            padding: 12px;
            background: #18222b;
            text-align: center;
        }
        .splash_2_header > div{
            display: inline-block;
            max-width: 150px;
        }
        .splash_2 p{
            font-size: 26px;
            color: #303941;
        }
        .splash_2 .para-holder{
            margin: 40px 0;
        }
        .splash_2 .splash-img-wrap{
            display: inline-block;
            margin-top: 40px;
        }
        .splash-footer{
            padding: 20px 12px;
            text-align: center;
            color: #fff;
            background: #18222b;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="splash_2">
    <div class="splash_2_header">
        <div>
            <img src="splash/logo_r.png" class="img-responsive">
        </div>
    </div>
    <section class="text-center para-holder">
        <p>サービス向上に向け、</p>
        <p>2016年春リニューアルオープン！</p>
        <div class="splash-img-wrap">
            <img src="splash/splashimg_small.png" class="img-responsive">
        </div>
    </section>
    <div class="splash-footer">
        <span>© Wazaar 2015</span>
    </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    @if( App::environment() == 'production' )
        <script>
            $(window).load(function() {
                window.setTimeout(function () {window.location.href = "http://wazaar.co.jp/"}, 10000);
            });
        </script>
    @endif
</body>
</html>
