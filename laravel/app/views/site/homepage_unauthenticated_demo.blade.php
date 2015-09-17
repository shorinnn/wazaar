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
    <section class="container-fluid discover-section">
        <div class="container">
            <div id='discover-courses-area' class="ajax-content">
                {{ View::make('site.discover_courses_demo')->with( compact('category_groups', 'wishlisted', 'filter') ) }} 
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