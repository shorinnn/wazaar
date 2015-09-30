@extends('layouts.default')

@section('page_title')
    Dashboard - 
@stop

@section('content')
	<style>
    	.student-dash .tab-content{
			border: none !important;
		}
		.student-dash .tab-content .tab-pane{
			border: 1px solid #e0e1e2;
		}
    </style>
	<div class="container-fluid new-dashboard top-section" style="min-height: 200px;">
    	<div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 lesson-description">
                    <div class="row">
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @if( $lastLesson != null )
                        	<h2>{{ trans('courses/general.back-to-where-you-left') }}</h2>
                            @endif
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
                                           }}" class="blue-button large-button"><i class="wa-play"></i>{{ trans('courses/general.resume') }}</a>
                                    </div>
                                </div>

                        </div>
                        <div class="row current-lesson-row">
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                    <h6 class="current-lesson text-right">{{ trans('courses/dashboard.current_lesson') }} 
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
                        	<a href="#enrolled" role="tab" id="enrolled-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true">
                                {{trans('general.dash.enrolled')}}</a>
                        </li>
                        <li role="presentation">
                        	<a href="#finished" role="tab" id="finished-tab" data-toggle="tab" aria-controls="finished">
                                {{trans('general.dash.finished')}}</a>
                        </li>
                        <li role="presentation" class="dropdown">
                          <a href="#wishlist" role="tab" id="wishlist-tab" data-toggle="tab" aria-controls="wishlist">{{trans('general.dash.wishlist')}}</a>
                        </li>
                    </ul>               
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid new-dashboard student-dash dashboardTabs padding-bottom-25">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 pull-right">
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="enrolled">
                          @if($courses->count() == 0)
                          		<style>
									.student-dash .tab-content #enrolled{
										border: none;
									}
									.student-dash .tab-content{
										min-height: 200px;
									}
								</style>
                                @if(Auth::user()->_profile('Instructor') != null)
                                    @if( trim(Auth::user()->_profile('Instructor')->corporation_name) != '')
                                        <p class="text-center">でみたいことはありますか？</p>
                                        <p class="text-center margin-top-10"> Wazaarでコースを探してみましょう！</p>
                                    @else
                                        {{ Auth::user()->_profile('Instructor')->last_name }}
                                         <p class="text-center">でみたいことはありますか？</p>
                                         <p class="text-center margin-top-10"> Wazaarでコースを探してみましょう！</p>
                                    @endif                          
                                @elseif(Auth::user()->_profile('Student') != null)  

                                    {{ Auth::user()->_profile('Student')->last_name }}
                                            <p class="text-center">でみたいことはありますか？</p>
                                            <p class="text-center margin-top-10"> Wazaarでコースを探してみましょう！</p>
                                @else
                                    <p class="text-center">でみたいことはありますか？</p>
                                    <p class="text-center margin-top-10"> Wazaarでコースを探してみましょう！</p>
                                @endif
                            @endif
                        
                        
                          @foreach($courses as $course)
                               {{View::make('student.dashboard.enrolled-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                      </div>
                        
                      <div role="tabpanel" class="tab-pane fade" id="finished">
                          
                          
                          
                          @foreach($courses as $course)
                              <?php
                              $course = $course->product;
                              if( $student->courseProgress( $course ) < 100 ) continue;
                              $completedCourse = true;
                              ?>
                               {{View::make('student.dashboard.completed-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                          
                          @if( !isset($completedCourse) )
                          		<style>
									.student-dash .tab-content #finished{
										border: none;
									}
									.student-dash .tab-content{
										min-height: 200px;
									}
								</style>
                             <p class="text-center">あなたはまだ修了したコースがありません。</p>
                             <p class="text-center margin-top-10"> さあ、コースを探してみよう！</p>
                          @endif
                      </div>
                        
                      <div role="tabpanel" class="tab-pane fade" id="wishlist">
                          @if($wishlist->count() == 0)
                          		<style>
									.student-dash .tab-content #wishlist{
										border: none;
									}
									.student-dash .tab-content{
										min-height: 200px;
									}
								</style>
                           <p class="text-center">お気に入りのコースはありません。</p>
                          @endif
                           
                          @foreach($wishlist as $course)
                               {{View::make('student.dashboard.wishlist-course')->with( compact( 'course', 'student' ) ) }}
                          @endforeach
                      </div>
                    </div>
                </div>
            	<div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                	<div class="sidebar">
                        <div class="profile-picture-holder"
                              style='background:url(
                            @if( isset($profile->photo) && trim($profile->photo) !='' )
                                {{ $profile->photo }}
                            @else
                                http://s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg
                            @endif
                            ) no-repeat center center; background-color:white; background-size:100%'
                             >
                            
<!--                            @if( isset($profile->photo) && trim($profile->photo) !='' )
                                <img src="{{@$profile->photo}}" alt="" id="img-profile-picture" class="img-responsive"/>
                            @else
                                <img src="http://s3-ap-northeast-1.amazonaws.com/wazaar/profile_pictures/avatar-placeholder.jpg" alt="" id="img-profile-picture" class="img-responsive"/>
                            <img src="{{ Auth::user()->commentPicture('student') }}" class="img-responsive">
                            @endif-->
                        </div>
                        <div href="#" class="name">
                            <h4 class="hide">{{ Auth::user()->commentName('student') }}</h4>
                            <a href="{{action('ProfileController@index')}}" class="edit-profile"><i class="fa fa-cog"></i>{{ trans('general.edit-profile') }}</a>
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
            var hash = window.location.hash;
            if( isset(hash) ){
                $('[href="'+hash+'"]').click();
            }
            
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