    @extends('layouts.default')
    @section('content')	
        <section class="course-detail-top-section clearfix">
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
                @if(Auth::guest() || Auth::user()->can_purchase($course) )
                <div class="white-box">
                    
                        <div class="sale-ends">SALE ENDS IN 2 DAYS 15:22:21</div>
                        
                        {{ Form::open(['action' => ["CoursesController@purchase", $course->slug], 'id' => 'purchase-form']) }}
                       
                            <button class="join-class">
                                {{ trans("courses/general.join_class") }}<span>¥{{ number_format($course->price, Config::get('custom.currency_decimals')) }}</span>
                            </button>
                       
                        {{Form::close()}}
                         
                        <p>Original <span> ¥500.000 </span> You saved <em> ¥150.000</em></p>
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
                 @endif
            </div>
        </section>
        <section class="main-content-container clearfix">
        	<div class="main-content">
            	<div class="left-content">
                    <p class="lead">Description</p>
                    <article class="bottom-margin">
                    {{$course->description}}
                    </article>
                	<p class="lead">What you will archieve at the end of the course.</p>
                    <article class="bottom-margin">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure 
                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non 
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit 
                    voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto 
                    beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur 
                    magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, 
                    adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.                    	
                    </article>
                </div>
                <div class="sidebar">
                	<aside>
                    	<p class="lead">Who is this for?</p>
                        <ul>
                        	<li>Beginners that don’t know anything about C++ and that want to start from scratch</li>
                        	<li>Existing who want to pick up javascript.</li>
                        	<li>Exiting students that want to learn extra next to their study</li>
                        </ul>
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
                    <div class="lessons">
                    	<span>Module 1</span>
                        <p>Creating a splash screen with javascript</p>
                        <a href="#" class="button">CRASH CLASS</a>
                    </div>
                    <div class="lessons">
                    	<span>Lesson 1</span>
                        <p>Introduction</p>
                    </div>
                    <div class="lessons">
                    	<span>Lesson 2</span>
                        <p>Your very first</p>
                    </div>
                    <div class="lessons">
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
            @if (Session::get('success'))
                <div class="alert alert-success">{{{ Session::get('success') }}}</div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
            @endif
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