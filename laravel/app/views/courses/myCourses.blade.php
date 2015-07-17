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
                    <h1>{{ trans('courses/general.dashboard') }}</h1>
                    <a href="#" class="header-tabs regular-paragraph active">{{ trans('courses/general.my-courses-link-instructor') }}</a>
                    <a href="#" class="header-tabs regular-paragraph">{{ trans('courses/general.analytics') }}</a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                	@if($courses->count() == 0)
                    	<a href="{{action('CoursesController@create')}}" class="blue-button large-button hide">{{ trans('courses/create.create-btn-instructor') }}</a>
                    @else
                    	<a href="{{action('CoursesController@create')}}" class="blue-button large-button">{{ trans('courses/create.create-btn-instructor') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid mycourses-main">
        <div class="container">
            <div class="row">
                <!-- no courses -->
                @if($courses->count() == 0)
                	<div class="no-courses-available text-center">
                        <p>{{ trans('courses/general.instructor-no-courses')}}</p>
                        <a href="{{action('CoursesController@create')}}" class="blue-button large-button">{{ trans('courses/general.create-btn-instructor') }}</a>
                    </div>
                @endif
                <!--/ no courses -->
            	@foreach($courses as $course)
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-3 col-lg-offset-3 mycourse-card course-row-{{$course->id}}">
                    <div class="row mycourse-card-main">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="mycourses-thumb">
                                @if($course->previewImage!=null)
                                <a href="{{ $course->previewImage->url }}" target="_blank">
                                    <img src="{{ $course->previewImage->url }}" height="90" />
                                </a>
                                @endif                        
                            </div>                    
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <h3>{{$course->name}}</h3>
                            <p class="regular-paragraph">
                            	<i class="fa fa-user"></i>
                            	<span class="student-count">
                            		{{ $course->student_count }}
                                </span> 
                                {{ trans('courses/general.students') }}
                            </p>
                            <p class="regular-paragraph">
                            	@if( $course->dashboardComments->count() > 0 ) 
                                    <a href="{{ action( 'CoursesController@dashboard', $course->slug ) }}?tab=discussions" class="discussion-count">
                                    	<i class="fa fa-comments wazaar-blue-text"></i>                                	                                	                                  	
                                        <i>{{ $course->dashboardComments->count() }}</i> {{ trans('courses/general.new') }}
                                        {{ trans('courses/general.discussions') }} 
                                    </a>
                                @else
                                	<i class="fa fa-comments"></i>
                                	{{ trans('courses/general.no-new-discussions') }}
                                @endif
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                            <a href='{{ action('CoursesController@edit', $course->slug) }}' 
                               class='edit-button'>
                                <i class="fa fa-pencil-square-o"></i>
                                {{ trans('courses/general.edit') }}
                            </a>
                            <!--{{-- link_to_action('CoursesController@edit', trans('courses/general.edit'), $course->slug, [ 'class'=>'transparent-button' ] ) --}}-->
                            @if($course->student_count==0)
                                {{ Form::open(['action' => ['CoursesController@destroy', $course->id], 
                                               'method' => 'delete', 'id'=>'course-form-'.$course->id,
                                               'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '.course-row-'.$course->id]) }}
                                    <button class="btn btn-danger delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}" type="submit" >
                                        <i class="fa fa-trash-o"></i> {{trans('crud/labels.delete')}}</button>
                                {{ Form::close() }}
                            @else
                                <button title="{{trans('crud/labels.cannot-delete-students-purchased')}}" class="default-button tooltipable">
                                    <i class="fa fa-exclamation-triangle"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="row mycourse-card-footer">
                        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                            <p class="date-created regular-paragraph">{{ trans('courses/general.created-on') }}: 
                                <span> {{ date('m/d/Y', strtotime($course->created_at)) }}</span></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-md-offset-1 col-lg-offset-1">
                            
                            <span class="default-button {{ $course->privacy_status }}">
                                {{ trans('courses/general.my-courses-privacy.'.$course->privacy_status) }}
                            </span>
                            <span class="default-button 
                                  @if($course->publish_status=='pending') submitted @endif
                                  @if($course->publish_status=='approved') published @endif
                                  ">
                                    {{ trans('courses/general.my-courses-publish.'.$course->publish_status) }}</span>
                            
                            
                            <span class="default-button @if($course->free=='yes') free @else paid @endif">
                                @if($course->free=='yes')
                                    {{ trans('courses/create.free') }}
                                @else
                                    {{  trans('courses/create.paid') }}
                                @endif
                            </span>
                            
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{$courses->links()}}
    </section>
</div>
<div class="toggle-comments">

</div>
<div class="comments-overlay-wrapper">

</div>
@stop