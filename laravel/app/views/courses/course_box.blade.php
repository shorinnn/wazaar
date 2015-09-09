@if($course->course)
    @include('courses.course_box_bestsellers',['course' => $course->course])
@else
 <?php
 $course = courseApprovedVersion($course);
  echo Flatten::section('top-course-box-'.$course->id, Config::get('custom.cache-expiry.course-box'), function () use ($course) { ?>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <a href="{{ action('CoursesController@show', $course->slug) }}">
            <div class="object small-box small-box-one">
                <div class="img-container">
                    
                    <img
                    @if($course->course_preview_image_id == null)
                        src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
                        @else
                        src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                        @endif
                        class="img-responsive" alt="">
                    <span class="video-play-button"><em></em></span>
                    <span class="likes"><i class="wa-like"></i>{{ $course->reviewsScore() }}</span>
            <span class="box-overlay">
<!--                <p>{{trans('general.lesson')}}</p>
                <p>{{trans('general.weeks-of-learning')}}</p>-->
                <p>{{ trans('general.'.$course->courseDifficulty->name) }}</p>
                 <?php });?>
                
                <div class="footer clearfix">
                    <div class="heart-icon">
                         
                           @if( !in_array($course->id, $wishlisted) )
                               <i class="fa fa-heart-o tooltipable wishlist-change-button" title="Add to wishlist" data-auth="{{ intval(Auth::check() )}}"
                                  data-url="{{action('WishlistController@change', $course->slug)}}" data-state="0"></i>
                           @else
                               <i class="fa fa-heart tooltipable wishlist-change-button" title="Remove from wishlist" data-auth="{{ intval(Auth::check() )}}"
                                  data-url="{{action('WishlistController@change', $course->slug)}}" data-state="1"></i>
                           @endif
                           
                    </div>
					<div class="highly-recommend">
                    	<i class="wa-like"></i> {{ $course->reviewsScore() }} {{ $course->rating() }}
                    </div> 
                </div>
                <?php echo Flatten::section('bottom-course-box-'.$course->id, Config::get('custom.cache-expiry.course-box'), function () use ($course) { ?>
            </span>
                </div>
                <div class="course-box-content clearfix">
                	<div class="title-and-descript">
                        <h3>{{ $course->name }}</h3>
                        <div class="short-description-container">
                            
                            <p>{{{ Str::limit( strip_tags( $course->short_description) , Config::get('custom.short_desc_max_chars')  ) }}}
                                
                            </p>
                        </div>
                    </div>
                    <div class="bottom-contents clearfix">
<!--                        <div class="difficulty-bar {{ difficultyToCss( $course->courseDifficulty->name ) }}"
                        data-toggle="tooltip" data-placement="top" title="Difficulty: {{ $course->courseDifficulty->name }}">
                            <span class="bar-1"></span>
                            <span class="bar-2"></span>
                            <span class="bar-3"></span>
                        </div>-->
                        <div class="next_">
                            <div class="students-attending" data-toggle="tooltip" data-placement="top" title="Students enrolled">
                               <i class="wa-user-n"></i> {{ $course->student_count }}
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
@endif