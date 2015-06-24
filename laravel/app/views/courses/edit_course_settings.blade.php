@extends('layouts.default')

@section('content')

<style>
    #save-indicator{
        border:1px solid black;
        background-color:white;
        width:90px;
        height:30px;
        position:fixed;
        top:100px;
        left:-100px;
        text-align: right;
        padding-right: 10px;
    }
    
    #publish-status-header{
        font-size:15px;
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
	<section class="container-fluid header">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<h1>{{ trans('courses/general.edit') }}: Course name</h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class="blue-button large-button right">{{ trans('courses/general.submit_for_approval') }}</a>
                <a href="#" class="default-button large-button right">
                	{{ trans('courses/general.preview_course') }}
            	</a>

            </div>
        </div>
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            	<a href="#" class="header-tabs regular-paragraph">{{ trans('courses/general.course_description') }}</a>
            	<a href="#" class="header-tabs regular-paragraph">{{ trans('courses/general.curriculum') }}</a>
            	<a href="#" class="header-tabs regular-paragraph active">{{ trans('courses/general.settings') }}</a>
                
            </div>
        </div>
    </section>
    <section class="container main course-editor">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 left-content">
            	<div class="approval-box">
                	<h4 class="not-approved">Not approved!</h4>
                    <p class="regular-paragraph">
                    Wazaar must review and approve your course before you can publish it.
                    </p>
                </div>
                <div class="row editor-settings-layout margin-bottom-30">
                	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    	<h4 class="text-right">Enable Ask Coach</h4>
                    </div>
                	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    	<div class="toggle-switch">
                        	<button name="yes" class="toggle-button">Yes</button>
                            <button name="no" class="toggle-button">No</button>
                        </div>
                    </div>
                </div>
                <div class="row editor-settings-layout margin-bottom-30">
                	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    	<h4 class="text-right">Payment type</h4>
                    </div>
                	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    	<select>
                        	<option>One time</option>
                            <option></option>
                        </select>
                        <span class="regular-paragraph clue-text">How users will pay for a course. </span>
                    </div>
                </div>
                <div class="row editor-settings-layout margin-bottom-30">
                	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    	<h4 class="text-right">Difficulty</h4>
                    </div>
                	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    	<div class="toggle-switch">
                        	<button name="beginner" class="toggle-button">Beginner</button>
                            <button name="intermediate" class="toggle-button">Intermediate</button>
                            <button name="advanced" class="toggle-button">Advanced</button>
                        </div>
                    </div>
                </div>
                <div class="row editor-settings-layout margin-bottom-30">
                	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    	<h4 class="text-right">Discount</h4>
                    </div>
                	<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                    	<input type="text">
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
                    	<select>
                        </select>
                    </div>
                </div>
                <div class="row editor-settings-layout margin-bottom-30">
                	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    	<h4 class="text-right">Price</h4>
                    </div>
                	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    	<div class="value-unit">
                        	<input type="text" name="amount">
                            <span>¥</span>
                        </div>
                    </div>
                </div>
                <div class="row editor-settings-layout margin-bottom-30">
                	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    	<h4 class="text-right">Affiliate percentage</h4>
                    </div>
                	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    	<div class="value-unit">
                        	<input type="text" name="amount">
                            <span>%</span>
                        </div>
                    </div>
                </div>
                <div class="row editor-settings-layout margin-bottom-30">
                	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    	<h4 class="text-right">{{ trans('courses/general.sale_starts_on') }}</h4>
                    </div>
                	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    	<div class="calender">
                              <div class="clear clearfix input-group date">
                                  {{ Form::text('sale_starts_on', null, ['class'=>'form-control sales-end-calender datetimepicker']) }}
                                  <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="row editor-settings-layout margin-bottom-30">
                	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    	<h4 class="text-right">{{ trans('courses/general.sale_ends_on') }}</h4>
                    </div>
                	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    	<div class="calender">
                            <div class="clear clearfix input-group date">
                                {{ Form::text('sale_ends_on', null, ['class'=>'form-control sales-end-calender datetimepicker']) }}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 right-content">
            	<h2>Course summary</h2>
            	<div class="row category-row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">Category</p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">IT & WEB</p>
                            </div>
                        </div>
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">Sub-category</p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">Websites</p>
                            </div>
                        </div>
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">Price: </p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">7,200</p>
                            </div>
                        </div>
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">Modules: </p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">4</p>
                            </div>
                        </div>
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">Total lessons: </p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">26</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="edit-button">Edit</a>
                </div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>Description:</h4>
                        <p class="regular-paragraph">
                        Did you know that if you upload a test video you are over 3 times as likely to have your course published and 
                        featured on Udemy? Upload a short, ~1 ...minute long video and upload it to the test video tool by following 
                        </p>
                    </div>
                </div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>What is this for:</h4>
                        <ul>
                        	<li>Did you know that </li>
                        	<li>If you upload a test video </li>
                        	<li>You are over 3 times as likely to have your course published and featured on </li>
                        </ul>
                    </div>
               	</div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>Requirements:</h4>
                        <ul>
                        	<li>Did you know that </li>
                        	<li>If you upload a test video </li>
                        	<li>You are over 3 times as likely to have your course published and featured on </li>
                        </ul>
                    </div>
               	</div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>At the end of course you will be able:</h4>
                        <ul>
                        	<li>Did you know that </li>
                        	<li>If you upload a test video </li>
                        	<li>You are over 3 times as likely to have your course published and featured on </li>
                        </ul>
                    </div>
               	</div>
                <div class="row next-step-button">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<button class="blue-button extra-large-button">SUBMIT FOR APPROVAL</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('videos.playerModal')
@stop

@section('extra_js')
<script src="{{url('plugins/uploader/js/vendor/jquery.ui.widget.js')}}"></script>
<script src="{{url('plugins/uploader/js/jquery.iframe-transport.js')}}"></script>
<script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}"></script>
<script src="{{url('plugins/slider/js/bootstrap-slider.js')}}"></script>
<script src="{{url('js/videoUploader.js')}}" type="text/javascript"></script>
<script src="{{url('js/videoLookup.js')}}" type="text/javascript"></script>
<script src="{{url('js/videoModal.js')}}" type="text/javascript"></script>
<script src="{{url('js/moment.js')}}" type="text/javascript"></script>
<script src="{{url('js/bootstrap-datetimepicker.js')}}" type="text/javascript"></script>
<script type="text/javascript">
        $(function (){
           $('.lesson-no-video .video .a-add-video').click();
	       $('.lesson-no-video .video .a-add-video').attr('data-loaded', 1);
            
            enableFileUploader( $('#upload-preview-image') );
            enableFileUploader( $('#upload-banner-image') );
            enableSlider('#affiliate_percentage');
            $('textarea').each(function(){
                if( $(this).attr('id') != 'short_description' ){
                    enableRTE( '#'+$(this).attr('id') );
                }
            });
            videoLookup.prepareModalEvents();
            videoLookup.initialize(function ($lessonId, $videoId){
                /**** if lesson is 0 or undefined, this means we are looking up for a video intended to a course(description) ***/
                if ($lessonId == 0 || $lessonId == undefined){
                    var $courseId = $('.course-id').val();
                    //make post call to update course
                    $.post('/courses/'+ $courseId +'/video/set-description',{videoId: $videoId});

                    videoUploader.getVideo($videoId, function ($video){
                        $('#course-video-anchor').html($video.original_filename);
                        $('#course-video-anchor').attr('data-filename',$video.original_filename);
                        $('#course-video-anchor').attr('data-video-url',$video.formats[0].video_url);

                    });
                    return;
                }

                /*** Lesson video lookup below *****/

				var uploadedVideo = $('#video-player-container-' + $lessonId).find('video');
				var videoDuration = uploadedVideo[0].duration;
				var timeFormat = function(seconds){
					var m = Math.floor(seconds/60)<10 ? "0"+Math.floor(seconds/60) : Math.floor(seconds/60);
					var s = Math.floor(seconds-(m*60))<10 ? "0"+Math.floor(seconds-(m*60)) : Math.floor(seconds-(m*60));
					return m+":"+s;
				};
				videoUploader.getVideo($videoId, function ($video){
					console.log($video);
					
					$('.lesson-options-' + $lessonId).find('#video-thumb-container').css({
						display: 'block'	
					});
					
					$('.lesson-options-' + $lessonId).find(
						'#video-thumb-container').html(
						"<P></P><a href='#' class='fa fa-eye' data-toggle='modal' onclick='videoModal.show(this, event)' data-filename='"+ $video.original_filename +"' data-video-url='"+ $video.formats[0].video_url +"'></a> <img src='" + $video.formats[0].thumbnail +"'/>");
						
					$('.lesson-options-' + $lessonId).find('#video-thumb-container p').text($video.formats[0].duration);
				});

                $.post('/lessons/blocks/' + $lessonId + '/video/assign', {videoId : $videoId}, function (){
                    $('#video-link-' + $lessonId).trigger('click');
                    $('#lesson-'+$lessonId).find('.lesson-no-video').removeClass('lesson-no-video');
                });
            });



                $('#btn-close-previews').on('click', function (){
                    $('#selected-previews').html('');
                    $('.display-border').each(function (){
                        console.log($(this).parent().find('img').attr('src'));
                        $('#selected-previews').append("<img width='100' src='" +  $(this).parent().find('img').attr('src') + "' />");
                    });
                });
                
                $('#btn-close-previews-banner').on('click', function (){
                    $('#video-selected-previews').html('');
                    $('.display-border').each(function (){
                        console.log($(this).parent().find('img').attr('src'));
                        $('#video-selected-previews').append("<img width='100' src='" +  $(this).parent().find('img').attr('src') + "' />");
                    });
                });


        });
</script>

<script type="text/javascript">



    
    var $courseVideoInterval;

    jQuery(function(){
        
        $('.datetimepicker').datetimepicker( { 
            sideBySide:true,
            extraFormats: ['YYYY-MM-DD hh:mm:s']
        } );
        
        var formData = $('#form-aws-credentials').serialize();

        jQuery('#upload-course-video').fileupload({
            url: '//s3-ap-southeast-1.amazonaws.com/videosinput-tokyo',
            formData: {
                key:$('#form-aws-credentials').find('input[name=key]').val(),
                AWSAccessKeyId:$('#form-aws-credentials').find('input[name=AWSAccessKeyId]').val(),
                acl:$('#form-aws-credentials').find('input[name=acl]').val(),
                success_action_status:$('#form-aws-credentials').find('input[name=success_action_status]').val(),
                policy:$('#form-aws-credentials').find('input[name=policy]').val(),
                signature:$('#form-aws-credentials').find('input[name=signature]').val()
            }
        }).on('fileuploadprogress', function ($e, $data) {
            var $progress = parseInt($data.loaded / $data.total * 100, 10);
            $('#progress-course-video').css('width',$progress + '%');
        }).bind('fileuploaddone', function ($e, $data) {
            $('.course-video-upload-button-progress').addClass('hidden');
            $('.course-video-upload-processing').removeClass('hidden');

            if ($data.jqXHR.status == 201){
                if ($data.files[0].name !== undefined){
                    var $elem = $(this)[0];
                    var $courseId = $('.course-id').val();

                    $.post('/video/add-by-filename',{videoFilename: $data.uniqueKey + '-' + $data.files[0].name}, function ($response){
                        $.post('/courses/'+ $courseId +'/video/set-description',{videoId: $response.videoId});
                        $courseVideoInterval = setInterval (function() {
                            $.ajax({
                                dataType: "json",
                                url: '/video/' + $response.videoId + '/json',
                                success: function ($video){
                                    if ($video.transcode_status == 'Complete'){
                                        clearInterval($courseVideoInterval);
                                        $('.course-video-thumb').removeClass('hidden');
                                        $('.course-video-upload-processing').addClass('hidden');
                                        $('#course-video-anchor').attr('data-filename',$video.original_filename);
                                        $('#course-video-anchor').attr('data-video-url',$video.formats[0].video_url);
                                        $('#course-video-anchor').html($video.original_filename);

                                        console.log($video);
                                    }
                                }
                            });
                        },5000);
                    },'json');
                }
            }
        });

        /*videoLookup.initialize($('.course-video-select-existing-anchor'), function ($lessonId, $videoId){
            alert($videoId);
        });*/
    });
</script>


@stop