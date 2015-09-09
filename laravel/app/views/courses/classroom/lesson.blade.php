@extends('layouts.default')
        
@section('content')
	<style>
		html{
			background: #18222b;
		}
	</style>
    <div class="container-fluid classroom-view" style="overflow-x:hidden;">

        @if( !Auth::user()->hasRole('Affiliate') )
            {{ View::make('courses.classroom.lesson-ajax')->with( compact('course', 'lesson', 'video', 'nextLesson', 'prevLesson', 'currentLesson',
                            'instructor', 'student', 'crashLesson') ) }}
        @else
            {{ View::make('courses.classroom.lesson-ajax-affiliates')->with( compact('course', 'lesson', 'video', 'nextLesson', 'prevLesson', 'currentLesson',
                            'instructor', 'student', 'crashLesson') ) }}
        @endif
    </div>

@stop

@section('extra_js')
<script>
	function add_scroll_class_if_have_scrollbar(){
		if($(document).height() > $(window).height()){
			$('.course-question-sidebar').addClass('hasScroll');
		} else {
			$('.course-question-sidebar').removeClass('hasScroll');
		}
	}
	
    var videoHash = '{{$lesson->module->course->slug}}-{{$lesson->module->slug}}-{{$lesson->slug}}';	
    $(function(){
        add_scroll_class_if_have_scrollbar();

        if( $('#myVideo').length > 0 ){
            $('#myVideo').on('timeupdate', function(e){
                localStorage.setItem('vid-progress-'+videoHash, 
                $('#myVideo')[0].currentTime );
            });
            if( localStorage.getItem('vid-progress-{{$lesson->module->course->slug}}-{{$lesson->module->slug}}-{{$lesson->slug}}') != 'undefined' ){
                $('#myVideo')[0].currentTime =  localStorage.getItem('vid-progress-'+videoHash);
            };
        }
        
        var lessonId = {{ $lesson->id }};
        $('#myVideo').on('ended', function(e){
            lessonComplete( lessonId );
        });

    });
	
	$(document).ready(function(){
		resizeVideo();
	});

	var rtime;
	var timeout = false;
	var delta = 200;
	$(window).resize(function() {
		add_scroll_class_if_have_scrollbar();
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


// By Chris Coyier & tweaked by Mathias Bynens

$(function() {
    makeYTfluid();
});

function makeYTfluid(){
    // Find all YouTube videos
	var $allVideos = $("iframe"),

	    // The element that is fluid width
	    $fluidEl = $(".videoContainer");

	// Figure out and save aspect ratio for each video
	$allVideos.each(function() {
            console.log('YT VID');
		$(this)
			.data('aspectRatio', this.height / this.width)

			// and remove the hard coded width/height
			.removeAttr('height')
			.removeAttr('width');

	});

	// When the window is resized
	// (You'll probably want to debounce this)
	$(window).resize(function() {
                setTimeout(function(){
                    var newWidth = $fluidEl.width();

                    // Resize all videos according to their own aspect ratio
                    $allVideos.each(function() {

                            var $el = $(this);
                            $el
                                    .width(newWidth)
                                    .height(newWidth * $el.data('aspectRatio'));

                    });
                }, 500);
		

	// Kick off one resize to fix all videos on page load
	}).resize();
}
</script>
@stop