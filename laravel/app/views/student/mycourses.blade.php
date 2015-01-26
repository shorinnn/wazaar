@extends('layouts.default')

@section('content')


    @if($purchases->count() == 0)
        <h1>You have no courses.</h1>
    @else
        <h1>Here are your courses:</h1>
        @foreach($purchases as $purchase)
        <p>
            <span class="label label-info">{{$purchase->course->courseCategory->name}} >
            {{$purchase->course->courseSubcategory->name}}</span>
            {{$purchase->course->name}} - <a href='{{ action("ClassroomController@dashboard", $purchase->course->slug )}}'>Go To Dashboard</a></p>
        @endforeach
    @endif
   
@stop