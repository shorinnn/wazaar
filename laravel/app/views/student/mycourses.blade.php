@extends('layouts.default')

@section('page_title')
    Dashboard - 
@stop

@section('content')
	<div class="container-fluid new-dashboard top-section">
    	<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 lesson-description">
                    <div class="row">
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        	<h2>Go back where you left it</h2>
                        </div>
                    </div>
                    @if( $lastLesson != null )
                        <div class="row margin-top-30">
                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <div class="img-wrap">
                                        <img 
                                            @if($lastLesson->lesson->module->course->course_preview_image_id == null)
                                                src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
                                            @else
                                                src="{{ cloudfrontUrl( $lastLesson->lesson->module->course->previewImage->url ) }}"
                                            @endif
                                             class="img-responsive" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                                        <h3>{{ $lastLesson->lesson->module->course->name }}</h3>
                                    <p class="regular-paragraph">
                                        {{ $lastLesson->lesson->module->course->short_description }}
                                    </p> 
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                                    <div class="radial-progress">
<!--                                        <div class="progress-radial progress-{{ $student->courseProgress($lastLesson->lesson->module->course) }}">
                                          <div class="overlay">{{ $student->courseProgress($lastLesson->lesson->module->course) }}%</div>
                                        </div>-->
                                        @if(  $student->courseProgress($lastLesson->lesson->module->course)  > 0)
                                            <div id='progress-circle-top-{{$lastLesson->lesson->module->course->id}}' class='progress-circle' data-color='#0099ff' data-trail-color='#2f3439' data-stroke='4' style='height:90px; width:90px'
                                             data-progress='{{ $student->courseProgress($lastLesson->lesson->module->course) }}'></div>
                                        @else
                                            <div id='progress-circle-top-{{$lastLesson->lesson->module->course->id}}' class='progress-circle' data-color='#0099ff' data-trail-color='tomato' data-stroke='4' data-progress='0' 
                                                 style='height:90px; width:90px'></div>
                                        @endif
                                        <a href="{{
                                            action('ClassroomController@lesson', 
                                            [ $lastLesson->lesson->module->course->slug,
                                            $lastLesson->lesson->module->slug,
                                            $lastLesson->lesson->slug])
                                           }}" class="blue-button large-button"><i class="wa-play"></i>Resume</a>
                                    </div>
                                </div>

                        </div>
                        <div class="row current-lesson-row">
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                    <h6 class="current-lesson text-right">Current lesson 
                                        ({{ $lastLesson->lesson->lessonPosition() }}/ {{$lastLesson->lesson->module->course->lessonCount(false) }}): </h6>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                                    <p class="regular-paragraph current-lesson-title">
                                        {{$lastLesson->lesson->module->order}}.{{$lastLesson->lesson->order}}. 
                                        {{ $lastLesson->lesson->name }}
                                    </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs-header">
    	<div class="container">
        	<div class="row">
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active">
                        	<a href="#enrolled" role="tab" id="enrolled-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">Enrolled</a>
                        </li>
                        <li role="presentation">
                        	<a href="#finished" role="tab" id="finished-tab" data-toggle="tab" aria-controls="finished">Finished</a>
                        </li>
                        <li role="presentation" class="dropdown">
                          <a href="#wishlist" role="tab" id="wishlist-tab" data-toggle="tab" aria-controls="wishlist">Wishlist</a>
                        </li>
                    </ul>               
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pull-right">
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="enrolled">
                          @foreach($courses as $course)
                              <?php
                              $course = $course->product;
//                              $firstModule = $course->modules()->orderBy('order','asc')->first();
                              $firstModule = $course->firstModule();
                              $firstLesson = null;
                              if($firstModule !=null ){
//                                  $firstLesson = $firstModule->lessons()->orderBy('order','asc')->first();
//                                  $firstLesson = $firstModule->firstLesson();
                              }
                              $lastLesson = $student->lastLessonInCourse($course);
                              
                              if($lastLesson != null ) $lastLesson = $lastLesson->lesson;
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
                                              <h4><a href="{{ action('ClassroomController@dashboard', $course->slug) }}">{{ $course->name }}</a></h4>
                                              @if( $lastLesson != null )
                                                <p class="regular-paragraph">{{$lastLesson->lessonPosition() }} / {{ $course->lessonCount() }} 
                                                    lessons completed</p>
                                                <p class="regular-paragraph">Current lesson: 
                                          
                                                    <a href="{{
                                                        action('ClassroomController@lesson', 
                                            [ $lastLesson->module->course->slug,
                                            $lastLesson->module->slug,
                                            $lastLesson->slug])
                                                       }}">{{$lastLesson->module->order}}.{{$lastLesson->order}}. {{$lastLesson->name}}</a></p>
                                              @else
                                                <p class="regular-paragraph">0 / {{ $course->lessonCount() }} lessons completed</p>
                                                      @if($firstLesson != null)
                                                      <p class="regular-paragraph">Current lesson: 
                                                          <a href="{{
                                                             action('ClassroomController@lesson', 
                                              [ $firstLesson->module->course->slug,
                                              $firstLesson->module->slug,
                                              $firstLesson->slug])
                                                             }}">1.1. {{$firstLesson->name}}</a></p>
                                                      @endif
                                              @endif
                                              
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                              <div class="enrolled-lessons-progress">
                                                  <span class="finished block"><i class="wa-check"></i>Finished</span>
                                                  <span class="review regular-paragraph">Review</span>
                                                  <span class="progress-value">{{ $student->courseProgress( $course ) }}%</span>
                                                  <!--<img src="../images/radial-progress.png">-->
                                                  <div class='pull-right'>
                                                      <div id='progress-circle-{{$course->id}}' 
                                                           data-text='<i class="fa">&#xf04b;</i>'
                                                           class='progress-circle' data-color='#0099ff' data-trail-color='#E0E1E2' data-stroke='3' 
                                                           style='height:40px; width:40px'
                                                           data-progress='{{ $student->courseProgress( $course ) }}'>
                                                      </div>
                                                  </div>
                                                  
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          @endforeach
                      </div>
                        
                      <div role="tabpanel" class="tab-pane fade" id="finished">
                          @foreach($courses as $course)
                              <?php
                              $course = $course->product;
                              if( $student->courseProgress( $course ) < 100 ) continue;
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
                                              <h4><a href="{{ action('ClassroomController@dashboard', $course->slug) }}">{{ $course->name }}</a></h4>
                                               <p class="regular-paragraph">{{ $course->lessonCount() }} / {{ $course->lessonCount() }} 
                                                    lessons completed</p>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                              <div class="enrolled-lessons-progress">
                                                  <span class="finished block"><i class="wa-check"></i>Finished</span>
                                                  <span class="review regular-paragraph">Review</span>
                                                  <span class="progress-value">{{ $student->courseProgress( $course ) }}%</span>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          @endforeach
                      </div>
                        
                      <div role="tabpanel" class="tab-pane fade" id="wishlist">
                          @foreach($wishlist as $course)
                              <?php $course = $course->course; ?>
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
<!--                                                  <span class="finished block"><i class="wa-check"></i>Finished</span>
                                                  <span class="review regular-paragraph">Review</span>
                                                  <span class="progress-value">{{ $student->courseProgress( $course ) }}%</span>
                                                  <img src="../images/radial-progress.png">
                                                  <div class='pull-right'>
                                                      <div id='progress-circle-{{$course->id}}' 
                                                           data-text='<i class="fa">&#xf04b;</i>'
                                                           class='progress-circle' data-color='#0099ff' data-trail-color='#E0E1E2' data-stroke='3' 
                                                           style='height:40px; width:40px'
                                                           data-progress='{{ $student->courseProgress( $course ) }}'>
                                                      </div>
                                                  </div>-->
                                                  
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          @endforeach
                      </div>
                    </div>                
                </div>
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                	<div class="sidebar">
                        <div class="profile-picture-holder">
                            <img src="{{ $student->commentPicture('student') }}" class="img-responsive">
                        </div>
                        <div href="#" class="name">
                            <h2>{{ $student->fullName() }}</h2>
                            <a href="{{action('ProfileController@index')}}" class="edit-profile"><i class="fa fa-cog"></i>Edit profile</a>
                        </div>
                        <a href="#" class="message-count message">
                        	<i class="fa fa-comment-o"></i>
                            Messages
                            <span class="count">(2)</span>
                        </a>
                        <a href="#" class="message-preview unread message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <a href="#" class="message-preview message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <a href="#" class="message-preview unread message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <a href="#" class="message-preview message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <div class="text-center read-message">
                        	<a href="#" class="default-button large-button">Read all messages</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@stop

@section('extra_js')
<script src='{{ url('js/progressbar.min.js')}}'></script>
<script>
    $(function(){
            $('.progress-circle').each(function(){
                var $elem = $(this);
                var text = $elem.attr('data-text');
                var circle = new ProgressBar.Circle( '#'+$elem.attr('id'), {
                    color: $elem.attr('data-color'),
                    strokeWidth: 4,
                    trailWidth: 4,
                    trailColor: $elem.attr('data-trail-color'),
                    duration: 1000,
                    text: {
                        value: '0'
                    },
                    step: function(state, bar) {
                        if( typeof(text) == 'undefined') bar.setText((bar.value() * 100).toFixed(0));
                        else {
                            $elem.find('.progressbar-text').html( text );
                        }
                    }
                });
            progress = $elem.attr('data-progress') / 100;
            circle.animate( progress );
        });
            
    });
</script>
@stop