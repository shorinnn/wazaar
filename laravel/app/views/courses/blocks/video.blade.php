<div class="text-center">
    
    @if($lesson->module->course->free == 'yes')
        <div class='external-video-preview preview-{{$lesson->id}}'>
            {{ externalVideoPreview($lesson->external_video_url) }}
        </div>
        <input type="text" class="ajax-updatable" onkeyup="externalVideoAdded(event)" data-lesson='{{$lesson->id}}'
               data-callback='externalVideoPreview' data-target='.preview-{{$lesson->id}}'
               data-url='{{action('LessonsController@update', [$lesson->module->id, $lesson->id] )}}' placeholder='Youtube or Vimeo Link'
                          data-name='external_video_url' id='external-video-{{$lesson->id}}' value="{{ $lesson->external_video_url }}" />
    @else
        <div id="video-player-container-{{$lessonId}}">
            <!--<div id="notify-warning-new-video" class="alert alert-warning
                @if (@$video->transcode_status == Video::STATUS_COMPLETE)
                    hide
                @endif ">
                <strong>{{trans('crud/labels.note')}}: </strong>
                {{trans('video.willAppearHere')}}
            </div>-->
            <div id="video-player" class="@if (!isset($video->formats[0]->video_url)) hide @endif">
                <video controls>
                    <source id="source-video-url" src="{{@$video->formats[0]->video_url}}">
                    {{trans('video.doesNotSupportHthml5')}}
                </video>
            </div>
        </div>
        <h3 class="no-margin"><!--{{trans('video.uploadOr')}} -->
        <form action="{{UploadHelper::AWSVideosInputURL()}}" enctype="multipart/form-data" method="POST" class="fileupload">
            <input type="hidden" name="key" value="{{$uniqueKey}}-${filename}">
            <input type="hidden" name="AWSAccessKeyId" value="{{Config::get('aws::config.key')}}">
            <input type="hidden" name="acl" value="private">
            <input type="hidden" name="success_action_status" value="201">
            <input type="hidden" name="policy" value="{{$awsPolicySig['base64Policy']}}">
            <input type="hidden" name="signature" value="{{$awsPolicySig['signature']}}">

            <div class="form-inline">
                        @if ($video!=null && isset($video->formats[0]->video_url))
                                    <span id="video-transcoding-indicator-{{$lessonId}}" class="video-transcoding-indicator" style="display: block;">{{trans('video.currentVideo')}}:
                                    <a href="#" class="video-title" data-filename="{{$video->original_filename}}" data-video-url="{{$video->formats[0]->video_url}}" onclick="videoModal.show(this, event)">{{$video->original_filename}}</a>
                            </span> 
                            <div class="form-group video-upload clear">
                                                            <style>
                                    .course-editor #modules-list > li .video-upload{
                                        font-size: 16px !important;
                                    }
                                </style>
                                <span>{{ trans('video.upload-new-video') }}</span>
                                <input type="file" multiple="multiple" name="file" class="upload" data-unique-key="{{$uniqueKey}}" data-block-id="{{$block->id}}" data-lesson-id="{{$lessonId}}" id="fileupload-{{$lessonId}}">
                            </div>

                        @else
                            <span id="video-transcoding-indicator-{{$lessonId}}" class="video-transcoding-indicator hidden">{{trans('video.videoCurrentlyProcessing')}}</span>
                            <div class="form-group video-upload clear">
                                    <span>{{ trans('video.upload-video') }}</span>                   
                                <input type="file" multiple="multiple" name="file" class="upload" data-unique-key="{{$uniqueKey}}" data-block-id="{{$block->id}}" data-lesson-id="{{$lessonId}}" id="fileupload-{{$lessonId}}">
                            </div>

                        @endif

                        <p class="video-info">{{trans('video.maxFileSize')}}</p>
                <!-- Progress Bar -->

                <div class="progress">
                    <div id="progress-bar-{{$lessonId}}" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        <span><span id="percent-complete-{{$lessonId}}"></span> <!--{{trans('crud/labels.complete')}}--></span>
                    </div>
                </div>

                <em class="or-text"
                   @if ( Video::where('created_by_id', Lesson::find($lessonId)->module->course->instructor_id)->count() > 0)
                       style='display:inline;'
                   @endif
                > 
                {{ trans('site/login.or') }}</em>
                <a href="#" class="show-videos-archive-modal" data-lesson-id="{{$lessonId}}"
                   @if ( Video::where('created_by_id', Lesson::find($lessonId)->module->course->instructor_id)->count() > 0)
                       style='display:inline-block;'
                   @endif            
                >
                {{trans('video.selectExisting')}}</a></h3>
                <!--<p class="video-info">{{trans('video.formatsSupported')}}</p>-->


            </div>

       </form>
    </div>
    @endif
<script type="text/javascript">
    var timeFormat = function(seconds){
        var m = Math.floor(seconds/60)<10 ? "0"+Math.floor(seconds/60) : Math.floor(seconds/60);
        var s = Math.floor(seconds-(m*60))<10 ? "0"+Math.floor(seconds-(m*60)) : Math.floor(seconds-(m*60));
        return m+":"+s;
    };

    function externalVideoAdded(e){
            target = $(e.target);
            $localLessonId = target.attr('data-lesson');
            $('#lesson-'+$localLessonId).find('.lesson-no-video').removeClass('lesson-no-video');
    }
    
    function externalVideoPreview(e,json){
        dest = $(e.target).attr('data-target');
        $dest = $(dest);
        json = JSON.parse(json);
        $dest.html( json.embed_code);
    }
    
    $(function (){
        
        
        var $blockId = {{$block->id}};
        var $lessonId = {{$lessonId}};
        var $intervalId = 0;
        

		var videoVariable = $('#lesson-{{$lessonId}} #video-player-container-' + $lessonId).html();
		
		@if (isset($video->formats[0]->video_url))
			$('#video-link-' + $lessonId).removeClass('active').addClass('done');
			$('.lesson-options-{{$lessonId}}').find('#video-thumb-container').css('display', 'block');
			
			$('.lesson-options-{{$lessonId}}').find('#video-thumb-container').html("<P></P><a href='#' class='fa fa-eye' onclick='videoModal.show(this, event)' data-filename='{{$video->original_filename}}' data-video-url='{{$video->formats[0]->video_url}}' data-toggle='modal'></a> <img src='{{$video->formats[0]->thumbnail}}'/>");
			$('.lesson-options-{{$lessonId}}').find('#video-thumb-container p').text("{{$video->formats[0]->duration}}");
			
			$('.lesson-options-{{$lessonId}}').find('.lesson-options-buttons').find('.load-remote-cache').addClass('done');
		@endif
		
		@if(@$video->transcode_status == Video::STATUS_COMPLETE)
			$('.lesson-options-{{$lessonId}}').find('#video-thumb-container').css('display', 'block');
			
			$('.lesson-options-{{$lessonId}}').find('#video-thumb-container').html("<P></P><a href='#' class='fa fa-eye' onclick='videoModal.show(this, event)' data-filename='{{$video->original_filename}}' data-video-url='{{$video->formats[0]->video_url}}' data-toggle='modal'></a> <img src='{{$video->formats[0]->thumbnail}}'/>");
			$('.lesson-options-{{$lessonId}}').find('#video-thumb-container p').text("{{$video->formats[0]->duration}}");
			
			$('.lesson-options-{{$lessonId}}').find('.lesson-options-buttons').find('.load-remote-cache').addClass('done');
		@endif
		

		
		$('#video-player-container-' + $lessonId).addClass('hide');
//		$('.course-editor #modules-list > li .progress').addClass('hide');
		$('.lesson-options-{{$lessonId}}').find('.progress').addClass('hide');

        videoUploader.initialize({
            'fileInputElem' : $('#fileupload-' + $lessonId),
            'progressCallBack' : function ($data, $progressPercentage, $elem){
                var $lessonId = $($data.fileInput[0]).attr("data-lesson-id");
				$('#progress-bar-' + $lessonId).parent('.progress').removeClass('hide');
                $('#progress-bar-' + $lessonId).css('width', $progressPercentage + '%');
                $('#percent-complete-' + $lessonId).html($progressPercentage + '%');
                $('#video-transcoding-indicator-' + $lessonId).addClass('hidden');

            },
            'failCallBack' : function ($data){

            },
            'successCallBack' : function ($data, $elem){
                var $localLessonId = $($elem.fileInput[0]).attr("data-lesson-id");
                var $localBlockId = $($elem.fileInput[0]).attr("data-block-id");
				$('#video-transcoding-indicator-' + $localLessonId).removeClass('hidden');
				
				function videoTranscodingAnimation(){
					var count = 0;
					animationInterval = setInterval(function(){
					  count++;
					  document.getElementById('video-transcoding-indicator-' + $localLessonId).innerHTML = _("Video Currently Processing") + new Array(count % 4).join('.');
					}, 500);	
				}
				videoTranscodingAnimation();
				$('.lesson-options-' + $localLessonId).find('#video-thumb-container').html("<em>Processing</em>");
				$('.lesson-options-' + $localLessonId + '.buttons.active em').css('display', 'block');
				$('.lesson-options-'+ $localLessonId +' .buttons.active').css({
					width: '120px',
					border: 'solid 1px #b0bfc1'	
				});
                if ($data.videoId !== undefined) {
                    //$('#video-player-container-' + $lessonId).find('#video-player').addClass('hide');
                    $('#video-player-container-' + $localLessonId).find('#notify-warning-new-video').removeClass('hide');
                    $.post('/lessons/blocks/' + $localLessonId + '/video', {videoId : $data.videoId, blockId : $localBlockId });
                    console.log('has video id');
                    //Run timer to check for video transcode status
                    $intervalId = setInterval (function() {
                        console.log('interval running');
                        videoUploader.getVideo($data.videoId, function ($video){

							console.log($video);
							if ($video.transcode_status == 'Complete'){
                                console.log('Transcoding complete');
								$('#video-link-' + $localLessonId).addClass('done');
								$('#video-transcoding-indicator-' + $localLessonId).css('display', 'none');
                                $('#lesson-'+$localLessonId).find('.lesson-no-video').removeClass('lesson-no-video');
								clearInterval($intervalId);
								var uploadedVideo = $('#video-player-container-' + $localLessonId).find('video');
								var videoDuration = $video.formats[0].duration;// uploadedVideo[0].duration;
								var timeFormat = function(seconds){
									var m = Math.floor(seconds/60)<10 ? "0"+Math.floor(seconds/60) : Math.floor(seconds/60);
									var s = Math.floor(seconds-(m*60))<10 ? "0"+Math.floor(seconds-(m*60)) : Math.floor(seconds-(m*60));
									return m+":"+s;
								};
								
								
								$('#lesson-'+ $localLessonId +' > .new-lesson').removeClass('gray').addClass('green');
								
								$('.lesson-options-'+ $localLessonId +' .buttons.active div#video-thumb-container').css({
									display: 'block'	
								});
								
								$('.lesson-options-' + $localLessonId).find(
									'#video-thumb-container').html(
									"<P></P><a href='#' class='fa fa-eye' data-toggle='modal' onclick='videoModal.show(this, event)' data-filename='"+ $video.original_filename +"' data-video-url='"+ $video.formats[0].video_url +"'></a> <img src='" + $video.formats[0].thumbnail +"'/>");
								$('.lesson-options-' + $localLessonId).find('#video-thumb-container p').text(videoDuration);
								$('#video-player-container-' + $lessonId).find('video').attr('src', $video.formats[0].video_url);

								$('.lesson-options-'+ $localLessonId +' .buttons.active div#video-thumb-container a').on('click', function(){
									$('#uploadedVideoPlayer').html(videoVariable);
								});
								//$('#video-link-' + $lessonId).removeClass('load-remote-cache').trigger('click');
								//reload video partial
							}
                    }) }, 5000);
                }
            }
        });
    });
</script>