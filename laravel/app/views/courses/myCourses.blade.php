@extends('layouts.default')
@section('content')	
    
@if (Session::get('success'))
    <div class="alert alert-success">{{{ Session::get('success') }}}</div>
@endif
@if (Session::get('error'))
    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
@endif

<table class="table">
@foreach($courses as $course)
<tr>
    <td>
        @if($course->previewImage!=null)
        <a href="{{ $course->previewImage->url }}" target="_blank">
            <img src="{{ $course->previewImage->url }}" height="90" />
        </a>
        @endif
    </td>
    <td>
        {{$course->name}}<br />
        <span class="label label-primary">{{$course->courseCategory->name}}</span>
        <br /><small>Published: {{$course->created_at}}</small>
        <br /><small>Updated: {{$course->updated_at}}</small>
    </td>
    <td>
        {{$course->student_count}}
        {{Lang::choice('general.student', $course->student_count)}}
    </td>
    <td>{{link_to_action('CoursesController@show', trans('crud/labels.view'), $course->slug)}}</td>
    <td>{{link_to_action('CoursesController@edit', trans('crud/labels.edit'), $course->slug)}} </td>
    <td>
        <td>
            @if($course->student_count==0)
                {{ Form::open(array('action' => array('CoursesController@destroy', $course->id), 'method' => 'delete', 'id'=>'course-form-'.$course->id)) }}
                    <button class="btn btn-danger delete-button" data-message="Are you sure you want to delete?" type="submit" >{{trans('crud/labels.delete')}}</button>
                {{ Form::close() }}
            @endif
    </td>
    </td>

@endforeach
</table>
{{$courses->links()}}

@stop