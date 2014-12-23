    @extends('layouts.default')
    @section('content')	
        <section class="course-detail-top-section clearfix">
                @if($course->bannerImage != null)
                    <img src="{{$course->bannerImage->url}}" alt="" class="img-responsive" />
                @else
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/course-detail-banner-img.jpg" 
                         alt="" class="img-responsive" />
                @endif
        	
        	<div class="centered-contents clearfix">
            	<h1> {{ $course->name }}</h1>
                <div class="clearfix">
                	<div class="level">{{ $course->courseDifficulty->name }}</div>
                    <div class="number-of-students">{{ $course->student_count }} {{Lang::choice('general.student', $course->student_count)}}</div>
                </div>
                <div class="number-of-reviews">
                	21 REVIEWS
                    <span>89%</span>
                </div>
                
                
                        @if($course->isDiscounted())
                        <div class="white-box">
                            <div class="sale-ends">SALE ENDS IN {{$course->discount_ends_in}}</div>
                        @else
                        <div class="white-box not-on-sale">
                        @endif
                        
                        {{ Form::open(['action' => ["CoursesController@purchase", $course->slug], 'id' => 'purchase-form']) }}
                         @if(Auth::guest() || Auth::user()->can_purchase($course) )
                              <button class="join-class">
                         @else 
                              <button class="join-class" disabled="disabled">
                         @endif
                        {{ trans("courses/general.join_class") }}<span>¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}</span>
                            </button>
                       
                        {{Form::close()}}
                         @if($course->isDiscounted())
                            <p>Original <span> ¥{{ number_format($course->discount_original, Config::get('custom.currency_decimals')) }} </span> 
                                You saved <em> ¥{{ number_format($course->discount_saved, Config::get('custom.currency_decimals')) }}</em></p>
                        @endif
                        <a href="#" class="crash-class">CRASH CLASS</a>
                        <div class="clearfix">
                            <a href="#" class="add-to-wishlist">Add to Wishlist</a>
                            <ul class="social-icons">
                                    <li><a href="#" class="twitter-icon"></a></li>
                                    <li><a href="#" class="fb-icon"></a></li>
                                    <li><a href="#" class="google-icon"></a></li>
                            </ul>
                        </div>
                   
                	
                    
                </div>
                <a href="#" class="watch-video-button">WATCH VIDEO</a>
                 
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
                    <p class="lead">Description</p>
                    <article class="bottom-margin">
                    {{$course->description}}
                    </article>
                	<p class="lead">What you will archieve at the end of the course.</p>
                    <article class="bottom-margin">
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
                    	<p class="lead">Your Teacher</p>
                        <div class="avater">
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
                </div>
                <div class="curriculum clearfix clear">
                	<h3>Curriculum</h3>
                    <div class="lessons clearfix">
                    	<span>Module 1</span>
                        <p>Creating a splash screen with javascript</p>
                        <a href="#" class="button">CRASH CLASS</a>
                    </div>
                    <div class="lessons clearfix">
                    	<span>Lesson 1</span>
                        <p>Introduction</p>
                    </div>
                    <div class="lessons clearfix">
                    	<span>Lesson 2</span>
                        <p>Your very first</p>
                    </div>
                    <div class="lessons clearfix">
                    	<span>Lesson 3</span>
                        <p>Time to show it off!</p>
                    </div>
                    <div class="assignment">
                    	<span>Assignment 1</span>
                        <p>Your very first Javascript code</p>
                    </div>
                </div>
            </div>
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