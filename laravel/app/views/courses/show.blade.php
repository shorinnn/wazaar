    @extends('layouts.default')
        
    @section('page_title')
    {{ $course->name }} -
    @stop
    
    @section('content')	
    <style>
    .inline-block{
        display:inline-block;
    }
    </style>
@if(Auth::check() && Auth::user()->hasRole('Affiliate'))
<div style="background-color:silver;" class='text-center'>
    <a href='{{ action('AffiliateController@promote', $course->slug)}}' class='btn btn-warning btn-sm'>{{ trans('courses/promote.promote') }}</a>
</div>
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
                                    <!--<li class="tags">
                                        <a href="#">Information</a>
                                    </li>
                                    <li class="tags">
                                        <a href="#">Tech & Design </a>
                                    </li>
                                    <li class="tags">
                                        <a href="#">Engineering</a>
                                    </li>-->
                                </ul>
                            </div>
                            <!--<ol class="breadcrumb">
                              <li><a href="{{action('CoursesController@category', [$course->courseCategory->slug] )}}">{{ $course->courseCategory->name }}</a></li>
                              <li class="active">
                                  <a href='{{action('CoursesController@subCategory', [$course->courseCategory->slug, $course->courseSubcategory->slug] )}}'>
                                      {{ $course->courseSubcategory->name }}
                                  </a></li>
                            </ol>-->
                            <h1> {{ $course->name }}</h1>
                            <!--
                            
                            <div class="clearfix banner-content-wrapper">
                                <div class="number-of-students"></div>
                                <a href="#bottom-student-reviews" class="number-of-reviews">                   
                                    <span>{{ $course->reviews_positive_score }}%</span>
                                </a>
                                    @if($course->isDiscounted())
                                        <div class="white-box">
                                            <div class="sale-ends">SALE ENDS IN {{$course->discount_ends_in}}</div>
                                    @else
                                        <div class="white-box not-on-sale">
                                            <!--<div class="sale-ends">SALE ENDS IN {{$course->discount_ends_in}}</div>-->
                                            
                               <!--
                               
                                    @endif
                            
                            
                                    <!--<a href="#" class="crash-class">CRASH CLASS</a>-->
                                    
                        <!--
                                    <div class="clearfix wishlist-and-social">
                                        
                                        <!--<a href="#" class="add-to-wishlist">Add to Wishlist</a>-->
                         <!--
                                        
                                        <ul class="social-icons">
                                                <li><a href="#" class="twitter-icon"></a></li>
                                                <li><a href="#" class="fb-icon"></a></li>
                                                <li><a href="#" class="google-icon"></a></li>
                                        </ul>
                                    </div>             
                                </div>
                            </div>
                        
                        -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-push-8 col-lg-push-8">
                            <div class="instructor margin-top-30 margin-bottom-30">
                                <!--<h2>{{ trans('courses/general.instructor') }}</h2>-->
                                @if( $instructor!=null )
                                    @if($instructor->profile == null)
                                        <div class="clearfix">
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/profile_pictures/avatar-placeholder.jpg" alt="" >
                                            <em>{{$instructor->first_name}} {{$instructor->last_name}}</em>
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
                                            <em class="name">{{$instructor->profile->first_name}} {{$instructor->profile->last_name}}</em>
                                            <span class="instructor-skills">{{ $instructor->profile->title }}</span>
                                        </div>
                                        <!--@if(Auth::check())
                                            {{ View::make('courses.followed_form')->withInstructor($instructor) }}
                                        @endif-->
                                        <!--<h4>{{ trans('general.about') }} {{$instructor->profile->first_name}}</h4>-->
                                        <p class="clearfix regular-paragraph expandable-content short-text">
                                            @if( $course->show_bio=='custom' )
                                                {{ $course->custom_bio }}
                                            @else
                                                {{ $instructor->profile->bio }}
                                            @endif
                                        </p>                                                                  
                                        <span class="show-full-description blue-button large-button" data-toggle="modal" data-target="#instructor-bio">Read more</span>
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
                            <div class="pre-view-image video-player">
                                <img src="{{ cloudfrontUrl( $course->previewImage->url) }}" />
                            </div>
                        @if( $video==null )
                            <!--!-->       
                        @else
                        <div class="video-player video-container description-page video-container-toggler" style="display:none; background:none; text-align: right">
                            @if( Agent::isMobile() )
                                <video id='myVideo' preload="auto" controls poster="{{ cloudfrontUrl( $course->previewImage->url) }}">
                                    <source src="{{ $video->formats()->where('resolution', 'Custom Preset for Mobile Devices')
                                            ->first()->video_url }}" type="video/mp4">
                                </video>
                            @else
    
    
                                <div class="videoContainer">
                                    <video id="myVideo" preload="auto" poster="{{ cloudfrontUrl( $course->previewImage->url) }}" />
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
                                                <div class="sound sound2 btn hidden-xs" title="Mute/Unmute sound">
                                                	<i class="wa-sound"></i>
                                                    <i class="fa fa-volume-off"></i>
                                                </div>
                                                <div class="btnFS btn" title="Switch to full screen"><i class="wa-expand"></i></div>
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
                        @endif                                        
                    	</div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 enroll-button-section">
                        @if( admin() )
                             <a href='{{ action( "ClassroomController@dashboard" ,['slug'=> $course->slug] ) }}' class="enroll-button">Classroom</a>
                        @endif
                        @if($course->cost() > 0)
                            {{ Form::open(['action' => ["CoursesController@purchase", $course->slug], 'id' => 'purchase-form']) }}

                                @if(Auth::guest() || Student::find(Auth::user()->id)->canPurchase($course) )
                                     <span class="price clearfix">                                          	
                                       ¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
                                     </span>
                                     <button class="clearfix enroll-button blue-button extra-large-button">
                                     {{ trans("courses/general.enroll") }} 
                                @else 
                                     <span class="price clearfix">
                                     </span>
                                     <button class="clearfix enroll-button blue-button extra-large-button" disabled="disabled" data-toggle="tooltip" data-placement="left" title="Available for customers">
                                      {{ trans("courses/general.enroll") }} 

                                @endif
                                   </button>
                                <input type='hidden' name='gid' value='{{Input::get('gid')}}' />
                                <input type='hidden' name='aid' value='{{Input::get('aid')}}' />
                            {{Form::close()}}
                            <!--@if($course->isDiscounted())
                                <p>Original <span> ¥{{ number_format($course->discount_original, Config::get('custom.currency_decimals')) }} </span> 
                                    You saved <em> ¥{{ number_format($course->discount_saved, Config::get('custom.currency_decimals')) }}</em></p>
                            @endif-->
                        @else
                             {{ Form::open(['action' => ["CoursesController@crashCourse", $course->slug], 'id' => 'purchase-form']) }}
                                @if(Auth::guest() || Student::find(Auth::user()->id)->canPurchase($course) )
                                     <button class="clearfix enroll-button blue-button extra-large-button join-class margin-top-50">
                                @else 
                                     <button class="clearfix enroll-button blue-button extra-large-button join-class margin-top-50" disabled="disabled">
                                @endif
                               {{ trans("courses/general.enroll_for_free") }}
                                   </button>
                            {{Form::close()}}
                            
                            @if($course->isDiscounted())
                                <p>Original <span> ¥{{ number_format($course->discount_original, Config::get('custom.currency_decimals')) }} </span> 
                                    You saved <em> ¥{{ number_format($course->discount_saved, Config::get('custom.currency_decimals')) }}</em></p>
                            @endif
                        @endif
                        

                    </div>
                </div>
            	<div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 column-1">
                    	<div class="number-of-lessons">
                            <span>{{ trans("general.lessons") }}</span>
                            <em>{{ $course->lessonCount(false) }}</em>
                            
                        </div>
                    	<div class="number-of-students">
                            <span>{{Lang::choice('general.student', $course->student_count)}}</span>
                            <em>{{ $course->student_count }} </em>
                            
                        </div>
                    	<div class="number-of-videos">
                        	<span>{{ trans("general.time") }}</span>
                            <em>{{ $course->videoHours(false) }}h</em>
                            
                        </div>
                    	<div class="recommends">
                        	<span>{{ trans("general.recommends") }}</span>
                            <em>{{ $course->reviews_positive_score }}%</em>
                            
                        </div>
                    	<div class="difficulty-level">
                        	<span>{{ trans("general.difficulty") }}</span>
                                <em> {{ trans('general.'.$course->courseDifficulty->name) }}</em>
                            
                        </div>
                    	<!--<div class="star-rating">
                        	<em>{{ $course->total_reviews }}</em>
                            <span>
                            {{-- singplural($course->total_reviews, 'REVIEWS') --}}
                            {{ Lang::choice( 'courses/general.reviews', $course->total_reviews) }}
                            <!--{{ trans("general.reviews") }}-->
                            <!--</span>
                        </div>-->
                    </div>
                	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 column-3">
                        <div class="add-to-wishlist-container clearfix">
                        	
                        	{{Form::open(['action' => ['WishlistController@store'] ])}}
                                    <input type='hidden' name='id' value='{{ $course->id }}' />
                                    <i class="wa-Heart"></i>
                                    <input type='submit' class="add-to-wishlist" value='{{trans('courses/general.add_to_wishlist')}}' />
                                {{Form::close()}}
                        	<!--<a href="#">{{ trans("general.add-to-wishlist") }}</a>-->
                            <a href="#" class="share-lesson no-margin"><i class="wa-Share"></i>{{ trans("general.share-this-lesson") }}</a>                        
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="course-description-container container-fluid clearfix">
            @if($course->bannerImage==='has banner bro')
                <img src='{{$course->bannerImage->url}}' />
            @endif
        	<div class="main-content container">
            	<div class="row">
                	<div class="col-xs-12 col-sm-12 col-md-8">
                        @if (Session::get('success'))
                        <div class="alert alert-success">{{{ Session::get('success') }}}</div>
                        @endif
                        @if (Session::get('error'))
                        <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
                        @endif
                        <div class="course-description no-margin-top module-box padding-top-30 padding-bottom-20">
                        	<h2>{{ trans('courses/general.about-this-course') }}</h2>
                                <p class="intro-paragraph expandable-content short-text">              	
                                    {{$course->description}}
                                </p>
                                <div class="fadeout-text"></div>
                                <span class="show-full-description expandable-button show-more" data-less-text='Show less description' data-more-text='Show full description'> {{ trans("courses/general.show-full-description") }}</span>
                        </div>
                        <div class="what-you-will-learn no-margin-top module-box padding-top-30 padding-bottom-20">
                            <h2>{{ trans('courses/general.what-you-will-learn') }}</h2>
                            <ul>
                                @if($achievements = json2Array($course->what_will_you_achieve))
                                    @foreach($achievements as $achievement)
                                        <li>{{ $achievement }}</li>
                                    @endforeach
                                @endif    
                            </ul>
                        </div>

                        <div class="who-its-for no-margin-top module-box padding-top-30 padding-bottom-20">
                        	<h2>{{ trans('courses/general.who_is_this_for?') }}</h2>
                             @if($who_for = json2Array($course->who_is_this_for))
                            <ul>
                                @foreach($who_for as $who)
                                    <li>{{$who}}</li>
                                @endforeach
                            </ul>
                             @endif
                        </div>
                        
                        <div class="requirements no-margin-top module-box padding-top-30 padding-bottom-20">
                            <h2>{{ trans('courses/general.requirements') }}</h2>
                            @if($requirements = json2Array($course->requirements))
                                <ul>
                                @foreach($requirements as $requirement)
                                    <li>{{ $requirement }}</li>
                                @endforeach
                                </ul>
                            @endif    
                        </div>

                        @foreach($course->modules as $module)
                        <div class="module-box">
                        	<h2>{{ $module->order }}. {{ $module->name }}</h2>
                            <p class="regular-paragraph">
                            <!--A short description of the module goes here...-->
                            </p>
                            <ul class="lesson-topics expandable-content clearfix">
                            @foreach($module->lessons as $lesson)
                                @if($lesson->id == $module->lessons->last()->id)
                                    <li class="lessons lesson-1">
                                @else
                                    <li class="lessons lesson-1 bordered clearfix">                                    	                                    
                                @endif
                                		<span><i class="wa-play"></i></span>
                                        <a href="#" class="clearfix lesson-name">{{ $lesson->name }}
                                        	
                                        </a>
                                        <!--<em>Type of lesson</em>-->
                                        <div class="buttons">
                                            @if($lesson->blocks()->where('type','video')->first() != null
                                                && VideoFormat::where('video_id', $lesson->blocks()->where('type','video')->first()->content )
                                                        ->first() !=null 
                                                )
                                            <a href="#" class="default-button reading-button large-button">
                                            {{ 
                                                VideoFormat::where('video_id', $lesson->blocks()->where('type','video')->first()->content )->first()
                                                        ->duration 
                                            }}</a>
                                        @endif
                                            
                                            @if( $lesson->free_preview == 'yes' )
                                                <!--<a href="#" class="default-button preview-button large-button">Preview</a>-->
                                                
                                                {{ Form::open( [ 'action' => ['CoursesController@crashLesson', $course->slug, $lesson->slug ], 'class' => 'inline-form' ] ) }}
                                                    <button type="submit" class='default-button preview-button large-button'
                                                    @if( Auth::check() && ( !Auth::user()->canPurchase($course) || !Auth::user()->canPurchase($lesson) ) )
                                                        disabled="disabled" data-crash-disabled='1'
                                                    @endif
                                                            >{{ trans('courses/general.free_preview') }}</button>
                                                {{ Form::close() }}
                                            @else
                                                @if( $lesson->individual_sale == 'yes' )
                                                    <!--<a href="#" class="blue-button buy-button large-button">Buy</a>-->
                                                     {{ Form::open( [ 'action' => ['CoursesController@purchaseLesson', $course->slug, $lesson->slug ], 'class' => 'inline-form' ] ) }}
                                                        <button class="blue-button buy-button large-button" 
                                                                @if( Auth::check() && ( !Auth::user()->canPurchase($course) || !Auth::user()->canPurchase($lesson) ) )
                                                                disabled="disabled" data-crash-disabled='1'
                                                                @endif
                                                                >{{ trans('courses/general.purchase') }}</button>
                                                        {{ Form::close() }}
                                                @endif
                                            @endif
                                            
                                            
                                        
                                        </div>
                                    </li>
                            	<!--<li>
                                	<a href="#">Welcome to Marketing in a Digital World
                                    	<span>5 min</span>
                                    </a>
                                </li>
                            	<li>
                                	<a href="#">What is Marketing?
                                    	<span>Reading</span>
                                    </a>
                                </li>
                            	<li>
                                	<a href="#">Getting to Know Your Classmates
                                    	<span>Quiz</span>
                                    </a>
                                </li>
                            	<li>
                                	<a href="#">Social Media
                                    	<span>11 min</span>
                                    </a>
                                </li>-->
                                @endforeach
                            </ul>
                            <span class="hide-lesson-topics expandable-button show-more"
                            	data-less-text='Show less lessons' 
                                data-more-text='Show more lessons'>Show more lessons</span>
                        </div>
                        @endforeach
                        
                        <div class="reviews instructed-by clearfix module-box">
                            <div class="row">
                                <div class="user-thumb col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                	<img src="{{cloudfrontUrl("//s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg")}}" class="img-responsive" />
                                </div>
                                <div class="user-review col-xs-9 col-sm-10 col-md-10 col-lg-10">
                                  <div class="clearfix margin-bottom-20">
                                  	<h4>Instructed by <em class="name"> Saulius Kirklys</em></h4>
                                    <span class="role">Visual Designer</span>
                                  </div>
                                  <p class="regular-paragraph expandable-content">
                                    Saulius is a designer, speaker and teacher. He designs great User interfaces at Cocorium.         
                                  </p>
                                  <div class="fadeout-text"></div>
                                  <span class="view-more-reviews expandable-button show-more" data-less-text='Less' data-more-text='More'>{{ trans("courses/general.more") }}</span>                                
                                </div>
                            </div>
                        </div>
                        
                        @if($course->allTestimonials->count() > 0)
                        <div class="lesson-reviews">
                            <h2>{{ $course->testimonials()->count() }} {{ trans("courses/general.reviews") }}</h2>
                            <div class='bottom-testimonials'>
                                @foreach($course->allTestimonials as $testimonial)
                                    <!--<div>-->
                                   {{ View::make('courses.testimonials.testimonial')->with( compact('testimonial') ) }}
                                   <!--</div>-->
                                @endforeach
                            </div>
                            
                            <!--<span class="read-all-reviews">Read all reviews</span>-->
                            <a href='1' id="load-more-ajax-button" class="load-more-comments load-more-ajax read-all-reviews" 
                               data-url='{{ action('TestimonialsController@more') }}' 
                               data-target='.bottom-testimonials' data-skip='2' data-id='{{ $course->id }}' data-post-field="course">
                                {{ trans('general.read-all-reviews') }}
                            </a>
                        </div>
                        @endif
                        <!--<div class="curriculum clearfix clear">
                            <h3 class="text-center">
                                <!--<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/divider.jpg" alt="">-->
                                <!--{{ trans('courses/general.curriculum') }}
                            </h3>
        
                            @foreach($course->modules as $module)
                            <div class="clearfix">
                                
                                    <div class="modules module-1 clearfix clear">
                                        <p>{{trans('courses/general.module')}} {{ $module->order }}</p>
                                        <span>{{ $module->name }}</span>
                                    </div>                        
                                <ul class="lesson-container">
                                    @foreach($module->lessons as $lesson)
                                        @if($lesson->id == $module->lessons->last()->id)
                                            <li class="lessons lesson-1">
                                        @else
                                            <li class="lessons lesson-1 bordered">
                                        @endif
                                            <span>{{trans('courses/general.lesson')}} {{ $lesson->order }}</span>
                                            <p>{{ $lesson->name }}</p>
                                            @if($lesson->price==0)
                                            
                                            {{ Form::open( [ 'action' => ['CoursesController@crashLesson', $course->slug, $lesson->slug ] ] ) }}
                                                <button type="submit" class='btn crash-lesson-button pull-right'
                                                @if( Auth::guest() || !Auth::user()->canPurchase($course) || !Auth::user()->canPurchase($lesson) )
                                                    disabled="disabled" data-crash-disabled='1'
                                                @endif
                                                        >{{ trans('courses/general.crash_class') }}</button>
                                            {{ Form::close() }}
                                            
                                            @else
                                            
                                            {{ Form::open( [ 'action' => ['CoursesController@purchaseLesson', $course->slug, $lesson->id ] ] ) }}
                                            <!--<a href="#" class="crash-lesson-button">CRASH LESSON</a>-->
                                            <!--<button class="btn crash-lesson-button pull-right" 
                                                    @if( Auth::guest() || !Auth::user()->canPurchase($course) || !Auth::user()->canPurchase($lesson) )
                                                    disabled="disabled" data-crash-disabled='1'
                                                    @endif
                                                    >{{ trans('courses/general.purchase') }}</button>
                                            {{ Form::close() }}
                                            
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                
                            </div>
                            @endforeach
                        </div>-->
              		</div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="sidebar"> 
                            <!--<div class="money-back">
                        		<small>{{ trans('general.you-are-backed-by-our') }}</small>                           
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/30-days-coupon.png" alt="">
                                <p>{{ trans('general.money-back-guarantee') }}</p>
                            </div>-->
                            <!--<div class="who-its-for">
                                 @if($who_for = json2Array($course->who_is_this_for))
                                <ul>
                                    @foreach($who_for as $who)
                                        <li>{{$who}}</li>
                                    @endforeach
                                </ul>
                                 @endif
                            </div>-->


                            <!--<div class="testimonial-block">        
                                <div class="testimonials">
                                    @if($course->testimonials->count() > 1)
                                    <h4> {{ trans('courses/general.testimonials') }}</h4>
                                        <p>
                                         {{{ $course->testimonials->last()->content }}}
                                        </p>
                                        <span class="name">
                                            {{$course->testimonials->last()->student->first_name}}
                                            {{$course->testimonials->last()->student->last_name}}
                                        </span>
                                    @endif
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
		</section>                        
        @if(Auth::guest() || !Auth::user()->hasRole('Instructor'))
            <section class="container-fluid become-an-instructor description">
                <div class="container">
                  <div class="row">
                    <div class="col-xs-12">
                      <h1>{{ trans('site/homepage.become') }}</h1>
                      <h2>{{ trans('site/homepage.an-instructor') }}</h2>
                      <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
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
            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    @stop
    

    @section('extra_js')
        <script>
            $(function(){
                if( $('#myVideo').length > 0){
                   console.log('READY!');
                   $('.pre-view-image').hide(); 
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
