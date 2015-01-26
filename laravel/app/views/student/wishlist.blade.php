@extends('layouts.default')

@section('content')


    @if($wishlist->count() == 0)
        <h1>You have no items on your wishlist.</h1>
    @else
        <h1>Your wishlist:</h1>
        @foreach($wishlist as $course)
        <p> <a href='{{action( 'CoursesController@show', $course->slug )}}'>{{ $course->name }}</a> - ¥{{ number_format($course->cost(), Config::get('custom.currency_decimals')) }}</p>
        @endforeach
    @endif
   
@stop