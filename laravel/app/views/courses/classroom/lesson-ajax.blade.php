<script>
    var videoHash = '{{$lesson->module->course->slug}}-{{$lesson->module->slug}}-{{$lesson->slug}}';
    var lessonId = {{ $lesson->id }};
    var currentLocation = '{{ action('ClassroomController@lesson', 
                                            [ $lesson->module->course->slug,
                                            $lesson->module->slug,
                                            $lesson->slug] )}}';

</script>
<style>
            .small-overlay{
                position:fixed;
                top: 50%;
                left: 50%;
            }
            header, footer{
                display: none;
            }
            
            .classroom-view .right-slide-menu{
                    width: 500px;
                    height: 100%;
                    position: absolute;
                    top: 0;
                    right: -600px;
                    z-index: 8;
                    background: #fff;
                    -webkit-transition: all 0.5s;
                    -moz-transition: all 0.5s;
                    transition: all 0.5s;
            }
			
			.discussion-sidebar,
			.classroom-view .right-slide-menu > div{
				height: 100%;
			}
			
            .classroom-view .right-slide-menu.in{
                    right: 0;
            }
            
            .classroom-view::-webkit-scrollbar {
             display: none;
            }
			.video-quality-wrap{
				float: left;
				padding-top: 3px;
			}
			
			.video-quality-wrap .dropdown-menu > li > a:hover,
			.video-quality-wrap .dropdown-menu > li > a,
			.video-quality-wrap .dropdown-toggle:hover,
			.video-quality-wrap .dropdown-toggle{
				font-weight: normal;
				font-size: 10px !important;
				color: #a7b5c2;
				box-shadow: none !important;
				background: none;
				cursor: pointer;
			}

			.video-quality-wrap .dropdown-menu > li > a:hover{
				color: #fff;
			}
			
			.video-quality-wrap .dropdown-menu > li > a b,
			.video-quality-wrap .dropdown-toggle b{
				font-size: 12px;
				font-weight: bold;
			}
			
			.video-quality-wrap .dropdown-menu{
				bottom: 120%;
				left: -40px;
				box-shadow: none;
				border: none;
				min-width: 130px;
				padding: 0 0 9px !important;
				background: #242d36;
			}
			
			.video-quality-wrap .dropdown-menu > li > a{
				padding: 15px 20px 6px;
			}
			
			.video-quality-wrap .dropdown-menu > li > a{
				text-align: left;
			}
			
			.video-quality-wrap .fa.fa-caret-down {
				bottom: -13px;
				color: #242d36;
				font-size: 21px;
				left: 60px;
				position: absolute;
				z-index: 1;
			}											
			.video-quality-wrap .dropdown-toggle{
				padding: 6px 0;
			}
        </style>
        
            <div class="right-slide-menu"></div>
        <div class="row">
            
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 slide-to-left">
                <div class="classroom-header row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <span class="left-menu slide-menu-toggler">
                            <i class="wa-hamburger"></i>
                        </span>
                        <a href="3" class="logo">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive">
                        </a>
                        <h4 class="lesson-title">
                            {{ $lesson->module->order }}.{{ $lesson->order }}. 
                            {{ $lesson->name }}</h4>
                        <div class="navigate-lessons-buttons">
                            @if( $prevLesson != null )
                                <a href="{{ action('ClassroomController@lesson', 
                                            [ $prevLesson->module->course->slug,
                                            $prevLesson->module->slug,
                                            $prevLesson->slug] )}}#{{$prevLesson->slug}}"
                                    data-indicator-style='small'
                                    data-url="{{ action('ClassroomController@lesson', 
                                    [ $prevLesson->module->course->slug,
                                    $prevLesson->module->slug,
                                    $prevLesson->slug] )}}#{{$prevLesson->slug}}" class="prev-button load-remote"  data-target='.classroom-view'><i class="wa-chevron-left"> {{ $prevLesson->name }}</i></a>
                            @endif
                            @if( $nextLesson != null )
                                <a href="{{ action('ClassroomController@lesson', 
                                            [ $nextLesson->module->course->slug,
                                            $nextLesson->module->slug,
                                            $nextLesson->slug] )}}#{{$nextLesson->slug}}" 
                                    data-indicator-style='small'
                                    data-url="{{ action('ClassroomController@lesson', 
                                    [ $nextLesson->module->course->slug,
                                    $nextLesson->module->slug,
                                    $nextLesson->slug] )}}#{{$nextLesson->slug}}" class="next-button load-remote" data-target='.classroom-view'>{{ $nextLesson->name }} <i class="wa-chevron-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="video-player video-container classroom-video" style="background:none; text-align: right">
                            
                                @if( $video != null)
                                    <video id="myVideo" preload="auto">
                                        @if( Agent::isMobile() &&  $video->formats()->where('resolution', 'Low Resolution')
                                                    ->first() != null)
                                            <source src="{{ $video->formats()->where('resolution', 'Low Resolution')
                                                    ->first()->video_url }}" type="video/mp4">
                                        @elseif($video->formats()->where('resolution', 'Custom Preset for Desktop Devices')
                                                            ->first() != null)
                                            <source src="{{ $video->formats()->where('resolution', 'Custom Preset for Desktop Devices')
                                                            ->first()->video_url }}" type="video/mp4">
                                        @else
                                        @endif
                                        <p>Your browser does not support the video tag.</p>
                                    </video>
                                @else
                                    @if($lesson->external_video_url != '')
                                        <div class="videoContainer">
                                            {{ externalVideoPreview($lesson->external_video_url, true, true) }}
                                        </div>
                                    @endif
                                @endif
                                <div class="control-container clearfix">
                                    <div class="control">

                                        <div class="btmControl clearfix">
                                            <div class="btnPlay btn" title="Play/Pause video">
                                                <i class="wa-play"></i>
                                                <i class="wa-pause"></i>
                                            </div>
                                            <div class="time hidden-xs">
                                                <span class="current"></span>
                                            </div>
                                            <div class="topControl">
                                                <div class="progress">
                                                    <span class="bufferBar"></span>
                                                    <span class="timeBar"></span>
                                                </div>
<!--                                                <div class="add-video-note">
                                                    <span class="note-number">11</span>
                                                    <form>
                                                        <input type="text" placeholder=" Add note ...">
                                                    </form>
                                                </div>-->
                                            </div>
                                            <div class="volume-container">
                                                <div class="volume" title="Set volume">
                                                        <span class="volumeBar">
                                                            <em></em>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="time hidden-xs">
                                                <span class="duration"></span>
                                            </div>
                                             @if($video != null)
                                            <div class="btn-group dropup video-quality-wrap">
                                                <a class="btn dropdown-toggle" data-toggle="dropdown" style="font-size: 12px;" aria-expanded="false">
                                                    <b style="" class='quality-label'>
                                                        @if(  Agent::isMobile() )
                                                            SD
                                                        @else
                                                            HD
                                                        @endif
                                                    </b>
                                                </a>
                                                <ul class="dropdown-menu">
                                                      @foreach($video->formats()->get() as $format)
                                                        <?php
                                                            if( strpos($format->resolution, 'Mobile') !== false ) $label = 'SD';
                                                            else $label = 'HD';
                                                        ?>
                                                        
                                                      <li onclick='setQuality(this)' class="dropdown-submenu" data-label='{{$label}}' data-quality='{{ $format->video_url }}'><a><b>{{$label}}</b></a></li>
                                                    @endforeach
                                                      <i class="fa fa-caret-down"> </i>
                                                </ul>
                                                
                                            </div>
                                            @endif
                                            
                                            <div class="btnFS btn" title="Switch to full screen"><i class="wa-expand"></i></div>
                                            <div class="sound sound2 btn hidden-xs" title="Mute/Unmute sound">
                                                <i class="wa-sound"></i>
                                                <i class="fa fa-volume-off"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="loading"></div>
                            
                            <!--<div id="lesson-video-overlay">
                                <div>
                                </div>
                            </div>-->
                            <span class="play-intro-button"><i class="wa-play"></i><em>{{ trans("courses/general.play-intro") }}</em></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="overflow:hidden;">
                @if( count($lesson->attachments()) > 0)
                    <div class="course-material">
                            <div class="course-material-header expandable-button show-more" data-more-text="Show course materials" data-less-text="Hide course materials">
                            Show course materials <i class="wa-chevron-down"></i>
                        </div>
                        <div class="materials expandable-content ">
                            <ul class="clearfix">
                                @foreach($lesson->blocks as $block)
                                    @if($block->type == 'file')
                                        <li>
                                            <a href="{{ action('ClassroomController@resource', PseudoCrypt::hash($block->id) ) }}" target="_blank">
                                                @if( strpos( $block->mime, 'image')!== false )
                                                    <i class="fa fa-file-image-o"></i> 
                                                @elseif( strpos( $block->mime, 'pdf' ) !== false )
                                                    <i class="fa fa-file-pdf-o"></i> 
                                                @else
                                                    <i class='fa fa-file-text'></i>
                                                @endif
                                                {{ $block->name }}  
                                                <span class="size">{{ $block->size() }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <!--<a href="#" class="download-material large-button">Download all (.zip) - <span class="size">2MB</span></a>-->
                        </div>
                    </div>
                @endif
                <div class="questions-sidebar">
                    <div class="header clearfix">
                        <a href="#" class="questions-tab-header active">{{ $lesson->discussions()->count() }} Questions</a>
                        
                        <!--<a href="#" class="notes-tab-header">10 Notes</a>-->
                    </div>
                    <div class="tab-contents clear">
                        <div class="rows search-discussion-form">
                            <form>
                                <div>
                                    <input id='question-search-box' type="search" onkeyup="searchDiscussions()" placeholder="Search discussion ...">
                                    <button><i class="wa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class='question-holder'>
                            @foreach($lesson->discussions()->where( 'student_id', Auth::user()->id )->get() as $discussion)
                                {{ View::make('courses.classroom.discussions.question')->with( compact('discussion') ) }}
                            @endforeach
                            @foreach($lesson->discussions()->where( 'student_id', '!=', Auth::user()->id )->orderBy('upvotes','desc')->get() as $discussion)
                                {{ View::make('courses.classroom.discussions.question')->with( compact('discussion') ) }}
                            @endforeach
                        </div>
                        
                        <div class="ask-question">
                            <div class="img-container">
                                <img src="{{Auth::user()->commentPicture('student')}}" alt="" class="img-responsive">
                            </div>
                            <span onclick="showLessonQuestionForm()">Ask a question</span>
                            <div style="display:none" id="question-form">
                                {{ View::make('courses.classroom.discussions.form')->with( compact('lesson') ) }}
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
                
        </div>
        <div class="slide-menu">
            <div class="header">
                <div class="clearfix">
                    <a href="#" class="course"><i class="wa-chevron-left"></i>Course</a>
                    <span class="toggler slide-menu-toggler"><i class="wa-hamburger-close"></i></span>
                </div>
                <h2 class="clear">{{$course->name}}</h2>
                <div class="progress-box">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {{ $student->courseProgress($course)  }}%;">
                            <span></span>
                        </div>
                    </div>
                    <span class="progress-count">{{ $student->courseProgress($course)  }}%</span>
                </div>
            </div>

            @foreach($course->modules as $index => $module)
                <div class="course-topics-box">
                    <div class="topic-header clearfix">
                        <h3 class="left"><em>{{$index+1}}. </em> {{$module->name}}</h3>
                        <span class="right">{{$module->completedLessons()}} / {{ $module->lessons->count() }}</span>
                    </div>
                    <div class="topics">
                        <ul>
                            @foreach($module->lessons as $lesson)
                                @if( $student->purchased($course) || $student->purchased( $lesson ) )
                                    <li class="@if( $student->isLessonCompleted($lesson) ) 
                                            completed 
                                        @elseif( $student->isLessonViewed($lesson) )
                                            active
                                        @endif">
                                        <a href="{{ action('ClassroomController@lesson', 
                                            [ $lesson->module->course->slug,
                                            $lesson->module->slug,
                                            $lesson->slug]) }}">{{$lesson->name}}<span><em></em><i class="wa-check"></i></span></a>
                                    </li>
                                @endif
                            @endforeach

                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
        
       
            
            
<script>
    if(typeof($)=='function'){
        skinVideoControls();
        showMoreContent();
        $('#myVideo').on('timeupdate', function(e){
            localStorage.setItem('vid-progress-'+videoHash, 
            $('#myVideo')[0].currentTime );
        });
        if( localStorage.getItem('vid-progress-{{$lesson->module->course->slug}}-{{$lesson->module->slug}}-{{$lesson->slug}}') != 'undefined' ){
            $('#myVideo')[0].currentTime =  localStorage.getItem('vid-progress-'+videoHash);
        };
        
        
        $('#myVideo').on('ended', function(e){
            lessonComplete( lessonId );
        });
		
		/*var askQuestionHeight = $('.ask-question').height();
		var tabContents = $('.questions-sidebar .tab-contents').height();
		var newQuestionHolderHeight = tabContents - askQuestionHeight;
		$('.question-holder').height(newQuestionHolderHeight);
		console.log(newQuestionHolderHeight);*/		


    }
    
    function setVideoFormat(){
        ct = $('#myVideo')[0].currentTime;
        console.log( 'set format!');
        url = $('#vid-quality').val();
        $('#myVideo').attr('src', url);
        $('#myVideo source').attr('src', url);
        //skinVideoControls();
        $('#myVideo')[0].currentTime = ct;
    }
    
    function setQuality(elem){
        ct = $('#myVideo')[0].currentTime;
        console.log( 'set format!');
        url = $(elem).attr('data-quality');
        $('#myVideo').attr('src', url);
        $('#myVideo source').attr('src', url);
        //skinVideoControls();
        $('#myVideo')[0].currentTime = ct;
        $('.quality-label').html( $(elem).attr('data-label') );
    }
    
    function lessonComplete(lesson){
        localStorage.setItem( 'vid-progress-'+videoHash, 0 );
        $.get( COCORIUM_APP_PATH+'classroom/complete-lesson/'+lesson );
    }
    
    
    window.onpopstate =  function(e){
        console.log('e state:');
        console.log(e.state);
        if(e.state==null) return;
        window.onpopstate = null;
        window.location.href = window.location.href ;
        window.location.reload();
//        console.log( window.location );
//        console.log('hash chanaged');
    }
</script>
           