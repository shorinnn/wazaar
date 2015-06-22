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
</style>

@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if (Session::get('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
@include('videos.archiveModal')
<div class="edit-course">
	<section class="container-fluid header">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<h1>{{ trans('courses/general.edit') }}: {{ $course->name }}</h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class="blue-button large-button disabled-button right">{{ trans('courses/general.submit_for_approval') }}</a>
                <a href="#" class="default-button large-button right">
                	{{ trans('courses/general.preview_course') }}
            	</a>

            </div>
        </div>
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class="header-tabs regular-paragraph active load-remote-cache" data-callback='courseChangedTabs' data-cached-callback='courseChangedTabs'
                   data-url="{{ action('CoursesController@edit', $course->slug)}}/1" data-target='.course-ajax-holder .step1' data-steps-remaining='2 steps'
                   >{{ trans('courses/general.course_description') }}</a>
            	<a href="#" class="header-tabs regular-paragraph load-remote-cache" data-callback='courseChangedTabs' data-cached-callback='courseChangedTabs'
                   data-url="{{ action('CoursesController@edit', $course->slug)}}/2" data-target='.course-ajax-holder .step2'  data-steps-remaining='1 step'
                   >{{ trans('courses/general.curriculum') }}</a>
            	<a href="#" class="header-tabs regular-paragraph load-remote-cache" data-callback='courseChangedTabs' data-cached-callback='courseChangedTabs'
                   data-url="{{ action('CoursesController@edit', $course->slug)}}/3" data-target='.course-ajax-holder .step3'  data-steps-remaining='0'
                   >{{ trans('courses/general.settings') }}</a>
                
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<div class="right steps-remaining">
                	<p class="regular-paragraph no-margin">
                    	{{ trans('courses/general.complete') }} <span>2 {{ trans('courses/general.steps') }}</span> {{ trans('courses/general.to_submit_course') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="container main course-editor">
    	<div class="row course-ajax-holder">
            <div class='step1'>
                {{ View::make('courses.editor.step1',compact('awsPolicySig','uniqueKey' ,'course', 'images', 'bannerImages', 'assignedInstructor', 'difficulties'))
                        ->with(compact('categories', 'subcategories', 'assignableInstructors', 'affiliates')) }}
            </div>
            <div class='step2'></div>
            <div class='step3'></div>
        </div>
    </section>
</div>

@include('videos.playerModal')
@stop

