@extends('layouts.default')
@section('content')
	<div class="container-fluid student-dashboard student-course top-section">
    	<div class="container">
            <div class="row">
                <div class="col-xs-4 col-sm-3 col-md-3 col-lg-3">
                    <div class="profile-picture-holder">
                        <img 
                            @if($course->course_preview_image_id == null)
                                src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
                            @else
                                src="{{ cloudfrontUrl( $course->previewImage->url ) }}"
                            @endif
                            class="img-responsive">
                    </div>
                </div>
                <div class="col-xs-8 col-sm-9 col-md-9 col-lg-9">
                	<a href="{{ action( 'StudentController@mycourses' ) }}" class="back-to-courses"><i class="wa-chevron-left"></i>Back to courses</a>
                	<h1>{{ $course->name }}</h1>
                    <p>
                    Current lesson {{$currentLesson->module->order}}.{{$currentLesson->order}}. {{ $currentLesson->name }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid student-dashboard student-course percentage-completed">
    	<div class="container">
        	<div class="row">
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                	<p>{{ $student->courseProgress($course) }}% completed</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {{ $student->courseProgress($course) }}%;">
                            <span></span>
                        </div>
                    </div>
                    <a href="{{
                        action('ClassroomController@lesson', 
                                            [ $currentLesson->module->course->slug,
                                            $currentLesson->module->slug,
                                            $currentLesson->slug])
                       }}" class="resume-course large-button blue-button"><i class="wa-play"></i>Resume course</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid student-dashboard student-course">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 margin-top-25">
                	<div class="sidebar">
                            @foreach($course->modules as $module)
                                <div class="course-topics-box">
                                    <div class="topic-header clearfix">
                                        <h3 class="left"><em>{{ $module->order }}. </em> {{ $module->name }}</h3>
                                        <span class="right"> {{$module->completedLessons()}} / {{ $module->lessons->count() }} </span>               
                                    </div>
                                    <div class="topics">
                                        <ul>
                                            @foreach($module->lessons as $lesson)
                                                <li @if( $student->isLessonCompleted($lesson) ) class="completed" @endif>
                                                    <a href="{{ action('ClassroomController@lesson', 
                                                        [ $lesson->module->course->slug,
                                                        $lesson->module->slug,
                                                        $lesson->slug]) }}">{{ $lesson->name }} 
                                                        <span><em></em><i class="wa-check"></i></span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                    </div>
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 margin-top-25">
                	<div class="question-answer-wrap">
                        <div class="row question-answer">
                            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                                <div class="row question no-margin">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <h3>What are the best resources for learning bleeding-edge web, UI and UX design?</h3>
                                        <p class="regular-paragraph">
                                        I'm looking for any kind of resource, including those that are highly technical, those directed to 
                                        experienced UI/UX designers, and just interesting philosophical works that inform awesome modern/current 
                                        web UIs/UXs (like Quora's!).
                                        </p>
                                    </div>
                                </div>
                                <div class="row answer no-margin">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="avatar">
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                        </div>
                                        <div class="replies-box">
                                            <div class="clearfix">
                                                <span class="name">Mac Chinedu</span>
                                                <div class="role teacher">Teacher</div>
                                            </div>
                                            <p class="reply">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                            UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                                            <p class="reply">There is a difference between UI design and UX design. </p>
                                        </div>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row question-answer">
                            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                                <div class="row question no-margin">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <h3>What are the best resources for learning bleeding-edge web, UI and UX design?</h3>
                                        <p class="regular-paragraph">
                                        I'm looking for any kind of resource, including those that are highly technical, those directed to 
                                        experienced UI/UX designers, and just interesting philosophical works that inform awesome modern/current 
                                        web UIs/UXs (like Quora's!).
                                        </p>
                                    </div>
                                </div>
                                <div class="row answer no-margin">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="avatar">
                                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                        </div>
                                        <div class="replies-box">
                                            <div class="clearfix">
                                                <span class="name">Mac Chinedu</span>
                                                <div class="role others">Co-founder @ trydesignlab.com</div>
                                            </div>
                                            <p class="reply">I'm looking for any kind of resource, including those that are highly technical, those directed to experienced 
                                            UI/UX designers, and just interesting philosophical works that inform awesome modern/current web UIs/UXs (like Quora's!).</p>
                                            <p class="reply">There is a difference between UI design and UX design. </p>
                                        </div>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                                <div class="discussion-sidebar-footer clearfix">
                                    <div class="avatar">
                                        <img src="https://s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar.jpg" alt="" class="img-responsive">
                                    </div>
                                    <form>
                                        <input type="text" placeholder="Write you answer">
                                    </form>
                                </div>  
                            </div>
                        </div>
                    </div>              
            	</div>
            </div>
        </div>    
    </div>
@stop
