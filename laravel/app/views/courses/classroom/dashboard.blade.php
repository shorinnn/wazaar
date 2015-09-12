@extends('layouts.default')
@section('content')
	<div class="container-fluid student-dashboard student-course top-section">
    	<div class="container">
            <div class="row">
                            @if( Session::has('message') )
                                <h4 class="alert alert-success alert-dismissable" style="background-color:#88C95E; color:white; border:transparent; margin-bottom: 0px">
                                    {{ Session::get('message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </h4>
                            @endif
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
                	<a href="{{ action( 'StudentController@mycourses' ) }}" class="back-to-courses"><i class="wa-chevron-left"></i>{{ trans('courses/dashboard.back-to-courses') }}</a>
                	<h1>{{ $course->name }}</h1>
                    <p>
                        @if($currentLesson != null)
                            Current lesson {{$currentLesson->module->order}}.{{$currentLesson->order}}. {{ $currentLesson->name }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid student-dashboard student-course percentage-completed">
    	<div class="container">
        	<div>
            	<div class="col-xs-12 col-sm-12 col-md-9 col-md-offset-3 col-lg-9 col-lg-offset-3">
                    <p>{{ $student->courseProgress($course) }}% {{ trans('courses/dashboard.completed') }}</p>
                    <div class="progress @if($currentLesson == null) full @endif">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {{ $student->courseProgress($course) }}%;">
                            <span></span>
                        </div>
                    </div>
                    @if($currentLesson != null)
                        <div class="resume-course-button-container">
                            <a href="{{
                                action('ClassroomController@lesson', 
                                                    [ $currentLesson->module->course->slug,
                                                    $currentLesson->module->slug,
                                                    $currentLesson->slug])
                               }}" class="resume-course large-button blue-button"><i class="wa-play"></i>{{ trans('affiliates.gifts.resume-course' )}}</a>
                        </div>
                    @endif
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
                                        <span class="right"> {{$module->completedLessons(Auth::user()->id)}} / {{ $module->lessons->count() }} </span>               
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

                    @if($gift != null)
                            <div class="affiliate-gift-wrap">
                                <div class="row description-wrap no-margin">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 text-center">
                                        <img class="img-responsive gift-coupon inline-block" src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/gift-coupon.png" alt="">
                                </div>
                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                        <div class="description">
                                        <h3>
                                            {{ trans('affiliates.gifts.course-gift-from-name', ['name' => $gift->affiliate->fullName()] ) }}
                                            
                                            
                                        </h3>
                                        <p>{{ $gift->text }}</p>
                                    </div>
                                    <div class="open-button-wrap">
                                        <span class="open-gift blue-button large-button blue-button-shadow">Open Gift</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row files-wrap download-files-wrap no-margin">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                        <a href="#collapseExample" class="toggle-button show-more" data-toggle="collapse"
                                           data-less-text="{{ trans('affiliates.gifts.hide-files') }}" 
                                           data-more-text="{{ trans('affiliates.gifts.show-files') }}">
                                        <i class="wa-chevron-down"></i>{{ trans('affiliates.gifts.show-files') }}
                                    </a>
                                </div>
                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                    <span style='opacity:0' class="default-button large-button">{{ trans('affiliates.gifts.download-all-files-in-zip') }}</span>
                                    <span class="file-size">{{$gift->files->count()}} {{ trans('affiliates.gifts.files') }} </span>
                                </div>    
                            </div>
                            <div class="row files-wrap toggle-container collapse no-margin" id="collapseExample">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                </div>
                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                        <ul>
                                            @foreach($gift->files as $file)
                                                <li class="file">
                                                        <a href="{{ $file->presignedUrl() }}">
                                                        @if( strpos( $file->mime, 'image')!== false )
                                                          <i class="fa fa-file-image-o"></i> 
                                                        @elseif( strpos( $file->mime, 'pdf' ) !== false )
                                                          <i class="fa fa-file-pdf-o"></i> 
                                                        @else
                                                          <i class='fa fa-file-text'></i>
                                                        @endif
                                                        <span class="file-name regular-paragraph">{{ $file->name }}</span>
                                                        <span class="file-size regular-paragraph">{{ $file->size }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                    </ul>
                                </div>    
                            </div>
                        </div>
                    @endif
                        @if($nextLesson !=null && $currentLesson == null)
                            <style>
                                .resume-button-container{
                                    padding: 24px;
                                    text-align: center;
                                    background: #fff;
                                    border: 1px solid #e0e1e2;
                                    border-radius: 4px;
                                    margin-bottom: 20px;
                                }
                                .resume-button-container h3{
                                    color: #303941;
                                    margin: 0 0 10px;
                                }
                            </style>
                            <div class="resume-button-container">
                                <!-- <h3>{{ trans('courses/general.continue-lesson') }}</h3> -->

                                    <a href="{{
                                        action('ClassroomController@lesson', 
                                                            [ $nextLesson->module->course->slug,
                                                            $nextLesson->module->slug,
                                                            $nextLesson->slug])
                                       }}" class="resume-course large-button blue-button"><i class="wa-play"></i>{{ trans('affiliates.gifts.begin-course' )}}</a>
                                
                            </div>
                            	
                   
                        <div class="question-answer-wrap">
                        <div class="row question-answer">
                            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                                <div class="row question no-margin">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <h3></h3>
                                        <p class="regular-paragraph">
                                        {{ trans('courses/general.dash-you-have-no-questions-yet') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @endif
                </div>
            </div>
        </div>    
    </div>
@stop

@section('extra_js')
<script>
    $(".open-gift").click(function(){
            $(".download-files-wrap").show();
            $(".open-button-wrap").hide();
            $(".affiliate-gift-wrap .description").css({width: "100%"});
    });
</script>
@stop