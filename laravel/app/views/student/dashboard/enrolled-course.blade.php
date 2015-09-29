<?php
                              $course = $course->product;
                              $firstModule = $course->firstModule();
                              $firstLesson = null;
                              if($firstModule !=null ){
                                  $firstLesson = $firstModule->firstLesson();
                              }
                              $lastLesson = $student->lastLessonInCourse($course);
                              
//                              if($lastLesson != null ) $lastLesson = $lastLesson->lesson;
                              ?>
                            <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="clearfix enrolled-lesson no-border 
                                         @if( $student->courseProgress( $course ) == 100)
                                         finished-lesson
                                         @endif
                                         ">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                            <?php echo Flatten::section('student-courses-image-'.$course->id, Config::get('custom.cache-expiry.student-dash-enrolled-image'), 
                                                    function () use( $course )  { ?>
                                              <div class="image-wrap">
                                                  <img 
                                                        @if($course->course_preview_image_id == null)
                                                            src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
                                                        @else
                                                            src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                                                        @endif
                                                    class="img-responsive" />
                                              </div>
                                            <?php }); ?>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
                                              <h4 class="single-line-ellipsis"><a href="{{ action('ClassroomController@dashboard', $course->slug) }}">{{ $course->name }}</a></h4>
                                              @if( $lastLesson != null )
                                              <?php $theLesson = $lastLesson;?>
                                                <p class="regular-paragraph">{{$lastLesson->lessonPosition() }} / 
                                                    <?php echo Flatten::section('student-courses-lesson-count-'.$course->id, Config::get('custom.cache-expiry.student-dash-lesson-count'), function () use( $course )  { ?>
                                                    {{ $course->lessonCount() }} 
                                                    <?php }); ?>
                                                    {{ trans('courses/dashboard.lessons_completed') }}</p>
                                                <p class="regular-paragraph single-line-ellipsis">{{ trans('courses/dashboard.current_lesson') }}: 
                                          
                                                    <a href="{{
                                                        action('ClassroomController@lesson', 
                                            [ $lastLesson->module->course->slug,
                                            $lastLesson->module->slug,
                                            $lastLesson->slug])
                                                       }}">{{$lastLesson->module->order}}.{{$lastLesson->order}}. {{$lastLesson->name}}</a></p>
                                              @else
                                                <?php echo Flatten::section('student-courses-first-lesson-'.$course->id, 
                                                        Config::get('custom.cache-expiry.student-dash-first-lesson'), function () use($course, $firstLesson)  { ?>
                                                  <p class="regular-paragraph">0 / {{ $course->lessonCount() }} {{ trans('courses/dashboard.lessons_completed') }}</p>
                                                        @if($firstLesson != null)
                                                        <?php $theLesson = $firstLesson;?>
                                                        <p class="regular-paragraph">{{ trans('courses/dashboard.current_lesson') }}: 
                                                            <a href="{{
                                                               action('ClassroomController@lesson', 
                                                [ $firstLesson->module->course->slug,
                                                $firstLesson->module->slug,
                                                $firstLesson->slug])
                                                               }}">1.1. {{$firstLesson->name}}</a></p>
                                                        @endif
                                                 <?php }); ?>
                                              @endif
                                              
                                            </div>
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 progress-column">
                                              <div class="enrolled-lessons-progress clearfix">
                                                  <span class="finished block"><i class="wa-check"></i>{{trans('general.finished')}}</span>
                                                  <span class="review regular-paragraph">{{ trans('courses/general.review') }}</span>
                                                  <span class="progress-value">{{ $student->courseProgress( $course ) }}%</span>
                                                  <!--<img src="../images/radial-progress.png">-->
                                                  <div class='pull-left radial-progress-wrap'>
                                                          <a 
                                                            @if( isset($theLesson) )
                                                                href="{{
                                                               action('ClassroomController@lesson', 
                                                [ $theLesson->module->course->slug,
                                                $theLesson->module->slug,
                                                $theLesson->slug])
                                                               }}"
                                                            @else
                                                                href="{{ action('ClassroomController@dashboard', $course->slug) }}"
                                                            @endif
                                                                >
                                                              <div id='progress-circle-{{$course->id}}' 
                                                                   data-text='<i class="fa">&#xf04b;</i>'
                                                                   class='progress-circle' data-color='#0099ff' data-trail-color='#E0E1E2' data-stroke='3' 
                                                                   style='height:40px; width:40px'
                                                                   data-progress='{{ $student->courseProgress( $course ) }}'>
                                                              </div>
                                                          </a>
                                                  </div>
                                                  
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>