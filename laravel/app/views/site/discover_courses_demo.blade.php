<div class="row clear homepage-course-groups group_1">
    <div class="col-md-12 course-group-header">
        <a href="#" class="back_all_courses hide" data-group="group_1"><i class="fa fa-chevron-left"></i> Back</a>
        <h2>Make more money</h2>
        <a href="#" class="show_all_courses pull-right" data-group="group_1"><i class="fa fa-plus"></i> show all</a>
        <div class="clearfix"></div>
    </div>
    <div>
    @foreach( $discoverCourses as $i => $course )
     <?php 
     $course = courseApprovedVersion($course);
     $course->count = $i;
     echo Flatten::section('top-discover-course-'.$course->id, Config::get('custom.cache-expiry.course-box'), function () use ($course) { ?>
        {{$course->count}}
        <div class="col-xs-12 col-sm-6 col-md-4 course-box-wrap">
            <a href="{{ action('CoursesController@show', $course->slug) }}" class="small-box-link-wrapper">
                <div class="object small-box small-box-one">
                    <div class="img-container">
                        <img 
                            @if( $course->previewImage != null ) 
                                src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                            @else
                                src="{{ url('splash/logo.png') }}"
                            @endif
                           
                            class="img-responsive" alt="" style="max-height: 182px"  />
                        <span class="video-play-button"><em></em></span>
                        <span class="likes"><i class="wa-like"></i>{{ $course->reviewsScore() }}</span>         
                        <span class="box-overlay">
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
                                    <i class="wa-like"></i>{{ $course->reviewsScore() }} {{ $course->rating() }}
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
                            <div class="next_">
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
        @if($course->count == 2)
        </div>
        <div class="hidden_courses hide">
        @endif
    
    <?php }); ?>
    @endforeach
    </div>
</div>

<div class="row clear homepage-course-groups group_2">
    <div class="col-md-12 course-group-header">
        <a href="#" class="back_all_courses hide" data-group="group_2"><i class="fa fa-chevron-left"></i> Back</a>
        <h2>Lifestyle and Beauty</h2>
        <a href="#" class="show_all_courses pull-right" data-group="group_2"><i class="fa fa-plus"></i> show all</a>
        <div class="clearfix"></div>
    </div>
    <div>
    @foreach( $discoverCourses as $i => $course )
     <?php 
     $course = courseApprovedVersion($course);
     $course->count = $i;
     echo Flatten::section('top-discover-course-'.$course->id, Config::get('custom.cache-expiry.course-box'), function () use ($course) { ?>
        <div class="col-xs-12 col-sm-6 col-md-4 course-box-wrap">
            <a href="{{ action('CoursesController@show', $course->slug) }}" class="small-box-link-wrapper">
                <div class="object small-box small-box-one">
                    <div class="img-container">
                        <img 
                            @if( $course->previewImage != null ) 
                                src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                            @else
                                src="{{ url('splash/logo.png') }}"
                            @endif
                           
                            class="img-responsive" alt="" style="max-height: 182px"  />
                        <span class="video-play-button"><em></em></span>
                        <span class="likes"><i class="wa-like"></i>{{ $course->reviewsScore() }}</span>         
                        <span class="box-overlay">
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
                                    <i class="wa-like"></i>{{ $course->reviewsScore() }} {{ $course->rating() }}
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
                            <div class="next_">
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
        @if($course->count == 2)
        </div>
        <div class="hidden_courses hide">
        @endif
    
    <?php }); ?>
    @endforeach
    </div>
</div>

<div class="row clear homepage-course-groups group_3">
    <div class="col-md-12 course-group-header">
        <a href="#" class="back_all_courses hide" data-group="group_3"><i class="fa fa-chevron-left"></i> Back</a>
        <h2>Health and Fitness</h2>
        <a href="#" class="show_all_courses pull-right" data-group="group_3"><i class="fa fa-plus"></i> show all</a>
        <div class="clearfix"></div>
    </div>
    <div>
    @foreach( $discoverCourses as $i => $course ) 
     <?php 
     $course = courseApprovedVersion($course);
     $course->count = $i;
     echo Flatten::section('top-discover-course-'.$course->id, Config::get('custom.cache-expiry.course-box'), function () use ($course) { ?>
        <div class="col-xs-12 col-sm-6 col-md-4 course-box-wrap">
            <a href="{{ action('CoursesController@show', $course->slug) }}" class="small-box-link-wrapper">
                <div class="object small-box small-box-one">
                    <div class="img-container">
                        <img 
                            @if( $course->previewImage != null ) 
                                src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                            @else
                                src="{{ url('splash/logo.png') }}"
                            @endif
                           
                            class="img-responsive" alt="" style="max-height: 182px"  />
                        <span class="video-play-button"><em></em></span>
                        <span class="likes"><i class="wa-like"></i>{{ $course->reviewsScore() }}</span>         
                        <span class="box-overlay">
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
                                    <i class="wa-like"></i>{{ $course->reviewsScore() }} {{ $course->rating() }}
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
                            <div class="next_">
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
        @if($course->count == 2)
        </div>
        <div class="hidden_courses hide">
        @endif
    
    <?php }); ?>
    @endforeach
    </div>
</div>