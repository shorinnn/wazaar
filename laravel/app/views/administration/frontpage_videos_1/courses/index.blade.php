@extends('layouts.default')
@section('content')	

{{ Form::open([ 'action' => ['FrontpageController@doFeaturedCourses'], 'class'=>'ajax-form',  'data-callback'=>'formSaved' ] ) }}
<center><button type='submit' class='button blue-button large-button'>{{ trans('crud/labels.update') }}</button></center>
<table class="table table-striped table-bordered" style='width: 50%; margin-left:auto; margin-right: auto' id='grid-table'>
@foreach($featured as $course)
<tr class='course-{{$course->id}}'>
    <td>
        {{ $course->name }} <input type='hidden' name='featured[]' value='{{ $course->id }}' />
    </td>
    <td>
        <button type='button' data-delete='.course-{{$course->id}}' class='btn btn-danger btn-sm' onclick='deleteItem(null, event)' ><i class="fa fa-trash-o"></i></button>
    </td>
</tr>
@endforeach
<tr id='addRow'>
    <td>
        <select id='allCourses'>
            @foreach($allCourses as $course)
                <option value='{{$course->id}}'>{{$course->name}}</option>
            @endforeach
        </select>
    </td>
    <td>
        <button type='button' class='btn btn-primary btn-sm' onclick='addFeatured()'><i class="fa fa-plus-square"></i></button>
    </td>
</tr>
</table>
<center><button type='submit' class='button blue-button large-button'>{{ trans('crud/labels.update') }}</button></center>
{{ Form::close() }}
@stop

@section('extra_js')
<script>
    function addFeatured(){
        courseID = $('#allCourses').val();
        if( $(".course-"+courseID).length >0 ){
            $(".course-"+courseID).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
            return false;
        }
        
        courseName = $('#allCourses option:selected').text();
        console.log(courseID + ' '+courseName);
        row = "<tr class='course-"+courseID+"'><td>"+courseName+" <input type='hidden' name='featured[]' value='"+courseID+"}' /></td><td>"
        + "<button type='button' data-delete='.course-"+courseID+"' class='btn btn-danger btn-sm' onclick='deleteItem(null, event)' >"
        + "<i class='fa fa-trash-o'></i></button></td></tr>";
        $('#addRow').before(row);
    }
</script>
@stop