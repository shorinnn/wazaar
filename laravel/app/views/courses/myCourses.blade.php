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

<div class="container instructor-mycourses">
	<div class="row">
    	<div class="col-md-12">
            <div>
                <a class='btn btn-primary pull-right' href='{{action('CoursesController@create')}}'>{{ trans('courses/create.create') }}</a>
            	<h1>{{ trans('courses/general.my-courses') }}</h1>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
        	<div>
              	@foreach($courses as $course)
            	<div class="course-wrapper">
                	<div class="top-content course-header course-row-{{$course->id}} clearfix">
                        <div class="row clearfix">
                            <div class="col-md-6 clearfix">
                                <div class="clearfix">
                                    <h4>{{$course->name}}</h4>
                                    <span class="label label-primary">{{$course->courseCategory->name or ' - '}} ></span>
                                    <span class="label label-primary">{{$course->courseSubcategory->name or ' - '}}</span>
                                </div>
                        	</div>
                            <div class="col-md-6 clearfix">
                                <div class="clearfix">
                                    <p class="created-date">
                                    {{ trans('courses/general.created-on') }}: <span>23-04-2014</span>
                                    </p>
                                    {{ link_to_action('CoursesController@edit', trans('courses/general.edit'), $course->slug, [ 'class'=>'edit-button' ] ) }}
                                </div>
                        	</div> 
                        </div>                   
                    </div>
                    <div class="middle-content course-info course-row-{{$course->id}} clearfix">
                    	<div class="row clearfix">
                        	<div class="col-xs-12 col-sm-6 col-md-4 clearfix">
                                <div class="image-container clearfix">
                                    @if($course->previewImage!=null)
                                    <a href="{{ $course->previewImage->url }}" target="_blank">
                                        <img src="{{ $course->previewImage->url }}" height="90" />
                                    </a>
                                    @endif                        
                                </div>
                        	</div>
                        	<div class="hidden-xs hidden-sm col-md-6 clearfix">
                                <div class="description clearfix">
                                    <p>
                                    @if($course->testimonials()->where('rating','positive')->where('reported','no')->first() != null)
                                        “{{ $course->testimonials()->where('rating','positive')->where('reported','no')->first()->content }}”
                                    @else
                                    {{ trans('courses/general.your-students-are-going-to-love') }} “{{ $course->name }}”!
                                    @endif
                                    </p>
                                </div>
                        	</div>
                        	<div class="col-xs-12 col-sm-6 col-md-2 clearfix">
                                <div class="buttons clearfix">
                                    <ul class="clearfix">
                                        <li class="questions clearfix">
                                            <a href="{{ action( 'CoursesController@dashboard', $course->slug ) }}?tab=questions">
                                                <span>
                                                    @if( $course->questions->count() > 0 )
                                                        <i>{{ $course->questions->count() }}</i>
                                                    @endif
                                                </span>
                                                <em>{{ trans('courses/general.questions') }}</em></a>
                                        </li>
                                        <li class="discussions clearfix">
                                            <a href="{{ action( 'CoursesController@dashboard', $course->slug ) }}?tab=discussions">
                                                <span>
                                                @if( $course->dashboardComments->count() > 0 )
                                                    <i>{{ $course->dashboardComments->count() }}</i>
                                                @endif
                                                </span>
                                                <em>{{ trans('courses/general.discussions') }}</em>
                                            </a>
                                        </li>
                                        <!--<li class="assignment">
                                            <a href="#"><span></span><em>Assignment</em></a>
                                        </li>
                                        <li class="compliments">
                                            <a href="#"><span></span><em>Compliments</em></a>
                                        </li>-->
                                    </ul>
                                </div>
                        	</div>
                        </div>
                    </div>
                    <div class="bottom-bar clearfix">
                    	<div class="row clearfix">
                            <div class="col-md-12 clearfix">
                                <span class="status-box">
                                    {{ trans('courses/general.publish-status') }}: 
                                    <em>{{ ucfirst( trans( 'courses/statuses.'.$course->publish_status ) ) }}</em>
                                    | 
                                    {{ trans('courses/general.privacy') }}:
                                    <em>{{ ucfirst( trans( 'courses/statuses.'.$course->privacy_status ) ) }}</em>
                                </span>
                                <a href="{{ action( 'CoursesController@dashboard', $course->slug ) }}" class="go-to-dashboard">
                                    {{ trans('courses/general.go-to-dashboard') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
    </div>
            <!--<div class="table-responsive">
                <table class="table table-bordered table-striped">
                @foreach($courses as $course)
                
                <tr class="course-header course-row-{{$course->id}}">
                    <td colspan="3">
                        {{$course->name}}
                        <span class="label label-primary">{{$course->courseCategory->name or 'No Category'}}</span>
                        <span class="label label-primary">{{$course->courseSubcategory->name or 'No Subcategory'}}</span>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr class="course-info course-row-{{$course->id}}">
                    <td>
                        @if($course->previewImage!=null)
                        <a href="{{ $course->previewImage->url }}" target="_blank">
                            <img src="{{ $course->previewImage->url }}" height="90" />
                        </a>
                        @endif
                    </td>
                    <td class="text-center">
                        <h3>{{$course->student_count}}</h3>
                        {{Lang::choice('general.student', $course->student_count)}}
                    </td>
                    <td class="text-center">{{link_to_action('CoursesController@show', trans('crud/labels.view'), $course->slug)}}</td>
                    <td class="text-center">
                        
                        {{ link_to_action('CoursesController@curriculum', trans('courses/general.manage_lessons'), $course->slug, [ 'class'=>'edit-button btn btn-primary' ] ) }}
                        {{ link_to_action('CoursesController@edit', trans('courses/general.edit_details'), $course->slug, [ 'class'=>'edit-button btn btn-primary' ] ) }}
                            
                            @if($course->student_count==0)
                                {{ Form::open(['action' => ['CoursesController@destroy', $course->id], 
                                               'method' => 'delete', 'id'=>'course-form-'.$course->id,
                                               'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '.course-row-'.$course->id]) }}
                                    <button class="btn btn-danger delete-button" data-message="{{ trans('crud/labels.you-sure-want-delete') }}" type="submit" >{{trans('crud/labels.delete')}}</button>
                                {{ Form::close() }}
                            @endif
                
                    </td>
                
                    </tr>
                
                @endforeach
                </table>
            </div>-->
            {{$courses->links()}}
		</div>
	</div>
</div>
@stop