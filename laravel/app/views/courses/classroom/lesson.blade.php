@extends('layouts.default')

@section('content')
    <h1>{{ $course->name }}</h1>
    <h2>{{ $lesson->name }}</h2>
    
    <h1>Video block right here after consulting Nigel</h1>
    
    @foreach($lesson->blocks as $block)
        @if($block->type=='text')
            {{ $block->content }}
        @endif
    @endforeach
    
    <h4>Files</h4>
    @foreach($lesson->blocks as $block)
        @if($block->type=='file')
            <p><a href='{{ $block->content }}' target='_blank'>{{ $block->name }}</a></p>
        @endif
    @endforeach
   
@stop