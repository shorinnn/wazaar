
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>    Success - Wazaar</title>    
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <!--<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="style.css">

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
       		<div class="row">
                <div class="top-menu clearfix col-md-12">
                    <a href="http://wazaar.jp" class="main-logo">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" 
                       class="img-responsive" alt="">
                    </a>    
                    <style>
                        .top-menu .main-logo {
                            display:block;
                        }
                    </style>
                                    
                    
                </div>
			</div>
        </header>
        
        <section class="container-fluid email-confirmation-pages">
            <div class="container">
                <div class="row congrats-message">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h2>
                        	<img src="registered-mark.png" alt="" class="inline-block">
                            <span class="block">
                                <span class="name"><?php if(isset($_GET['name'])) echo $_GET['name'];?>,</span>
                                さん、おめでとうございます！ 
                            </span>
                            <span class="block">あなたのメールアドレスは無事に登録完了いたしました。</span>
                        <br />
                        <center>
                            <a href="http://wazaar.jp/register" class="blue-button button large-button register center" style='width:220px'>
                                サインアップ
                            </a>
                        </center>
                        </h2>
                    </div>
                </div>
                <!--<div class="row verify-email">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
                        <span class="step-number">1</span>
                        <h3>Please verify your email</h3>
                        <p class="regular-paragraph">We have sent verification link to your email saulius@mail.com!</p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                        <a href="#" class="blue-button large-button">VERIFY EMAIL</a>
                    </div>
                </div>
                <div class="row invite-friends">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <span class="step-number">2</span>            
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <span class="step-number">2</span>            
                    </div>
                </div>-->
            </div>
        </section>
               	
        <footer>
          <section class="footer-container">
            <div class="container">
              <div class="row">
                <div class="col-md-4 col-sm-12 first-col">
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/footer-logo.png" alt="Wazaar" />
                </div>
                <div class="col-md-4 col-sm-12 second-col">
                  <strong>Phone:</strong> 000 000 000 000<br/>
                  <strong>Mail:</strong> info@wazaar.com
                </div>
                <div class="col-md-4 col-sm-12 third-col">
                  <strong>Wazaar</strong><br/>
                  All rights reserved<br/>
                  &copy; 2015
                </div>              
              </div>
            </div>
          </section>          
        </footer>
    </div>    

 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
        <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
        <script src="http://www.localeplanet.com/api/translate.js" /></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>        
        <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
    	<script type="text/javascript" src="http://wazaar.jp/js/bootbox.js"></script>

</body>
</html>
