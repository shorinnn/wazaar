
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
            alt="" 
             class="hidden-sm hidden-xs img-responsive">
        <div>
            <div class="level">{{ $course->courseDifficulty->name }}</div>
            <h2>{{ $course->name }}</h2>
            <p>{{ $course->description }}</p>
            <div class="next_">
                <div class="learn-more">
                    <a href="{{action("CoursesController@show", $course->slug)}}">Learn more</a>
                </div>
                <div class="students-attending">
                    {{ $course->student_count }}
                    {{Lang::choice('general.student', $course->student_count)}}
                </div>            
            </div> 
        </div>
    </div>
