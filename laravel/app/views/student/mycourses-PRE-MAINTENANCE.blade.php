@extends('layouts.default')

@section('page_title') 売上管理 - Wazaar @stop

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
                            <div class="col-xs-12 col-sm-8 col-md-7 col-lg-9">
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
                        	<a href="#enrolled" role="tab" id="enrolled-tab" data-toggle="tab" aria-controls="enrolled" aria-expanded="true"
                                    onclick='dashUrl("{{url("student/mycourses/enrolled") }}")'>
                                {{trans('general.dash.enrolled')}}</a>
                        </li>
                        <li role="presentation">
                        	<a href="#finished" role="tab" id="finished-tab" data-toggle="tab" aria-controls="finished"
                                    onclick='dashUrl("{{url("student/mycourses/finished") }}")'>
                                {{trans('general.dash.finished')}}</a>
                        </li>
                        <li role="presentation" class="dropdown">
                          <a href="#wishlist" role="tab" id="wishlist-tab" data-toggle="tab" aria-controls="wishlist"
                              onclick='dashUrl("{{url("student/mycourses/wishlist") }}")'>
                             {{trans('general.dash.wishlist')}}</a>
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
                            
                            @if( !isset($profile->photo) || trim($profile->photo) =='' )
                            <div class="upload-picture-button text-center" style="background-color: transparent; margin-top: 40%; border: none;
                                 margin-left: auto; margin-right: auto;">
                                <form action="{{url('profile/upload-profile-picture')}}" enctype="multipart/form-data" id='picture-form' method="post">
                                    <label for="upload-new-photo" class="default-button large-button">
                                        <span>{{ trans('general.upload_new_picture') }}</span>
                                        <input type="file" hidden="" class='' id="upload-new-photo" name="profilePicture"/>
                                    </label>
                                    <p class="label-progress-bar label-progress-bar-preview-img"></p>
                                    <div class="progress hidden">
                                        <div class="progress-bar progress-bar-striped active progress-bar-preview" role="progressbar" aria-valuenow="0" 
                                             data-label=".label-progress-bar-preview-img" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                            <span></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                        <div href="#" class="name">
                            <h4>{{ Auth::user()->commentName('student') }}</h4>
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
<script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}"></script>
<script>
    function showReview(cls){
        $(cls).modal('show');
    }        
    function dashUrl(page){
        history.pushState({}, '', page);
    }
    $(function(){

        @if( Request::segment(3) !='' )
            $('[href="#{{Request::segment(3)}}"]').click();
        @endif

        //Hide and show the positive and negative review textareas and labels
        $('body').delegate('.yes-button','click',  function(){
                $('.positive-review-wrap').removeClass('hide');
                $('.negative-review-wrap').addClass('hide');
                $(this).addClass('active');
                $('.no-button').removeClass('active');
                $('.long-later-button').hide();
        });
        $('body').delegate('.no-button','click',  function(){
                $('.positive-review-wrap').addClass('hide');
                $('.negative-review-wrap').removeClass('hide');
                $(this).addClass('active');
                $('.yes-button').removeClass('active');
                $('.long-later-button').hide();
        });
        
        $('#upload-new-photo').fileupload()
                .bind('fileuploadprogress', function ($e, data){
                    $progressLabel = $('.label-progress-bar');
                    var $progress = parseInt(data.loaded / data.total * 100, 10);
                    var progressbar = '.progress-bar';
                    $(progressbar).css('width', $progress + '%');
                    if( $progressLabel.length > 0 ) $progressLabel.html($progress);
                    else $(progressbar).find('span').html($progress);
                    if($progress=='100'){
                        console.log( $progressLabel );
                        if( $progressLabel.length > 0 ) $progressLabel.html( _('Upload complete. Processing') + ' <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
                        else $(progressbar).parent().find('span').html( _('Upload complete. Processing') + ' <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" />');
                    }
                }
                )
                .bind('fileuploaddone',function ($e,$data){
                    if ($data.result.success == 1){
                        $('.label-progress-bar').hide();
                        $('.progress-bar').hide();
                        $('#picture-form').remove();
                        $('#img-profile-picture').attr('src',$data.result.photo_url);
                        $('.profile-picture-holder').css('background-image', 'url('+$data.result.photo_url+')') ;
                    }
        });
            
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