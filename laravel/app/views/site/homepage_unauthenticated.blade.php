    @extends('layouts.default')
    @section('content')	
    <style>
        .boxes p{
              background-color: rgba(128, 128, 128, 0.40);
        }
    </style>
    <div class="main">
    </div>
    	<section class="bckgrd-video-wrapper">
            <div id="bckgrd-video-container">
            	<section id="video-container" class="text-center">
                    <!--<div class="videoContainer">
                        <video id="myVideo" preload="auto" controls>
                            <source src="http://d378r68ica1xoa.cloudfront.net/MRSIjNWfPAw1uqHl1421661161826cx6nmz.mp4" type="video/mp4">
                        	<p>Your browser does not support the video tag.</p>
                        </video> 
                        <div class="control-container">                       
                            <div class="topControl">
                                <div class="progress">
                                    <span class="bufferBar"></span>
                                    <span class="timeBar"></span>
                                </div>
                            </div>
                            <div class="control">
                                
                                <div class="btmControl clearfix">
                                    <div class="btnPlay btn" title="Play/Pause video"></div>
                                    <div class="sound sound2 btn" title="Mute/Unmute sound"></div>
                                    <div class="volume-container">
                                        <div class="volume" title="Set volume">
                                            <span class="volumeBar">
                                                <em></em>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="btnFS btn" title="Switch to full screen"></div>
                                    <div class="time">
                                        <span class="current"></span> / 
                                        <span class="duration"></span> 
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="loading"></div>
                    </div>-->
                    <span class="centered-play-button"></span>
                </section>
            	<!--<video id="bckgrd-video" src="videos/dock.mp4" muted="true"></video>-->
                <div id="bckgrd-video-overlay">
                    <span class="logo">
                        <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/logged-out-home-logo.png" alt="">
                    </span>
                	<!--<div id="play-button"></div>-->
                    <!--<div class="color-bubbles">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/color-bubbles.png" alt="" class="img-responsive">
                    </div>-->
                </div>
            </div>        	
        </section>
        <section class="container-fluid course-search-section unauthenticated-homepage">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                    	<p class="lead">
                            {{trans('site/homepage.advance')}} 
                            <span>{{trans('site/homepage.your-career')}}.</span> 
                            {{trans('site/homepage.discover-new-skills')}}. 
                        </p>
                        <p class="lead">
                        {{trans('site/homepage.learn-what-you-didnt')}}                       
                        </p>
                        <div class="course-search-form">
                        	<form>
                            	<input type="search" placeholder="E.g. Javascript, online business, etc ..." name="course-search">
                                <button></button>
                            </form>
                            <!--<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/sample-search-category.png" 
                            alt="" class="img-responsive">-->
                            <div class="top-category-carousel">
                                <div class="responsive">
                                    <a href="#">
                                        <h3>IT & Tech</h3>
                                        <ul>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        </ul>
                                    </a>
                                    <a href="">
                                        <h3>Business</h3>
                                        <ul>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        </ul>
                                    </a>
                                    <a href="#">
                                        <h3>Investments</h3>
                                        <ul>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        </ul>
                                    </a>
                                    <a href="">
                                        <h3>Music</h3>
                                        <ul>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        </ul>
                                    </a>
                                    <a href="#">
                                        <h3>Health</h3>
                                        <ul>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        </ul>
                                    </a>
                                    <a href="">
                                        <h3>Category</h3>
                                        <ul>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        </ul>
                                    </a>
                                    <a href="#">
                                        <h3>Category</h3>
                                        <ul>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        </ul>
                                    </a>
                                    <a href="">
                                        <h3>Category</h3>
                                        <ul>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        </ul>
                                    </a>
                                    <a href="#">
                                        <h3>Category</h3>
                                        <ul>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        </ul>
                                    </a>
                                    <a href="">
                                        <h3>Category</h3>
                                        <ul>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        	<li>Sub category</li>
                                        </ul>
                                    </a>
                                </div>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
<!--        <section class="thumb-carousel-section unauthenticated-homepage">
            <div id="slider1">
                <a class="buttons prev" href="#">&#60;</a>
                <div class="viewport">
                    <ul class="overview">
                        <li>
                        	<div class="column-1">
                                    @foreach( $frontpageVideos as $set)
                                        @if( cycle(1, 2, 3) == 1)
                                            <div class="big-box-holders box-holders left clearfix">
                                            @if( cycle('a','b') == 'a')
                                                <a href="#" class="small-boxes boxes left course-tile-{{$set[0]['id']}}">
                                                    <span></span>
                                                    <img src="{{ $set[0]['thumb'] }}">   
                                                    <p>{{ $set[0]['name'] }}</p>
                                                </a>
                                                    <a href="#" class="small-boxes boxes left course-tile-{{$set[1]['id']}}">
                                                    <span></span>
                                                    <img src="{{ $set[1]['thumb'] }}">   
                                                    <p>{{ $set[1]['name'] }}</p>
                                                </a>
                                                    <a href="#" class="big-boxes boxes clear course-tile-{{$set[2]['id']}}">
                                                    <span></span>
                                                    <img src="{{ $set[2]['thumb'] }}">   
                                                    <p>{{ $set[2]['name'] }}</p>
                                                </a>
                                            @else
                                                 <a href="#" class="big-boxes boxes clear course-tile-{{$set[0]['id']}}">
                                                    <span></span>
                                                    <img src="{{ $set[0]['thumb'] }}">   
                                                    <p>{{ $set[0]['name'] }}</p>
                                                </a>
                                                <a href="#" class="small-boxes boxes left course-tile-{{$set[1]['id']}}">
                                                    <span></span>
                                                    <img src="{{ $set[1]['thumb'] }}">   
                                                    <p>{{ $set[1]['name'] }}</p>
                                                </a>
                                                    <a href="#" class="small-boxes boxes left course-tile-{{$set[2]['id']}}">
                                                    <span></span>
                                                    <img src="{{ $set[2]['thumb'] }}">   
                                                    <p>{{ $set[2]['name'] }}</p>
                                                </a>
                                            @endif
                                            </div>
                                        @else
                                            <div class="small-box-holders box-holders left clearfix">
                                                
                                                @foreach($set as $vid)
                                                    <a href="#" class="small-boxes boxes clear course-tile-{{$vid['id']}}">
                                                        <span></span>
                                                        <img src="{{ $vid['thumb'] }}">   
                                                        <p>{{ $vid['name'] }}</p>
                                                    </a>
                                                @endforeach
                                                          
                                            </div>
                                        @endif
                                    @endforeach
                                          
                            </div>
                        </li>
                    </ul>
                </div>
                <a class="buttons next" href="#">&#62;</a>
            </div>        
        </section>-->

        <section class="unauthenticated-homepage thumb-carousel-section">
        <div id="video-grid" class="carousel slide" data-ride="carousel">
        
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <?php $first = true;?>
                    @foreach($frontpageVideos as $set)
                        @if( cycle(1, 2, 3, 4, ':first') == 1 ) 
                            <div class="item 
                                 <?php 
                                 if($first){
                                     echo 'active';
                                     $first = false;
                                 }?>">
                                <div class="container-fluid">
                                    <div class="row">
                        @endif

                                          @if( cycle('x', 'y', ':second') == 'x')
                                            <div class="col-xs-4 col-sm-4 col-md-4 big-box-holders box-holders clearfix">
                                                @if( cycle('a','b', ':third') == 'a')
                                                    <a href="#" class="small-boxes boxes left course-tile-{{$set[0]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                        <img class="img-responsive" src="{{ $set[0]['thumb'] }}">
                                                        <p class="hidden-xs">{{ $set[0]['name'] }}</p>
                                                    </a>
                                                    <a href="#" class="small-boxes boxes left course-tile-{{$set[1]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                        <img class="img-responsive"  src="{{ $set[1]['thumb'] }}"> 
                                                        <p class="hidden-xs">{{ $set[1]['name'] }}</p>
                                                    </a>
                                                    <a href="#" class="big-boxes boxes clear  course-tile-{{$set[2]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                       <img class="img-responsive"  src="{{ $set[2]['thumb'] }}"> 
                                                        <p class="hidden-xs">{{ $set[2]['name'] }}</p>
                                                    </a>
                                                @else
                                                    <a href="#" class="big-boxes boxes clear  course-tile-{{$set[2]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                       <img class="img-responsive"  src="{{ $set[2]['thumb'] }}"> 
                                                        <p class="hidden-xs">{{ $set[2]['name'] }}</p>
                                                    </a>
                                                    <a href="#" class="small-boxes boxes left course-tile-{{$set[0]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                        <img class="img-responsive" src="{{ $set[0]['thumb'] }}">
                                                        <p class="hidden-xs">{{ $set[0]['name'] }}</p>
                                                    </a>
                                                    <a href="#" class="small-boxes boxes left course-tile-{{$set[1]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                        <img class="img-responsive"  src="{{ $set[1]['thumb'] }}"> 
                                                        <p class="hidden-xs">{{ $set[1]['name'] }}</p>
                                                    </a>
                                                @endif
                                            </div>
                                            @else
                                                <div class="col-xs-2 col-sm-2 col-md-2 small-box-holders box-holders left clearfix">
                                                    @foreach($set as $vid)
                                                        <a href="#" class="small-boxes boxes clear course-tile-{{$vid['id']}}">
                                                            <span class="hidden-xs"></span>
                                                            <img class="img-responsive" src="{{ $vid['thumb'] }}">   
                                                            <p class="hidden-xs">{{ $vid['name'] }}</p>
                                                        </a>
                                                    @endforeach                                                              
                                                </div>
                                            @endif
                        @if( cycle(1, 2, 3, 4, ':fourth') == 4 ) 
                                    </div>
                               </div>
                           </div>
                        @endif
                    @endforeach
                   
<!--            <div class="item">
                <div class="container-fluid">
                    <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 big-box-holders box-holders clearfix">
                                <a href="#" class="small-boxes boxes left">
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>
                                <a href="#" class="small-boxes boxes left">
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg"> 
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>
                                <a href="#" class="big-boxes boxes clear">
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">    
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 small-box-holders box-holders left clearfix">
                                <a href="#" class="small-boxes boxes clear">
                                    <span class="hidden-xs"></span>
                                     <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">   
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>
                                <a href="#" class="small-boxes boxes clear">
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>
                                <a href="#" class="small-boxes boxes clear">
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>                                                                
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 big-box-holders box-holders left clearfix">
                                <a href="#" class="big-boxes boxes clear">
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>
                                <a href="#" class="small-boxes boxes left">
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>
                                <a href="#" class="small-boxes boxes left"> 
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>                                                                
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 small-box-holders box-holders left clearfix">
                                <a href="#" class="small-boxes boxes clear">
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>
                                <a href="#" class="small-boxes boxes clear">
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>
                                <a href="#" class="small-boxes boxes clear">
                                    <span class="hidden-xs"></span>
                                    <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/thumb-carousel-sample.jpg">
                                    <p class="hidden-xs">Dancing with Jerken on the top of the iceberg..</p>
                                </a>                                                                
                            </div>
                    </div>
                </div>
            </div>-->
          </div>
        
          <!-- Controls -->
          <a class="left carousel-control" href="#video-grid" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#video-grid" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        </section>

        <section class="container-fluid course-search-section unauthenticated-homepage discover-wazaar">
        	<div class="row">
            	<div class="col-md-12">
                    <a href="#" class="discover-wazaar-button">
                    {{trans('site/homepage.discover-wazaar')}}
                    </a>
                    <span class="down-arrow">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/down-arrow.png">
                    </span>                
                </div>
            </div>
        </section>

        <section class="unauthenticated-homepage parallax-1">
        	<!--<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image5.jpg" class="img-responsive">-->
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
        	<!--<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image7.jpg" class="img-responsive">-->
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
                            @foreach($categories as $category)
                                <li><a href="#cat-row-{{$category->color_scheme}}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div><!--nav-collapse ends--> 
                </div><!--navbar-default ends-->
            </div><!--container ends-->
        </section>
        {{View::make('courses.courses_list_unauthenticated')->with( compact('categories') )}}
        
       
        <section class="container unauthenticated-homepage" id="the-world-is-yours">
        	<div class="row">
            	<div class="col-md-12">
                	<h3>{{ trans('site/homepage.the-world-is-yours') }}.
                    	<span>{{ trans('site/homepage.create-yourself') }}.</span>
                    </h3>
                    <a href="#" class="sign-up">{{ trans('site/homepage.sign-up-now') }}</a>
                    <span class="get-reward">{{ trans('site/homepage.get-credit') }}!</span>
                </div>
            </div>
        </section>

    @stop
    
