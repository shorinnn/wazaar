@extends('layouts.default')

@section('content')
    <h1>{{ $course->name }}</h1>
    <h2>{{ $course->description }}</h2>
    
    <h3>Curriculum</h3>
    @foreach($course->modules()->orderBy('order','ASC')->get() as $module)
        <h4> {{$module->name}} </h4>
        @foreach($module->lessons()->orderBy('order','ASC')->get() as $lesson)
        <h5> <a href='{{ action( 'ClassroomController@lesson', [ 'course' => $course->slug, 'lesson' => $lesson->slug ] ) }}'>{{ $lesson->name }}</a></h5>
        @endforeach
    @endforeach
   
@stop