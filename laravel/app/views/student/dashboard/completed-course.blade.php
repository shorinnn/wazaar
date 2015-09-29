
                          <?php echo Flatten::section('student-courses-completed-'.$course->id, 
                                  Config::get('custom.cache-expiry.student-dash-completed-course'), function () use($course, $student)  { ?>
                            <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="clearfix enrolled-lesson no-border 
                                         @if( $student->courseProgress( $course ) == 100)
                                         finished-lesson
                                         @endif
                                         ">
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
                                            
                                                <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
                                                  <h4 class="single-line-ellipsis"><a href="{{ action('ClassroomController@dashboard', $course->slug) }}">{{ $course->name }}</a></h4>
                                                   <p class="regular-paragraph ">{{ $course->lessonCount() }} / {{ $course->lessonCount() }} 
                                                        {{ trans('courses/dashboard.lesson_completed') }}</p>
                                                </div>
                                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 progress-column">
                                                  <div class="enrolled-lessons-progress clearfix">
                                                      <span class="finished block"><i class="wa-check"></i>{{trans('general.finished')}}</span>
                                                      <span class="review regular-paragraph">{{ trans('courses/general.review') }}</span>
                                                      <span class="progress-value">{{ $student->courseProgress( $course ) }}%</span>
                                                  </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          <?php });?>