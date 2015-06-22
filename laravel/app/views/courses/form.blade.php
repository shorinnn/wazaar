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
            	<h1>Edit: course name</h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class="blue-button large-button disabled-button right">Submit for approval</a>
                <a href="#" class="default-button large-button right">Preview course</a>
            </div>
        </div>
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class="header-tabs regular-paragraph">Course description</a>
            	<a href="#" class="header-tabs regular-paragraph active">Curriculum</a>
            	<a href="#" class="header-tabs regular-paragraph">Settings</a>
                
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<div class="right steps-remaining">
                	<p class="regular-paragraph no-margin">
                    	Complete <span>1 steps</span> to submit course 
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="container main course-editor">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 left-content">
       			<p class="intro-paragraph">
                Create your lessons. Organise them by modules. You can create unlimited number of modules and lessons.
                </p>
                <div class="plan-your-curriculum">
                    <ul id="modules-list">
                        @foreach($course->modules()->orderBy('order','ASC')->get() as $module)
                            {{ View::make('courses.modules.module')->with(compact('module')) }}
                        @endforeach
                    </ul>                    
                    <form method='post' class='ajax-form' id="modules-form" data-callback='addModule'
                          action='{{ action('ModulesController@store',[$course->id] )}}'>
                        <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                        <button type='submit' class='add-new-module'>{{ trans('crud/labels.add_module') }}</button>
                    </form>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 right-content">
            	<h2>Course summary</h2>
            	<div class="row category-row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">Category</p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">IT & WEB</p>
                            </div>
                        </div>
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">Sub-category</p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">Websites</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="edit-button">Edit</a>
                </div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>Description:</h4>
                        <p class="regular-paragraph">
                        Did you know that if you upload a test video you are over 3 times as likely to have your course published and 
                        featured on Udemy? Upload a short, ~1 ...minute long video and upload it to the test video tool by following 
                        </p>
                    </div>
                </div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>What is this for:</h4>
                        <ul>
                        	<li>Did you know that </li>
                        	<li>If you upload a test video </li>
                        	<li>You are over 3 times as likely to have your course published and featured on </li>
                        </ul>
                    </div>
               	</div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>Requirements:</h4>
                        <ul>
                        	<li>Did you know that </li>
                        	<li>If you upload a test video </li>
                        	<li>You are over 3 times as likely to have your course published and featured on </li>
                        </ul>
                    </div>
               	</div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>At the end of course you will be able:</h4>
                        <ul>
                        	<li>Did you know that </li>
                        	<li>If you upload a test video </li>
                        	<li>You are over 3 times as likely to have your course published and featured on </li>
                        </ul>
                    </div>
               	</div>
                <div class="row next-step-button">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<button class="blue-button extra-large-button">NEXT STEP</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@stop