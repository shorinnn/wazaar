@extends('layouts.default')
        
@section('content')
	<style>
		html{
			background: #18222b;
		}
	</style>
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
	
$(document).ready(function(){
	resizeVideo();
	$('.scroll-pane').jScrollPane();
});

var rtime;
var timeout = false;
var delta = 200;
$(window).resize(function() {
    rtime = new Date();
    if (timeout === false) {
        timeout = true;
        setTimeout(resizeend, delta);
    }
});

function resizeend() {
    if (new Date() - rtime < delta) {
        setTimeout(resizeend, delta);
    } else {
        timeout = false;
        resizeVideo();
    }               
}

function resizeVideo(){
    $("#myVideo").removeAttr('style');
	var screenHeight = $(window).height();
	var screenWidth = $(window).width();
	var videoControlHeight = $(".control-container").height();
        
	screenHeight2 = screenHeight - videoControlHeight - 102;
	if( screenWidth/screenHeight2 <= 1.778 ) return;
	
	var classroomHeaderHeight = $(".classroom-header").height(); 


	$("#myVideo").innerHeight(screenHeight - videoControlHeight - 102);
 } 

</script>
@stop