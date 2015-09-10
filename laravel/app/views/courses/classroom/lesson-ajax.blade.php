<script>
    var videoHash = '{{$lesson->module->course->slug}}-{{$lesson->module->slug}}-{{$lesson->slug}}';
    var lessonId = {{ $lesson->id }};
    var currentLocation = '{{ action('ClassroomController@lesson', 
                                            [ $lesson->module->course->slug,
                                            $lesson->module->slug,
                                            $lesson->slug] )}}';

</script>
<style>
    span.link-to-remote, .discussion-votes{
        /*color:#428BCA;*/
		color: #697480;
		font-style: normal;
    }
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
                    position: fixed;
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
				float: right;
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
			.slide-to-left.in .navigate-lessons-buttons,
			.slide-to-left.in .control-container {
			  display: none;
			}
			.full-height{
				height: 100%;
			}
			.slide-to-left.in .video-row{
				margin-top: 25%;
			}
			.classroom-content-row h3{
				margin: 0 0 30px;
				color: #fff;
			}
			.classroom-content-row p{
				color: #798794;
				margin: 0 0 25px;
			}
			.classroom-view .classroom-header {
			  position: fixed;
			  z-index: 6;
			  width: 76%;
			  padding-bottom: 10px;
			  background-color: #18222b;
			}			
			.video-row {
			  margin-top: 106px;
			}
			.hiddendiv {
				display: none;
				white-space: pre-wrap;
				width: 100%;
				min-height: 42px;
				max-height: 490px;
				font-size: 13px;
				color: #798794;
				padding: 5px;
				word-wrap: break-word;
			}
			.slide-to-left{
				overflow: auto;
			}
			.classroom-content-row{
				padding-top: 50px;
			}
        </style>
        
            <div class="right-slide-menu"></div>
        <div class="row full-height">
            
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 slide-to-left full-height scroll-pane classroom-main">
                <div class="classroom-header row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @if( !$crashLesson)
                        <span class="left-menu slide-menu-toggler">
                            <i class="wa-hamburger"></i>
                        </span>
                        @endif
                      
                        <a href="{{action('SiteController@index') }}" class="logo">
                            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/logo/main-logo.png" class="img-responsive">
                        </a>
                        <h4 class="lesson-title">
                            {{ $lesson->module->order }}.{{ $lesson->order }}. 
                            {{ $lesson->name }}</h4>
                        <div class="navigate-lessons-buttons">
                            @if( $prevLesson != null && $crashLesson==false )
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
                            @if( $nextLesson != null  && $crashLesson==false )
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
                <div class="row video-row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @if( $video != null)
                            <video controls preload="auto" style="width: 100%">
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
                    </div>
                </div>
                @if( trim($lesson->notes) != '')
                    <div class="row classroom-content-row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h3>{{ trans('courses/dashboard.lesson-content') }}</h3>
                            <p class="regular-paragraph">{{ $lesson->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 course-question-sidebar no-padding"
                 @if($crashLesson)
                 style='opacity:0.8; pointer-events:none'
                 @endif
                 >
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
                                            <a href="{{ action('ClassroomController@resource', PseudoCrypt::hash($block->id) ) }}" target="_blank" data-toggle="tooltip" title="{{ $block->name }}">
                                                @if( strpos( $block->mime, 'image')!== false )
                                                    <i class="fa fa-file-image-o pull-left"></i> 
                                                @elseif( strpos( $block->mime, 'pdf' ) !== false )
                                                    <i class="fa fa-file-pdf-o pull-left"></i> 
                                                @else
                                                    <i class='fa fa-file-text pull-left'></i>
                                                @endif
                                                <span class="course-material-name pull-left">{{ $block->name }}</span>
                                                <span class="size pull-right">{{ $block->size() }}</span>
                                                <div class="clearfix"></div>
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
                        <a href="#" class="questions-tab-header active">{{ $lesson->discussions()->count() }} {{ trans('courses/dashboard.questions') }}</a>
                        
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
                        <div class='question-holder scroll-pane'>
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
                            <span onclick="showLessonQuestionForm()">{{ trans('courses/dashboard.ask-question') }}</span>
                            <div style="display:none" id="question-form">
                                {{ View::make('courses.classroom.discussions.form')->with( compact('lesson') ) }}
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
                
        </div>
        <div class="slide-menu scroll-pane @if($crashLesson) hide @endif">
            <div class="header">
                <div class="clearfix">
                    <a href="{{action('ClassroomController@dashboard', $lesson->module->course->slug)}}" class="course"><i class="wa-chevron-left"></i>ダッシュボード</a>
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
                            <?php $thisLesson = $lesson; ?>
                            @foreach($module->lessons as $lesson)
                                @if( $student->purchased($course) || $student->purchased( $lesson ) )
                                    <li class="@if( $student->isLessonCompleted($lesson) ) 
                                            completed 
                                        @elseif( $lesson->id == $thisLesson->id ) )
                                            active
                                        @else
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
        makeYTfluid();
        skinVideoControls();
        showMoreContent();
        if( $('myVideo').length > 0 ){
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
        }
		
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
           