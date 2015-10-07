{{--@if($course->course)
    @include('courses.course_box_bestsellers',['course' => $course->course])
@else--}}
 <?php
 if($course->course) $course = $course->course;
 else $course = courseApprovedVersion($course);
  echo Flatten::section('top-course-box-'.$course->id, Config::get('custom.cache-expiry.course-box'), function () use ($course) { ?>
     <div class="col-xs-12 col-sm-6 col-md-4 course-box-wrap">
            <a href="{{ action('CoursesController@show', $course->slug) }}" class="small-box-link-wrapper">
                <div class="object small-box small-box-one">
                    <!--<div class="level">Beginner</div>-->
                    <!--            <div class="new-tag">NEW</div>
                    -->
                    <div class="img-container">
                        <img 
                            @if( $course->previewImage != null ) 
                                src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                            @else
                                src="{{ url('splash/logo.png') }}"
                            @endif
                           
                            class="img-responsive" alt="" style="max-height: 182px"  />
                        <!--<img class="img-responsive" alt="" src="https://wazaardev.s3.amazonaws.com/course_preview/54905d8c6ecae.jpg">-->
                        <span class="video-play-button"><em></em></span>
                        <span class="likes"><i class="wa-like"></i>{{ $course->reviewsScore() }}</span>         
                        <span class="box-overlay">
                             <p>{{ trans('general.'.$course->courseDifficulty->name) }}</p>
                             <?php });?>
                            
                            <div class="footer clearfix">
                                <div class="heart-icon">
                                    @if( !in_array($course->id, $wishlisted) )
                                        <i class="fa fa-heart-o tooltipable wishlist-change-button" title="{{ trans('courses/general.add_to_wishlist') }}" data-auth="{{ intval(Auth::check() )}}"
                                           data-url="{{action('WishlistController@change', $course->slug)}}" data-state="0"></i>
                                    @else
                                        <i class="fa fa-heart tooltipable wishlist-change-button" title="{{ trans('courses/general.remove_from_wishlist') }}" data-auth="{{ intval(Auth::check() )}}"
                                           data-url="{{action('WishlistController@change', $course->slug)}}" data-state="1"></i>
                                    @endif
                                </div>
                                <div class="highly-recommend">
                                	<i class="wa-like"></i>
                                        {{ $course->reviewsScore() }} 
                                        @if($course->likes()> 0)
                                            {{ $course->rating() }}
                                        @endif
                                </div>
                            </div>
                            
                            <?php echo Flatten::section('bottom-discover-course-'.$course->id, Config::get('custom.cache-expiry.course-box'), function () use ($course) { ?>
                        </span>
                    </div>
                    <div class="course-box-content clearfix">
                    	<div class="title-and-descript">
                            <h3>{{ $course->name }}</h3>
                            <div class="short-description-container">
                                <p>{{ $course->short_description }}</p>
                            </div>
                        </div>
                        <div class="bottom-contents clearfix">
<!--                            <div class="difficulty-bar {{ difficultyToCss( $course->courseDifficulty->name ) }}"
                            data-toggle="tooltip" data-placement="top" title="Difficulty: {{  $course->courseDifficulty->name }}">
                                <?php
                                    $difficulty = 1;
                                    if($course->courseDifficulty->name=='Intermediate') $difficulty = 2;
                                    if($course->courseDifficulty->name=='Expert') $difficulty = 3;
                                ?>
                                <span class="bar-1"></span>
                                <span class="bar-2"></span>
                                <span class="bar-3"></span>
                          
                            </div>-->
                            <div class="next_">
                                <!--<div class="learn-more">
                                    <a href="http://wazaar.dev/courses/cJio3">Learn more</a>
                                </div>-->
                                <div class="students-attending" data-toggle="tooltip" data-placement="top" title="Students enrolled">
                                    @if( $course->isNewForStudentCount() )
                                    	<span class="new-for-student">
                                        {{ trans('general.new') }}
                                        </span>
                                   @else
                                        <i class="wa-user-n"></i>
                                       {{ $course->student_count }}
                                   @endif
                                </div>
                            </div>
                            <div class="price-tag-container clearfix">
                                <div class="price-tag">
                                    @if($course->isDiscounted())
                                        <span class="prev-price"> ¥ {{ number_format( $course->discount_original, Config::get('custom.currency_decimals') ) }}</span>
                                        <span class="discounted-price">
                                            ¥ {{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
                                        </span>
                                        <!--{{trans('courses/general.sale')}}-->
                                    @else
                                        @if($course->free=='yes' || $course->cost() == 0)
                                            {{ trans('courses/general.free') }}
                                        @else
                                            ¥ {{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
                                        @endif
                                    @endif                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
 <?php });?>
{{--@endif--}}