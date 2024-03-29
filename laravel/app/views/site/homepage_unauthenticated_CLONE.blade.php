@extends('layouts.default')
@section('page_title')Wazaar - 技の動画フリーマーケット「ワザール」遂に始動@stop
@section('meta_description')あなたの「好き」がお金になる。@stop
@section('content')

    <style>
        .popular-courses{
            width:300px;
            float:left;
            margin: 0;
            padding: 0;
        }

        .whats-hot-slider
        {
            width:100%;
            height: 330px;
            position: relative;
        }
		header{
			background: none;
		}
		.logged-out-header-search{
			display: none;
		}

    </style>
    <section class="homepage-header-wrapper clearfix">
        <span class="background-image-overlay"></span>
        <section class="container-fluid homepage-header clearfix">
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center clearfix">
                    <h1 class="extra-large-heading text-center clearfix">
                        {{trans('site/homepage.take_skill_to_new_level')}}
                        <p class="lead">{{trans('site/homepage.learning_has_never_been_easier')}}</p>
                    </h1>
                    <a href="#" onclick='showHomepagePromoVideo(this)' class="blue-button large-button round-button how-it-works"><i class="wa-play"></i>{{trans('site/homepage.how_it_works')}}</a>
                    <div class="home-search-form">
                        
                        <form action='{{ action('CoursesController@search') }}'>
                            <div>
                                <input type="search" name="term" class="left" placeholder="{{trans('site/homepage.what-do-you-want-to-learn')}}">
                                <button><i class="wa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <div class="homepage-carousel clearfix show">
        <h1>{{trans('site/homepage.what_is_hot')}}
            <p class="lead">{{trans('site/homepage.our_most_popular_courses')}}</p>
        </h1>
        
        <div class="popular-courses-carousel container-fluid">
            <div class="whats-hot-slider">
                @foreach($topCourses as $course)
                    <div class="popular-courses @if( $course['discounted'] > 0) discounted-course @endif">
                        <a href="{{ action('CoursesController@show', $course['slug'] ) }}">
                            <div class="img-container">
                                <img class="img-responsive" alt="" src="{{ $course['preview'] }}">
                                <!--<img class="img-responsive" alt="" src="https://wazaardev.s3.amazonaws.com/course_preview/54905d8c6ecae.jpg">-->
                                <div class="course-hover-data">
                                    @if( $course['discounted'] > 0)
                                        <span class="discount-percent left">- ¥ {{ number_format( $course['discounted'], Config::get('custom.currency_decimals') ) }}</span>
                                        <span class="video-length right"><i class="fa fa-clock-o"></i>
                                                <span class='countdown' data-final-date-seconds='{{ timeUntil($course['sale_ends_on'], true) }}'>{{ timeUntil($course['sale_ends_on']) }}</span>
                                            </span>
                                    @else
                                        <span class="discount-percent left">¥ {{ number_format( $course['price'], Config::get('custom.currency_decimals') ) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="">
                                @if( $course['discounted'] > 0)
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: {{ timeProgress($course['sale_starts_on'], $course['sale_ends_on'] ) }}%;">
                                            <span class="sr-only">
                                                {{ timeProgress($course['sale_starts_on'], $course['sale_ends_on'] ) }}% Complete</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="left preview-video-length clearfix">
                                    @if( $course['discounted'] > 0)
                                        <i class="fa fa-clock-o"></i>
                                        <span class="video-length countdown" data-final-date-seconds='{{ timeUntil($course['sale_ends_on'], true) }}'>{{ timeUntil($course['sale_ends_on']) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="course-title clearfix">
                                <h4 class="clear left"> {{ $course['name'] }}</h4>
                                    <span class="discount-percent right">
                                        @if( $course['discounted'] > 0)
                                            - ¥ {{ number_format( $course['discounted'], Config::get('custom.currency_decimals') ) }}
                                        @else
                                            ¥ {{ number_format( $course['price'], Config::get('custom.currency_decimals') ) }}
                                        @endif
                                    </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <section class="container-fluid">
        <section class="container homepage explore-category show">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h1 class="text-center">{{trans('site/homepage.explore_our_categories')}}
                        <p class="lead">{{trans('site/homepage.we_have_organised_courses')}}
                            <span class="block">{{trans('site/homepage.browse_categories_you_like')}}</span></p>
                    </h1>
                </div>
            </div>
            <div class="row">
                @foreach($categories->take(6)->get() as $cat)
                <?php 
                $class = $i = rand(0, count($cssClasses)-1);
                $class = $cssClasses[$i];
                unset( $cssClasses[$i] );
                $cssClasses = array_values($cssClasses);
                $cat->graphics_url = $class; ?>
                    <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 category-box">
                        <a href="{{ action( 'CoursesController@category', $cat->slug ) }}" class="{{$cat->graphics_url}}">
                            <em></em><span> {{ $cat->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach($categories->skip(6)->take(6)->get() as $cat)
                    <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 category-box">
                        <a href="{{ action( 'CoursesController@category', $cat->slug ) }}" class="{{$cat->graphics_url}}">
                            <em></em><span> {{ $cat->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </section>
    <section class="container-fluid discover-section">
        <div class="container">
            <div class="row discover-header show">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                	<div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </button>
                        <h1 class="left navbar-brand">{{trans('site/homepage.discover')}}</h1>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="categories-menu nav navbar-nav">
                            <li>
                                <a data-url="{{ action( 'SiteController@discoverCourses', 0 )}}" 
                                   data-callback='colorLinks' data-color='#0099ff' data-elem='.discover-links'
                                   class="load-remote discover-links
                                   @if( !isset($selectedGroup) || $selectedGroup==0 )
                                    active
                                   @endif
                                   "
                                   data-target="#discover-courses-area">All</a>
                            </li>
                            
                            @foreach($groups as $group)
                            <li>
                                <a  data-url="{{ action( 'SiteController@discoverCourses', $group->id )}}" 
                                    class="load-remote discover-links
                                    @if( isset($selectedGroup) && $selectedGroup==$group->id )
                                        active
                                    @endif
                                   "
                                   data-callback='colorLinks'  data-elem='.discover-links' data-color='#0099ff' data-target="#discover-courses-area">{{ $group->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                        <a href="{{ action('CoursesController@category','')}}" class="nav navbar-nav navbar-right">{{trans('site/homepage.browse_all_courses')}}</a>
                    </div>
                </div>
            </div>
            <div id='discover-courses-area' class="ajax-content oldhomepage">
                {{ View::make('site.discover_courses')->with( compact('discoverCourses', 'wishlisted', 'filter') ) }} 
            </div>
        </div>
    </section>
    
@stop

@section('extra_js')
    <script type="text/javascript" src="{{url('js/moment.js')}}"></script>

    <script src="{{url('plugins/smoothscroll/jquery.kinetic.min.js')}}" type="text/javascript"></script>
    <script src="{{url('plugins/smoothscroll/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>
    <script src="{{url('plugins/smoothscroll/jquery.mousewheel.min.js')}}" type="text/javascript"></script>
    <script src="{{url('plugins/smoothscroll/jquery.smoothdivscroll-1.3-min.js')}}" type="text/javascript"></script>
    <script>
        $(function(){
			$(document).ready(function(){
				$('.popular-courses-carousel').css('display', 'block');
			});
            $('.whats-hot-slider').smoothDivScroll({
                autoScrollingMode: "onStart",
                manualContinuousScrolling: true,
                mousewheelScrolling: "",
            });

            $('.whats-hot-slider .popular-courses').hover(function(){
                        $(".whats-hot-slider").smoothDivScroll("stopAutoScrolling");
                    },
                    function(){
                        $(".whats-hot-slider").smoothDivScroll("startAutoScrolling");
                    }
            );

            $(' .scrollingHotSpotRight').mouseout(function(){
                delay(function(){
                    $(".whats-hot-slider").smoothDivScroll("option","autoScrollDirection","endlessLoopLeft");
                    $(".whats-hot-slider").smoothDivScroll("startAutoScrolling");
                }, 500);

            });

            $('.scrollingHotSpotLeft').mouseout(function(){
                delay(function(){
                    $(".whats-hot-slider").smoothDivScroll("option","autoScrollDirection","endlessLoopRight");
                    $(".whats-hot-slider").smoothDivScroll("startAutoScrolling");
                }, 500);

            });
        });
        ajaxifyPagination( null, '#discover-courses-area' );
        
        function showHomepagePromoVideo(elem){
            $(elem).after('<iframe width="560" height="315" src="https://www.youtube.com/embed/KRFvov4XZik?rel=0&amp;showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');
            $(elem).remove();
        }
    </script>
@stop