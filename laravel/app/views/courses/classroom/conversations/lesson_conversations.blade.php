@extends('layouts.default')

@section('content')
<style>
    .replies:not(:empty){
        border:1px solid silver;
        width:80%;
    }
</style>
    <h2>"{{$course->name}} - {{ $lesson->name }}" Conversations:</h2>
    <section class="classroom-content container">
    @if( Auth::check() )
        @if(isset($replyto))
            {{ View::make('courses.classroom.conversations.form')->with( compact('lesson') )->withReplyto($replyto) }}
        @else
            {{ View::make('courses.classroom.conversations.form')->with( compact('lesson') ) }}
        @endif
    @endif

    {{ View::make('courses.classroom.conversations.all')->withComments( $lesson->comments ) }}
    </div>
@stop