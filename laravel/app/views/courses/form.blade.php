@extends('layouts.default')
@section('content')

@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if (Session::get('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
<a href='{{action("CoursesController@myCourses")}}' class="all-my-courses btn btn-primary">All My Courses</a>
<div class="table-responsive">
    <table class="table create-table table-striped table-bordered">
        @if($course->id > 0)
        {{ Form::model($course, ['action' => ['CoursesController@update', $course->slug], 'id' =>'create-form', 'files' => true, 'method' => 'PUT'])}}
        @else
        {{ Form::model($course, ['action' => ['CoursesController@store'], 'id' =>'create-form', 'files' => true])}}
        @endif
        <tr><td>Privacy Status</td><td><span class="custom-dropdown">{{ Form::select('privacy_status', [ 'private' => 'Private', 'public' => 'Public']) }}</span></td></tr>    
        <tr><td>Category</td><td><span class="custom-dropdown">{{ Form::select('course_category_id', $categories) }}</span></td></tr>    
        <tr><td>Sub Category</td><td><span class="custom-dropdown">{{ Form::select('course_subcategory_id', $subcategories) }}</span></td></tr>    
        <tr><td>Difficulty</td><td><span class="custom-dropdown">{{ Form::select('course_difficulty_id', $difficulties) }}</span></td></tr>    
        <tr><td>Name</td><td>{{ Form::text( 'name', null, ['class' => 'has-slug', 'data-slug-target' => '#slug' ]) }}</td></tr>
        <tr><td>Slug</td><td><span class="slug-path">{{ url('courses/') }}/</span>{{ Form::text( 'slug', null, ['id'=>'slug'] ) }}</td></tr>
        <tr><td>Preview Image</td>
            <td><label for="upload-preview-image">
                    <div class="upload-file-button">Upload Your File</div>
                </label>
                {{  Form::file('preview_image', ['id' => "upload-preview-image"]) }}
                @if($images->count() > 0)
                <span class="use-existing">Or Use existing:<br /></span>
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
            <td><label for="upload-banner-image">
                    <div class="upload-file-button">Upload Your File</div>
                </label>
            {{  Form::file('banner_image', ['id' => "upload-banner-image"]) }}
                @if($bannerImages->count() > 0)
                <span class="use-existing">Or Use existing:<br /></span>
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
        <tr><td>Description</td><td><div class="description-box">{{ Form::textarea('description') }}</div></td></tr>    
        <tr><td>Price</td><td>{{ Form::text('price') }}</td></tr>    
        <tr><td>Affiliate Percentage</td><td><div class="custom-dropdown affiliate-percentage">{{ Form::select('affiliate_percentage', range(0,70)) }}</div>%</td></tr>    
        <tr><td>Discount</td>
            <td>
                {{ Form::text('sale') }}
                <div class="custom-dropdown discount">{{ Form::select('sale_kind', ['amount' => '$', 'percentage' => '%'] ) }}</div>
            </td></tr>    
        <tr><td>Sale Ends On</td><td>{{ Form::text('sale_ends_on') }}</td></tr>    
        <tr><td colspan="2">{{ Form::submit( trans('crud/labels.update'), ['class' => 'btn btn-primary'] ) }}</td></tr>
        {{ Form::close() }}
    </table>
</div>
@stop