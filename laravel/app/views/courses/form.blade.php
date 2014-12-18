@extends('layouts.default')
@section('content')

@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if (Session::get('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
<a href='{{action("CoursesController@myCourses")}}'>All My Courses</a>
<table class="table">
    @if($course->id > 0)
    {{ Form::model($course, ['action' => ['CoursesController@update', $course->slug], 'id' =>'create-form', 'files' => true, 'method' => 'PUT'])}}
    @else
    {{ Form::model($course, ['action' => ['CoursesController@store'], 'id' =>'create-form', 'files' => true])}}
    @endif
    <tr><td>Privacy Status</td><td>{{ Form::select('privacy_status', [ 'private' => 'Private', 'public' => 'Public']) }}</td></tr>    
    <tr><td>Category</td><td>{{ Form::select('course_category_id', $categories) }}</td></tr>    
    <tr><td>Sub Category</td><td>{{ Form::select('course_subcategory_id', $subcategories) }}</td></tr>    
    <tr><td>Difficulty</td><td>{{ Form::select('course_difficulty_id', $difficulties) }}</td></tr>    
    <tr><td>Name</td><td>{{ Form::text( 'name', null, ['class' => 'has-slug', 'data-slug-target' => '#slug' ]) }}</td></tr>
    <tr><td>Slug</td><td>{{ url('courses/') }}/{{ Form::text( 'slug', null, ['id'=>'slug'] ) }}</td></tr>
    <tr><td>Preview Image</td>
        <td>{{  Form::file('preview_image') }}
            @if($images->count() > 0)
            Or Use existing:<br />
                @foreach($images as $img)
                    <div class="col-lg-3">
                        {{ Form::radio('course_preview_image_id', $img->id, null, ['id' => "img-$img->id"] ) }}
                        <label for="img-{{$img->id}}">
                            <img src="{{$img->url}}" height="100" />
                        </label>
                    </div>
                @endforeach
            @endif
        
        </td></tr>
    <tr><td>Details Page Banner Image</td>
        <td>{{  Form::file('banner_image') }}
            @if($bannerImages->count() > 0)
            Or Use existing:<br />
                @foreach($bannerImages as $img)
                    <div class="col-lg-3">
                        {{ Form::radio('course_banner_image_id', $img->id, null, ['id' => "img-$img->id"] ) }}
                        <label for="img-{{$img->id}}">
                            <img src="{{$img->url}}" height="100" />
                        </label>
                    </div>
                @endforeach
            @endif
        
        </td></tr>
    
    <tr><td>Who Is This For</td>
        <td>
            @if($values = json2Array($course->who_is_this_for))
                @foreach($values as $val)
                    <input type='text' name='who_is_this_for[]' value='{{$val}}' /><br />
                @endforeach
            @endif

            <input type='text' name='who_is_this_for[]' />
        </td></tr>    
    <tr><td>What you will achieve at the end of the course</td>
        <td>
            @if($values = json2Array($course->what_will_you_achieve))
                @foreach($values as $val)
                    <input type='text' name='what_will_you_achieve[]' value='{{$val}}' /><br />
                @endforeach
            @endif
            <input type='text' name='what_will_you_achieve[]' />
        </td></tr>    
    <tr><td>Description</td><td>{{ Form::textarea('description') }}</td></tr>    
    <tr><td>Price</td><td>{{ Form::text('price') }}</td></tr>    
    <tr><td colspan="2">{{ Form::submit( trans('crud/labels.update'), ['class' => 'btn btn-default'] ) }}</td></tr>
    {{ Form::close() }}
</table>
@stop