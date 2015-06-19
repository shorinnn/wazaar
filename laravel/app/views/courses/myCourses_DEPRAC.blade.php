@extends('layouts.default')

@section('page_title')
    {{ trans('courses/general.my-courses') }} - 
@stop

@section('content')	
    
@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif

<section class="container-fluid instructor-mycourses">
	<div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            	<h1>USER DASHBOARD</h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            	<a href="#" class="blue-button large-button">Create new course</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
            	<div class="preview-mycourses-video">
                	<img />
                </div>
                <div>
                	<h3></h3>
                    <p class="regular-paragraph"></p>
                    <div>
                    	<a href="#">Discussions</a>
                        <a href="#">Edit</a>
                        <span class="price"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="toggle-comments">

</div>
<div class="comments-overlay-wrapper">

</div>
@stop