    @extends('layouts.default')
    @section('content')	
        <section class="course-detail-top-section clearfix">
                @if($course->bannerImage != null)
                    <img src="{{$course->bannerImage->url}}" alt="" class="img-responsive" />
                @else
                    <!--<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/course-detail-banner-img.jpg" 
                         alt="" class="img-responsive" />-->
                @endif
        	
        	<div class="centered-contents clearfix">
                <ol class="breadcrumb">
                  <li><a href="{{action('CoursesController@category', [$course->courseCategory->slug] )}}">{{ $course->courseCategory->name }}</a></li>
                  <li class="active">
                      <a href='{{action('CoursesController@subCategory', [$course->courseCategory->slug, $course->courseSubcategory->slug] )}}'>
                          {{ $course->courseSubcategory->name }}
                      </a></li>
                </ol>
                <h1> {{ $course->name }}</h1>
                <div class="clearfix">
                	<!--<div class="level">{{ $course->courseDifficulty->name }}</div>-->
                </div>
                <div class="clearfix banner-content-wrapper">
                    <div class="number-of-students">{{ $course->student_count }} {{Lang::choice('general.student', $course->student_count)}}</div>
                    <div class="number-of-reviews">
                        21 REVIEWS
                        <span>89%</span>
                    </div>
                        @if($course->isDiscounted())
                            <div class="white-box">
                                <div class="sale-ends">SALE ENDS IN {{$course->discount_ends_in}}</div>
                        @else
                            <div class="white-box not-on-sale">
                                <!--<div class="sale-ends">SALE ENDS IN {{$course->discount_ends_in}}</div>-->
                        @endif
        
                        {{ Form::open(['action' => ["CoursesController@purchase", $course->slug], 'id' => 'purchase-form']) }}
                         @if(Auth::guest() || Auth::user()->can_purchase($course) )
                              <button class="join-class">
                         @else 
                              <button class="join-class" disabled="disabled">
                         @endif
                        <span>{{ trans("courses/general.enroll_for") }} ¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}</span>
                            </button>
                       
                        {{Form::close()}}
                        @if($course->isDiscounted())
                            <p>Original <span> ¥{{ number_format($course->discount_original, Config::get('custom.currency_decimals')) }} </span> 
                                You saved <em> ¥{{ number_format($course->discount_saved, Config::get('custom.currency_decimals')) }}</em></p>
                        @endif
                        <!--<a href="#" class="crash-class">CRASH CLASS</a>-->
                        <div class="clearfix wishlist-and-social">
                            {{Form::open(['action' => ['WishlistController@store'] ])}}
                            <input type='hidden' name='id' value='{{ $course->id }}' />
                            <!--<a href="#" class="add-to-wishlist">Add to Wishlist</a>-->
                            <input type='submit' class="add-to-wishlist" value='Add to Wishlist' />
                            {{Form::close()}}
                            <ul class="social-icons">
                                    <li><a href="#" class="twitter-icon"></a></li>
                                    <li><a href="#" class="fb-icon"></a></li>
                                    <li><a href="#" class="google-icon"></a></li>
                            </ul>
                        </div>             
                    </div>
                </div>
                <div class="video-player">
	                <a href="#" class="watch-video-button">WATCH VIDEO</a>
    				<span class="video-time">10:23</span>            
                </div>
                 
            </div>
        </section>
        <section class="main-content-container clearfix">
            @if($course->bannerImage!=null)
                <img src='{{$course->bannerImage->url}}' />
            @endif
        	<div class="main-content">
                    @if (Session::get('success'))
                        <div class="alert alert-success">{{{ Session::get('success') }}}</div>
                    @endif
                    @if (Session::get('error'))
                        <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
                    @endif
            	<div class="left-content">
                    <div class="testimonials">
                        <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                        </p>
                        <span class="name">Takeshi, muniku</span>
                    </div>
                    <p class="lead">Description</p>
                    <article class="bottom-margin">
                    {{$course->description}}
                    </article>
                    <!-- <p class="lead">Sub Description</p>
                    <article class="bottom-margin">
                    {{ $course->description }}
                    </article>
                    -->
                    <p class="lead what-you-will-learn">What you will archieve at the end of the course.</p>
                        <article class="bottom-margin what-you-will-learn">
                        <ul>
                        @if($achievements = json2Array($course->what_will_you_achieve))
                            @foreach($achievements as $achievement)
                                <li>{{ $achievement }}</li>
                            @endforeach
                        @endif    
                         </ul>
                    </article>
                </div>
                <div class="sidebar">
                    
                    <aside>
                    	<p class="lead">Who is this for?</p>
                         @if($who_for = json2Array($course->who_is_this_for))
                        <ul>
                            @foreach($who_for as $who)
                                <li>{{$who}}</li>
                            @endforeach
                        </ul>
                         @endif
                    </aside>
                    
                    <div class="your-teacher">
                        <div class="avater">
	                    	<p>Your Teacher</p>
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/teacher-avater.png" alt="" >
                        </div>
                        <h3>{{$course->instructor->first_name}} {{$course->instructor->last_name}}<span></span></h3>
                        <span class="role">Lead programmer, Wazaar</span>
                        <a href="#" class="follow-button">FOLLOW</a>
                        <h4>About {{$course->instructor->first_name}}</h4>
                        <p>
                        Description Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et 
                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo 
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim 
                        </p>
                    </div>
                    <div class="testimonial-block">
                    	<small>You are backed by our</small>
                        <div class="money-back">
                        	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/30-days-coupon.png" alt="">
                        	<p>MONEY BACK GUARANTEE</p>
                        </div>
                        <a href="#" class="crash-class clearfix">CRASH CLASS</a>
                        <a href="#" class="price clearfix">¥350,000</a>
                        <div class="testimonials">
                        	<h4>Testimonials</h4>
                            <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                            </p>
                            <span class="name">Takeshi, muniku</span>
                        </div>
                    </div>
                </div>
                <div class="curriculum clearfix clear">
                	<h3 class="text-center">
                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/divider.jpg" alt="">
                        Curriculum
                   	</h3>
<!--                    <div class="clearfix">
                        <div class="modules module-1 clearfix clear">
                            <p>Module 1</p>
                            <span>Introduction to Javascript</span>
                        </div>
                        <ul class="lesson-container">
                            <li class="lessons lesson-1 bordered">
                                <span>Lesson 1</span>
                                <p>e.g. what is javascript?</p>
                                <a href="#" class="crash-lesson-button">CRASH LESSON</a>
                            </li>
                            <li class="lessons lesson-1 bordered">
                                <span>Lesson 1</span>
                                <p>e.g. what is javascript?</p>
                                <a href="#" class="crash-lesson-button">CRASH LESSON</a>
                            </li>
                            <li class="lessons lesson-1 bordered">
                                <span>Lesson 1</span>
                                <p>e.g. what is javascript?</p>
                                <a href="#" class="crash-lesson-button">CRASH LESSON</a>
                            </li>
                            <li class="lessons lesson-1">
                                <span>Lesson 1</span>
                                <p>e.g. what is javascript?</p>
                                <a href="#" class="crash-lesson-button">CRASH LESSON</a>
                            </li>
                        </ul>
                    </div>-->
                    @foreach($course->modules as $module)
                    <div class="clearfix">
                        
                            <div class="modules module-1 clearfix clear">
                                <p>Module {{ $module->order }}</p>
                                <span>{{ $module->name }}</span>
                            </div>                        
                        <ul class="lesson-container">
                            @foreach($module->lessons as $lesson)
                                @if($lesson->id == $module->lessons->last()->id)
                                    <li class="lessons lesson-1">
                                @else
                                    <li class="lessons lesson-1 bordered">
                                @endif
                                    <span>Lesson {{ $lesson->order }}</span>
                                    <p>{{ $lesson->name }}</p>
                                    <a href="#" class="crash-lesson-button">CRASH LESSON</a>
                                </li>
                            @endforeach
                        </ul>
                        
                    </div>
                    @endforeach
                </div>
            </div>
            
            @if(Auth::guest() || !Auth::user()->hasRole('Instructor'))
                <section class="container-fluid become-an-instructor description">
                    <div class="container">
                      <div class="row">
                        <div class="col-xs-12">
                          <h1>BECOME</h1>
                          <h2>AN INSTRUCTOR</h2>
                          <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
                        </div>
                      </div>
                  </div>
                </section>
            @endif
        </section>
        <!--
        <section class="container">
            
			<!-- First row begins -->  
            <!--       
            <div class="row first-row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
               
                <div class="object big-box">
                	<div class="price-tag">
                     ¥ {{ number_format($course->price, Config::get('custom.currency_decimals')) }} {{trans('courses/general.sale')}}
                	</div>
                    <img 
                         @if($course->previewImage==null)
                            src="http://placehold.it/350x150&text=Preview Unavailable"
                        @else
                            src="{{$course->previewImage->url}}"
                        @endif
                        alt="" class="hidden-sm hidden-xs img-responsive">
                    <div>
                        <p>{{$course->description }}</p>
                        <div class="next_">
                        <div class="learn-more">
                            @if(Auth::guest() || Auth::user()->can_purchase($course) )
                                {{ Form::open(['action' => ["CoursesController@purchase", $course->slug], 'id' => 'purchase-form']) }}
                                <input type='submit' class='btn btn-primary' value='{{ trans("courses/general.purchase") }}' />
                                {{Form::close()}}
                            @endif
                        </div>        
                      </div>
                  </div>
                </div>
              </div>
            </div>       
         
			<!-- End of First row -->
            <!--
        </section>
        -->

    @stop