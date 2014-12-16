@extends('layouts.default')
@section('content')

@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if (Session::get('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

<table class="table">
    {{ Form::model($course, ['action' => ['CoursesController@store'], 'id' =>'create-form'])}}
    <tr><td>Category</td><td>{{ Form::select('course_category_id', $categories) }}</td></tr>    
    <tr><td>Difficulty</td><td>{{ Form::select('course_difficulty_id', $difficulties) }}</td></tr>    
    <tr><td>Name</td><td>{{ Form::text( 'name', null, ['class' => 'has-slug', 'data-slug-target' => '#slug' ]) }}</td></tr>
    <tr><td>Preview Image</td>
        <td>{{  Form::file('preview_image') }}</td></tr>
    <tr><td>Slug</td><td>{{ url('courses/') }}/ {{ Form::text( 'slug', null, ['id'=>'slug'] ) }}</td></tr>
    <tr><td>Description</td><td>{{ Form::textarea('description') }}</td></tr>    
    <tr><td>Price</td><td>{{ Form::text('price') }}</td></tr>    
    <tr><td colspan="2">{{ Form::submit( trans('crud/labels.update'), ['class' => 'btn btn-default'] ) }}</td></tr>
    {{ Form::close() }}
</table>
@stop