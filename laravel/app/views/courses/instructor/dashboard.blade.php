@extends('layouts.default')
@section('content')
    {{ View::make('courses/instructor/discussions')->with(compact('course', 'discussions') ) }}
@stop

@section('extra_js')
<script>
    Messages = {
        opened : function (e){
            $(e.target).parent().find('a').removeClass('active');
            $(e.target).removeClass('unread');
            $(e.target).addClass('active');
        }
    };
</script>
@stop