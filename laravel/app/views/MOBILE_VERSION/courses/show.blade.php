    @extends('MOBILE_VERSION.layouts.mobile')
    
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
        <section class="course-detail-top-section clearfix unauthenticated-homepage cat-box-{{$course->courseCategory->color_scheme}}">
                @if($course->bannerImage != null)
                    <img src="{{$course->bannerImage->url}}" alt="" class="img-responsive" />
                @else
                    <!--<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/course-detail-banner-img.jpg" 
                         alt="" class="img-responsive" />-->
                @endif
        	
        	<div class="centered-contents clearfix">
                <!--<ol class="breadcrumb">
                  <li><a href="{{action('CoursesController@category', [$course->courseCategory->slug] )}}">{{ $course->courseCategory->name }}</a></li>
                  <li class="active">
                      <a href='{{action('CoursesController@subCategory', [$course->courseCategory->slug, $course->courseSubcategory->slug] )}}'>
                          {{ $course->courseSubcategory->name }}
                      </a></li>
                </ol>-->
                <h1> {{ $course->name }}</h1>
                <p class="short-course-description">Lorem ipsum blah blah blah</p>
                
                <div class="your-teacher">
                    <div class="avater">
                            
                            @if($instructor->profile == null)
	                                <h3>{{ trans("courses/general.by") }}<a href="#">{{$instructor->first_name}} {{$instructor->last_name}}</a><span></span></h3>
                                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/teacher-avater.png" alt="" >
                                </div>
                                <!--<span class="role">Lead programmer, Wazaar</span>-->
                            @else
                             <h3>{{ trans("courses/general.by") }} <a href="#">{{$instructor->profile->first_name}} {{$instructor->profile->last_name}}</a><span></span></h3>  
                             <img src="{{ $instructor->profile->photo }}" alt="" >
                                </div>
                            @endif
                </div>
                
                <div class="clearfix">
                	<!--<div class="level">{{ $course->courseDifficulty->name }}</div>-->
                </div>
                
                <div class="video-player-wrapper">
                    @if( $video==null )
                    <div class="video-player"
                         @if( $course->bannerImage != null)
                         style="background-image:url('{{$course->bannerImage->url}}') !important"
                         @endif
                         >
                    <a href="#" class="watch-video-button">WATCH VIDEO</a>
                    <span class="video-time">10:23</span>
                    <div class="overlay"></div>            
                    @else
                    <div class="video-player" style="background:none; text-align: right">
                        @if( Agent::isMobile() )
                            <!--<video id='myVideo' controls><source src="{{ $video->formats()->where('resolution', 'Custom Preset for Mobile Devices')
                                        ->first()->video_url }}" type="video/mp4"></video>-->
                            <video id='myVideomobile'  height="266" controls><source src="{{ $video->formats()->where('resolution', 'Custom Preset for Desktop Devices')
                                        ->first()->video_url }}" type="video/mp4"></video>
                        @else
                        <video id='myVideodesktop'  height="266" controls><source src="{{ $video->formats()->where('resolution', 'Custom Preset for Desktop Devices')
                                        ->first()->video_url }}" type="video/mp4"></video>
                        @endif
                    @endif
                    </div>
                </div>
                <div class="course-features">
                	<div class="mobile-learning">
                    	<span>Mobile<br>Learning
                    </div>
                    <div class="money-back-seal">
                    	<span>Money-back <br> Guarantee</span>
                    </div>
                    <div></div>
                </div>
                <div class="clearfix banner-content-wrapper">
                    <!--<div class="number-of-students">{{ $course->student_count }} {{Lang::choice('general.student', $course->student_count)}}</div>-->
                    <!--<a href="#bottom-student-reviews" class="number-of-reviews">
                        {{ $course->total_reviews }} 
                        {{-- singplural($course->total_reviews, 'REVIEWS') --}}
                        
                        {{ Lang::choice( 'courses/general.reviews', $course->total_reviews) }}
                        
                        <span>{{ $course->reviews_positive_score }}%</span>
                    </a>-->
                        @if($course->isDiscounted())
                            <div class="white-box">
                                <!--<div class="sale-ends">SALE ENDS IN {{$course->discount_ends_in}}</div>-->
                        @else
                            <div class="white-box not-on-sale">
                                <!--<div class="sale-ends">SALE ENDS IN {{$course->discount_ends_in}}</div>-->
                        @endif
        
                        @if($course->cost() > 0)
                            {{ Form::open(['action' => ["CoursesController@purchase", $course->slug], 'id' => 'purchase-form']) }}
                             @if(Auth::guest() || Student::find(Auth::user()->id)->canPurchase($course) )
                                  <button class="join-class">
                             @else 
                                  <button class="join-class" disabled="disabled">
                             @endif
                            <span>{{ trans("courses/general.enroll_for") }} ¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}</span>
                                </button>
                             <input type='hidden' name='gid' value='{{Input::get('gid')}}' />
                             <input type='hidden' name='aid' value='{{Input::get('aid')}}' />
                            {{Form::close()}}
                            @if($course->isDiscounted())
                                <!--<p>Original <span> ¥{{ number_format($course->discount_original, Config::get('custom.currency_decimals')) }} </span> 
                                    You saved <em> ¥{{ number_format($course->discount_saved, Config::get('custom.currency_decimals')) }}</em></p>-->	
                            @endif
                        @else
                             {{ Form::open(['action' => ["CoursesController@crashCourse", $course->slug], 'id' => 'purchase-form']) }}
                             @if(Auth::guest() || Student::find(Auth::user()->id)->canPurchase($course) )
                                  <button class="join-class">
                             @else 
                                  <button class="join-class" disabled="disabled">
                             @endif
                            <span>{{ trans("courses/general.enroll_for_free") }}</span>
                                </button>

                            {{Form::close()}}
                            @if($course->isDiscounted())
                                <!--<p>Original <span> ¥{{ number_format($course->discount_original, Config::get('custom.currency_decimals')) }} </span> 
                                    You saved <em> ¥{{ number_format($course->discount_saved, Config::get('custom.currency_decimals')) }}</em></p>-->
                            @endif
                        @endif
                        <!--<a href="#" class="crash-class">CRASH CLASS</a>-->
                        <!--<div class="clearfix wishlist-and-social">
                            {{Form::open(['action' => ['WishlistController@store'] ])}}
                            <input type='hidden' name='id' value='{{ $course->id }}' />
                            <!--<a href="#" class="add-to-wishlist">Add to Wishlist</a>-->
                            <!--<input type='submit' class="add-to-wishlist" value='{{trans('courses/general.add_to_wishlist')}}' />
                            {{Form::close()}}
                            <ul class="social-icons">
                                    <li><a href="#" class="twitter-icon"></a></li>
                                    <li><a href="#" class="fb-icon"></a></li>
                                    <li><a href="#" class="google-icon"></a></li>
                            </ul>
                        </div>-->             
                    </div>
                </div>
                        
            </div>
        </section>
        <section class="main-content-container clearfix">
            @if($course->bannerImage==='has banner bro')
                <img src='{{$course->bannerImage->url}}' />
            @endif
        	<div class="main-content">
                    @if (Session::get('success'))
                        <div class="alert alert-success">{{{ Session::get('success') }}}</div>
                    @endif
                    @if (Session::get('error'))
                        <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
                    @endif
                <div class="middle-content-wrapper panel-group clearfix" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="left-content">
                        <!--@if($course->testimonials->count() > 0)
                            <div class="testimonials top-testimonials">
                                <p>
                                {{{ $course->testimonials->first()->content }}}
                                </p>
                                <span class="name">
                                    {{$course->testimonials->first()->student->first_name}}
                                    {{$course->testimonials->first()->student->last_name}}
                                </span>
                            </div>
                        @endif-->
                        <div class="misc-container-1 panel panel-default no-margin">
                        	<div class="panel-heading" role="tab" id="headingOne">
                            	<div class="panel-title">
                            		<p class="lead what-you-will-learn collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">{{trans('courses/general.what_you_will_achieve')}}.</p>
                                </div>
                            </div>
                            <article id="collapseOne" class="panel-collapse collapse in what-you-will-learn" role="tabpanel" aria-labelledby="headingOne">
                                <ul class="panel-body">
                                @if($achievements = json2Array($course->what_will_you_achieve))
                                    @foreach($achievements as $achievement)
                                        <li>{{ $achievement }}</li>
                                    @endforeach
                                @endif    
                                 </ul>
                        	</article>
                        </div>
                    </div>
                    <div class="sidebar">
                        
                        <aside>
                        	<div class="misc-container-2 panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <div class="panel-title">
                                        <p class="lead collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">{{ trans('courses/general.who_is_this_for?') }}</p>
                                         @if($who_for = json2Array($course->who_is_this_for))
                                         <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                                            <ul class="panel-body">
                                                @foreach($who_for as $who)
                                                    <li>{{$who}}</li>
                                                @endforeach
                                            </ul>
                                         </div>
                                         @endif
                                     </div>
                                 </div>
                             </div>
                        </aside>                        
                    </div>
                    <div class="left-content">
                        <!--@if($course->testimonials->count() > 0)
                            <div class="testimonials top-testimonials">
                                <p>
                                {{{ $course->testimonials->first()->content }}}
                                </p>
                                <span class="name">
                                    {{$course->testimonials->first()->student->first_name}}
                                    {{$course->testimonials->first()->student->last_name}}
                                </span>
                            </div>
                        @endif-->
                        <div class="misc-container-1 panel panel-default">
                        	<div class="panel-heading" role="tab" id="headingThree">
                            	<div class="panel-title">
                                    <p class="lead what-you-will-learn collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">{{trans('courses/create.course-requirements')}}.</p>
                                    <article id="collapseThree" class="panel-collapse collapse in what-you-will-learn" role="tabpanel" aria-labelledby="headingThree">
                                    <ul class="panel-body">
                                    @if($requirements = json2Array($course->requirements))
                                        @foreach($requirements as $requirement)
                                            <li>{{ $requirement }}</li>
                                        @endforeach
                                    @endif    
                                     </ul>
                                    </article>
                                </div>
                            </div>
                        </div>
                        <div class="misc-container-1 panel panel-default">
                        	<div class="panel-heading" role="tab" id="headingFour">
                            	<div class="panel-title">
                                    <p class="lead what-you-will-learn collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">{{ trans('courses/general.Description') }}</p>
                                    <article id="collapseFour" class="panel-collapse collapse in what-you-will-learn" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="panel-body">
                                            {{$course->description}}
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                        <!-- <p class="lead">Sub Description</p>
                        <article class="bottom-margin">
                        {{ $course->description }}
                        </article>
                        -->
                    </div>
                </div>
                <div class="divider clear">
                    <span></span>
                </div>
                <div class="curriculum clearfix clear">
                	<h3 class="text-center">
                        <!--<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/divider.jpg" alt="">-->
                        {{ trans('courses/general.curriculum') }}
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
                                    <button class="btn crash-lesson-button pull-right" 
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
                </div>
                <div class="divider clear">
                    <span></span>
                </div>
            
            @if($course->allTestimonials->count() > 0)
                        <div id="bottom-student-reviews" class="testimonials clearfix clear_fix clear bottom-testimonials">
                            <!--<h3 class="text-center">
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/divider.jpg" alt="">
                            </h3>-->
	                        <h2 class="text-center">{{ trans('courses/general.helpful-student-reviews') }}</h2>
                            @foreach($course->allTestimonials as $testimonial)
                            	<div>
                               {{ View::make('courses.testimonials.testimonial')->with( compact('testimonial') ) }}
                               </div>
                            @endforeach
                        </div>
                        <a href='1' id="load-more-ajax-button" class="load-more-comments load-more-ajax" 
               data-url='{{ action('TestimonialsController@more') }}' 
               data-target='.bottom-testimonials' data-skip='2' data-id='{{ $course->id }}' data-post-field="course">
                            {{ trans('general.load-more') }}
                        </a>
                        
            @endif
            </div>                       
            
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
        </section>
    
    @stop
    
    @if(Input::has('autoplay'))
        @section('extra_js')
            <script>
                $(function(){
                    var video = $('#myVideo');
                    video[0].play();
                });
            </script>
        @stop
    @endif
