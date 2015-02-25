@extends('layouts.default')
@section('content')
    
        <div class="classrooms-wrapper clearfix">
            <h1 class="classroom-course-title">Course: {{ $course->name }}</h1>
            <h2 class="classroom-lesson-title">Lesson: {{ $lesson->name }}</h2>
        	<section class="video-container">
            	@if( $video != null)
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
                        <div class="control">
                    
                            <div class="topControl">
                                <div class="progress">
                                    <span class="bufferBar"></span>
                                    <span class="timeBar"></span>
                                </div>
                            </div>
                            
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
                                    <span class="current"></span> / 
                                    <span class="duration"></span> 
                                </div>
                            </div>
                            
                        </div>
                        <div class="loading"></div>
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
                          @if($block->type=='text')
                              <div class="well">{{ $block->content }}</div>
                          @endif
                      @endforeach
                    </div>
                </div>
                <div class="row second-row">
                	<div class="col-md-12">
                    	<div class="files">
                            @foreach($lesson->blocks as $block)
                                @if($block->type=='file')
                                    <p><a href='{{ $block->content }}' target='_blank'><i class="fa fa-cloud-download"></i> {{ $block->name }}</a></p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row classmate-conversations-heading">
                	<div class="col-md-12">
                        <p class="lead">Conversations:</p>
                    </div>
                </div>
            </section>
            <section class="classroom-content container">
            @if( Auth::check() )
                {{ View::make('courses.classroom.conversations.form')->with( compact('lesson') ) }}
            @endif
            
                <div class='ajax-content fa-animated'>
                    {{ View::make('courses.classroom.conversations.all')->withComments( $lesson->comments ) }}
        
                   <!-- <a href='{{ action('ConversationsController@lesson', [$lesson->module->course->slug, $lesson->slug] )}}' class="load-more-comments load-more-ajax" 
                       data-url='{{action('ConversationsController@loadMore')}}' 
                       data-target='.users-comments' data-skip='2' data-post-field='lesson' data-id='{{$lesson->id}}'>LOAD MORE</a>
                    -->
                    <br />
                    <div class="text-center load-remote" data-target='.ajax-content' data-load-method="fade">
                        
                        {{ $lesson->comments->links() }}
                        <!--<a href='{{ action('ConversationsController@lesson', [$lesson->module->course->slug, $lesson->module->slug, $lesson->slug] )}}'>View All Comments Ever</a>-->
                    </div>
                </div>
            </section>
            <section class="container-fluid become-an-instructor">
                <div class="container">
                  <div class="row">
                    <div class="col-xs-12">
                      <h1>BECOME</h1>
                      <h2>AN INSTRUCTOR</h2>
                      <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
                    </div>
                  </div>
              </div>
            </section>
        </div>
@stop

