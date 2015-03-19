<div class="text-center">
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
    <h3><!--{{trans('video.uploadOr')}} -->
    {{Form::open(['url' => 'video/upload', 'id' => '', 'files' => true])}}
        <div class="form-inline">
        	<input disabled="disabled" placeholder="" id="uploadFile" style="">
            <div class="form-group video-upload clear">
	            <span>Upload Video</span>
                <input type="file" name="fileupload" class="upload" id="fileupload-{{$block->id}}">
            </div>
            <em>OR</em>
            <a href="#" class="show-videos-archive-modal" data-lesson-id="{{$lessonId}}">{{trans('video.selectExisting')}}</a></h3>
            <p class="video-info">{{trans('video.formatsSupported')}}</p>
            <p class="video-info">{{trans('video.maxFileSize')}}</p>

        </div>
        <!--<div class="video-upload fileUpload btn btn-primary clear">
            <span>Upload Video</span>
            <p>Lorem ipsum description here</p>
        </div>-->


        <!-- Progress Bar -->

        <div class="progress">
            <div id="progress-bar-{{$block->id}}" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                <span><span id="percent-complete-{{$block->id}}"></span>% {{trans('crud/labels.complete')}}</span>
            </div>
        </div>
    {{Form::close()}}
</div>

<script type="text/javascript">
    $(function (){
		//console.log("{{$video->formats[0]->video_url->transcode_status}}");
		@if($video->transcode_status == Video::STATUS_COMPLETE)
			console.log("Video transcoded");
			$('.lesson-options-' + $lessonId).find('#video-thumb-container').css({
				display: 'block'	
			});
			
			$('.lesson-options-{{$lessonId}}').find(
				'#video-thumb-container').html(
				"<P></P><a href='#' class='fa fa-eye' data-toggle='modal' data-target='#myModal'></a> <img src='" + $video.formats[0].thumbnail +"'/>");
			$('.lesson-options-{{$lessonId}}').find('#video-thumb-container p').text(timeFormat(videoDuration));
		@endif
		
        var $blockId = {{$block->id}};
        var $lessonId = {{$lessonId}};
        var $intervalId = 0;
		
		$('#video-player-container-' + $lessonId).addClass('hide')		
        videoUploader.initialize({
            'fileInputElem' : $('#fileupload-' + $blockId),
            'progressCallBack' : function ($data, $progressPercentage){
                $('#progress-bar-' + $blockId).css('width', $progressPercentage + '%');
                $('#percent-complete-' + $blockId).html($progressPercentage);
            },
            'failCallBack' : function ($data){

            },
            'successCallBack' : function ($data){
				//console.log("Output after successcallback");
				$('.lesson-options-{{$lessonId}} .buttons.active em').css('display', 'block');
				$('.lesson-options-{{$lessonId}} .buttons.active').css({
					width: '120px',
					border: 'solid 1px #b0bfc1'	
				});
                if ($data.result.videoId !== undefined) {
                    //$('#video-player-container-' + $lessonId).find('#video-player').addClass('hide');
                    $('#video-player-container-' + $lessonId).find('#notify-warning-new-video').removeClass('hide');
                    $.post('/lessons/blocks/' + $lessonId + '/video', {videoId : $data.result.videoId, blockId : $blockId });
                    console.log('has video id');
                    //Run timer to check for video transcode status
                    $intervalId = setInterval (function() {
                        console.log('interval running');
                        videoUploader.getVideo($data.result.videoId, function ($video){

							console.log($video);
							if ($video.transcode_status == 'Complete'){
								clearInterval($intervalId);
								var uploadedVideo = $('#video-player-container-' + $lessonId).find('video');
								var videoDuration = uploadedVideo[0].duration;
								var timeFormat = function(seconds){
									var m = Math.floor(seconds/60)<10 ? "0"+Math.floor(seconds/60) : Math.floor(seconds/60);
									var s = Math.floor(seconds-(m*60))<10 ? "0"+Math.floor(seconds-(m*60)) : Math.floor(seconds-(m*60));
									return m+":"+s;
								};
								
								var videoVariable = $('#lesson-{{$lessonId}} #video-player-container-' + $lessonId).html();
								
								$('.lesson-options-{{$lessonId}} .buttons.active div#video-thumb-container').css({
									display: 'block'	
								});
								
								$('.lesson-options-{{$lessonId}}').find(
									'#video-thumb-container').html(
									"<P></P><a href='#' class='fa fa-eye' data-toggle='modal' data-target='#myModal'></a> <img src='" + $video.formats[0].thumbnail +"'/>");
								$('.lesson-options-{{$lessonId}}').find('#video-thumb-container p').text(timeFormat(videoDuration));
								$('#video-player-container-' + $lessonId).find('video').attr('src', $video.formats[0].video_url);

								$('.lesson-options-{{$lessonId}} .buttons.active div#video-thumb-container a').on('click', function(){
									$('#uploadedVideoPlayer').html(videoVariable);
								})
								//$('#video-link-' + $lessonId).removeClass('load-remote-cache').trigger('click');
								//reload video partial
							}
                    }) }, 5000);
                }
            }
        });
    });
</script>