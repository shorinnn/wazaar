<div class="col-xs-12 col-sm-6 col-md-4">
	<a href="{{ action('CoursesController@show', $course->slug) }}">
    <div class="object small-box small-box-one">
        <!--<div class="level">{{ $course->courseDifficulty->name }}</div>-->
        <!--@if($course->isNew())
            <div class="new-tag">NEW</div>
        @endif-->
        <div class="img-container">
        <img 
            @if($course->course_preview_image_id == null)
                src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
            @else
                src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
            @endif
             class="img-responsive" alt="">
              <!--@if($course->isDiscounted())
                        <div class="sale-ends">
                        {{ trans('courses/general.sale_ends_in') }} {{$course->discount_ends_in}}</div>
              @endif-->
            <span class="video-play-button"><em></em></span>
            <span class="likes">{{ $course->reviews_positive_score }}</span>         
            <span class="box-overlay">
                <p>{{trans('general.lesson')}}</p>
                <p>{{trans('general.weeks-of-learning')}}</p>
                <div class="footer clearfix">
                    <div class="heart-icon"></div>
                    <div class="highly-recommend">{{trans('general.highly-recommend')}}</div>
                </div>
            </span>
        </div>
        <div class="course-box-content clearfix">
            <h2>{{ $course->name }}</h2>
            <div class="short-description-container">
                <p>{{{ Str::limit( strip_tags( $course->short_description, Config::get('custom.short_desc_max_chars') ) ) }}}
                <!--<span class="subcategory">
                        <small>{{ trans('courses/general.subcategory') }}: 
                            <a href="{{action('CoursesController@subCategory', [$course->courseCategory->slug, $course->courseSubcategory->slug] )}}">{{$course->courseSubcategory->name}}</a>
                        </small>
                    </span>-->
                </p>
            </div>
            <div class="bottom-contents clearfix">
            	<div class="difficulty-bar advanced">
                	<span class="bar-1"></span>
                	<span class="bar-2"></span>
                	<span class="bar-3"></span>
                </div>
                <div class="next_">
                    <!--<div class="learn-more">
                        <a href="{{action("CoursesController@show", $course->slug)}}">Learn more</a>
                    </div>-->
                    <div class="students-attending">
                        {{ $course->student_count }} <!--{{Lang::choice('general.student', $course->student_count)}}-->
                    </div>   
                </div> 
                <div class="price-tag-container clearfix">
                    <!--@if($course->isDiscounted())
                        <div class="price-tag-discount-percent">
                            -
                            @if($course->sale_kind=='amount')
                            ¥
                            @endif
                            {{ $course->sale }}
                            @if($course->sale_kind=='percentage')
                            %
                            @endif
                        </div>
                    @endif-->
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