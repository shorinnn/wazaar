<?php
  //NOTE: Not ideal, should be placed in a controller or helper, but this view is loaded from another view

  $block = Block::firstOrCreate(['lesson_id' => $lesson->id, 'type' => Block::TYPE_VIDEO]);
  $video = LessonHelper::getVideoByBlock($block);
  $uniqueKey = Str::random(8);
?>
<div class="shr-lesson shr-lesson-{{$lesson->id}} shr-lesson-editor-{{$lesson->id}}
     if($lesson->module->course->modules()->count()>1 && $lesson->module->lessons()->count()>1)
     lesson-minimized
     endif
     ">
     
    <div class="row lesson-data">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" id="lesson-wrapper-{{$lesson->id}}">
            <div class="lesson-name"><span><em></em></span>Lesson 
                <div class="inline-block lesson-module-{{$lesson->module->id}} lesson-order" data-id="{{$lesson->id}}">{{ $lesson->order }}</div></div>
            <div class="preview-thumb lesson-wrapper">

                @if ($video)

                    @if (@$video->transcode_status == Video::STATUS_COMPLETE)
                        <img class="video-preview" src="{{$video->formats[0]->thumbnail}}" />
                    @else
                        <img src="" alt="" class="hidden video-preview"/>
                    @endif
                @else
                    <img src="" alt="" class="hidden video-preview"/>
                @endif

                <div class="uploading-wrapper margin-top-15 hidden">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                            <span><span class="percent-complete"></span></span>
                        </div>
                    </div>
                </div>
                <div class="processing-wrapper margin-top-15 hidden">
                    Processing
                    <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif">
                </div>
            </div>
            <div class="dropdown text-center lesson-control">
              <a id="upload-new" class="default-button large-button" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Upload new
                <i class="wa-chevron-down"></i>
              </a>
            
              <ul class="dropdown-menu" aria-labelledby="upload-new">
                <label class="upload-button">
                    <span>Upload new video</span>
                    <input type="file" hidden="" id="fileupload-{{$lesson->id}}" name="file" data-unique-key="{{$uniqueKey}}" data-block-id="{{$block->id}}" data-lesson-id="{{$lesson->id}}"/>
                </label>
                <span class="use-existing use-existing-preview" >
                    <span class="use-existing">
                        <a href="#" class="show-videos-archive-modal" data-lesson-id="{{$lesson->id}}">
                            {{trans('video.selectExisting')}}
                        </a> 
                    </span>
                </span>
              </ul>
            </div>

            @if( $lesson->blocks()->where('type','video')->count() > 0  ) 
                <a href="#" class="remove-video lesson-control">Remove video</a>
            @endif
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <a class="edit-icon toggle-minimize"  data-target='.shr-lesson-editor-{{$lesson->id}}' data-class='lesson-minimized'>
                <i class="fa fa-pencil pull-right lesson-toggle-icon-{{$lesson->id}}" data-target='.shr-lesson-editor-{{$lesson->id}}' data-class='lesson-minimized'></i>
            </a>
             <p class='minimized-lesson-elem lesson-{{$lesson->id}}-copy-name'>{{$lesson->name}}</p>
             <p class='minimized-lesson-elem lesson-{{$lesson->id}}-copy-desc'>{{$lesson->description}}</p>
             <div class='minimized-lesson-elem'>
                 <!--<i class='fa fa-quote-left'></i> 1 Note-->
                 
                 <span class="attachments">
                 	<i class='fa fa-paperclip'></i> 
                    <span class='attachment-counter-{{$lesson->id}}'>{{ $lesson->blocks()->where('type','file')->count() }}</span> 
                    Attachments
                </span>
                 <a class="toggle-minimize"  data-target='.shr-lesson-editor-{{$lesson->id}}' data-class='lesson-minimized' data-toggle-icon='.lesson-toggle-icon-{{$lesson->id}}'>
                     <i class='fa fa-chevron-down' data-target='.shr-lesson-editor-{{$lesson->id}}' data-toggle-icon='.lesson-toggle-icon-{{$lesson->id}}' data-class='lesson-minimized'></i> Show</a>
             </div>
             
            <div class='maximized-elem'>
            {{ Form::open( ['action' => ['LessonsController@update', $lesson->module->id, $lesson->id ], 'method' => 'PUT', 
                        'class' => 'ajax-form lesson-form-'.$lesson->id, 'data-save-indicator' => '.submit-lesson-'.$lesson->id,
                     'data-callback' => 'minimizeAfterSave', 'data-elem' => ".shr-lesson-editor-".$lesson->id, 'data-error-list' => '.lesson-errors-'.$lesson->id] )  }}
                        <div style="display: none">
                                <button type="submit"></button>
                        </div>
            <div>
                <input type="text" name="name" class="lesson-title type-in-elements" data-elements='.lesson-{{$lesson->id}}-copy-name'
                       placeholder="Enter lesson title" value="{{ $lesson->name }}" >
            </div>
            <div>
                <h6>DESCRIPTION
                    <span class="lead"><span class="characters-desc-{{$lesson->id}}">360</span> Characters left</span>
                </h6>
                <textarea class='characters-left type-in-elements' data-target='.characters-desc-{{$lesson->id}}' maxlength="360"
                data-elements='.lesson-{{$lesson->id}}-copy-desc' name="description" placeholder="Enter short lesson description...">{{ $lesson->description }}</textarea>
            </div>
            <div>
                <h6>NOTES
                    <span class="lead"><span class="characters-notes-{{$lesson->id}}">360</span> Characters left</span>
                </h6>
                <textarea class='characters-left' data-target='.characters-notes-{{$lesson->id}}' maxlength="360" name="notes" placeholder="Add notes...">{{ $lesson->notes }}</textarea>
            </div>
            <div class="row">
                
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 switch-buttons">
                    <div class="">
                        <h6>Free Preview<span class="tip" data-toggle="tooltip" data-placement="top" title="Some tips here">?</span></h6>
                        <label class="switch">
                            {{ Form::checkbox('free_preview','yes', ($lesson->free_preview=='yes') ? true : false, [
                               'class'=>'switch-input',
                               'onchange' => 'toggleVisibility(event)',
                               'data-target' => ".depends-on-free-$lesson->id",
                               'data-visible' => ($lesson->free_preview=='no') ? 'hide':'show'
                            ] ) }}
                            <!--<input type="checkbox" id="free-preview-{{$lesson->id}}" name="free_preview" value="yes" class="switch-input" />-->
                            <span class="switch-label" data-on="Yes" data-off="No"></span>
                            <span class="switch-handle"></span>
                        </label>
                    </div>
                </div>
                <div class="depends-on-free-{{$lesson->id}} col-xs-4 col-sm-4 col-md-4 col-lg-4 switch-buttons "
                     @if($lesson->free_preview=='yes') style='display:none' @endif">
                    <div class="">
                        <h6>Individual sale <span class="tip" data-toggle="tooltip" data-placement="top" title="Some tips here">?</span></h6>
                        <label class="switch">
                            {{ Form::checkbox('individual_sale','yes', ($lesson->individual_sale=='yes') ? true : false, 
                             ['class'=>'switch-input',
                               'onchange' => 'toggleTheClass(event)',
                               'data-target' => ".depends-on-individual-$lesson->id",
                               'data-class' => 'inactive'
                             ] ) }}
                            <span class="switch-label" data-on="Yes" data-off="No"></span>
                            <span class="switch-handle"></span>
                        </label>
                    </div>
                </div>
                <div class="depends-on-free-{{$lesson->id}} depends-on-individual-{{$lesson->id}} col-xs-4 col-sm-4 col-md-4 col-lg-4 
                     @if($lesson->individual_sale=='no') inactive @endif"
                     @if($lesson->free_preview=='yes') style='display:none' @endif">
                    <div class="clearfix">
                        <h6>Lesson Price <span class="tip" data-toggle="tooltip" data-placement="top" title="Some tips here">?</span></h6>
                        <div class="value-unit-two">
                            <span class="unit">¥</span>
                            <input type="text" name="price" value="{{ $lesson->price }}" class="value">
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="row file-upload-row">
        @if( $lesson->blocks()->where('type','file')->count() > 0)
            <div class="uploader-area col-xs-12 col-sm-3 col-md-3 col-lg-3">
        @else
            <div class="uploader-area col-xs-12">
        @endif
            <i class="fa fa-cloud-upload"></i>
            <p class="regular-paragraph  lesson-dropzone-{{$lesson->id}}" style="border:1px silver dashed; padding:20px;">
                Drag & Drop<br> files to upload
            </p>
                <p class="label-progress-bar label-progress-bar-{{$lesson->id}}"></p>
                <div class="progress" style="display: none">
                    <div class="progress-bar progress-bar-striped active progress-bar-{{$lesson->id}}" role="progressbar" aria-valuenow="0"
                        data-label=".label-progress-bar-{{$lesson->id}}" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        <span></span>
                    </div>
                </div>
            <label class="default-button large-button upload-button">
<!--                <i class="fa fa-paperclip"></i>
                <span>Select</span>
                <input type="file" hidden=""/>-->
            
                <?php
                $filePolicy = UploadHelper::AWSAttachmentsPolicyAndSignature();
                ?>
                <form action="https://{{ $_ENV['AWS_BUCKET'] }}.s3-ap-northeast-1.amazonaws.com" method="post" enctype="multipart/form-data"
                      class='ajax-form' >
                      <input type="hidden" name="key" value="course_uploads/${filename}" data-value="course_uploads/{timestamp}--${filename}">
                      <input type="hidden" name="AWSAccessKeyId" value="{{Config::get('aws::config.key')}}">
                      <input type="hidden" name="acl" value="private">
                      <input type="hidden" name="success_action_status" value="201">
                      <input type="hidden" name="policy" value="{{$filePolicy['base64Policy']}}">
                      <input type="hidden" name="signature" value="{{$filePolicy['signature']}}">


                        <i class="fa fa-paperclip"></i>
                        <span>Select</span>
                        <input type='file' name='file' id='file-upload-{{$lesson->id}}' data-dropzone='.lesson-dropzone-{{$lesson->id}}' 
                       class='lesson-file-uploader' data-upload-to=".uploaded-files-{{$lesson->id}}"
                       data-progress-bar='.progress-bar-{{$lesson->id}}' data-callback='blockFileUploaded' 
                       data-lesson-id='{{$lesson->id}}' data-add-callback='limitLessonFiles' data-max-upload='{{ Config::get('custom.maximum_lesson_files') }}'
                       data-max-upload-error="{{trans('courses/general.max_upload_error')}}" />
                    <!--<input id="uploadFile" placeholder="{{ trans('courses/curriculum.choose-file') }}" disabled="disabled" />-->
                </form>
            </label>
        </div>
        
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 uploaded-files"
              @if( $lesson->blocks()->where('type','file')->count() == 0)
                style='display:none'
              @endif
              >
            
            <div style='display:none'>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active progress-bar-{{$lesson->id}}" role="progressbar" aria-valuenow="0"
                         aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        <span></span>
                    </div>
                </div>
            </div>
            
            <h6>Files to accompany lesson</h6>
            <ul class=" uploaded-files-{{$lesson->id}}">
                @foreach( $lesson->blocks()->where('type','file')->get() as $file )
                    {{ View::make('courses.editor.v2.file')->with( compact('file') )->render() }}
                @endforeach
                
            </ul>
        </div>                    
    </div>
    <div class="row footer-buttons">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="#" class="green-button large-button submit-form submit-lesson-{{$lesson->id}}" data-form='.lesson-form-{{ $lesson->id }}'>Save changes</a>
            <a href="#" class="default-button large-button reset-form" data-form='.lesson-form-{{ $lesson->id }}'>Cancel</a>
            
            <!--<a href="#" class="delete-lesson right"><i class="fa fa-trash-o"></i> Delete this lesson</a>-->
            
            <a href="{{ action('LessonsController@destroy', [ $lesson->module->id, $lesson->id]) }}" class="delete-lesson right link-to-remote-confirm"
                   data-url="{{ action('LessonsController@destroy', [ $lesson->module->id, $lesson->id]) }}" data-callback = 'deleteCurriculumItem' 
                   data-delete = '.shr-lesson-{{$lesson->id}}' data-message="{{ trans('crud/labels.you-sure-want-delete') }}">
                
                    <i class="fa fa-trash-o" data-callback = 'deleteCurriculumItem' data-delete = '.shr-lesson-{{$lesson->id}}'
                       data-message="{{ trans('crud/labels.you-sure-want-delete') }}" 
                       data-url="{{ action('LessonsController@destroy', [ $lesson->module->id, $lesson->id]) }}" ></i> Delete this lesson
                </a>
            <div class='input-error lesson-errors-{{$lesson->id}}'>
             </div>
        </div>
    </div>
</div>

<script type="text/javascript">


    var $intervalId{{$lesson->id}} = 0;

    $(function(){
        videoUploader.initialize({
            'fileInputElem' : $('#fileupload-{{$lesson->id}}'),
            'url': '{{UploadHelper::AWSVideosInputURL()}}',
            'formData' : {
                key:'{{$uniqueKey}}-${filename}',
                AWSAccessKeyId:$('#form-aws-credentials').find('input[name=AWSAccessKeyId]').val(),
                acl:$('#form-aws-credentials').find('input[name=acl]').val(),
                success_action_status:$('#form-aws-credentials').find('input[name=success_action_status]').val(),
                policy:$('#form-aws-credentials').find('input[name=policy]').val(),
                signature:$('#form-aws-credentials').find('input[name=signature]').val()
            },
            'fileAddedCallBack' : function($e, $data){
                var $lessonId = $($data.fileInput[0]).attr("data-lesson-id");
                $('#lesson-wrapper-' + $lessonId).find('.lesson-control').addClass('hidden');
            },
            'progressCallBack' : function ($data, $progressPercentage, $elem){
                var $lessonId = $($data.fileInput[0]).attr("data-lesson-id");
                var $lessonWrapper = $('#lesson-wrapper-' + $lessonId);

                $lessonWrapper.find('.uploading-wrapper').removeClass('hidden');
                $lessonWrapper.find('.progress-bar').css('width', $progressPercentage + '%');

            },
            'failCallBack' : function ($data){

            },
            'successCallBack' : function ($data, $elem){
                var $localLessonId = $($elem.fileInput[0]).attr("data-lesson-id");
                var $localBlockId = $($elem.fileInput[0]).attr("data-block-id");

                var $lessonWrapper = $('#lesson-wrapper-' + $localLessonId);

                $lessonWrapper.find('.uploading-wrapper').addClass('hidden');
                $lessonWrapper.find('.processing-wrapper').removeClass('hidden');


                if ($data.videoId !== undefined) {
                    $.post('/lessons/blocks/' + $localLessonId + '/video', {videoId : $data.videoId, blockId : $localBlockId });
                    console.log('has video id');
                    //Run timer to check for video transcode status
                    $intervalId{{$lesson->id}} = setInterval (function() {
                        console.log('interval running');
                        videoUploader.getVideo($data.videoId, function ($video){

                            if ($video.transcode_status == 'Complete'){

                                $lessonWrapper.find('.processing-wrapper').addClass('hidden');
                                $lessonWrapper.find('.video-preview').attr('src',$video.formats[0].thumbnail);
                                $lessonWrapper.find('.video-preview').removeClass('hidden');
                                $('.lesson-control').removeClass('hidden');

                                clearInterval($intervalId{{$lesson->id}});
                            }
                        }) }, 5000);
                }
            }
        });

    });
</script>