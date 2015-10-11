<?php
    $date = new DateTime();
    $date->setTimezone(new DateTimeZone('Asia/Tokyo'));
    $now = strtotime( $date->format('Y-m-d H:i:s') ) ;
    $show_on = strtotime( '2015-09-10 17:15:00' );
?>
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
                <a id="course-description" class="scroll-to-top header-tab-links"></a>
                <div class="course-description no-margin-top module-box padding-top-30 padding-bottom-20">
                    <h2>{{ trans('courses/general.about-this-course') }}</h2>
                    <p class="intro-paragraph short-text">
                        {{ strip_tags_and_attributes($course->description, "<p><b><ol><ul><li><u><br>")}}
                    </p>
                    <!--<div class="fadeout-text"></div>-->
                    <!--<span class="show-full-description"> {{ trans("courses/general.show-full-description") }}</span>-->
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
				
                <div>
                <a id="description-page-curriculum-wrap" class="scroll-to-top header-tab-links"></a>
                    @foreach($course->modules as $module)
                        <div class="module-box">
                            <h2>{{ $module->order }}. {{ $module->name }}</h2>
                            <p class="regular-paragraph">
                                <!--A short description of the module goes here...-->
                            </p>
                            <ul class="lesson-topics expandable-content clearfix">
                                @foreach($module->lessons as $i=>$lesson)
                                    <li class="lessons lesson-1 bordered clearfix">
                                        <span class="hidden-xs"><i class="wa-play"></i></span>
                                        <!--{{ Str::limit( $lesson->name, Config::get('custom.course-desc-lesson-chars') )  }}-->
                                        <a class="clearfix lesson-name" data-toggle="tooltip" title="{{$lesson->name}}" @if($i == 0) data-placement="bottom" @endif>{{$lesson->name}}</a>
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
                                                    @if( Auth::check() && Student::find(Auth::user()->id)->purchased($lesson)  )
                                                            <a href='{{ action( 'ClassroomController@lesson', 
                                                            [ 'course' => $lesson->module->course->slug, 'module' => $lesson->module->slug, 
                                                        'lesson' => $lesson->slug ] )}}' class='blue-button preview-button large-button' >Enter</a>
                                                    @else
                                                    <!-- to purchase -->
                                                        @if($now > $show_on)
                                                            {{ Form::open( [ 'action' => ['CoursesController@crashLesson', $course->slug, $lesson->slug ], 'class' => 'inline-form' ] ) }}
                                                        @else
                                                            {{ Form::open( [  'class' => 'inline-form' ] ) }}
                                                        @endif
                                                        <button type="submit" class='blue-button preview-button large-button'
                                                        @if( $now<$show_on || 
                                                        (Auth::check() && ( !Auth::user()->canPurchase($course) || !Auth::user()->canPurchase($lesson) ) ) )
                                                                disabled="disabled" data-crash-disabled='1'
                                                                @endif
                                                                ><small class="hidden-xs">{{ trans('courses/general.free_preview') }}</small><i class="fa fa-eye hidden-sm hidden-md hidden-lg"></i></button>
                                                          {{ Form::close() }}
                                                          <!-- / to purchase -->
                                                    @endif
                                            @else
                                                @if( $lesson->individual_sale == 'yes' )
                                                    <!--<a href="#" class="blue-button buy-button large-button">Buy</a>-->
                                                        @if( Auth::check() && Student::find(Auth::user()->id)->purchased($lesson)  )
                                                                <a href='{{ action( 'ClassroomController@lesson', 
                                                                [ 'course' => $lesson->module->course->slug, 'module' => $lesson->module->slug, 
                                                            'lesson' => $lesson->slug ] )}}' class='blue-button preview-button large-button' >Enter</a>
                                                            @else
                                                                <!-- can purchase -->
                                                                @if($now > $show_on)
                                                                    {{ Form::open( [ 'action' => ['CoursesController@purchaseLesson', $course->slug, $lesson->slug ], 'class' => 'inline-form' ] ) }}
                                                                @else
                                                                    {{ Form::open( [ 'class' => 'inline-form' ] ) }}
                                                                @endif
                                                                <button class="blue-button buy-button large-button"
                                                                 @if( $now<$show_on || 
                                                                    (Auth::check() && ( !Auth::user()->canPurchase($course) || !Auth::user()->canPurchase($lesson) ) ) )
                                                                        disabled="disabled" data-crash-disabled='1'
                                                                        @endif
                                                                        >{{ trans('courses/general.purchase') }}</button>
                                                                {{ Form::close() }}
                                                                @endif
                                                                <!-- / can purchase -->
                                                            @endif
                                                          
                                            @endif
    
    
    
                                        </div>
                                    </li>
    
                                @endforeach
                            </ul>
                                <!--<span class="hide-lesson-topics">{{ trans('courses/general.show-more-lessons') }}</span>-->
                        </div>
                    @endforeach
                </div>
                
                @if( $gift != null )
                
                    <div class="affiliate-gift-wrap">
                                    <div class="row description-wrap no-margin">
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
                                            <img class="img-responsive gift-coupon inline-block" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/gift-coupon.png" alt="">
                                    </div>
                                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                        <div class="description">
                                            <h3>
                                                {{ trans('affiliates.gifts.included-course-gift-from-name', ['name' => $gift->affiliate->fullName()] ) }}
                                            </h3>
                                            <p>{{ $gift->text }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                @endif

                @if( $course->assignedInstructor != null && $course->assignedInstructor->profile !=null  )
                
                    <div class="reviews instructed-by clearfix module-box">
                        <div class="row no-margin">
                            <div class="user-thumb col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            	<div class="img-wrap">
                                @if($course->assignedInstructor->profile == null || $course->assignedInstructor->profile->photo == '')
                                    <img src="{{cloudfrontUrl("//s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg")}}"
                                         class="img-responsive" />
                                @else
                                    <img src="{{cloudfrontUrl( $course->assignedInstructor->profile->photo )}}"
                                         class="img-responsive" />
                                @endif
                                </div>
                            </div>
                            <div class="user-review col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                <div class="clearfix margin-bottom-20">
                                    <h4>{{trans('courses/general.instructed-by') }}<em class="name"> {{ $course->assignedInstructor->fullName() }}</em></h4>
                                    <span class="role">{{ $course->assignedInstructor->profile->title }}</span>
                                </div>
                                <p class="regular-paragraph expandable-content">
                                    {{ $course->assignedInstructor->profile->bio }}
                                </p>
                                <div class="fadeout-text"></div>
                                <span class="view-more-reviews expandable-button show-more" data-more-text="More" data-less-text="Less">{{ trans("courses/general.profile-more") }}</span>
                            </div>
                        </div>
                    </div>
                @endif
                
                <a id="reviews" class="scroll-to-top header-tab-links"></a>
                @if($course->allTestimonials->count() > 0)
                
                    <div class="lesson-reviews">
                        <h2>{{ $course->testimonials()->where('content','!=','')->count() }} {{ trans("courses/general.reviews") }}</h2>
                        <div class='bottom-testimonials'>
                            @foreach($course->allTestimonials as $testimonial)
                                <!--<div>-->
                                {{ View::make('courses.testimonials.testimonial')->with( compact('testimonial') ) }}
                                <!--</div>-->
                            @endforeach
                        </div>

                        <!--<span class="read-all-reviews">Read all reviews</span>-->
                        @if( $course->testimonials()->where('content','!=','')->count() > $course->allTestimonials->count() )
                            <a href='#' id="load-more-ajax-button" class="load-more-comments load-more-ajax read-all-reviews"
                               data-url='{{ action('TestimonialsController@more') }}'
                               data-target='.bottom-testimonials' data-skip='3' data-id='{{ $course->id }}' data-post-field="course">
                                {{ trans( 'general.read-more' ) }}
                            </a>
                        @endif
                    </div>
                @else 
                    <div class="no-margin-top module-box padding-top-30 padding-bottom-20">
                    	<h4 class="text-center no-reviews-yet">{{trans('courses/general.no_reviews_yet') }}</h4>
                    </div>
                @endif

            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                @if( $course->recommendations != null && $course->recommendations->recommended_courses != '[]' )
                <div class="recommended-courses-container">
                    <h3 class="recommended-courses-maintitle">{{trans('courses/general.people_who_viewed_this_course') }}</h3>
                    <?php $recs = json_decode($course->recommendations->recommended_courses, true);?>
                    @foreach($recs as $rec)
                        <?php
                        $rec = Course::find($rec);
                        $rec = courseApprovedVersion( $rec );
                        ?>
                    <a href='{{ action( 'CoursesController@show', $rec->slug ) }}'>
                        <div class="recommended-courses-block row">
                            <div class="col-xs-4 col-sm-2 col-md-4 col-lg-4 instructor-img">
                                    <img 
                                         @if($rec->course_preview_image_id == null)
                                            src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
                                        @else
                                            src="{{ cloudfrontUrl( $rec->previewImage->url ) }}"
                                        @endif
                                        class="img-responsive">
                            </div>
                            <div class="col-xs-8 col-sm-10 col-md-8 col-lg-8">
                                <div class="course-box-content">
                                <h3 class="recommended-course-title">{{$rec->name }}</h3>
                                </div>
                                <h3 class="instructor-name">
                                    
                                @if($rec->instructor->profile == null)
                                    {{ $rec->$instructor->last_name }} {{ $rec->instructor->first_name }} 
                                @else
                                    {{$rec->instructor->profile->last_name}} {{$rec->instructor->profile->first_name}} 
                                @endif
                                </h3>
                                <span class="recommended-course-price">
                                @if($rec->free=='yes' || $rec->cost() == 0)
                                    {{ trans('courses/general.free') }}
                                @else
                                    ¥ {{ number_format($rec->cost(), Config::get('custom.currency_decimals')) }}
                                @endif
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    
                </div>
                @endif
            </div>
        </div>
    </div>
</section>