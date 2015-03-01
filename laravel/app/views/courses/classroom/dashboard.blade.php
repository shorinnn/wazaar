    @extends('layouts.default')
    @section('content')	
    
        <div class="classrooms-wrapper">
        	<section class="video-container text-center">
            	<div class="top-notification-bar"><span></span>You have 2 replies / Comments</div>
                @if($video)
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
                	<div class="col-md-6">
                    	<div class="additional-lesson-conntent">
                        	<h3>Additional lesson content</h3>
                            <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore 
                            magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo 
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                            </p>
                            <a href="#" class="read-more">READ MORE</a>
                        </div>
                    	<div class="header blue clearfix">
                        	<h2>ASK<small>THE TEACHER</small></h2>
                            <div class="avater hidden-xs">
                            	<p class="quote">You can ask me anything!</p>
                                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/teacher-avater-2.png" 
                                class="img-circle img-responsive">
                            </div>                        	
                        </div>
                        <p class="lead">Lesson Notes</p>
                        <div class="white-box">
                        	<div class="clearfix">
                            	<p class="lead"><span>Lesson 1</span>	Making your first splash page</p>
                                <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod te
								tmpor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
                                laboris nisi ut aliquip ex
                                </p>
                            	<p class="lead"><span>Lesson 1</span>	Making your first splash page</p>
                                <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod te
								tmpor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                </p>
                            </div>
                            <span class="view-curriculum">Vieuw full curriculum</span>
                        </div>
                    </div>
                	<div class="col-md-6">
                    	<div class="accompanying-material">
                        	<h3>Accompanying material</h3>
                        	<div class="pdf">
                            	<span>pdf</span>
                                <p>The beginner's manual</p>
                                <a href="#">Download</a>
                            </div>
                        	<div class="zip">
                            	<span>zip</span>
                                <p>Sample Script</p>
                                <a href="#">Download</a>
                            </div>
                        	<div class="zip">
                            	<span>zip</span>
                                <p>Sample Script</p>
                                <a href="#">Download</a>
                            </div>
                            
                        </div>
                        <div class="header green clearfix">
                            <h2>
                                @if( !$student->nextLesson($course))
                                    Completed all lessons - decide what to put here
                                @else
                                    <a href="{{ action( 'ClassroomController@lesson', [ 'course' => $course->slug, 'module' => $student->nextLesson($course)->module->slug , 'lesson' => $student->nextLesson($course)->slug ] ) }}">
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
                            <p>{{ $student->nextLesson($course)->description or ' finished all lessons ' }}</p>
                        </div>
                    </div>
                </div>
                <div class="row classmate-conversations-heading">
                	<div class="col-md-12">
                        <p class="lead">Classmate conversations</p>
                    </div>
                </div>
                <div class="row comment-section clearfix">
                	<div class="col-md-12">
                    	<div class="comment-box clearfix">
                        	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-1.png" 
                            class="img-circle img-responsive" alt="">
                        	<form>
                                <textarea></textarea>
                            </form>
                        </div>
                    </div>
                </div>
               <div class="row">
                	<div class="col-md-12">
                    	<div class="users-comments">
                        	<div class="clearfix">
                                <div class="comment clearfix clear">
                                    <div class="info clearfix clear">
                                        <span class="name">Bas Mooreland</span>
                                        <a href="#" class="reply-link">Reply</a>
                                        <span class="number-of-replies">14 others replied</span>
                                        <span class="time-of-reply">10 hours ago</span>
                                    </div>
                                    <div class="main clearfix clear">
                                        <img class="img-responsive img-circle" alt="" 
                                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">
                                        <span>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
                                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                                        </span>
                                    </div>
                                </div>
                                <div class="comment reply clearfix clear">
                                    <div class="info clearfix clear">
                                        <span class="name">Anabelle Jackson</span>
                                        <a href="#" class="reply-link">Reply</a>
                                        <span class="time-of-reply">10 hours ago</span>
                                    </div>
                                    <div class="main clearfix clear">
                                        <img class="img-responsive img-circle" alt="" 
                                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-3.png">
                                        <span>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
                                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        </span>
                                    </div>
                                </div>
                                <div class="comment clearfix clear">
                                    <div class="info clearfix clear">
                                        <span class="name">Bas Mooreland</span>
                                        <a href="#" class="reply-link">Reply</a>
                                        <span class="number-of-replies">14 others replied</span>
                                        <span class="time-of-reply">10 hours ago</span>
                                    </div>
                                    <div class="main clearfix clear">
                                        <img class="img-responsive img-circle" alt="" 
                                        src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">
                                        <span>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
                                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="load-more-comments">LOAD MORE</span>
                    </div>
                </div>
                <div class="row curriculum" id="curriculum">
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