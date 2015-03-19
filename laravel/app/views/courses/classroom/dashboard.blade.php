    @extends('layouts.default')
    
    @section('page_title')
        {{ $course->name }} Dashboard -
    @stop
    
    @section('content')	
    
        <div class="classrooms-wrapper">
        	<section class="video-container text-center">
               @if( $student->unreadAnnouncements->count() > 0)
                    <div class="top-notification-bar">
                        <span></span>You have {{ $student->unreadAnnouncements->count() }} announcements.
                    </div>
                @endif
                @if($student->unreadAnswers->count() > 0)
                    <div class="top-notification-bar">
                        <span></span>You have {{ $student->unreadAnswers->count() }} teacher responses.
                    </div>
                @endif
               
                @if($video && $video->video()!=null)
                    @if( Agent::isMobile() )
                    <video height=300 controls><source src="{{ $video->video()->formats()->where('resolution', 'Custom Preset for Mobile Devices')
                                    ->first()->video_url }}" type="video/mp4"></video>
                    @else
                    <div class="videoContainer">
                        <video id="myVideo" preload="auto" controls>
                            <source src="{{ $video->video()->formats()->where('resolution', 'Custom Preset for Desktop Devices')
                            ->first()->video_url }}" type="video/mp4">
                        	<p>Your browser does not support the video tag.</p>
                        </video> 
                        <div class="control-container">                       
                            <div class="topControl">
                                <div class="progress">
                                    <span class="bufferBar"></span>
                                    <span class="timeBar"></span>
                                </div>
                            </div>
                            <div class="control">
                                
                                <div class="btmControl clearfix">
                                    <div class="btnPlay btn" title="Play/Pause video"></div>
                                    <div class="sound sound2 btn" title="Mute/Unmute sound"></div>
                                    <div class="volume-container">
                                        <div class="volume" title="Set volume">
                                            <span class="volumeBar">
                                                <em></em>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="btnFS btn" title="Switch to full screen"></div>
                                    <div class="time">
                                        <span class="current"></span> / 
                                        <span class="duration"></span> 
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="loading"></div>
                    </div>
                    <span class="centered-play-button"></span>
                    @endif
                @endif
            </section>
            <section class="classroom-content container">
                
            	<div class="row">
                    <div class="col-md-12 additional-lesson-conntent">
                        <h3>Announcements</h3>
                        @foreach($student->announcements as $announcement)
                            <p class='alert alert-info
                               @if ($announcement->isUnread( $student->id ) )
                                   bolded
                               @endif
                               '>
                                <small class="pull-right"> {{$announcement->created_at->diffForHumans() }}</small>
                                {{ $announcement->content }}</p>
                            
                            {{ $announcement->markRead( Auth::user()->id ) }}
                        @endforeach
                    </div>
                </div>
            	<div class="row">
                	<div class="col-md-6">
                            
                    	<div class="additional-lesson-conntent">
                        	<h3>Additional lesson content</h3>
                            @if($nextLesson != false)
                                @if($nextLesson->blocks()->where('type','text')->first())
                                    <p> {{ 
                                            Str::limit( strip_tags( $nextLesson->blocks()->where('type','text')->first()->content), 100)
                                         }} 
                                    </p>
                                    <a href="{{ action( 'ClassroomController@lesson', 
                                            [ 'course' => $nextLesson->module->course->slug, 
                                              'module' => $nextLesson->module->slug, 
                                              'lesson' => $nextLesson->slug ] ) }}" class="read-more">READ MORE</a>
                                @endif
                            @endif
                        </div>
                    @if( $course->ask_teacher=='enabled')
                    	<div class="header blue clearfix">
                        	<h2>ASK<small>THE TEACHER</small></h2>
                            <div class="avater hidden-xs">
                            	<p class="quote">You can ask me anything!</p>
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/teacher-avater-2.png" 
                                class="img-circle img-responsive">
                            </div>                        	
                        </div>
                        <div class="white-box">
                            @foreach($student->answers as $answer)
                            <p>
                                <small class="pull-right"> {{$answer->created_at->diffForHumans() }}</small>
                                <b>{{ $answer->sender->commentName('instructor') }}</b>: <br />
                                {{ $answer->content }}
                                <small><a href='{{ action( 'ClassroomController@lesson', 
                                            [ 'course' => $course->slug, 'module' => $answer->lesson->module->slug, 'lesson' => $answer->lesson->slug ] ) }}#ask-teacher'>[View in lesson]</a></small>
                            </p>
                            @endforeach
                        </div>
                    @endif
                        <br />
                        <p class="lead">Upcoming</p>
                        <div class="white-box">
                        	<div class="clearfix">
                                    <?php
                                    $upcoming = $nextLesson;
                                    ?>
                                @for($i = 0; $i < 3; ++$i)
                                    <?php
                                    if($upcoming) {
                                        $upcoming = $upcoming->lessonAfter();
                                    }
                                    ?>
                                    @if($upcoming)
                                        <p class="lead">
                                            <span>Lesson {{$upcoming->lesson_number}} </span>	
                                            {{$upcoming->name}}
                                        </p>
                                        <p
                                        @if($i==2)
                                            style='margin-bottom:-34px'
                                        @endif
                                        >
                                             {{$upcoming->description}}
                                        </p>
                                    @endif
                            	@endfor
                            </div>
                            <span class="view-curriculum">
                                <a href='#curriculum'>View full curriculum</a>
                            </span>
                        </div>
                    </div>
                	<div class="col-md-6">
                    	<div class="accompanying-material">
                            <h3>Accompanying material</h3>
                            @if($nextLesson != false)
                                @foreach($nextLesson->blocks as $block)
                                    @if($block->type=='file')
                                    <?php
                                        $extension = substr( mime_to_extension( mimetype ( $block->content) ), 1 );
                                    ?>
                                        <div 
                                            @if($extension=='pdf')
                                                class="pdf"
                                            @elseif($extension=='zip')
                                                class="zip"
                                            @else
                                                class="pdf"
                                            @endif
                                            >
                                            <span> {{ $extension  }}</span>
                                            <p>{{ $block->name }}</p>
                                            <a href="{{ $block->content }}">Download</a>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                                                        
                        </div>
                        <div class="header green clearfix">
                            <h2>
                                @if( !$nextLesson )
                                    Completed all lessons - decide what to put here
                                @else
                                    <a href="{{ action( 'ClassroomController@lesson', [ 'course' => $course->slug, 
                                        'module' => $nextLesson->module->slug , 'lesson' => $nextLesson->slug ] ) }}">
                                    @if( $student->viewedLessons->count()==0 )
                                        BEGIN <small>FIRST LESSON</small>
                                    @else
                                        CONTINUE <small>Where you left off</small>
                                    @endif
                                    </a>
                                @endif
                            </h2>
                        </div>
                        <p class="lead">In the next lesson you will learn</p>
                        <div class="white-box">
                            <p>{{ $nextLesson->description or ' finished all lessons ' }}</p>
                        </div>
                    </div>
                </div>
                <a name='conversations'></a>
                <div class="row classmate-conversations-heading">
                	<div class="col-md-12">
                        <p class="lead">Classmate conversations</p>
                    </div>
                </div>

            {{ View::make('courses.classroom.conversations.form')->withCourse( $course ) }}
            
            <div class='ajax-content fa-animated'>
                {{ View::make('courses.classroom.conversations.all')->withComments( $course->comments ) }}
                <br />
                <div class="text-center load-remote" data-target='.ajax-content' data-load-method="fade">
                    {{ $course->comments->links() }}
                </div>
            </div>
                
        
               
            
                <div class="row curriculum" id="curriculum">
                    <a name='curriculum'></a>
                	<div class="col-md-12">
                    	<div class="clearfix">
                            <p class="lead">Curriculum<span id="view-all-lessons">View All</span></p>
                            <span id="close-button" class="fa fa-times fa-6"></span>
                            
                            <!--<div class="view-previous-lessons">view previous lessons</div>-->
                            <ul class="lessons">
                                <?php $i = $j = 1;  ?>
                                @foreach($course->modules as $module)
                                    <li>
                                        <a class="module module-lesson">
                                            <span>Module {{$i}}</span>
                                            <p>{{ $module->name }}</p>
                                        </a>
                                    </li>
                                    @foreach($module->lessons as $lesson)
                                        <li id="curriculum-lesson-{{$lesson->id}}">
                                            @if( $student->purchased($course) || $student->purchased( $lesson ) )
                                                <a href="{{ action( 'ClassroomController@lesson', [ 'course' => $course->slug, 'module' => $lesson->module->slug, 'lesson' => $lesson->slug ] ) }}" 
                                                   @if( $student->isLessonViewed($lesson) )
                                                       class="lesson-1 module-lesson">
                                                   @else
                                                       class="lesson-2 module-lesson">
                                                   @endif
                                                    <span>Lesson {{$j}}</span>
                                                    <p>{{ $lesson->name }}</p>
                                                </a>
                                            @else
                                                <a class="lesson-4 module-lesson">
                                                    <span>Lesson {{$j}}</span>
                                                    <p>{{ $lesson->name }}</p>
                                                </a>
                                            @endif
                                        </li>
                                    <?php ++$j;?>
                                    @endforeach
                                    <?php ++$i;?>
                                @endforeach
                            </ul>
<!--                            <div class="custom-scrollbar">
                            	<span></span>
                            </div>-->
                        </div>
                    </div>
                </div>
            </section>
            
            @if(Auth::guest() || !Auth::user()->hasRole('Instructor'))
                <section class="container-fluid become-an-instructor">
                    <div class="container">
                      <div class="row">
                        <div class="col-xs-12">
                          <h1>BECOME</h1>
                          <h2>AN INSTRUCTOR</h2>
                          <a href="{{ action('InstructorsController@become') }}"><span>{{trans('site/homepage.get-started')}}</span></a>
                        </div>
                      </div>
                  </div>
                </section>
            @endif
        </div>

@stop

@section('extra_js')
    @if( $student->viewedLessons->count() > 0 )
        <script type="text/javascript">
            $(function(){
                $('.lessons').scrollToChild( $('.lesson-2').first() );
            });
        </script>
    @endif
@stop