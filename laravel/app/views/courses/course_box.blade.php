@if($course->course)
    @include('courses.course_box_bestsellers',['course' => $course->course])
@else
 <?php // echo Flatten::section('course-box-'.$course->id, 10, function () use ($course) { ?>
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
                    <span class="likes"><i class="wa-like"></i>{{ $course->reviews_positive_score }}%</span>
            <span class="box-overlay">
                <p>{{trans('general.lesson')}}</p>
                <p>{{trans('general.weeks-of-learning')}}</p>
                <div class="footer clearfix">
                    <div class="heart-icon" data-toggle="tooltip" data-placement="top" title="Add to wishlist"><i class="wa-Heart"></i></div>
                    <div class="highly-recommend"><i class="wa-like"></i> {{ $course->reviews_positive_score }}% {{trans('general.highly-recommend')}}</div>
                </div>
            </span>
                </div>
                <div class="course-box-content clearfix">
                    <h2>{{ $course->name }}</h2>
                    <div class="short-description-container">
                        
                        <p>{{{ Str::limit( strip_tags( $course->short_description) , Config::get('custom.short_desc_max_chars')  ) }}}
                            
                        </p>
                    </div>
                    <div class="bottom-contents clearfix">
                        <div class="difficulty-bar {{ difficultyToCss( $course->courseDifficulty->name ) }}"
                        data-toggle="tooltip" data-placement="top" title="Difficulty: Intermediate">
                            <span class="bar-1"></span>
                            <span class="bar-2"></span>
                            <span class="bar-3"></span>
                        </div>
                        <div class="next_">
                            <div class="students-attending" data-toggle="tooltip" data-placement="top" title="Students enrolled">
                               <i class="wa-user-n"></i> {{ $course->student_count }}
                            </div>
                        </div>
                        <div class="price-tag-container clearfix">
                            <div class="price-tag">
                                @if($course->isDiscounted())
                                    <style>
                                        .small-box .price-tag-container .price-tag{
                                            color: #ec4316;
                                        }
                                    </style>
                                    <span class="prev-price"> ¥ {{ number_format( $course->discount_original, Config::get('custom.currency_decimals') ) }}</span>
                                @endif
                                ¥ {{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
                                @if($course->isDiscounted())
                                    {{trans('courses/general.sale')}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
 <?php // });?>
@endif