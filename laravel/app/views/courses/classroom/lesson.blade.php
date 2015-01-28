@extends('layouts.default')

@section('content')
<style>
    .replies:not(:empty){
        border:1px solid silver;
        width:80%;
    }
</style>
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
   
    <h2>Conversations:</h2>
    <section class="classroom-content container">
    @if( Auth::check() )
        {{ View::make('courses.classroom.conversations.form')->with( compact('lesson') ) }}
    @endif
    
    <a href='{{ action('ConversationsController@lesson', [$lesson->module->course->slug, $lesson->slug] )}}' class="load-more-comments load-more-ajaxx" 
       data-url='{{action('ConversationsController@loadMore')}}' 
       data-target='.users-comments' data-skip='2' data-lesson='{{$lesson->id}}'>LOAD MORE</a>
    {{ View::make('courses.classroom.conversations.all')->withComments( $lesson->comments ) }}
    </div>
@stop