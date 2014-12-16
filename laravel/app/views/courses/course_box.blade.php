<div class="col-xs-12 col-sm-6 col-md-4">
    <div class="object small-box small-box-one">
        <div class="price-tag">
            ¥ {{ number_format($course->price, Config::get('custom.currency_decimals')) }}
        </div>
        <div class="level">{{ $course->courseDifficulty->name }}</div>
        <div class="new-tag">NEW</div>
        <img 
            @if($course->previewImage==null)
                src="http://placehold.it/350x150&text=Preview Unavailable"
            @else
                src="{{$course->previewImage->url}}"
            @endif
             class="img-responsive" alt="">
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