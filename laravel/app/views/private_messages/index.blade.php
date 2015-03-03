@extends('layouts.default')
@section('content')
<style>
    .bolded > *{
        font-weight: bold !important;
    }
</style>
        <div class="classrooms-wrapper clearfix">
            <section class="classroom-content container">
                <div class='ajax-content fa-animated'>
                    {{ View::make('private_messages.partials.inbox_list')->with( compact('messages') ) }}
                </div>
            </section>
        </div>
@stop

