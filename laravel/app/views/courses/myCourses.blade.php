@extends('layouts.default')
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
            	<h1>My Courses</h1>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
        	<div>
              	@foreach($courses as $course)
            	<div class="course-wrapper">
                	<div class="top-content course-header course-row-{{$course->id}}">
                    	<div>
                        	<h4>{{$course->name}}</h4>
                        	<span class="label label-primary">{{$course->courseCategory->name or 'No Category'}} ></span>
                        	<span class="label label-primary">{{$course->courseSubcategory->name or 'No Subcategory'}}</span>
                        </div>
                        <div>
                        <p class="created-date">
                        Created on: <span>23-04-2014</span>
                        </p>
                        {{ link_to_action('CoursesController@edit', trans('courses/general.edit'), $course->slug, [ 'class'=>'edit-button btn btn-primary' ] ) }}
                        </div>                    
                    </div>
                    <div class="middle-content course-info course-row-{{$course->id}}">
                    	<div class="image-container">
                            @if($course->previewImage!=null)
                            <a href="{{ $course->previewImage->url }}" target="_blank">
                                <img src="{{ $course->previewImage->url }}" height="90" />
                            </a>
                            @endif                        
                        </div>
                        <div class="description">
                        	<p>
                            “Thank you so much teacher! I’ve never thought that this course would help me this much in PHP.  
                            Learned a lot from it!”
                            </p>
                            <span class="status-box">
                            	Status:
                                <em>Public</em>
                            </span>
                        </div>
                        <div class="buttons">
                        	<ul>
                            	<li class="questions">
                                	<a href="#"><span><i>24</i></span><em>Questions</em></a>
                                </li>
                            	<li class="discussions">
                                	<a href="#"><span><i>254</i></span><em>Discussions</em></a>
                                </li>
                            	<li class="assignment">
                                	<a href="#"><span></span><em>Assignment</em></a>
                                </li>
                            	<li class="compliments">
                                	<a href="#"><span></span><em>Compliments</em></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="bottom-bar">
                    
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