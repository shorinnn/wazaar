<div class="col-xs-12 col-sm-6 col-md-4">
    <div class="object small-box small-box-one">
        <!--<div class="level">{{ $course->courseDifficulty->name }}</div>-->
        <!--@if($course->isNew())
            <div class="new-tag">NEW</div>
        @endif-->
        <div class="img-container">
        <img 
            @if($course->course_preview_image_id == null)
                src="http://placehold.it/350x150&text=Preview Unavailable"
            @else
                src="{{$course->previewImage->url}}"
            @endif
             class="img-responsive" alt="">
              @if($course->isDiscounted())
                        <div class="sale-ends">SALE ENDS IN {{$course->discount_ends_in}}</div>
              @endif
        </div>
        <h2>{{ $course->name }}</h2>
        <p>{{{ Str::limit( strip_tags( $course->short_description, Config::get('custom.short_desc_max_chars') ) ) }}}
            <br />
            <small>Subcategory: 
                <a href="{{action('CoursesController@subCategory', [$course->courseCategory->slug, $course->courseSubcategory->slug] )}}">{{$course->courseSubcategory->name}}</a>
            </small>
            [<a href="{{ action('CoursesController@show', $course->slug) }}">Temporary access link</a>]
        </p>
        <div class="price-tag clear">
             ¥ {{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
            @if($course->isDiscounted())
                {{trans('courses/general.sale')}}
            @endif
        </div>

        <div class="next_">
            <!--<div class="learn-more">
                <a href="{{action("CoursesController@show", $course->slug)}}">Learn more</a>
            </div>-->
            <div class="students-attending">
                {{ $course->student_count }} {{Lang::choice('general.student', $course->student_count)}}
            </div>   
            <span class="likes">{{ $course->reviews_positive_score }}%</span>         
        </div> 
    </div>
</div>