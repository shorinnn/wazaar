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
        <section class="container-fluid course-search-section">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                    	<p class="lead">{{trans('site/homepage.what-do-you-want-to-learn')}}</p>
                        <div class="course-search-form">
                        	<form>
                            	<input type="search" placeholder="E.g. Javascript, online business, etc ..." name="course-search">
                                <button></button>
                            </form>
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/sample-search-category.png" 
                            alt="" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="container-fluid progress-bar-container">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12 progress-bar-contents">
                    	<p class="lead">{{trans('site/homepage.your-progress')}}</p>
                        <div class="clearfix">
                        	<div class="course-title">
                            	<em>A1</em>
                                <a href="#">Javascript Crash Course I</a>
                            </div>
                            <div class="deadline-date">
                            	<em>{{trans('site/homepage.deadline-date')}}</em>
                                <p>23h 43m 52s</p>
                                <a href="#">{{trans('site/homepage.continue-course')}}</a>
                            </div>
                        </div>
                        <div class="progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                            <span class="sr-only">50% Complete</span>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="alert-message container">
        	<div class="row">
            	<div class="col-md-12">
                	<p>{{trans('site/homepage.finish-course-alert')}}</p>
                </div>
            </div>
        </section>
        <section class="container-fluid main-nav-section">
        	<div class="container">
                <div class="navbar navbar-default">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
                        	<span class="icon-bar"></span> 
                            <span class="icon-bar"></span> 
                            <span class="icon-bar"></span> 
                        </button>
                    </div><!--navbar-header ends-->
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">{{trans('site/nav-menu.it-and-tech')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.business')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.investments')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.music')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.beauty')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.health')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.it-and-tech')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.business')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.investments')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.music')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.beauty')}}</a></li>
                            <li><a href="#">{{trans('site/nav-menu.health')}}</a></li>
                        </ul>
                    </div><!--nav-collapse ends--> 
                </div><!--navbar-default ends-->
            </div><!--container ends-->
        </section>
        <section class="container">
			<!-- First row begins -->         
            <div class="row first-row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
                <div class="category-heading">         
                    <div class="clearfix">
                        <p class="lead">{{trans('site/homepage.it-and-technology')}}<small>Programming, Javascript, C++, etc...</small></p>
                        <a href="#">{{trans('site/homepage.view-all')}}</a>
                    </div>
                </div>
                <div class="object big-box">
                	<div class="price-tag">
                    300,000 &yen; SALE
                	</div>
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image1.jpg" alt="" 
                    class="hidden-sm hidden-xs img-responsive">
                    <div><div class="level">{{trans('site/homepage.beginner')}}</div><h2>App development</h2>
                        <p>Create your very first application in 2 weeks! You get a beginner award after completing the course.</p>
                        <div class="next_">
                        <div class="learn-more">
                          <a href="#">{{trans('site/homepage.learn-more')}}</a>
                        </div>
                        <div class="students-attending">
                          1233 Students
                        </div>            
                      </div>
                  </div>
                </div>
              </div>
            </div>       
            <div class="row first-row">
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-one">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><div class="new-tag">NEW</div>
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image2.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-two">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image3.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-three">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div>
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image4.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div>
                </div>
              </div>
            </div>
			<!-- End of First row -->

			<!-- Second row begins -->           
            <div class="row second-row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
                <div class="category-heading">         
                    <div class="clearfix">
                        <p class="lead">IT & Technology<small>Programming, Javascript, C++, etc...</small></p>
                        <a href="#">View all</a>
                    </div>
                </div>
                <div class="object big-box">
                	<div class="price-tag">
                    300,000 &yen; SALE
                	</div>
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image1.jpg" alt="" 
                    class="hidden-sm hidden-xs img-responsive">
                    <div><div class="level">{{trans('site/homepage.beginner')}}</div><h2>App development</h2>
                        <p>Create your very first application in 2 weeks! You get a beginner award after completing the course.</p>
                        <div class="next_">
                        <div class="learn-more">
                          <a href="#">{{trans('site/homepage.learn-more')}}</a>
                        </div>
                        <div class="students-attending">
                          1233 Students
                        </div>            
                      </div>
                  </div>
                </div>
              </div>
            </div>       
            <div class="row second-row">
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-one">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><div class="new-tag">NEW</div>
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image2.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-two">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image3.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-three">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image4.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div>
                </div>
              </div>
            </div>
			<!-- End of Second row -->

			<!-- Third row begins -->            
            <div class="row third-row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
                <div class="category-heading">         
                    <div class="clearfix">
                        <p class="lead">IT & Technology<small>Programming, Javascript, C++, etc...</small></p>
                        <a href="#">View all</a>
                    </div>
                </div>
                <div class="object big-box">
                	<div class="price-tag">
                    300,000 &yen; SALE
                	</div>
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image1.jpg" alt="" 
                    class="hidden-sm hidden-xs img-responsive">
                    <div><div class="level">{{trans('site/homepage.beginner')}}</div><h2>App development</h2>
                        <p>Create your very first application in 2 weeks! You get a beginner award after completing the course.</p>
                        <div class="next_">
                        <div class="learn-more">
                          <a href="#">{{trans('site/homepage.learn-more')}}</a>
                        </div>
                        <div class="students-attending">
                          1233 Students
                        </div>            
                      </div>
                  </div>
                </div>
              </div>
            </div>       
            <div class="row third-row">
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-one">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><div class="new-tag">NEW</div>
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image2.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-two">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image3.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-three">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image4.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div>
                </div>
              </div>
            </div>
			<!-- End of third row -->

			<!-- Fourth row begins -->            
            <div class="row fourth-row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
                <div class="category-heading">         
                    <div class="clearfix">
                        <p class="lead">IT & Technology<small>Programming, Javascript, C++, etc...</small></p>
                        <a href="#">View all</a>
                    </div>
                </div>
                <div class="object big-box">
                	<div class="price-tag">
                    300,000 &yen; SALE
                	</div>
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image1.jpg" alt="" 
                    class="hidden-sm hidden-xs img-responsive">
                    <div><div class="level">{{trans('site/homepage.beginner')}}</div><h2>App development</h2>
                        <p>Create your very first application in 2 weeks! You get a beginner award after completing the course.</p>
                        <div class="next_">
                        <div class="learn-more">
                          <a href="#">{{trans('site/homepage.learn-more')}}</a>
                        </div>
                        <div class="students-attending">
                          1233 Students
                        </div>            
                      </div>
                  </div>
                </div>
              </div>
            </div>       
            <div class="row fourth-row">
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-one">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><div class="new-tag">NEW</div>
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image2.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-two">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image3.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-three">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image4.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div>
                </div>
              </div>
            </div>
			<!-- End of fourth row -->

			<!-- Fifth row begins -->   
            <div class="row fifth-row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
                <div class="category-heading">         
                    <div class="clearfix">
                        <p class="lead">IT & Technology<small>Programming, Javascript, C++, etc...</small></p>
                        <a href="#">View all</a>
                    </div>
                </div>
                <div class="object big-box">
                	<div class="price-tag">
                    300,000 &yen; SALE
                	</div>
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image1.jpg" alt="" 
                    class="hidden-sm hidden-xs img-responsive">
                    <div><div class="level">{{trans('site/homepage.beginner')}}</div><h2>App development</h2>
                        <p>Create your very first application in 2 weeks! You get a beginner award after completing the course.</p>
                        <div class="next_">
                        <div class="learn-more">
                          <a href="#">{{trans('site/homepage.learn-more')}}</a>
                        </div>
                        <div class="students-attending">
                          1233 Students
                        </div>            
                      </div>
                  </div>
                </div>
              </div>
            </div>       
            <div class="row fifth-row">
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-one">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><div class="new-tag">NEW</div>
                  <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image2.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-two">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image3.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div> 
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="object small-box small-box-three">
                  <div class="price-tag">
                    300,000 &yen;
                  </div><div class="level">{{trans('site/homepage.beginner')}}</div><img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image4.jpg" 
                  class="img-responsive" alt="">
                  <h2>Javascript Primer</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incid sed do eiusmod tempor incid</p>
                  <div class="next_">
                    <div class="learn-more">
                      <a href="#">{{trans('site/homepage.learn-more')}}</a>
                    </div>
                    <div class="students-attending">
                      1233 Students
                    </div>            
                  </div>
                </div>
              </div>
            </div>
			<!-- End of fifth row -->
        </section>
        <section class="container-fluid become-an-instructor">
        	<div class="container">
              <div class="row">
                <div class="col-xs-12">
                  <h1>BECOME</h1>
                  <h2>AN INSTRUCTOR</h2>
                  <button><span>{{trans('site/homepage.get-started')}}</span></button>
                </div>
              </div>
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
