@extends('layouts.default')

@section('content')

    @if($student->courses()->count() == 0 )
        <h1>You have no courses.</h1>
    @else
        <h1>Here are your courses:</h1>
        @foreach($student->courses() as $course)
        <p>
            <span class="label label-info">{{$course->courseCategory->name}} >
            {{$course->courseSubcategory->name}}</span>
            {{$course->name}} - <a href='{{ action("ClassroomController@dashboard", $course->slug )}}'>Go To Dashboard</a></p>
        @endforeach
    @endif
   
@stop