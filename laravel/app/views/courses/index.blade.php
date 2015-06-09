    @extends('layouts.default')
    @section('content')	
        {{ View::make('courses.courses_list')->with(compact('categories')) }}
    @stop