@extends('layouts.default')
@section('content')	
    
@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif

<div class="table-responsive">
<table class="table table-bordered table-striped">
@foreach($courses as $course)

<tr class="course-header">
    <td colspan="3">
        {{$course->name}}
        <span class="label label-primary">{{$course->courseCategory->name or 'No Category'}}</span>
        <span class="label label-primary">{{$course->courseSubcategory->name or 'No Subcategory'}}</span>
    </td>
    <td>
    </td>
</tr>
<tr class="course-info">
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
                {{ Form::open(array('action' => array('CoursesController@destroy', $course->id), 'method' => 'delete', 'id'=>'course-form-'.$course->id)) }}
                    <button class="btn btn-danger delete-button" data-message="{{ trans('you-sure-want-delete') }}" type="submit" >{{trans('crud/labels.delete')}}</button>
                {{ Form::close() }}
            @endif

    </td>

    </tr>

@endforeach
</table>
</div>
{{$courses->links()}}

@stop