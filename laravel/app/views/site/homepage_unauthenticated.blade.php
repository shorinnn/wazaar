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
                    <span class="centered-play-button"></span>
                </section>
                <div id="bckgrd-video-overlay">
                    <span class="logo">
                        <img class="img-responsive" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/logged-out-home-logo.png" alt="">
                    </span>
                </div>
            </div>        	
        </section>

        <section class="container-fluid course-search-section unauthenticated-homepage">
        	<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                    	<p class="lead">
                            <span>{{trans('site/homepage.what-do-you-want-to-learn')}}</span> 
                        </p>
                        <div class="course-search-form">
                        	<form>
                            	<input type="search" placeholder="E.g. Javascript, online business, etc ..." name="course-search">
                                <button></button>
                            </form>
                            <!--<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/sample-search-category.png" 
                            alt="" class="img-responsive">-->
                            <div class="top-categories-slider-container">
                                <div class="top-categories-slider">
                                    @foreach($categories as $category)
                                        <a href="{{ action('CoursesController@category', $category->slug) }}">
                                            <h3>{{ $category->name }}</h3>
                                            <ul>
                                                @foreach($category->courseSubcategories()->limit(3)->get() as $sub)
                                                    <li>{{ $sub->name }}</li>
                                                @endforeach
                                            </ul>
                                        </a>
                                    @endforeach
                                </div>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
                                                    <a href="{{$set[2]['url']}}" class="small-boxes boxes left course-tile-{{$set[2]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                        <img class="img-responsive" src="{{ $set[2]['thumb'] }}">
                                                        <p class="hidden-xs">{{ $set[2]['name'] }}</p>
                                                    </a>
                                                    <a href="{{$set[1]['url']}}" class="small-boxes boxes left course-tile-{{$set[1]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                        <img class="img-responsive"  src="{{ $set[1]['thumb'] }}"> 
                                                        <p class="hidden-xs">{{ $set[1]['name'] }}</p>
                                                    </a>
                                                    <a href="{{$set[0]['url']}}" class="big-boxes boxes clear  course-tile-{{$set[0]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                       <img class="img-responsive"  src="{{ $set[0]['thumb'] }}"> 
                                                        <p class="hidden-xs">{{ $set[0]['name'] }}</p>
                                                    </a>
                                                @else
                                                    <a href="{{$set[0]['url']}}" class="big-boxes boxes clear  course-tile-{{$set[2]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                       <img class="img-responsive"  src="{{ $set[0]['thumb'] }}"> 
                                                        <p class="hidden-xs">{{ $set[0]['name'] }}</p>
                                                    </a>
                                                    <a href="{{$set[1]['url']}}" class="small-boxes boxes left course-tile-{{$set[1]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                        <img class="img-responsive"  src="{{ $set[1]['thumb'] }}"> 
                                                        <p class="hidden-xs">{{ $set[1]['name'] }}</p>
                                                    </a>
                                                    <a href="{{$set[2]['url']}}" class="small-boxes boxes left course-tile-{{$set[2]['id']}}">
                                                        <span class="hidden-xs"></span>
                                                        <img class="img-responsive" src="{{ $set[2]['thumb'] }}">
                                                        <p class="hidden-xs">{{ $set[2]['name'] }}</p>
                                                    </a>
                                                @endif
                                            </div>
                                            @else
                                                <div class="col-xs-2 col-sm-2 col-md-2 small-box-holders box-holders left clearfix">
                                                    @foreach($set as $vid)
                                                        <a href="{{$vid['url']}}" class="small-boxes boxes clear course-tile-{{$vid['id']}}">
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
        {{ View::make('courses.courses_list_unauthenticated')->with( compact('categories') ) }}
       
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
    
