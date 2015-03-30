@extends('layouts.default')

@section('page_title')
    {{ trans('courses/general.my-courses') }} - 
@stop

@section('content')

    @if($student->courses()->count() == 0 )
        <h1>{{ trans('courses/general.you-have-no-courses') }}</h1>
    @else
        <h1>{{ trans('courses/general.my-courses') }}:</h1>
        @foreach($student->courses() as $course)
        <p>
            <span class="label label-info">{{ $course->courseCategory->name }} >
            {{ $course->courseSubcategory->name }}</span>
            {{ $course->name }} - <a href='{{ action("ClassroomController@dashboard", $course->slug ) }}'>
            {{ trans('courses/general.go-to-dashboard') }}</a></p>
        @endforeach
    @endif
   
@stop