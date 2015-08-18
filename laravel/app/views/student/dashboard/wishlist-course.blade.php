<?php $course = $course->course; ?>
<?php echo Flatten::section('student-courses-wishlist-' . $course->id, Config::get('custom.cache-expiry.student-dash-wishlist-course'), 
        function () use($course) { ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="clearfix enrolled-lesson no-border">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                        <div class="image-wrap">
                            <img 
                                @if($course->course_preview_image_id == null)
                                src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
                                @else
                                src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                                @endif
                                class="img-responsive" />
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                        <h4><a href="{{ action('CoursesController@show', $course->slug) }}">{{ $course->name }}</a></h4>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                        <div class="enrolled-lessons-progress">
                            <a href="{{ action('CoursesController@show', $course->slug) }}">View</a>                                                  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }); ?>