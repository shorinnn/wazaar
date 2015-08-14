@extends('layouts.default')

@section('page_title')
    Dashboard - 
@stop

@section('content')
	<div class="container-fluid new-dashboard top-section">
    	<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 lesson-description">
                    <div class="row">
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        	<h2>Go back where you left it</h2>
                        </div>
                    </div>
                    @if( $lastLesson != null )
                        <div class="row margin-top-30">
                                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                        <div class="img-wrap">
                                        <img 
                                            @if($lastLesson->lesson->module->course->course_preview_image_id == null)
                                                src="http://placehold.it/350x150&text={{ trans('general.preview-unavailable') }}"
                                            @else
                                                src="{{ cloudfrontUrl( $lastLesson->lesson->module->course->previewImage->url ) }}"
                                            @endif
                                             class="img-responsive" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-8 col-md-7 col-lg-7">
                                        <h3>{{ $lastLesson->lesson->module->course->name }}</h3>
                                    <p class="regular-paragraph">
                                        {{ $lastLesson->lesson->module->course->short_description }}
                                    </p> 
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                                    <div class="radial-progress">
<!--                                        <div class="progress-radial progress-{{ $student->courseProgress($lastLesson->lesson->module->course) }}">
                                          <div class="overlay">{{ $student->courseProgress($lastLesson->lesson->module->course) }}%</div>
                                        </div>-->
                                        @if(  $student->courseProgress($lastLesson->lesson->module->course)  > 0)
                                            <div id='progress-circle-top-{{$lastLesson->lesson->module->course->id}}' class='progress-circle' data-color='#0099ff' data-trail-color='#2f3439' data-stroke='4' style='height:90px; width:90px'
                                             data-progress='{{ $student->courseProgress($lastLesson->lesson->module->course) }}'></div>
                                        @else
                                            <div id='progress-circle-top-{{$lastLesson->lesson->module->course->id}}' class='progress-circle' data-color='#0099ff' data-trail-color='tomato' data-stroke='4' data-progress='0' 
                                                 style='height:90px; width:90px'></div>
                                        @endif
                                        <a href="{{
                                            action('ClassroomController@lesson', 
                                            [ $lastLesson->lesson->module->course->slug,
                                            $lastLesson->lesson->module->slug,
                                            $lastLesson->lesson->slug])
                                           }}" class="blue-button large-button"><i class="wa-play"></i>Resume</a>
                                    </div>
                                </div>

                        </div>
                        <div class="row current-lesson-row">
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                    <h6 class="current-lesson text-right">Current lesson 
                                        ({{ $lastLesson->lesson->lessonPosition() }}/ {{$lastLesson->lesson->module->course->lessonCount(false) }}): </h6>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                                    <p class="regular-paragraph current-lesson-title">
                                        {{$lastLesson->lesson->module->order}}.{{$lastLesson->lesson->order}}. 
                                        {{ $lastLesson->lesson->name }}
                                    </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs-header">
    	<div class="container">
        	<div class="row">
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active">
                        	<a href="#enrolled" role="tab" id="enrolled-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">Enrolled</a>
                        </li>
                        <li role="presentation">
                        	<a href="#finished" role="tab" id="finished-tab" data-toggle="tab" aria-controls="finished">Finished</a>
                        </li>
                        <li role="presentation" class="dropdown">
                          <a href="#wishlist" role="tab" id="wishlist-tab" data-toggle="tab" aria-controls="wishlist">Wishlist</a>
                        </li>
                    </ul>               
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard dashboardTabs">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pull-right">
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="enrolled">
                          @foreach($courses as $course)
                               {{View::make('student.dashboard.enrolled-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                      </div>
                        
                      <div role="tabpanel" class="tab-pane fade" id="finished">
                          @foreach($courses as $course)
                              <?php
                              $course = $course->product;
                              if( $student->courseProgress( $course ) < 100 ) continue;
                              ?>
                               {{View::make('student.dashboard.completed-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                      </div>
                        
                      <div role="tabpanel" class="tab-pane fade" id="wishlist">
                          @foreach($wishlist as $course)
                               {{View::make('student.dashboard.wishlist-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                      </div>
                    </div>
                </div>
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                	<div class="sidebar">
                        <div class="profile-picture-holder">
                            <img src="{{ Auth::user()->commentPicture('student') }}" class="img-responsive">
                        </div>
                        <div href="#" class="name">
                            <h2>{{ Auth::user()->commentName('student') }}</h2>
                            <a href="{{action('ProfileController@index')}}" class="edit-profile"><i class="fa fa-cog"></i>Edit profile</a>
                        </div>
                        <a href="#" class="message-count message">
                        	<i class="fa fa-comment-o"></i>
                            Messages
                            <span class="count">(2)</span>
                        </a>
                        <a href="#" class="message-preview unread message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <a href="#" class="message-preview message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <a href="#" class="message-preview unread message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <a href="#" class="message-preview message">
                        	<h4>Jeremy Wong <span class="date">Yesterday</span></h4>
                            <p class="regular-paragraph">I am new to course creation. I have many doubts and i am ... </p>
                        </a>
                        <div class="text-center read-message">
                        	<a href="#" class="default-button large-button">Read all messages</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
@stop

@section('extra_js')
<script src='{{ url('js/progressbar.min.js')}}'></script>
<script>
    $(function(){
            $('.progress-circle').each(function(){
                var $elem = $(this);
                var text = $elem.attr('data-text');
                var circle = new ProgressBar.Circle( '#'+$elem.attr('id'), {
                    color: $elem.attr('data-color'),
                    strokeWidth: 4,
                    trailWidth: 4,
                    trailColor: $elem.attr('data-trail-color'),
                    duration: 1000,
                    text: {
                        value: '0'
                    },
                    step: function(state, bar) {
                        if( typeof(text) == 'undefined') bar.setText((bar.value() * 100).toFixed(0));
                        else {
                            $elem.find('.progressbar-text').html( text );
                        }
                    }
                });
            progress = $elem.attr('data-progress') / 100;
            circle.animate( progress );
        });
            
    });
</script>
@stop