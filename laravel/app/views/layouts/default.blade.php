<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Wazaar | Home</title>    
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="style.css">
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="wrapper">
    	<header class="container-fluid">
        	<div class="row">
            	<div class="top-menu clearfix">
                	<a href="#" class="main-logo"><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" 
                    class="img-responsive" alt=""></a>
                    <ul>
                    	<li>
                        	<a href="#">{{trans('site/homepage.dashboard')}}</a>
                        </li>
                    	<li>
                        	<a href="#">{{trans('site/homepage.store')}}</a>
                        </li>
                    	<li>
                        	<a href="#">{{trans('site/homepage.learn')}}</a>
                        </li>
                    	<li>
                        	<a href="#">{{trans('site/homepage.expert')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="top-profile-info">
                	<span class="profile-level">12</span>
                    <ul class="profile-name">
                    	<li>
                        	<button aria-expanded="false" data-toggle="dropdown" 
                            class="btn btn-default dropdown-toggle" type="button" 
                            id="btnGroupDrop1">Ryan
        					</button>
                            <ul id="top-profile-dropdown" aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu">
                            	<li>
                                	<a class="profile-button" href="#">{{trans('site/homepage.profile')}}</a>
                                </li>
                            	<li>
                                	<a class="courses-button" href="#">{{trans('site/homepage.courses')}}</a>
                                </li>
                            	<li>
                                	<a class="settings-button" href="#">{{trans('site/homepage.settings')}}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="profile-thumbnail">
                    	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/thumbnails/top-profile-thumbnail.png" alt="">
                        <span class="notification-number">3</span>
                    </div>
                </div>
            </div>
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script></body>
</body>
</html>
