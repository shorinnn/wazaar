@extends('layouts.default')
@section('content')
        <div class="classrooms-wrapper clearfix">            
            {{ View::make('private_messages.partials.all_inbox')->withComments( $messages )->with( compact('id') ) }}
        </div>
@stop

