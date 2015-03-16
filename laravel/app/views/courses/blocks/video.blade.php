<div class="text-center">
    <div id="video-player-container-{{$lessonId}}">

            <div id="notify-warning-new-video" class="alert alert-warning
                @if (@$video->transcode_status == Video::STATUS_COMPLETE)
                    hide
                @endif
                    "><strong>{{trans('crud/labels.note')}}: </strong>{{trans('video.willAppearHere')}}</div>



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

        var $blockId = {{$block->id}};
        var $lessonId = {{$lessonId}};
        var $intervalId = 0;

        videoUploader.initialize({
            'fileInputElem' : $('#fileupload-' + $blockId),
            'progressCallBack' : function ($data, $progressPercentage){
                $('#progress-bar-' + $blockId).css('width', $progressPercentage + '%');
                $('#percent-complete-' + $blockId).html($progressPercentage);
            },
            'failCallBack' : function ($data){

            },
            'successCallBack' : function ($data){
				console.log("Output after successcallback");
                if ($data.result.videoId !== undefined) {
                    $('#video-player-container-' + $lessonId).find('#video-player').addClass('hide');
                    $('#video-player-container-' + $lessonId).find('#notify-warning-new-video').removeClass('hide');
                    $.post('/lessons/blocks/' + $lessonId + '/video', {videoId : $data.result.videoId, blockId : $blockId });
                    console.log('has video id');
                    //Run timer to check for video transcode status
                    $intervalId = setInterval (function() {
                        console.log('interval running');
						$('.plan-your-curriculum .lesson-options .buttons.active p, .plan-your-curriculum .lesson-options .buttons.active em').css('display', 'block');
						$('.plan-your-curriculum .lesson-options .buttons.active').css({
							width: '120px',
							border: 'solid 1px #b0bfc1'	
						});
						$('.plan-your-curriculum .lesson-options .buttons.active span').addClass('processed');
                        videoUploader.getVideo($data.result.videoId, function ($video){
					console.log($video);
                        if ($video.transcode_status == 'Complete'){
                            clearInterval($intervalId);
							console.log('Uploaded'); 
                            $('#video-player-container-' + $lessonId).find('#notify-warning-new-video').addClass('hide')
                            $('#video-player-container-' + $lessonId).find('#video-player').removeClass('hide');
                            $('#video-player-container-' + $lessonId).find('video').attr('src', $video.formats[0].video_url);
                            //$('#video-link-' + $lessonId).removeClass('load-remote-cache').trigger('click');
                            //reload video partial
                        }
                    }) }, 5000);
                }
            }
        });
    });
</script>