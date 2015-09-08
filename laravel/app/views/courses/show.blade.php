@extends('layouts.default')
 
@section('page_title')
    {{ $course->name }} -
@stop
 
@section('content')
    <style>
        .inline-block{
            display:inline-block;
        }
        
        .paid-content button{
            opacity: 0.3 !important;
        }
    </style>
    @if(Auth::check() && Auth::user()->hasRole('Affiliate'))
@section('affiliate-toolbar')
    {{ View::make('affiliate.affiliate-toolbar')->with( compact('course') ) }}
 
@stop
@endif
<section class="container-fluid course-detail-top-section clearfix unauthenticated-homepage cat-box-{{$course->courseCategory->color_scheme}}">
    @if($course->bannerImage != null)
        <!--<img src="{{$course->bannerImage->url}}" alt="" class="img-responsive" />-->
        @else
                <!--<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/course-detail-banner-img.jpg"
                         alt="" class="img-responsive" />-->
    @endif
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="category-tags clearfix">
                    <ul>
                        <li class="back-to-category">
                            <a href="{{ action( 'CoursesController@category', $course->courseCategory->slug ) }}">
                                <i class="wa-chevron-left"></i> {{$course->courseCategory->name }}
                            </a>
                        </li>
 
                    </ul>
                </div>
                <h1> {{ $course->name }}</h1>
 
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-push-8 col-lg-push-8">
                <div class="instructor margin-top-30 margin-bottom-30">
                    @if( $instructor!=null )
                        @if($instructor->profile == null)
                            <div class="clearfix">
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/profile_pictures/avatar-placeholder.jpg" alt="" >
                                <em>{{$instructor->last_name}} {{$instructor->first_name}} </em>
                            </div>
                            <p class="clearfix regular-paragraph">
                                @if( $course->show_bio=='custom' )
                                    {{ $course->custom_bio }}
                                @else
                                    {{ trans('general.no-bio-available') }}
                                @endif
                            </p>
                        @else
                            <div class="clearfix">
                                <img style='max-height: 120px; max-width: 120px; border-radius:50% ' src="{{ $instructor->profile->photo }}" alt="" >
                                <em class="name">
                                    @if($course->details_name=='person')
                                        {{$instructor->profile->last_name}} {{$instructor->profile->first_name}} 
                                    @else
                                        {{$instructor->profile->corporation_name}}
                                    @endif
                                </em>
                                <span class="instructor-skills">{{ $instructor->profile->title }}</span>
                            </div>
                            <!--@if(Auth::check())
                                            {{ View::make('courses.followed_form')->withInstructor($instructor) }}
                                        @endif-->
                                        <!--<h4>{{ trans('general.about') }} {{$instructor->profile->first_name}}</h4>-->
                            <p class="clearfix regular-paragraph expandable-content short-text instructor-bio-p">
                                @if( $course->show_bio=='custom' )
                                    {{ $course->custom_bio }}
                                @else
                                    {{ $instructor->profile->bio }}
                                @endif
                            </p>
                            <span class="show-full-description transparent-button transparent-button-primary instructor-bio-btn" data-toggle="modal" 
                                  style='display:none' data-target="#instructor-bio">
                                {{ trans( 'general.read-more' ) }}
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="container-fluid course-data">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 course-details-player">
<!--                <div class="pre-view-image video-player">
                    @if($course->previewImage !=null)
                        <img src="{{ cloudfrontUrl( $course->previewImage->format('desc') ) }}" />
                    @endif
                </div>-->
 
                <div class="video-wrap">
                @if( $video==null )
                    @if($course->external_video_url != '')
                        <div class="pre-view-image video-player" onclick="playVideo(this)" style="cursor:pointer">
                            <span class="play-intro-button" style="top: 162.5px; display: inline;"><i class="wa-play"></i><em>Play intro</em></span>
                            
                            <img src="{{ cloudfrontUrl( $course->previewImage->format('desc') ) }}" />
                        </div>
                        <div class="videoContainer" id="videoContainer" style="display:none">
                            {{ externalVideoPreview($course->external_video_url, false, true) }}
                        </div>
                    @else
                        <div class="pre-view-image video-player">
                            @if($course->previewImage !=null)
                                <img src="{{ cloudfrontUrl( $course->previewImage->format('desc') ) }}" />
                            @endif
                        </div>
                    @endif
                    
                @else
                    <video style="width: 100%" preload="auto" controls poster="{{ cloudfrontUrl( $course->previewImage->format() ) }}">
                        <source src="{{ $video->formats()->where('resolution', 'Custom Preset for Desktop Devices')
                                                    ->first()->video_url }}" type="video/mp4">
                        <p>Your browser does not support the video tag.</p>
                    </video>
                    {{--
                    <div class="video-player video-container description-page video-container-toggler" style="display:none; background:none; text-align: right">
                        @if( Agent::isMobile() )
                            <video id='myVideo' preload="auto" controls poster="{{ cloudfrontUrl( $course->previewImage->format() ) }}">
                                <source src="{{ $video->formats()->where('resolution', 'Low Resolution')
                                            ->first()->video_url }}" type="video/mp4">
                            </video>
                        @else


                            <div class="videoContainer">
                                <video id="myVideo" preload="auto" controls poster="{{ cloudfrontUrl( $course->previewImage->format() ) }}">
                                <source src="{{ $video->formats()->where('resolution', 'Custom Preset for Desktop Devices')
                                                    ->first()->video_url }}" type="video/mp4">
                                <p>Your browser does not support the video tag.</p>
                                </video>
                                <div class="control-container clearfix">
                                    <div class="control">

                                        <div class="btmControl clearfix">
                                            <div class="btnPlay btn" title="Play/Pause video">
                                                <i class="wa-play"></i>
                                                <i class="wa-pause"></i>
                                            </div>
                                            <div class="time hidden-xs">
                                                <span class="current"></span>
                                            </div>
                                            <div class="topControl">
                                                <div class="progress">
                                                    <span class="bufferBar"></span>
                                                    <span class="timeBar"></span>
                                                </div>
                                            </div>
                                            <div class="volume-container">
                                                <div class="volume" title="Set volume">
                                                        <span class="volumeBar">
                                                            <em></em>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="time hidden-xs">
                                                <span class="duration"></span>
                                            </div>
                                            <div class="btnFS btn" title="Switch to full screen"><i class="wa-expand"></i></div>
                                            <div class="sound sound2 btn hidden-xs" title="Mute/Unmute sound">
                                                <i class="wa-sound"></i>
                                                <i class="fa fa-volume-off"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="loading"></div>
                            </div>
                            <div id="lesson-video-overlay">
                                <div>
                                </div>
                            </div>
                            <span class="play-intro-button"><i class="wa-play"></i><em>{{ trans("courses/general.play-intro") }}</em></span>
                        @endif
                    </div>
                    --}}
                @endif
                </div>
                        <?php
                        if( Input::has('preview') ) echo View::make('courses.description.top-cache')->withCourse($course);
                        else{
                            echo Flatten::section('courses-show-details'.$course->id, Config::get('custom.cache-expiry.course-desc-top-details'), function () use( $course )  {
                                echo View::make('courses.description.top-cache')->withCourse($course);
                            }); 
                        }
                        ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 enroll-button-section right">
                <div class="enroll-button-wrap clearfix paid-content">
                @if($course->cost() > 0 && !Input::has('preview') )
                
                        {{-- Form::open(['action' => ["CoursesController@purchase", $course->slug], 'id' => 'purchase-form']) --}}
                        {{ Form::open([ 'disabled' => 'disabled', 'id' => 'purchase-form']) }}
 
                        @if(Auth::guest() || $student->canPurchase($course) )
                            <span class="price clearfix">
                                           ¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
                                         </span>
                            {{--
                            <button class="clearfix enroll-button blue-button extra-large-button">
                                {{ trans("courses/general.course-enroll") }}
                            </button>
                            --}}

                            <button class="clearfix enroll-button blue-button extra-large-button tooltipable" type="button"
                                    data-toggle='tooltip' data-placement='left' title='Opens on 10/9'
                                    onclick="{{--TEMP DISABLED Payment.showForm(this,event);--}}"
                                    data-product-type="course"
                                    data-product-id="{{$course->id}}"
                                    data-item-name="{{$course->name}}"
                                    data-price="{{$course->cost()}}">{{ trans("courses/general.course-enroll") }}</button>
                        @elseif(Auth::check() && $student->purchased($course) )
                            <span class="price clearfix"> ¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}</span>
                            <a class="clearfix enroll-button blue-button extra-large-button"
                               href="{{ action('ClassroomController@dashboard', $course->slug)}}">
                                {{ trans("courses/general.enter-classroom") }}
                            </a>
                        @else
                                <span class="price clearfix">
                                   ¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
                                 </span>
                            <button type='button' class="clearfix enroll-button blue-button extra-large-button tooltipable"
                                    data-toggle="tooltip" data-placement="left" 
                                    @if( Auth::user()->hasRole('Affiliate') )
                                        title="Log in to your student/instructor account to purchase."
                                    @else
                                        title="Available for customers"
                                    @endif
                                        >
                                {{ trans("courses/general.course-enroll") }}
                            </button>
                        @endif
 
                        <input type='hidden' name='gid' value='{{Input::get('gid')}}' />
                        <input type='hidden' name='aid' value='{{Input::get('aid')}}' />
                        {{Form::close()}}
                        @if($course->isDiscounted())
                            <p>Original <span> ¥{{ number_format($course->discount_original, Config::get('custom.currency_decimals')) }} </span> 
                                You saved <em> ¥{{ number_format($course->discount_saved, Config::get('custom.currency_decimals')) }}</em></p>
                        @endif
                        
                @elseif( !Input::has('preview') )
                
                    {{ Form::open(['action' => ["CoursesController@crashCourse", $course->slug], 'id' => 'purchase-form']) }}
                                @if(Auth::guest() || $student->canPurchase($course) )
                                    <span class="price clearfix ">{{trans('courses/general.free') }}</span>
                                     <button class="clearfix enroll-button blue-button extra-large-button join-class">
                                         {{ trans("courses/general.course-enroll") }}
                                     </button>
                                @elseif(Auth::check() && ( Auth::user()->hasRole('Affiliate') || $student->purchased($course) ) )
                                    <span class="price clearfix ">{{trans('courses/general.free') }}</span>
                                     <a class="clearfix enroll-button blue-button extra-large-button"
                                        href="{{ action('ClassroomController@dashboard', $course->slug)}}">
                                         {{ trans("courses/general.enter-classroom") }}
                                     </a>
                                @else
                            <span class="price clearfix ">{{trans('courses/general.free') }}</span>
                             <button class="clearfix enroll-button blue-button extra-large-button join-class" disabled="disabled">
                                 {{ trans("courses/general.course-enroll") }}
                                     </button>
                                @endif
 
                     {{Form::close()}}
                             
                            @if($course->isDiscounted())
                                <p>Original <span> ¥{{ number_format($course->discount_original, Config::get('custom.currency_decimals')) }} </span> 
                                    You saved <em> ¥{{ number_format($course->discount_saved, Config::get('custom.currency_decimals')) }}</em></p>
                            @endif
                            
                @else
                    {{ Form::open(['action' => ["CoursesController@purchase", $course->slug], 'id' => 'purchase-form']) }}
                        @if($course->isDiscounted())
                            <div class="price discount-box">
                                <div class="original-price text-muted text-left"><del>¥{{ number_format($course->discount_original, Config::get('custom.currency_decimals')) }}</del></div>
                                <div class="text-warning">
                                    <div class="discounted-price pull-left">¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}</div>
                                    <div class="discounted-time-left pull-right"><i class="fa fa-clock-o"></i> time here</div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- <p>
                                Original <span> ¥{{ number_format($course->discount_original, Config::get('custom.currency_decimals')) }} </span> 
                                You saved <em> ¥{{ number_format($course->discount_saved, Config::get('custom.currency_decimals')) }}</em>
                            </p> -->
                        @else
                            <span class="price clearfix">
                                @if($course->cost()>0)
                                    ¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
                                @else
                                    {{trans('courses/general.free') }}
                                @endif
                            </span>
                        @endif
                        <button class="clearfix enroll-button blue-button extra-large-button btn-block">
                            {{ trans("courses/general.course-enroll") }}
                        </button>
                    <input type='hidden' name='gid' value='{{Input::get('gid')}}' />
                    <input type='hidden' name='aid' value='{{Input::get('aid')}}' />
                    {{Form::close()}}
                @endif
               
                    </div>
                     <div class="column-3">
                        <div class="add-to-wishlist-container clearfix">
                            @if( !in_array($course->id, $wishlisted) )
                            	<span class="tooltipable" title="{{ trans('courses/general.add_to_wishlist')}}" style="display:inline-block !important">
                                    <i class="wish-icon-holder fa fa-heart-o  wishlist-change-button" data-auth="{{ intval(Auth::check() )}}" 
                                      data-url="{{action('WishlistController@change', $course->slug)}}" data-state="0" style="display:inline"
                                      data-icon-holder='.wish-icon-holder' data-text-holder='.wish-text-holder'></i>
                                    <span style='display:inline' class='wish-text-holder wishlist-change-button' data-auth="{{ intval(Auth::check() )}}" 
                                      data-url="{{action('WishlistController@change', $course->slug)}}" data-state="0" style="display:inline"
                                      data-icon-holder='.wish-icon-holder' data-text-holder='.wish-text-holder'>
                                        {{ trans('courses/general.add_to_wishlist')}}</span>
                                @else
                                <span class="tooltipable" title="{{ trans('courses/general.remove_from_wishlist')}}"  style="display:inline-block !important">
                                    <i class="wish-icon-holder fa fa-heart wishlist-change-button" data-auth="{{ intval(Auth::check() )}}"
                                       data-url="{{action('WishlistController@change', $course->slug)}}" data-state="1" style="display:inline"
                                       data-icon-holder='.wish-icon-holder' data-text-holder='.wish-text-holder'></i>
                                    <span style='display:inline' class='wish-text-holder wishlist-change-button'
                                           data-auth="{{ intval(Auth::check() )}}"
                                       data-url="{{action('WishlistController@change', $course->slug)}}" data-state="1" style="display:inline"
                                       data-icon-holder='.wish-icon-holder' data-text-holder='.wish-text-holder'>
                                        {{ trans('courses/general.remove_from_wishlist')}}</span>
                                @endif
                                
                                    
                                    
                                </span>
                                <?php
                                 
//                          {{//Form::open(['action' => ['WishlistController@store'] ])}}
//                                    <input type='hidden' name='id' value='{{// $course->id }}' />
//                                    <i class="wa-Heart"></i>
//                                    <input type='submit' class="add-to-wishlist" value='{{//trans('courses/general.add_to_wishlist')}}' />
//                                {{//Form::close()}}
                                    ?>
                            <!--<a href="#">{{ trans("general.add-to-wishlist") }}</a>-->
                            <a href="#" class="share-lesson no-margin"><i class="wa-Share"></i>{{ trans("general.share-this-lesson") }}</a>
                        </div>

                            </div>
                        </div>
    	</div>
 
    </div>
</section>
<?php 
    if( Input::has('preview')) echo View::make('courses.description.bottom-cache')->withCourse($course);
    else{
        echo Flatten::section('course-show-detailed-desc'.$course->id, Config::get('custom.cache-expiry.course-desc-bottom-details'), function () use( $course )  { 
            echo View::make('courses.description.bottom-cache')->withCourse($course);
        }); 
    }
    ?>
@if(Auth::guest() || !Auth::user()->hasRole('Instructor'))
    <section class="become-an-instructor-section container-fluid">
        <span class="background-image-overlay"></span>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <h1>{{trans('site/homepage.be-an-instructor')}}</h1>
                    <a href="{{ action('InstructorsController@become') }}" class="blue-button large-button">{{ trans('general.register') }}</a>
                </div>
            </div>
        </div>
    </section>
    @endif
            <!-- Modal -->
    <div class="modal fade" id="instructor-bio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        @if($instructor->profile == null)
                            {{$instructor->last_name}} {{$instructor->first_name}} 
                        @else
                            {{$instructor->profile->last_name}} {{$instructor->profile->first_name}} 
                        @endif
                    </h4>
                </div>
                <div class="modal-body">
                    @if( $course->show_bio=='custom' )
                        {{ $course->custom_bio }}
                    @else
                        {{ $instructor->profile->bio }}
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
 
    @stop
 
 
@section('extra_js')
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script>
        function unauthenticatedEnrollAttempt(){
            if( $('.login-to-purchase-alert').length == 0 ){
                $('#registerModal').find('h1').after('<p class="alert alert-danger login-to-purchase-alert">{{ trans('courses/general.login_to_purchase') }}</p>');
            }
            $('[data-target="#registerModal"]').first().click();
            
        }
        
        function playVideo(div){
            thevid=document.getElementById('videoContainer');
            thevid.style.display='block'; 
            div.style.display='none';
//            $("iframe").attr("src", $("iframe").attr("data-src").replace("autoplay=0", "autoplay=1"));
             $("#embeded-video")[0].src += "&autoplay=1";
        }
        $(function(){       
            @if( Auth::guest() )
                $('#purchase-form').submit(function(e){
                    e.preventDefault();
                    unauthenticatedEnrollAttempt();
                });
            @endif
            
            if( $('.instructor-bio-p').getLines() > 4){
                $('.instructor-bio-btn').show();
            }
            if( $('#myVideo').length > 0 || $('.videoContainer').length > 0  ){
                console.log('READY!');
//                $('.pre-view-image').first().hide();
                $('.video-container-toggler').show();
                skinVideoControls();
            }
 
            @if(Input::has('autoplay'))
            var video = $('#myVideo');
            video[0].play();
            $('.video-container.description-page #lesson-video-overlay').hide();
            $('.video-container.description-page .centered-play-button, .play-intro-button').hide();
 
            var playerWidth = video.innerWidth();
            var playerHeight = video.innerHeight();
            var centerPlayButtonHeight = $('.play-intro-button').outerHeight();
            var controlContainerHeight = $('.course-details-player .control-container').outerHeight();
            $('.play-intro-button').show().css('top', (playerHeight)/2 - centerPlayButtonHeight / 2);
 
            $('.btnPlay').addClass('playing').removeClass('paused');
            $('.btnPlay .wa-play').hide();
            $('.btnPlay .wa-pause').show();
            video[0].play();
            $('.centered-play-button, .play-intro-button').hide();
 
            @endif
        });



    </script>
@stop