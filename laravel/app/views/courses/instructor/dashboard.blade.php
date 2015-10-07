@extends('layouts.default')
@section('content')
    {{ View::make('courses/instructor/discussions')->with(compact('course', 'discussions') ) }}
@stop
