<div class="row">
    <div class="col-md-12">
        <div class="image-upload">
            <h3>Course Video</h3>
            <div class="course-video-upload-button-progress">
                <label for="upload-course-video" class="uploadFile">
                    <!--<div class="upload-file-button">{{ trans('crud/labels.upload_your_file') }}</div>-->
                    <span>{{ trans('courses/curriculum.upload') }}</span>
                    <form action="//s3-ap-southeast-1.amazonaws.com/videosinput" enctype="multipart/form-data" method="POST" class="fileupload">
                        <input type="hidden" name="key" value="{{Str::random(8)}}-${filename}">
                        <input type="hidden" name="AWSAccessKeyId" value="{{Config::get('aws::config.key')}}">
                        <input type="hidden" name="acl" value="private">
                        <input type="hidden" name="success_action_status" value="201">
                        <input type="hidden" name="policy" value="{{$awsPolicySig['base64Policy']}}">
                        <input type="hidden" name="signature" value="{{$awsPolicySig['signature']}}">
                        <input type="file" multiple="multiple" name="file" class='upload-banner-image' id="upload-course-video">
                    </form>
                </label>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active progress-bar-banner" id="progress-course-video" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                         aria-valuemax="100" style="width: 0%;">
                        <span></span>
                    </div>
                </div>

            </div>

            <div class="course-video-upload-processing hidden">
                Processing video please wait...
            </div>


            <span class="use-existing use-existing-preview" id="use-existing-video">
                <span class="use-existing">
                    <em class="or-text"> {{ trans('site/login.or') }}</em>
                    <a href="#">
                        {{trans('video.selectExisting')}}
                    </a>
                </span>
            </span>
        </div>
    </div>
</div>

