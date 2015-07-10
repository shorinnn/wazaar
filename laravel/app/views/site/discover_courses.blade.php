<div class="row">
    @foreach( $discoverCourses->take(3) as $course )
 
        <div class="col-xs-12 col-sm-6 col-md-4">
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
                        <!---->
                        <span class="video-play-button"><em></em></span>
                        <span class="likes">{{ $course->likes() }}</span>         
                        <span class="box-overlay">
                            <p>Lesson</p>
                            <p>weeks of learning</p>
                            <div class="footer clearfix">
                                <div class="heart-icon"></div>
                                <div class="highly-recommend">{{ $course->rating() }}</div>
                            </div>
                        </span>
                    </div>
                    <div class="course-box-content clearfix">
                        <h2>{{ $course->name }}</h2>
                        <div class="short-description-container">
                            <p>{{ $course->short_description }}</p>
                        </div>
                        <div class="bottom-contents clearfix">
                            <div class="difficulty-bar {{ difficultyToCss( $course->courseDifficulty->name ) }}">
                                <?php
                                    $difficulty = 1;
                                    if($course->courseDifficulty->name=='Intermediate') $difficulty = 2;
                                    if($course->courseDifficulty->name=='Expert') $difficulty = 3;
                                ?>
                                @for($i = 0; $i<$difficulty; ++$i)
                                    <span class="bar-{{$i+1}}"></span>
                                @endfor
                            </div>
                            <div class="next_">
                                <!--<div class="learn-more">
                                    <a href="http://wazaar.dev/courses/cJio3">Learn more</a>
                                </div>-->
                                <div class="students-attending">
                                    {{ $course->student_count }}
                                </div>
                            </div>
                            <div class="price-tag-container clearfix">
                                <div class="price-tag">
                                    ¥ {{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach( $discoverCourses->slice(3)->take(3) as $course )
 
        <div class="col-xs-12 col-sm-6 col-md-4">
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
                        <!---->
                        <span class="video-play-button"><em></em></span>
                        <span class="likes">{{ $course->likes() }}</span>       
                        <span class="box-overlay">
                            <p>Lesson</p>
                            <p>weeks of learning</p>
                            <div class="footer clearfix">
                                <div class="heart-icon"></div>
                                <div class="highly-recommend">{{ $course->rating() }}</div>
                            </div>
                        </span>
                    </div>
                    <div class="course-box-content clearfix">
                        <h2>{{ $course->name }}</h2>
                        <div class="short-description-container">
                            <p>{{ $course->short_description }}</p>
                        </div>
                        <div class="bottom-contents clearfix">
                            <div class="difficulty-bar  {{ difficultyToCss($course->courseDifficulty->name) }}">
                                <?php
                                    $difficulty = 1;
                                    if($course->courseDifficulty->name=='Intermediate') $difficulty = 2;
                                    if($course->courseDifficulty->name=='Expert') $difficulty = 3;
                                ?>
                                @for($i = 0; $i<$difficulty; ++$i)
                                    <span class="bar-{{$i+1}}"></span>
                                @endfor
                            </div>
                            <div class="next_">
                                <!--<div class="learn-more">
                                    <a href="http://wazaar.dev/courses/cJio3">Learn more</a>
                                </div>-->
                                <div class="students-attending">
                                    {{ $course->student_count }}
                                </div>
                            </div>
                            <div class="price-tag-container clearfix">
                                <div class="price-tag">
                                    ¥ {{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
