@extends('layouts.default')

    
@section('page_title')
    {{ $lesson->name }} - {{ $lesson->module->name }} - {{ $course->name }} -
@stop
    
    
@section('content')
    
        <div class="classrooms-wrapper clearfix">
            <!--<h1 class="classroom-course-title">{{trans('courses/general.Course')}}: {{ $course->name }}</h1>
            <h2 class="classroom-lesson-title">{{trans('courses/general.lesson')}}: {{ $lesson->name }}</h2>-->
        	<section class="video-container">
            	@if( $video != null && $video->video()!=null)
                <div class="text-center">
                    @if( Agent::isMobile() )
                        <video controls>
                        	<source src="{{ $video->video()->formats()->where('resolution', 'Custom Preset for Mobile Devices')
                            ->first()->video_url }}" type="video/mp4">
                        </video>
                    @else
                    <div class="videoContainer">
                        <video id="myVideo" preload="auto" controls>
                            <source src="{{ $video->video()->formats()->where('resolution', 'Custom Preset for Desktop Devices')
                            ->first()->video_url }}" type="video/mp4">
                        	<p>Your browser does not support the video tag.</p>
                        </video> 
                        <div class="control-container">                       
                            <div class="topControl">
                                <div class="progress">
                                    <span class="bufferBar"></span>
                                    <span class="timeBar"></span>
                                </div>
                            </div>
                            <div class="control clearfix">
                                
                                <div class="btmControl clearfix">
                                    <div class="btnPlay btn" title="Play/Pause video"></div>
                                    <div class="sound sound2 btn" title="Mute/Unmute sound"></div>
                                    <div class="volume-container">
                                        <div class="volume" title="Set volume">
                                            <span class="volumeBar">
                                                <em></em>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="btnFS btn" title="Switch to full screen"></div>
                                    <div class="time">
                                        <span class="current"></span>
                                        <span class="duration"></span> 
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="loading"></div>
                    </div>
                    <div id="lesson-video-overlay">
                    	<div>
                        	<h4>{{ $course->name }}</h4>
                        	<h3>{{ $lesson->name }}</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                        </div>
                    </div>
                    <span class="centered-play-button"></span>
                    @endif
                </div>
            	@endif
            </section>
            <section class="classroom-content container">
            	<div class="row first-row">
                	<div class="col-md-12">
                      @foreach($lesson->blocks as $block)
                          @if($block->type=='text' && trim($block->content)!='')
                              <div class="well">{{ $block->content }}</div>
                          @endif
                      @endforeach
                    </div>
                </div>
                <div class="row second-row">
                    @if($lesson->blocks()->where('type','file')->count() > 0)
                            <div class="col-md-12">
                            <div class="files">
                                @foreach($lesson->blocks as $block)
                                    @if($block->type=='file')
                                        <p> 
                                            <a href="{{ action('ClassroomController@resource', PseudoCrypt::hash($block->id) ) }}">
                                            <i class="fa fa-cloud-download"></i> {{ $block->name }}</a>
                                        </p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                
            </section>
            
            @if($course->ask_teacher == 'enabled')
                @if( $lesson->ask_teacher_messages->count() == 0)
                    <section class="classroom-content container">
                        <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                        <span id="show-teacher-questions">
                                            <em>{{ trans('courses/general.ask') }}</em>
                                            @if($instructor->profile == null)
                                                <span>{{ trans('courses/general.instructor-a-question') }}</span>
                                                <img class="img-circle img-responsive hidden-xs" 
                                                src="{{ cloudfrontUrl('https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/teacher-avater-2.png') }} " 
                                                />
                                            @else
                                                <span>{{$instructor->profile->first_name}}</span>
                                                <img src="{{ cloudfrontUrl( $instructor->profile->photo ) }}" class="img-circle hidden-xs">
                                            @endif
                                        </span>                    
                            </div>
                        </div>
                    </section>
                @endif
                <section class="classroom-content container
                         @if( $lesson->ask_teacher_messages->count() == 0)
                             hide-teacher-questions no-teacher-questions
                         @endif
                         " id="lesson-ask-teacher-section">
                	<div>
                	<a name='ask-teacher'></a>
                    <div class="row classmate-conversations-heading">
                            <div class="col-md-12">
                            <p class="lead">{{trans('conversations/general.ask-the-teacher')}}:</p>
                        </div>
                    </div>
                @if( Auth::check() )
                    {{ View::make('private_messages.partials.ask_teacher_form')->with( compact('lesson', 'student') ) }}
                @endif

                    <div class='ask-content fa-animated                          
                    	 @if( $lesson->ask_teacher_messages->count() == 0)
                             hide
                         @endif'>
                        {{ View::make('private_messages.all')->withComments( $lesson->ask_teacher_messages )->withStudent( $student ) }}
                        <br />
                        
                        <div class="text-center load-remote" data-target='.ask-content' data-load-method="fade">
                            {{ $lesson->ask_teacher_messages->appends( [ 'ask' => 1 ] )->links() }}
                        </div>
                    </div>
                   	</div>
                </section>
                
            @endif
            
            
            <section class="classroom-content container">
                <div class="row classmate-conversations-heading">
                	<div class="col-md-12">
                        <p class="lead">{{trans('conversations/general.classmate-conversations')}}</p>
                    </div>
                </div>
                
            @if( Auth::check() )
                {{ View::make('courses.classroom.conversations.form')->with( compact('lesson','student') ) }}
            @endif
            
                <div class='ajax-content fa-animated'>
                    {{ View::make('courses.classroom.conversations.all')->withComments( $lesson->comments )->withStudent('student') }}
                    <br />
                    <div class="text-center load-remote" data-target='.ajax-content' data-load-method="fade">
                        
                        {{ $lesson->comments->links() }}
                    </div>
                </div>
            </section>
            
            <div class="clearfix container">
                    <div class="row">
                    <div class="col-md-6">
                        @if( $prevLesson )
                        <a href="{{ action('ClassroomController@lesson',[
                            'course' => $prevLesson->module->course->slug, 
                                              'module' => $prevLesson->module->slug, 
                                              'lesson' => $prevLesson->slug 
                        ]) }}"  class="previous-lesson-button left">
                            <h2>
                                {{ trans('courses/general.prev-lesson')}}
                                <small>{{ $prevLesson->name }}</small>
                            </h2>
                        </a>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if( $nextLesson )
                        <a href="{{ action('ClassroomController@lesson',[
                            'course' => $nextLesson->module->course->slug, 
                                              'module' => $nextLesson->module->slug, 
                                              'lesson' => $nextLesson->slug 
                        ]) }}" class="previous-lesson-button right">
                            <h2>
                                {{ trans('courses/general.next-lesson')}}
                                <small>{{ $nextLesson->name }}</small>
                            </h2>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            
            
            
            
            
            <!--<section class="container-fluid become-an-instructor">
                <div class="container">
                  <div class="row">
                    <div class="col-xs-12">
                      <h1>{{trans('site/homepage.become')}}</h1>
                      <h2>{{trans('site/homepage.an-instructor')}}</h2>
                      <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
                    </div>
                  </div>
              </div>
            </section>-->
        </div>
@stop

