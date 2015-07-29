@extends('layouts.default')
        
@section('content')
    <div class="container-fluid classroom-view">
        {{ View::make('courses.classroom.lesson-ajax')->with( compact('course', 'lesson', 'video', 'nextLesson', 'prevLesson', 'currentLesson',
                        'instructor', 'student') ) }}
    </div>

@stop

@section('extra_js')
<script>
    $(function(){
        $('#myVideo').off('timeupdate');
        $('#myVideo').on('timeupdate', function(e){
            localStorage.setItem('vid-progress-{{$lesson->module->course->slug}}-{{$lesson->module->slug}}-{{$lesson->slug}}', 
            $('#myVideo')[0].currentTime );
        });
//        if( localStorage.getItem('vid-progress-{{$lesson->module->course->slug}}-{{$lesson->module->slug}}-{{$lesson->slug}}') != 'undefined' ){
//            $('#myVideo')[0].currentTime =  localStorage.getItem('vid-progress-{{$lesson->module->course->slug}}-{{$lesson->module->slug}}-{{$lesson->slug}}');
//        };
    });

</script>
@stop