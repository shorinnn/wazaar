@extends('layouts.default')

@section('content')
<style>
    .replies:not(:empty){
        border:1px solid silver;
        width:80%;
    }
</style>

    <section class="classroom-content container">
    {{ View::make('courses.classroom.conversations.all')->withComments( [$comment] ) }}

    {{ View::make('courses.classroom.conversations.all')->withComments( $comment->replies ) }}
    </div>
@stop