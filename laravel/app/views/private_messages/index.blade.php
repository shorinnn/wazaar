@extends('layouts.default')
@section('content')
<style>
    .bolded > *{
        font-weight: bold !important;
    }
</style>
        <div class="classrooms-wrapper clearfix">
            @if( Input::has('send-to') )
                <section class="classroom-content container">
                     <div>
                         {{ View::make('private_messages.partials.student_form')->withRecipient( Input::get('send-to') )->withNew(1) }}
                     </div>
                    <br />
                </section>
            @endif
            <section class="classroom-content container">
                <div class='ajax-content fa-animated'>
                    {{ View::make('private_messages.partials.inbox_list')->with( compact('messages') ) }}
                </div>
            </section>
        </div>
@stop

