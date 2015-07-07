@extends('layouts.default')
@section('page_title')
    {{ $course->name }} - {{ trans('courses/general.edit') }} -
@stop

@section('content')

<style>
    #save-indicator{
        border:1px solid black;
        background-color:white;
        width:90px;
        height:30px;
        position:fixed;
        top:100px;
        left:-100px;
        text-align: right;
        padding-right: 10px;
    }
    
    #publish-status-header{
        font-size:15px;
    }
    .edit-course select{
        width:auto;
    }
    .course-description-video-preview img, .course-listing-image-preview img{
        max-height: 100px;
    }
</style>

@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if (Session::get('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
@include('videos.archiveModal')
<div class="edit-course">
    <input type='hidden' class='step-1-filled' value='{{ $course->short_description !='' ? 1 : 0}}' />
    <input type='hidden' class='step-2-filled' value='{{ $course->lessonCount() >= 0 ? 1 : 0}}' />
    <input type='hidden' class='step-3-filled' value='{{ $course->course_difficulty_id > 0 ? 1 : 0}}' />
	<section class="container-fluid header">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<div class="video-preview-thumb">
                
                </div>
                <div class="left">
                <ul class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Course Edit</a></li>
                </ul>                    
                <h1>{{ $course->name }}
                        <!--<a href="{{ action('CoursesController@myCourses') }}" class="blue-button large-button back-to-course-list">
                            {{ trans('courses/general.back-to-course-list')}}
                        </a>-->
                    </h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class=" submit-for-approval blue-button large-button disabled-button right">{{ trans('courses/general.submit') }}</a>
                <!--<a href='#' data-href="{{ action( 'CoursesController@show', $course->slug ) }}" class="default-button disabled-button large-button right preview-course-btn">
                	{{ trans('courses/general.preview_course') }}
            	</a>-->

            </div>
        </div>
        <div class="row header-tabs-container">
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            	<a href="#" class="header-tabs active load-remote-cache" data-callback='courseChangedTabs' data-cached-callback='courseChangedTabs'
                   data-url="{{ action('CoursesController@edit', $course->slug)}}/1" data-target='.course-ajax-holder .step1' data-steps-remaining='2 steps'
                   data-loaded='1' data-gif='ajax-loader-3.gif' ><em>1</em>{{ trans('courses/general.description') }}</a>
            	<a href="#" class="header-tabs load-remote-cache link-to-step-2" data-callback='courseChangedTabs' data-cached-callback='courseChangedTabs'
                   data-url="{{ action('CoursesController@edit', $course->slug)}}/2" data-target='.course-ajax-holder .step2'  data-steps-remaining='1 step'
                   data-gif='ajax-loader-3.gif' ><em>2</em>{{ trans('courses/general.curriculum') }}</a>
            	<a href="#" class="header-tabs load-remote-cache link-to-step-3" data-callback='courseChangedTabs' data-cached-callback='courseChangedTabs'
                   data-url="{{ action('CoursesController@edit', $course->slug)}}/3" data-target='.course-ajax-holder ._step3'  data-steps-remaining='0'
                   data-gif='ajax-loader-3.gif' ><em>3</em>{{ trans('courses/general.settings') }}</a>
                
            </div>
            
               <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="right steps-remaining">
                        @if( courseStepsRemaining($course)==0 || $course->publish_status!='unsubmitted')
                            <p class="regular-paragraph no-margin">
                               <span>{{ trans('courses/general.course-ready-for-submission') }} </span>
                            </p>
                        @else
                            <p class="regular-paragraph no-margin">
                            {{ trans('courses/general.complete-x-steps-to-submit', ['steps' => courseStepsRemaining($course) ] )}}
                            <br />
<!--                            {{ trans('courses/general.complete') }} 
                            <span>
                                <span>{{ courseStepsRemaining($course) }}</span>
                                {{ trans('courses/general.steps') }}</span> {{ trans('courses/general.to_submit_course') }}-->
                            <!--</p>
                        @endif
                    </div>
                </div>-->
        </div>
    </section>
    <section class="container main course-editor">
    	<div class="row course-ajax-holder">
                <form id="form-aws-credentials" action="">
                    <input type="hidden" name="key" value="{{$uniqueKey}}-${filename}">
                    <input type="hidden" name="AWSAccessKeyId" value="{{Config::get('aws::config.key')}}">
                    <input type="hidden" name="acl" value="private">
                    <input type="hidden" name="success_action_status" value="201">
                    <input type="hidden" name="policy" value="{{$awsPolicySig['base64Policy']}}">
                    <input type="hidden" name="signature" value="{{$awsPolicySig['signature']}}">
                </form>
            <div class='step1' data-loaded='1'>
                <input class="course-id" type="hidden" value="{{$course->id}}"/>
                {{ View::make('courses.editor.step1',compact('awsPolicySig','uniqueKey' ,'course', 'images', 'bannerImages', 'assignedInstructor', 'difficulties'))
                        ->with(compact('categories', 'subcategories', 'assignableInstructors', 'affiliates', 'filePolicy' ) ) }}
            </div>
            <div class='step2'></div>
            <div class='_step3'></div>
        </div>
    </section>
</div>
@include('videos.playerModal')
<script>
    var course_steps_remaining = {{ courseStepsRemaining($course) }};
</script>
@stop

