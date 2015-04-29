    @extends('layouts.default')
    
    @section('page_title')
        {{ $course->name }} {{ trans('courses/student_dash.dashboard') }} -
    @stop
    
    @section('content')	
    
        <div class="classrooms-wrapper">
        	<section class="video-container text-center">
               @if( $student->unreadAnnouncements->count() > 0)
                    <div class="top-notification-bar">
                        <span></span>{{ trans('courses/student_dash.you-have') }} {{ $student->unreadAnnouncements->count() }} 
                        {{ Lang::choice('courses/student_dash.announcements', $student->unreadAnnouncements->count() ) }}.
                    </div>
                @endif
                @if($student->unreadAnswers->count() > 0)
                    <div class="top-notification-bar">
                        <span></span>{{ trans('courses/student_dash.you-have') }} {{ $student->unreadAnswers->count() }} 
                        {{ Lang::choice('courses/student_dash.teacher-responses',  $student->unreadAnswers->count()) }}.
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
                    <div id="lesson-video-overlay">
                    	<div>
                        	<h4>Course Name</h4>
                        	<h3>Lesson Name</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                        </div>
                    </div>
                    <span class="centered-play-button"></span>
                    @endif
                @endif
            </section>
            <section class="classroom-content container">
                @if( $gift !=null)
                    <div class="row">
                    <div class="col-md-12 additional-lesson-conntent">
                        <h3 style="text-transform: capitalize">{{ trans('courses/student_dash.your-gift') }}</h3>
                        <div class='alert alert-info'>
                            {{ $gift->text }}
                        
                            @foreach($gift->files as $file)
                                <p class='well well-sm'>
                                    {{$file->name}}
                                    <a href='{{ action('ClassroomController@gift', PseudoCrypt::hash($file->id) ) }}' 
                                       class='btn btn-primary pull-right'>{{ trans('courses/student_dash.download') }}</a>
                                </p>
                            @endforeach
                            </div>
                    </div>
                </div>
                @endif
                
            	<div class="row">
                    <div class="col-md-12 additional-lesson-conntent">
                        <h3 style="text-transform: capitalize">{{ Lang::choice('courses/student_dash.announcements', 2) }}</h3>
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
					<div class="col-md-12">
                    	<div class="additional-lesson-conntent">
                        	<h3>{{ trans('courses/student_dash.additional-lesson-content') }}</h3>
                            @if($nextLesson != false)
                                @if($nextLesson->blocks()->where('type','text')->first())
                                    <p> {{ 
                                            Str::limit( strip_tags( $nextLesson->blocks()->where('type','text')->first()->content), 100)
                                         }} 
                                    </p>
                                    <a href="{{ action( 'ClassroomController@lesson', 
                                            [ 'course' => $nextLesson->module->course->slug, 
                                              'module' => $nextLesson->module->slug, 
                                              'lesson' => $nextLesson->slug ] ) }}" class="read-more">{{ trans('courses/student_dash.read-more') }}</a>
                                @endif
                            @endif
                        </div>                   
                    </div>
                    <div class="col-md-12">
                    	<div class="accompanying-material">
                            <h3>{{ trans('courses/student_dash.accompanying-material') }}</h3>
                            @if($nextLesson != false)
                                @foreach($nextLesson->blocks as $block)
                                    @if($block->type=='file')
                                    <?php
                                        $extension = substr( mime_to_extension( $block->mime ), 1 );
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
                                            <a href="{{ action('ClassroomController@resource', PseudoCrypt::hash($block->id) ) }}">
                                                {{ trans('courses/student_dash.download') }}</a>
                                            
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                                                        
                        </div>
                    
                    </div>                
                </div>
            	<div class="row">
                	<div class="col-md-6">
                    	<div class="dashboard-students-count-box">
                        	<div class="students-attending">1333 STUDENTS</div>
                            <p class="your-progress">Your Progress: <span> 40%</span></p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active progress-bar-banner" role="progressbar" aria-valuenow="0" aria-valuemin="0" 
                                     aria-valuemax="100" style="width: 0%;">
                                    <span></span>
                                </div>
                            </div>
							<p class="comments-posted">Comments Posted: <span> 0</span></p>
                            <div class="course-description">
                            	<h3>About Course</h3>
                                <p>A little bit of this, a little bit of that. Cool stuff mostly.</p>
                                <p>A little bit of this, a little bit of that. Cool stuff mostly.
                                A little bit of this, a little bit of that. Cool stuff mostly.
                                A little bit of this, a little bit of that. Cool stuff mostly.</p>
                                <p>A little bit of this, a little bit of that. Cool stuff mostly.</p>
                            </div>
                        </div>
                    <!--@if( $course->ask_teacher=='enabled')
                    	<div class="header blue clearfix">
                            @if($instructor->profile == null)
                        	<h2>{{ trans('courses/student_dash.ask') }}
                                    <small>{{ trans('courses/student_dash.the-teacher') }}</small></h2>
                                <div class="avater hidden-xs">
                                    <p class="quote">{{ trans('courses/student_dash.you-can-ask-anything') }}!</p>
                                    <img height="50" src="//s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar-placeholder.jpg" 
                                    class="img-circle">
                                </div>
                            @else
                                <h2>{{ trans('courses/student_dash.ask') }}
                                    <small>{{ $instructor->profile->first_name }}</small></h2>
                                <div class="avater hidden-xs">
                                    <p class="quote">{{ trans('courses/student_dash.you-can-ask-anything') }}!</p>
                                    <img height="50" src="{{ $instructor->profile->photo }}" class="img-circle">
                                </div>
                            @endif
                        </div>
                        <div class="white-box">
                            @foreach($student->answers as $answer)
                            <p>
                                <small class="pull-right"> {{$answer->created_at->diffForHumans() }}</small>
                                <b>{{ $answer->sender->commentName('instructor') }}</b>: <br />
                                {{ $answer->content }}
                                <small><a href='{{ action( 'ClassroomController@lesson', 
                                            [ 'course' => $course->slug, 'module' => $answer->lesson->module->slug, 'lesson' => $answer->lesson->slug ] ) }}#ask-teacher'>
                                        [{{ trans('courses/student_dash.view-in-lesson') }}]</a></small>
                            </p>
                            @endforeach
                        </div>
                    @endif
                        <br />
                        <p class="lead">{{ trans('courses/student_dash.upcoming') }}</p>
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
                                            <span>{{ trans('courses/general.lesson') }} {{$upcoming->lesson_number}} </span>	
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
                                <a href='#curriculum'>{{ trans('courses/student_dash.view-full-curriculum') }}</a>
                            </span>
                        </div>-->
                    </div>
                	<div class="col-md-6">
                        <div class="header green clearfix">
                            <h2>
                                @if( !$nextLesson )
                                    Completed all lessons
                                @else
                                    <a href="{{ action( 'ClassroomController@lesson', [ 'course' => $course->slug, 
                                        'module' => $nextLesson->module->slug , 'lesson' => $nextLesson->slug ] ) }}">
                                    @if( $student->viewedLessons->count()==0 )
                                        {{ trans('courses/student_dash.begin') }} 
                                        <small>{{ trans('courses/student_dash.first-lesson') }}</small>
                                    @else
                                        {{ trans('courses/student_dash.continue') }} 
                                        <small>{{ trans('courses/student_dash.where-you-left-off') }}</small>
                                    @endif
                                    </a>
                                @endif
                            </h2>
                        </div>
                        <p class="lead"><!--{{ trans('courses/student_dash.in-the-next-lesson') }}--> [Lesson Title]</p>
                        <div class="white-box">
                            <p><!--{{ $nextLesson->description or trans('courses/student_dash.finished-all') }}--> [Lesson description]</p>
                        </div>
                        @if( $course->ask_teacher=='enabled')
                            <!--<div class="header blue clearfix">
                                @if($instructor->profile == null)
                                <h2>{{ trans('courses/student_dash.ask') }}
                                        <small>{{ trans('courses/student_dash.the-teacher') }}</small></h2>
                                    <div class="avater hidden-xs">
                                        <p class="quote">{{ trans('courses/student_dash.you-can-ask-anything') }}!</p>
                                        <img height="50" src="//s3-ap-northeast-1.amazonaws.com/wazaardev/profile_pictures/avatar-placeholder.jpg" 
                                        class="img-circle">
                                    </div>
                                @else
                                    <h2>{{ trans('courses/student_dash.ask') }}
                                        <small>{{ $instructor->profile->first_name }}</small></h2>
                                    <div class="avater hidden-xs">
                                        <p class="quote">{{ trans('courses/student_dash.you-can-ask-anything') }}!</p>
                                        <img height="50" src="{{ $instructor->profile->photo }}" class="img-circle">
                                    </div>
                                @endif
                            </div>-->
                            <div class="white-box">
                                @foreach($student->answers as $answer)
                                <p>
                                    <small class="pull-right"> {{$answer->created_at->diffForHumans() }}</small>
                                    <b>{{ $answer->sender->commentName('instructor') }}</b>: <br />
                                    {{ $answer->content }}
                                    <small><a href='{{ action( 'ClassroomController@lesson', 
                                                [ 'course' => $course->slug, 'module' => $answer->lesson->module->slug, 'lesson' => $answer->lesson->slug ] ) }}#ask-teacher'>
                                            [{{ trans('courses/student_dash.view-in-lesson') }}]</a></small>
                                </p>
                                @endforeach
                            </div>
                        @endif
                        <br />
                        <p class="lead">{{ trans('courses/student_dash.upcoming') }}</p>
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
                                            <span>{{ trans('courses/general.lesson') }} {{$upcoming->lesson_number}} </span>	
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
                                <a href='#curriculum'>{{ trans('courses/student_dash.view-full-curriculum') }}</a>
                            </span>
                        </div>

                    </div>
                </div>
                <a name='conversations'></a>
                <div class="row classmate-conversations-heading">
                	<div class="col-md-12">
                        <p class="lead">{{ trans('courses/student_dash.classmate-conversations') }}</p>
                    </div>
                </div>

            {{ View::make('courses.classroom.conversations.form')->with(compact('course', 'student') ) }}
            
            <div class='ajax-content fa-animated'>
                {{ View::make('courses.classroom.conversations.all')->withComments( $course->comments )->withStudent( $student ) }}
                <br />
                <div class="text-center load-remote" data-target='.ajax-content' data-load-method="fade">
                    {{ $course->comments->links() }}
                </div>
            </div>
                
        
               
            
                <div class="row curriculum" id="curriculum">
                    <a name='curriculum'></a>
                	<div class="col-md-12">
                    	<div class="clearfix">
                            <p class="lead">{{ trans('courses/student_dash.curriculum') }}
                                <span id="view-all-lessons">{{ trans('courses/student_dash.view-all') }}</span></p>
                            <span id="close-button" class="fa fa-times fa-6"></span>
                            
                            <!--<div class="view-previous-lessons">view previous lessons</div>-->
                            <ul class="lessons">
                                <?php $i = $j = 1;  ?>
                                @foreach($course->modules as $module)
                                    <li>
                                        <a class="module module-lesson">
                                            <span>{{ trans('courses/general.module') }} {{$i}}</span>
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
                                                    <span>{{ trans('courses/general.lesson') }} {{$j}}</span>
                                                    <p>{{ $lesson->name }}</p>
                                                </a>
                                            @else
                                                <a class="lesson-4 module-lesson">
                                                    <span>{{ trans('courses/general.lesson') }} {{$j}}</span>
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
                          <h1>{{ trans('site/homepage.become') }}</h1>
                          <h2>{{ trans('site/homepage.an-instructor') }}</h2>
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