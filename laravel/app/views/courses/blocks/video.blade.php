<div class="text-center">
    <div id="video-player-container">

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
    <h3>{{trans('video.uploadOr')}} <a href="#" class="show-videos-archive-modal" data-lesson-id="{{$lessonId}}">{{trans('video.selectExisting')}}</a></h3>
    <p>{{trans('video.formatsSupported')}}</p>
    <p>{{trans('video.maxFileSize')}}</p>

    {{Form::open(['url' => 'video/upload', 'id' => '', 'files' => true])}}
        <div class="form-inline">
            <div class="form-group">
                <input type="file" name="fileupload" id="fileupload-{{$block->id}}">
            </div>
            <hr/>

        </div>
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

                if ($data.result.videoId !== undefined) {
                    $('#video-player').hide();
                    $('#notify-warning-new-video').removeClass('hide');
                    $.post('/lessons/blocks/' + $lessonId + '/video', {videoId : $data.result.videoId, blockId : $blockId });

                    //Run timer to check for video transcode status
                    $intervalId = setInterval (function() { videoUploader.getVideo($data.result.videoId, function ($video){
                        console.log($video);
                        if ($video.transcode_status == 'Complete'){
                            clearInterval($intervalId);
                            $('#video-link-' + $lessonId).trigger('click');
                            //reload video partial
                        }
                    }) }, 5000);
                }
            }
        });


    });
</script>