@extends('layouts.default')
        
@section('content')
    <div class="container-fluid classroom-view" style="overflow-x:hidden;">

        {{ View::make('courses.classroom.lesson-ajax')->with( compact('course', 'lesson', 'video', 'nextLesson', 'prevLesson', 'currentLesson',
                        'instructor', 'student') ) }}
    </div>

@stop

@section('extra_js')
<script>
    var videoHash = '{{$lesson->module->course->slug}}-{{$lesson->module->slug}}-{{$lesson->slug}}';	
    $(function(){
        $('#myVideo').on('timeupdate', function(e){
            localStorage.setItem('vid-progress-'+videoHash, 
            $('#myVideo')[0].currentTime );
        });
        if( localStorage.getItem('vid-progress-{{$lesson->module->course->slug}}-{{$lesson->module->slug}}-{{$lesson->slug}}') != 'undefined' ){
            $('#myVideo')[0].currentTime =  localStorage.getItem('vid-progress-'+videoHash);
        };
        
        var lessonId = {{ $lesson->id }};
        $('#myVideo').on('ended', function(e){
            lessonComplete( lessonId );
        });
    });
</script>
@stop