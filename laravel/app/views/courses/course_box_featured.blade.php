<!--
    <div class="object big-box clearfix">
    	<a href="{{action("CoursesController@show", $course->slug)}}">
            <div class="price-tag">
                <span class="success-color">¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}</span>
                @if($course->isDiscounted())
                    {{trans('courses/general.sale')}}
                @endif
            </div>
            <div class="featured-img-container hidden-sm hidden-xs">
            <img
                @if($course->course_preview_image_id==null)
                    src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
                @else
                    src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                @endif
                alt="" 
                 class="hidden-sm hidden-xs img-responsive">
            </div>
            <div class="featured-contents-container">
                <div class="level">{{ trans( 'general.'.$course->courseDifficulty->name ) }}</div>
                <h2>{{ $course->name }}</h2>
                <p>{{{ Str::limit( strip_tags($course->short_description, Config::get('custom.short_desc_max_chars') ) ) }}}
                    <br />
-->                    
                    <!-- DO not uncomment this <small> tag -->
			<!--<small>{{ trans('courses/general.subcategory') }}: 
                    <a href="{{action('CoursesController@subCategory', [$course->courseCategory->slug, $course->courseSubcategory->slug] )}}">{{$course->courseSubcategory->name}}</a>
                </small>-->
                
 <!--               
                </p>
                <div class="next_">
                    <div class="learn-more">
                    
                    	<!-- Do not uncomment this learn-more button -->
                        <!--<a href="{{action("CoursesController@show", $course->slug)}}">{{ trans('site/homepage.learn-more') }}: </a>-->
<!--                        
                    </div>
                    <div class="students-attending">
                        {{ $course->student_count }}
                        {{Lang::choice('general.student', $course->student_count)}}
                    </div>            
                </div> 
            </div>
        </a>
    </div>
-->