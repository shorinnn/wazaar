@extends('layouts.default')

@section('content')
<style>
    .replies:not(:empty){
        border:1px solid silver;
        width:80%;
    }
</style>
<a href="{{ action('ClassroomController@lesson', [ $course->slug, $lesson->slug ]) }}">Back To Lesson</a>
    <h2>"{{$course->name}} - {{ $lesson->name }}" Conversations:</h2>
    <section class="classroom-content container">
    @if( Auth::check() )
        @if(isset($replyto))
                Reply to: 
                <blockquote>{{$comment->content}}</blockquote>
            {{ View::make('courses.classroom.conversations.form')->with( compact('lesson') )->withReplyto($replyto) }}
        @else
            {{ View::make('courses.classroom.conversations.form')->with( compact('lesson') ) }}
        @endif
    @endif

    {{ View::make('courses.classroom.conversations.all')->withComments( $lesson->comments ) }}
    {{ $lesson->comments->links() }}
    </div>
@stop