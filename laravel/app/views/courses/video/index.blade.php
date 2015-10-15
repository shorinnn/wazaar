{{--
<div class="row">
    <div class="col-md-12 margin-top-10">
        <div class="course-video-upload-processing hidden" align="center">
            <!--<img src="{{url('images/ajax-loader.gif')}}" alt=""/>-->
            <span id="video-transcoding-indicator-course-description" class="video-transcoding-indicator">{{trans('video.videoCurrentlyProcessing')}}</span>
        </div>
        <p>&nbsp;</p>
        <div class="course-video-thumb @if (!$course->descriptionVideo) hidden @endif" align="center" style="padding:5px">
            {{trans('video.currentVideo')}}:
            @if ($course->descriptionVideo)
                <a href="#" id="course-video-anchor" class="video-title" data-filename="{{$course->descriptionVideo->original_filename}}" data-video-url="{{$course->descriptionVideo->formats[0]->video_url}}" onclick="videoModal.show(this, event)">{{$course->descriptionVideo->original_filename}}</a>
            @else
                <a href="#" id="course-video-anchor" class="video-title" data-filename="BfE1cTQk-fighting_cats4.wmv" data-video-url="http://d378r68ica1xoa.cloudfront.net/BfE1cTQk-fighting_cats4.wmv1421660966371o9l23s.mp4" onclick="videoModal.show(this, event)">BfE1cTQk-fighting_cats4.wmv</a>
            @endif
        </div>
    </div>
</div>
--}}


            <div class="course-video-upload-button-progress" id="introduction-video-wrapper">
                <div class="file-processing-handler">
                    <div class="dropdown listing-video-upload
                         @if ($course->descriptionVideo)
                             resource-uploaded
                         @endif
                         ">

                        <div class="upload-dropdown-wrapper">
                            <a id="upload-new" class="default-button" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ trans('courses/general.upload_video') }}
                                <i class="wa-chevron-down"></i>
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="upload-new" style="margin-left:30px">
                                <label for="upload-course-video" class="upload-button">

                                    <span>{{ trans('courses/curriculum.upload') }}</span>
                                    <form action="{{UploadHelper::AWSVideosInputURL()}}" enctype="multipart/form-data" method="POST" class="fileupload">
                                        <input type="hidden" name="key" value="{{$uniqueKey}}">
                                        <input type="hidden" name="AWSAccessKeyId" value="{{Config::get('aws::config.key')}}">
                                        <input type="hidden" name="acl" value="private">
                                        <input type="hidden" name="success_action_status" value="201">
                                        <input type="hidden" name="policy" value="{{$awsPolicySig['base64Policy']}}">
                                        <input type="hidden" name="signature" value="{{$awsPolicySig['signature']}}">
                                        <input type="file" multiple="multiple" name="file" class='upload-banner-image' id="upload-course-video" data-unique-key="{{$uniqueKey}}">
                                    </form>
                                </label>
                                <span class="use-existing use-existing-preview" id="use-existing-video">
                                    <span class="use-existing">
                                        <a href="#" class="course-video-select-existing-anchor">
                                            {{trans('video.selectExisting')}}
                                        </a>
                                    </span>
                                </span>
                                <span>
                                    <span class="use-existing">
                                        <a href="#" onclick="removePromoVideo(event)">{{ trans('video.remove-video') }}</a>
                                    </span>
                                </span>
                            </ul>
                        </div> <!-- //upload-dropdown-wrapper -->

                        <div class="upload-progress-wrapper hidden">

                            <p class="label-progress-bar upload-label-progress-bar-preview-img"></p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active progress-bar-banner" id="progress-course-video" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                     aria-valuemax="100" style="width: 0%;">

                                </div>

                            </div>
                        </div> <!-- //upload-progress-wrapper -->

                        <div class="processing-wrapper hidden">
                            <p class="label-progress-bar label-progress-bar-preview-img">{{trans('video.videoCurrentlyProcessing')}} <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif"></p>
                        </div>

                    </div>
                </div>
            </div>

