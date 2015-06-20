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

<div class="mycourses-wrapper">
    <section class="container-fluid mycourses-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <h1>Dashboard</h1>
                    <a href="#" class="header-tabs regular-paragraph active">My courses</a>
                    <a href="#" class="header-tabs regular-paragraph">Analytics</a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <a href="#" class="blue-button large-button">Create new course</a>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid mycourses-main">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3 mycourse-card">
                    <div class="row mycourse-card-main">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="mycourses-thumb">
                                <img />
                            </div>                    
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <h3>Build a Website from Scratch</h3>
                            <p class="regular-paragraph"><span class="student-count">13,600</span> students</p>
                            <p class="regular-paragraph"><span class="discussion-count">12 NEW </span> Discussions</p>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <a href="#" class="transparent-button">Edit</a>
                        </div>
                    </div>
                    <div class="row mycourse-card-footer">
                        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                            <p class="date-created regular-paragraph">Created on 12/05/2015</p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-md-offset-1 col-lg-offset-1">
                            <a href="#" class="default-button">Private</a>
                            <a href="#" class="default-button">Unsubmitted</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="toggle-comments">

</div>
<div class="comments-overlay-wrapper">

</div>
@stop