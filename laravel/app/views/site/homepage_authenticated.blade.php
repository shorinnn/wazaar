@extends('layouts.default')
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


    </style>
    <section class="homepage-header-wrapper">
        <span class="background-image-overlay"></span>
        <section class="container-fluid homepage-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <h1 class="extra-large-heading text-center">
                        {{trans('site/homepage.take_skill_to_new_level')}}
                        <p class="lead">{{trans('site/homepage.learning_has_never_been_easier')}}</p>
                    </h1>
                    <a href="#" class="blue-button large-button round-button how-it-works"><i class="fa fa-play-circle"></i>{{trans('site/homepage.how_it_works')}}</a>
                    <div class="home-search-form">
                        <form>
                            <div>
                                <input type="search" name="home-search" class="left" placeholder="What do you want to learn?">
                                <button><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <div class="homepage-carousel clearfix">
        <h1>{{trans('site/homepage.what_is_hot')}}
            <p class="lead">{{trans('site/homepage.our_most_popular_courses')}}</p>
        </h1>

        <div class="popular-courses-carousel container-fluid">
            <div class="whats-hot-slider">
                @foreach($topCourses as $course)
                    <div class="popular-courses">
                        <a href="{{ action('CoursesController@show', $course['slug'] ) }}">
                            <div class="img-container">
                                <img class="img-responsive" alt="" src="{{ $course['preview'] }}">
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
                            <div class="clearfix">
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
        <section class="container homepage explore-category">
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
                    <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 category-box">
                        <a href="{{ action( 'CoursesController@category', $cat->slug ) }}">
                            <span> {{ $cat->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row">
                @foreach($categories->skip(6)->take(6)->get() as $cat)
                    <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 category-box">
                        <a href="{{ action( 'CoursesController@category', $cat->slug ) }}">
                            <span> {{ $cat->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </section>
    <section class="container-fluid discover-section">
        <div class="container">
            <div class="row discover-header">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <h1 class="left">{{trans('site/homepage.discover')}}</h1>
                    <ul class="left categories-menu">
                        <li>
                            <a class="load-remote" data-url="{{ action( 'SiteController@discoverCourses', 0 )}}" data-no-push-state="1"
                               data-target="#discover-courses-area">All</a>
                        </li>
                        
                        @foreach($groups as $group)
                        <li>
                            <a class="load-remote" data-url="{{ action( 'SiteController@discoverCourses', $group->id )}}"  data-no-push-state="1"
                               data-target="#discover-courses-area">{{ $group->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-right">
                    <a href="{{ action('CoursesController@category','')}}">{{trans('site/homepage.browse_all_courses')}}</a>
                </div>
            </div>
            
            <div id='discover-courses-area'>
                
                {{ View::make('site.discover_courses')->with( compact('discoverCourses') ) }}
            </div>
        </div>
    </section>
    <section class="become-an-instructor-section container-fluid">
        <span class="background-image-overlay"></span>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <h1>{{trans('site/homepage.be-an-instructor')}}
                        <p class="lead intro-paragraph">{{trans('site/homepage.earn_for_creating_course')}}</p>
                    </h1>
                    <a href="#" class="blue-button large-button">{{ trans('general.register') }}</a>
                </div>
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
            $('.whats-hot-slider').smoothDivScroll({
                autoScrollingMode: "onStart",
                manualContinuousScrolling: true,
                mousewheelScrolling: ""
            });

            $('.whats-hot-slider img').hover(function(){
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
    </script>
@stop