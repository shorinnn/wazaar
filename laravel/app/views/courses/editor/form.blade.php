@extends('layouts.default')
@section('page_title')
    {{ $course->name }} - {{ trans('courses/general.edit') }} -
@stop

@section('content')
    <style>
        #save-indicator{
            border:1px solid black;
            background-color:white;
            width:130px;
            height:30px;
            position:fixed;
            top:100px;
            left:-140px;
            text-align: right;
            padding-right: 10px;
            white-space: nowrap;
        }

        #publish-status-header{
            font-size:15px;
        }
        .edit-course select{
            width:auto;
        }
        .course-description-video-preview img, .course-listing-image-preview img{
            height: 100%;
            max-height: 100px;
        }
        
             
    .inactive > *{
        pointer-events: none;
    }
    
    /************ PROGRESS BAR **************/
    .label-progress-bar{
        font-size: 12px;
        font-weight: normal !important;
        margin: 0px !important;
    }
    .edit-course .progress, .progress{
        background-color:gray;
        height: 3px;
    }
    .progress-bar{
        background-color: #069BFF;
    }
    
    .step2 h2:hover, .step2 .description-text:hover{
        background-color: initial;
    }
    /************ /PROGRESS BAR **************/
    
    /************ MINIMIZED MODULE **************/
    .minimized-elem{
        display: none;
    }
    .module-minimized .minimized-elem{
        display: block;
		word-wrap: break-word;
    }
    .module-minimized:hover .minimized-elem{
        background-color:#e8eced;
    }
    .module-minimized .module-data{
        border:none !important;
    }
    .module-minimized .footer-buttons > *{
        opacity:0;
    }
    .lesson-container .footer-buttons > *{
        opacity:1;
    }
    
    .module-zone:hover .toggle-minimize:not([type=reset]){
        display:block !important;
        cursor: pointer;
    }
    .module-minimized .module-zone{
        height: auto;
        overflow: hidden;
        border-bottom: 0px solid #E8ECED;
    }
    .module-minimized .module-zone .footer-buttons {
		display: none;
	}
    .module-minimized .module-zone input, .module-minimized .module-zone textarea,  .module-minimized .module-zone button{
        display:none !important;
    }
    /************ /MINIMIZED MODULE **************/
    
    /************ MINIMIZED LESSON **************/
    .minimized-lesson-elem{
        display: none;
    }
	.module-minimized .minimized-elem .minimized-description{
		font-size: 13px;
		color: #798794;
	}
	
    .lesson-minimized .minimized-lesson-elem{
        display: block;
    }
    .lesson-minimized:hover .minimized-lesson-elem:not(.no-highlight){
        background-color:#e8eced;
    }

    .lesson-minimized .minimized-lesson-elem .attachments{
        color:#a7b7c4;
		font-size: 13px;
    }

    .lesson-minimized .minimized-lesson-elem .toggle-minimize , .show-files{
		font-size: 12px;
		font-weight: bold;
		color: #069bff;
		margin-left: 20px;
		cursor: pointer;
	}
	.minimized-lesson-elem[class*=copy-name]{
		font-size: 14px;
		color: #41474c;
		font-weight: 600;
	}
	
	.minimized-lesson-elem[class*=copy-desc]{
		font-size: 13px;
		color: #798794;
	}
	
    .lesson-zone:hover .toggle-minimize{
        display:block !important;
        cursor: pointer;
    }
    .lesson-minimized{
         background-color: #F7F9FA !important;
    }
    .lesson-minimized .lesson-data{
        /*height: 290px;*/
        overflow: visible;
        border-bottom: 2px solid #E8ECED;
        background-color: transparent !Important;
    }
    
    .lesson-minimized .footer-buttons, .lesson-minimized .file-upload-row{
        display: none;
    }
    
    .lesson-minimized .lesson-control{
        display: none !important;
    }
    .lesson-minimized .maximized-elem,.lesson-minimized .lesson-data input, .lesson-minimized .lesson-data textarea,  .lesson-minimized .lesson-data button{
        display:none !important;
    }
    
    .lesson-data .edit-icon{
        display:none;
    }
    .lesson-data:hover .edit-icon{
        display: block;
        margin-right: -22px;
        cursor:pointer;
    }
	@media (min-width: 1200px){
	.edit-course .main {
		overflow: visible;
	}
	
	.lesson-container .shr-lesson{
		-webkit-transition: all .2s ease-in-out;
		-moz-transition: all .2s ease-in-out;
		-ms-transition: all .2s ease-in-out;
		-o-transition: all .2s ease-in-out;
		transition: all .2s ease-in-out;
	}
	
	.shr-editor-module .module-zone{
		-webkit-transform: scale(1.05, 1);
		-moz-transform: scale(1.05, 1);
		-ms-transform: scale(1.05, 1);
		-o-transform: scale(1.05, 1);
		transform: scale(1.05, 1);
		position: relative;
		z-index: 3;
		margin: 4px 0;
	    border-radius: 4px;
		box-shadow: 1px 1px 4px 2px #d8dbdc;
		/*-webkit-transition: all .2s ease-in-out;
		-moz-transition: all .2s ease-in-out;
		-ms-transition: all .2s ease-in-out;
		-o-transition: all .2s ease-in-out;
		transition: all .2s ease-in-out;*/
	}

	.shr-editor-module.module-minimized .module-zone,
	.lesson-container .lesson-minimized{
		-webkit-transform: scale(1);
		-moz-transform: scale(1);
		-ms-transform: scale(1);
		-o-transform: scale(1);
		transform: scale(1);
	    border-radius: 0;
		box-shadow: none;
		position: relative;
		z-index: 0;
	}

	.lesson-container .shr-lesson:not(.lesson-minimized){
		-webkit-transform: scale(1.05, 1);
		-moz-transform: scale(1.05, 1);
		-ms-transform: scale(1.05, 1);
		-o-transform: scale(1.05, 1);
		transform: scale(1.05, 1);
	    border-radius: 4px;
		-moz-box-shadow: 1px 1px 4px 2px #cfd8df;
		-ms-box-shadow: 1px 1px 4px 2px #cfd8df;
		-o-box-shadow: 1px 1px 4px 2px #cfd8df;
		-webkit-box-shadow: 1px 1px 4px 2px #cfd8df;
		box-shadow: 1px 1px 4px 2px #cfd8df;
		position: relative;
		z-index: 1;
		margin: 4px 0;
		-webkit-transition: all .2s ease-in-out;
		-moz-transition: all .2s ease-in-out;
		-ms-transition: all .2s ease-in-out;
		-o-transition: all .2s ease-in-out;
		transition: all .2s ease-in-out;
	}
	.step2 .shr-editor-module{
		overflow: visible;
	}
}

    /************ /MINIMIZED LESSON **************/
    
    /*** price box ***/
    .value-unit-two input{
        width:63px !Important;
    }
    /*** /price box ***/
    
    .file-preview{
        background-color: white;
        position: absolute;
        padding: 10px;
        display: none;
    }
    
    .file-preview li{
        margin:5px;
    }
    </style>


@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if (Session::get('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
@include('videos.archiveModal')
<div class="edit-course">
    <input type='hidden' class='step-1-filled' value='{{ $course->short_description !='' ? 1 : 0}}' />
    <input type='hidden' class='step-2-filled' value='{{ $course->lessonCount() >= 0 ? 1 : 0}}' />
    <input type='hidden' class='step-3-filled' value='{{ $course->course_difficulty_id > 0 ? 1 : 0}}' />
	<section class="container-fluid header">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 text-left">
                        <div class="video-preview-thumb">
                            <div class="preview-overlay">
                                <i class="fa fa-eye"></i>
                                <span>PREVIEW</span>
                            </div>
                        </div>
                        <ul class="breadcrumb">
                            <li><a href="{{ action('CoursesController@myCourses') }}">Dashboard</a><i class="wa-chevron-right"></i></li>
                            <li class="active"><a href="#">Course Edit</a></li>
                        </ul>                    
                        <h1 class="">{{ $course->name }}<span>DRAFT</span>
                                <!--<a href="{{ action('CoursesController@myCourses') }}" class="blue-button large-button back-to-course-list">
                                    {{ trans('courses/general.back-to-course-list')}}
                                </a>-->
                        </h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-right margin-bottom-15">
                <!--<a href="#" class=" submit-for-approval blue-button large-button right">{{ trans('courses/general.submit') }}</a>
                <a href="/courses/{{$course->slug}}?preview=1"></a>-->
                <a href="#" class=" submit-for-approval blue-button large-button disabled-button">{{ trans('courses/general.submit') }}</a>                
                <a href='#' data-href="{{action('CoursesController@show', $course->slug ) }}?preview=1" class="default-button large-button preview-course-btn">
                	{{ trans('courses/general.preview_course') }}
            	</a>
                                
                @if(Auth::user()->hasRole('Admin') )
                {{ Form::open(['action' => ['CoursesController@disapprove', $course->id ] ] ) }}
                    <button class='default-button large-button'>
                        Disapprove course
                    </button>
                {{ Form::close() }}
                @endif
            </div>
        </div>
        <div class="row header-tabs-container">
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            	<a href="#" class="header-tabs active load-remote-cache" data-callback='courseChangedTabs' data-cached-callback='courseChangedTabs'
                   data-url="{{ action('CoursesController@edit', $course->slug)}}/1" data-target='.course-ajax-holder .step1' data-steps-remaining='2 steps'
                   data-loaded='1' data-gif='ajax-loader-3.gif' ><em>1</em>{{ trans('courses/general.description') }}</a>
            	<a href="#" class="header-tabs load-remote-cache link-to-step-2" data-callback='courseChangedTabs' data-cached-callback='courseChangedTabs'
                   data-url="{{ action('CoursesController@edit', $course->slug)}}/2" data-target='.course-ajax-holder .step2'  data-steps-remaining='1 step'
                   data-gif='ajax-loader-3.gif' ><em>2</em>{{ trans('courses/general.curriculum') }}</a>
            	<a href="#" class="header-tabs load-remote-cache link-to-step-3" data-callback='courseChangedTabs' data-cached-callback='courseChangedTabs'
                   data-url="{{ action('CoursesController@edit', $course->slug)}}/3" data-target='.course-ajax-holder ._step3'  data-steps-remaining='0'
                   data-gif='ajax-loader-3.gif' ><em>3</em>{{ trans('courses/general.settings') }}</a>

                <div class="right steps-remaining">
                    @if( courseStepsRemaining($course)==0 || $course->publish_status!='unsubmitted')
                        <p class="regular-paragraph no-margin">
                           <span>{{ trans('courses/general.course-ready-for-submission') }} </span>
                        </p>
                    @else
                        <p class="regular-paragraph no-margin">
                        {{ trans('courses/general.complete-x-steps-to-submit', ['steps' => courseStepsRemaining($course) ] )}}
                        <!--<br />
                         {{ trans('courses/general.complete') }}
                        <span>
                            <span>{{ courseStepsRemaining($course) }}</span>
                            {{ trans('courses/general.steps') }}</span> {{ trans('courses/general.to_submit_course') }}-->
                        </p>
                    @endif
                </div>
                
            </div>
        </div>
    </section>
    <section class="container-fluid main course-editor">
    	<div class="container">
            <div class="row course-ajax-holder">
                    <form id="form-aws-credentials" action="">
                        <input type="hidden" name="key" value="{{$uniqueKey}}">
                        <input type="hidden" name="AWSAccessKeyId" value="{{Config::get('aws::config.key')}}">
                        <input type="hidden" name="acl" value="private">
                        <input type="hidden" name="success_action_status" value="201">
                        <input type="hidden" name="policy" value="{{$awsPolicySig['base64Policy']}}">
                        <input type="hidden" name="signature" value="{{$awsPolicySig['signature']}}">
                    </form>
                <div class='container step1' data-loaded='1'>
                    <input class="course-id" type="hidden" value="{{$course->id}}"/>
                    
                    {{ View::make('courses.editor.step1',compact('awsPolicySig','uniqueKey' ,'course', 'images', 'bannerImages', 'assignedInstructor', 'difficulties'))
                            ->with(compact('categories', 'subcategories', 'assignableInstructors', 'affiliates', 'filePolicy' ) )->render() }}
                </div>
                <div class='step2'></div>
                <div class='container _step3'></div>
            </div>
        </div>
    </section>
</div>



    @include('videos.playerModal')
    <script>
        var course_steps_remaining = {{ courseStepsRemaining($course) }};
        
        function showVideoPreview(elem){
            url = $(elem).attr('data-video-url');
            video = '<video style="width:100%" preload="auto"controls=1><source src="'+url+'" type="video/mp4"></video>';
            if( isset( $(elem).attr('data-yt') ) ) video = '<center><iframe width="530" height="315" src="'+url+'" frameborder="0" allowfullscreen></iframe></center>';
            if( isset( $(elem).attr('data-v') ) ) video = '<center><iframe src="'+url+'?color=ffffff&title=0&portrait=0&badge=0" width="530" height="315" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></center>';
            bootbox.dialog({ 
                title: _('Video Preview') + ' (' + $(elem).attr('data-filename') + ')',
                message: video
            });
            skinVideoControls();
        }
        
        function externalVideoPreview(e,json){
            dest = $(e.target).attr('data-target');
            $dest = $(dest);
            json = JSON.parse(json);
            $dest.html( json.embed_code);
        }
        
        function externalVideoAdded(e){
                target = $(e.target);
                $localLessonId = target.attr('data-lesson');
                $('#lesson-'+$localLessonId).find('.lesson-no-video').removeClass('lesson-no-video');
        }
        
        function removePromoVideo(e){
            e.preventDefault();
            course = $('.course-id').val();
            $.post(COCORIUM_APP_PATH+'courses/'+course+'/remove-promo', function(){
                $('.course-description-video-preview').find('img').remove();
            });
        }


    </script>
@stop