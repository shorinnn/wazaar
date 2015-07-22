<div class="shr-lesson shr-lesson-{{$lesson->id}}">
     
    <div class="row lesson-data">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <div class="lesson-name"><span><em></em></span>Lesson 
                <div class="inline-block lesson-module-{{$lesson->module->id}} lesson-order" data-id="{{$lesson->id}}">{{ $lesson->order }}</div></div>
            <div class="preview-thumb">

            </div>
            <label class="default-button large-button upload-button">
                <span>Upload new</span>
                <input type="file" hidden=""/>
            </label>
            <a href="#" class="remove-video">Remove video</a>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            {{ Form::open( ['action' => ['LessonsController@update', $lesson->module->id, $lesson->id ], 'method' => 'PUT', 
                        'class' => 'ajax-form lesson-form-'.$lesson->id, 'data-save-indicator' => '.submit-lesson-'.$lesson->id ] )  }}
                        <div style="display: none">
                                <button type="submit"></button>
                        </div>
            <div>
                <input type="text" name="name" class="lesson-title" placeholder="Enter lesson title" value="{{ $lesson->name }}" >
            </div>
            <div>
                <h6>DESCRIPTION
                    <span class="lead"><span class="characters-desc-{{$lesson->id}}">360</span> Characters left</span>
                </h6>
                <textarea class='characters-left' data-target='.characters-desc-{{$lesson->id}}' maxlength="360" name="description" placeholder="Enter short lesson description...">{{ $lesson->description }}</textarea>
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
<!--    <div class="row file-upload-row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <i class="fa fa-cloud-upload"></i>
            <p class="regular-paragraph">
                Drag & Drop<br> files to upload
            </p>
            <label class="default-button large-button upload-button">
                <i class="fa fa-paperclip"></i>
                <span>Select</span>
                <input type="file" hidden=""/>
            </label>
        </div>                    
    </div>-->
    <div class="row file-upload-row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <i class="fa fa-cloud-upload"></i>
            <p class="regular-paragraph  lesson-dropzone-{{$lesson->id}}" style="border:1px silver dashed; padding:20px;">
                Drag & Drop<br> files to upload
            </p>
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
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 uploaded-files">
            <h6>Files to accompany lesson</h6>
            <ul class=" uploaded-files-{{$lesson->id}}">
                @foreach( $lesson->blocks()->where('type','file')->get() as $file )
                    {{ View::make('courses.editor.v2.file')->with( compact('file') ) }}
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
        </div>
    </div>
</div>