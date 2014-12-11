<div class="col-xs-12 col-sm-6 col-md-4">
    <div class="object small-box small-box-one">
        <div class="price-tag">
            ¥ {{ number_format($course->price, Config::get('custom.currency_decimals')) }}
        </div><div class="level">{{ $course->courseDifficulty->name }}</div><div class="new-tag">NEW</div>
        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/home-stock-images/home-stock-image2.jpg" class="img-responsive" alt="">
        <h2>{{ $course->name }}</h2>
        <p>{{ $course->description }}</p>
        <div class="next_">
            <div class="learn-more">
                <a href="{{action("CoursesController@show", $course->slug)}}">Learn more</a>
            </div>
            <div class="students-attending">
                {{ $course->student_count }} Students
            </div>            
        </div> 
    </div>
</div>