    @extends('layouts.default')
    @section('content')	
        <section class="container-fluid course-search-section unauthenticated-homepage">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                    	<span class="logo">
                        	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/logged-out-home-logo.png" alt="">
                        </span>
                        <div class="color-bubbles">
                        	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/color-bubbles.png" alt="" class="img-responsive">
                        </div>
                    	<p class="lead">Advance <span>Your Career.</span> Discover new skills. 
                        </p>
                        <p class="lead">
                        {{trans('site/homepage.learn-what-you-didnt')}}                       
                        </p>
                        <div class="course-search-form">
                        	<form>
                            	<input type="search" placeholder="E.g. Javascript, online business, etc ..." name="course-search">
                                <button></button>
                            </form>
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/sample-search-category.png" 
                            alt="" class="img-responsive">
                        </div>
                        <a href="#" class="discover-wazaar-button">
                        {{trans('site/homepage.discover-wazaar')}}
                        </a>
                        <span class="down-arrow">
                        	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/down-arrow.png">
                        </span>
                    </div>
                </div>
            </div>
        </section>
        <section class="unauthenticated-homepage parallax-1">
        	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image5.jpg" class="img-responsive">
        </section>
        <section class="school-is-a-thing unauthenticated-homepage clearfix">
        	<div>
            	<h3>{{trans('site/homepage.thing-of-yesterday')}}
                	<span>This is the new way to upgrade yourself. Save time and money, and get a promotion.</span>
                </h3>
                        <p class="description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo. Lorem ipsum dolor sit amet, 
                consectetur adipisicing elit, sed do 
                </p>
                <a href="#" class="sign-up-button">{{trans('site/homepage.sign-up-and-earn')}}</a>
            </div>
            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image6.jpg" alt="" 
            class="hidden-xs img-responsive">
        </section>
        <section class="unauthenticated-homepage parallax-2">
        	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image7.jpg" class="img-responsive">
        </section>
        <section class="container-fluid main-nav-section jp">
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
                            <li><a href="#">IT & Technology</a></li>
                            <li><a href="#">Business</a></li>
                            <li><a href="#">Investments</a></li>
                            <li><a href="#">Music</a></li>
                            <li><a href="#">Beauty</a></li>
                            <li><a href="#">Health</a></li>
                        </ul>
                    </div><!--nav-collapse ends--> 
                </div><!--navbar-default ends-->
            </div><!--container ends-->
        </section>
        <section class="container-fluid unauthenticated-homepage" id="it-and-tech">
        	<div class="container course-listing-container">
            	<div class="row">
                	<div class="col-md-6">
                    	<h3>IT & Tech</h3>
                        <p class="description">
                        Get the skills you need to become an IT worker or build your dreams.
                        </p>
                        <a href="#" class="learn-more">Learn more</a>
                        <i class="fa fa-arrow-down fa-1"></i>
                        <a href="#" class="sign-up">Sign up and earn ¥500 credit</a>
                    </div>
                	<div class="col-md-6 hidden-xs">
                    	<img class="hidden-xs img-responsive right"
                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-7.png" alt="">
                    </div>
                </div>
            	<div class="row">
                    <!-- include the 3 course boxes -->
                    <?php $category = CourseCategory::where('name','Beauty')->first();?>
                    @foreach($category->courses()->orderBy('id','Desc')->where('featured',0)->take(3)->get() as $course)
                        {{ View::make('courses.course_box')->with(compact('course')) }}
                    @endforeach
                    <!-- end of the 3 course boxes -->
                </div>
            </div>
        </section>
        <section class="container-fluid unauthenticated-homepage" id="music-and-arts">
        	<div class="container course-listing-container">
            	<div class="row">
                	<div class="col-md-6 hidden-xs">
                    	<img class="hidden-xs img-responsive left"
                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-8.png" alt="">
                    </div>
                	<div class="col-md-6">
                    	<h3>Music & Arts</h3>
                        <p class="description">
                        Keep the weight off and stay slim, or become like Brad Pitt!
                        </p>
                        <a href="#" class="learn-more">Learn more</a>
                        <i class="fa fa-arrow-down fa-1"></i>
                        <a href="#" class="sign-up">Sign up and earn ¥500 credit</a>
                    </div>
                </div>
            	<div class="row">
                    <!-- include the 3 course boxes -->
                    <?php $category = CourseCategory::where('name','Beauty')->first();?>
                    @foreach($category->courses()->orderBy('id','Desc')->where('featured',0)->take(3)->get() as $course)
                        {{ View::make('courses.course_box')->with(compact('course')) }}
                    @endforeach
                    <!-- end of the 3 course boxes -->
                </div>
            </div>
        </section>
        <section class="container-fluid unauthenticated-homepage" id="love-and-relationships">
        	<div class="container course-listing-container">
            	<div class="row">
                	<div class="col-md-6">
                    	<h3>Love & Relationships</h3>
                        <p class="description">
                        Get the partner of your dreams, or turn your relationship around.
                        </p>
                        <a href="#" class="learn-more">Learn more</a>
                        <i class="fa fa-arrow-down fa-1"></i>
                        <a href="#" class="sign-up">Sign up and earn ¥500 credit</a>
                    </div>
                	<div class="col-md-6 hidden-xs">
                    	<img class="hidden-xs img-responsive right"
                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-9.png" alt="">
                    </div>
                </div>
            	<div class="row">
                    <!-- include the 3 course boxes -->
                    <?php $category = CourseCategory::where('name','Beauty')->first();?>
                    @foreach($category->courses()->orderBy('id','Desc')->where('featured',0)->take(3)->get() as $course)
                        {{ View::make('courses.course_box')->with(compact('course')) }}
                    @endforeach
                    <!-- end of the 3 course boxes -->
                </div>
            </div>
        </section>
        <section class="container-fluid unauthenticated-homepage" id="personal-development">
        	<div class="container course-listing-container">
            	<div class="row">
                	<div class="col-md-6 hidden-xs">
                    	<img class="hidden-xs img-responsive left"
                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-10.png" alt="">
                    </div>
                	<div class="col-md-6">
                    	<h3>Personal Development</h3>
                        <p class="description">
                        Master life and be happier than you’ve ever been.  Health, prosperity and happiness.
                        </p>
                        <a href="#" class="learn-more">Learn more</a>
                        <i class="fa fa-arrow-down fa-1"></i>
                        <a href="#" class="sign-up">Sign up and earn ¥500 credit</a>
                    </div>
                </div>
            	<div class="row">
                    <!-- include the 3 course boxes -->
                    <?php $category = CourseCategory::where('name','Beauty')->first();?>
                    @foreach($category->courses()->orderBy('id','Desc')->where('featured',0)->take(3)->get() as $course)
                        {{ View::make('courses.course_box')->with(compact('course')) }}
                    @endforeach
                    <!-- end of the 3 course boxes -->
                </div>
            </div>
        </section>
        <section class="container-fluid unauthenticated-homepage" id="language">
        	<div class="container course-listing-container">
            	<div class="row">
                	<div class="col-md-6">
                    	<h3>Language</h3>
                        <p class="description">
                        Learn a new language. It’s never been easier.
                        </p>
                        <a href="#" class="learn-more">Learn more</a>
                        <i class="fa fa-arrow-down fa-1"></i>
                        <a href="#" class="sign-up">Sign up and earn ¥500 credit</a>
                    </div>
                	<div class="col-md-6 hidden-xs">
                    	<img class="hidden-xs img-responsive right"
                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-11.png" alt="">
                    </div>
                </div>
            	<div class="row">
                    <!-- include the 3 course boxes -->
                    <?php $category = CourseCategory::where('name','Beauty')->first();?>
                    @foreach($category->courses()->orderBy('id','Desc')->where('featured',0)->take(3)->get() as $course)
                        {{ View::make('courses.course_box')->with(compact('course')) }}
                    @endforeach
                    <!-- end of the 3 course boxes -->
                </div>
            </div>
        </section>
        <section class="container-fluid unauthenticated-homepage" id="money">
        	<div class="container course-listing-container">
            	<div class="row">
                	<div class="col-md-6 hidden-xs">
                    	<img class="hidden-xs img-responsive left"
                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-12.png" alt="">
                    </div>
                	<div class="col-md-6">
                    	<h3>Money</h3>
                        <p class="description">
                        Learn how to make the best use of your money and let it grow for you!
                        </p>
                        <a href="#" class="learn-more">Learn more</a>
                        <i class="fa fa-arrow-down fa-1"></i>
                        <a href="#" class="sign-up">Sign up and earn ¥500 credit</a>
                    </div>
                </div>
            	<div class="row">
                    <!-- include the 3 course boxes -->
                    <?php $category = CourseCategory::where('name','Beauty')->first();?>
                    @foreach($category->courses()->orderBy('id','Desc')->where('featured',0)->take(3)->get() as $course)
                        {{ View::make('courses.course_box')->with(compact('course')) }}
                    @endforeach
                    <!-- end of the 3 course boxes -->
                </div>
            </div>
        </section>
        <section class="container-fluid unauthenticated-homepage" id="health-and-fitness">
        	<div class="container course-listing-container">
            	<div class="row">
                	<div class="col-md-6">
                    	<h3>Health & Fitness</h3>
                        <p class="description">
                        Keep the weight off and stay slim, or become like Brad Pitt!
                        </p>
                        <a href="#" class="learn-more">Learn more</a>
                        <i class="fa fa-arrow-down fa-1"></i>
                        <a href="#" class="sign-up">Sign up and earn ¥500 credit</a>
                    </div>
                	<div class="col-md-6 hidden-xs">
                    	<img class="hidden-xs img-responsive right"
                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-13.png" alt="">
                    </div>
                </div>
            	<div class="row">
                    <!-- include the 3 course boxes -->
                    <?php $category = CourseCategory::where('name','Beauty')->first();?>
                    @foreach($category->courses()->orderBy('id','Desc')->where('featured',0)->take(3)->get() as $course)
                        {{ View::make('courses.course_box')->with(compact('course')) }}
                    @endforeach
                    <!-- end of the 3 course boxes -->
                </div>
            </div>
        </section>
        <section class="container-fluid unauthenticated-homepage" id="business-and-marketing">
        	<div class="container course-listing-container">
            	<div class="row">
                	<div class="col-md-6 hidden-xs">
                    	<img class="hidden-xs img-responsive left"
                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-14.png" alt="">
                    </div>
                	<div class="col-md-6">
                    	<h3>Business & Marketing</h3>
                        <p class="description">
                        Start your business right
                        </p>
                        <a href="#" class="learn-more">Learn more</a>
                        <i class="fa fa-arrow-down fa-1"></i>
                        <a href="#" class="sign-up">Sign up and earn ¥500 credit</a>
                    </div>
                </div>
            	<div class="row">
                    <!-- include the 3 course boxes -->
                    <?php $category = CourseCategory::where('name','Beauty')->first();?>
                    @foreach($category->courses()->orderBy('id','Desc')->where('featured',0)->take(3)->get() as $course)
                        {{ View::make('courses.course_box')->with(compact('course')) }}
                    @endforeach
                    <!-- end of the 3 course boxes -->
                </div>
            </div>
        </section>
        <section class="container-fluid unauthenticated-homepage" id="photography-and-video">
        	<div class="container course-listing-container">
            	<div class="row">
                	<div class="col-md-6">
                    	<h3>Photography and Video</h3>
                        <p class="description">
                        Learn how to make the best use of your money and let it grow for you!
                        </p>
                        <a href="#" class="learn-more">Learn more</a>
                        <i class="fa fa-arrow-down fa-1"></i>
                        <a href="#" class="sign-up">Sign up and earn ¥500 credit</a>
                    </div>
                	<div class="col-md-6 hidden-xs">
                    	<img class="hidden-xs img-responsive right"
                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/misc-icons-15.png" alt="">
                    </div>
                </div>
            	<div class="row">
                    <!-- include the 3 course boxes -->
                    <?php $category = CourseCategory::where('name','Beauty')->first();?>
                    @foreach($category->courses()->orderBy('id','Desc')->where('featured',0)->take(3)->get() as $course)
                        {{ View::make('courses.course_box')->with(compact('course')) }}
                    @endforeach
                    <!-- end of the 3 course boxes -->
                </div>
            </div>
        </section>
        <section class="container unauthenticated-homepage" id="the-world-is-yours">
        	<div class="row">
            	<div class="col-md-12">
                	<h3>The world is yours to conquer.
                    	<span>Create yourself.</span>
                    </h3>
                    <a href="#" class="sign-up">Sign up now</a>
                    <span class="get-reward">Get 500¥ Credit!</span>
                </div>
            </div>
        </section>
    @stop