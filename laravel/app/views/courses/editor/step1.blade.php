<!--<form method='post' class='ajax-form' id="create-form" data-callback='followRedirect' 
                  action='{{action('CoursesController@store')}}' data-parsley-validate>-->

<input type='hidden' class='course-id' value='{{ $course->id }}' />


@include('videos.archiveModal')
    <div class="row content-row margin-bottom-20">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
            <h3>{{ trans('courses/create.presentation-graphics') }}</h3>
            <div class="row no-margin">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 main-content">
                    <div class="row">
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 listing-image">
                            <h6>{{ trans('courses/create.listing-image-thumbnail') }}</h6>
                            <div class="file-details relative">
                                <div class="course-listing-image-preview">
                                    @if($course->course_preview_image_id > 0)
                                    <img src="{{ cloudfrontUrl( $course->previewImage->url ) }}" />
                                    @endif
                                </div>

    <!--<p class="regular-paragraph">{{ trans('courses/general.recommended_image_size') }}</p>
    <p class="regular-paragraph">{{ trans('courses/general.available_formats') }}</p>-->
    							<div class="file-processing-handler">
                                    <p class="label-progress-bar label-progress-bar-preview-img-s1"></p>
                                    <div class="progress hidden">
                                        <div class="progress-bar progress-bar-striped active progress-bar-preview" role="progressbar" aria-valuenow="0" 
                                             data-label=".label-progress-bar-preview-img-s1" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="dropdown listing-image-upload
                                         @if($course->course_preview_image_id > 0)
                                             resource-uploaded
                                         @endif
                                         ">
                                      <a id="upload-new" class="default-button large-button" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        {{ trans('courses/general.upload_image') }}
                                        <i class="wa-chevron-down"></i>
                                      </a>
                                    
                                      <ul class="dropdown-menu" aria-labelledby="upload-new" style="margin-left: 30px;">
                                        {{ Form::open(['action' => ['CoursesController@update', $course->slug], 'files' => true, 'method' => 'PUT']) }}
                                            <label for="upload-preview-image" class="upload-button">
                                                <span>{{ trans('courses/general.upload_image') }}</span>
                                                <input type="file" hidden="" class='upload-preview-image' 
                                                       data-upload-url=""
                                                       id="upload-preview-image" name="preview_image" data-dropzone='.dropzone-preview'
                                                       data-progress-bar='.progress-bar-preview' data-callback='courseImageUploaded' 
                                                       data-targez='#use-existing-preview > div > .radio-buttons'
                                                       data-target='.all-img-previews-modal'/>
                                            </label>
                                        </form>
                                        @if($images->count() > 0)
                                        <span class="use-existing use-existing-preview" >
                                            <span class="use-existing">
                                                <a href="#" onclick="$('#existing-previews-modal').modal('show'); return false;">
                                                    {{trans('courses/create.select-existing-image')}}
                                                </a> 
                                            </span>
                                        </span>
                                        @endif
                                      </ul>
                                    </div>
                                </div>
                                <em>{{ trans('courses/create.image-used-for-listings') }}</em>
                            </div>
                            
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 listing-video">
                            <h6>{{ trans('courses/create.introduction-video') }}</h6>
                            @if( $course->free == 'no') 
                                <div class="file-details relative">
                                    <div class="course-description-video-preview">
                                        @if (isset($course->descriptionVideo->formats[0]))
                                            <img data-filename="{{$course->descriptionVideo->original_filename}}" data-video-url='{{ $course->descriptionVideo->formats[0]->video_url }}' onclick="showVideoPreview(this)" src="{{ $course->descriptionVideo->formats[0]->thumbnail }}" />
                                        @endif

                                    </div>
                                    @include('courses.video.index')
                                    
                                    
                                </div>
                                <div class="clearfix"></div>
                                <em>{{ trans('courses/create.video-on-public-course-page') }}</em>
                                
                            @else
                                <div class='external-video-preview preview-course'>
                                    {{ externalVideoPreview($course->external_video_url) }}
                                </div>             
                                <input type="text" class="ajax-updatable" data-course='{{$course->id}}'
                                      data-callback='externalVideoPreview' data-target='.preview-course'
                                      data-url='{{action('CoursesController@updateExternalVideo', $course->id )}}' placeholder='Youtube or Vimeo Link'
                                      data-name='external_video_url' 
                                      id='external-video-course' value="{{ $course->external_video_url }}" />
                
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 side-info">
                    <h4> {{ trans('courses/create.size-and-format') }}</h4>
                    <p class="regular-paragraph">{{ trans('courses/general.recommended_image_size') }} <br> {{ trans('courses/general.available_formats') }}</p>
                    <p class="regular-paragraph">{{ trans('courses/general.video_size') }}</p>
                </div>
            </div>
            <br />
        </div>
    </div>
{{ Form::model($course, ['action' => ['CoursesController@update', $course->slug], 'data-parsley-validate' => '1',
                'id'=>'edit-course-form', 'files' => true, 'method' => 'PUT', 'class' => 'ajax-form step-1-form',  'data-callback'=>'saveAndNextTab' ]) }}

                <span class="use-existing use-existing-preview" id="use-existing-preview">
                    @include('courses.previewsModal')
                </span>
                
    <div class="row content-row margin-bottom-20">
    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
        	<h3>{{ trans('courses/general.course_description') }}</h3>
            	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 main-content">
                    <div>
                        <h6>
                        {{ trans('courses/create.title') }}
                        </h6>
                        {{ Form::text('name', null,['id'=>'name', 'required' => 'required' ] ) }}                    
                    </div>
                    
                    <div>
                        <h6>
                        {{ trans('courses/general.short_description') }}
                        </h6>
                        
                        {{ Form::textarea('short_description', null,['id'=>'short_description', 'required' => 'required', 'maxlength' => 41 ] ) }}
                        <!--<em>{{ trans('courses/create.short-description-tip') }}</em>-->                           
                    </div>
                    
                    <div class="margin-top-50">
                        <h6>
                        {{ trans('courses/general.full_description') }}
                        </h6>
                        {{ Form::textarea('description', null,['id'=>'description'] ) }}  
                        <!--<em>{{ trans('courses/create.short-description-tip') }}</em>-->      
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 side-info">
                	<h4>{{ trans('courses/create.tips') }}</h4>
                    <p class="regular-paragraph">{{ trans('courses/create.description-tips') }}</p>
                </div>
        </div>
    </div>
    <div class="row content-row margin-bottom-20">
    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
        	<h3>{{ trans('courses/general.course_description') }}</h3>
            	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 main-content">
                	<div>
                    	<h4 class="clearfix">{{ trans('courses/create.requirements') }}
                            <span class="lead regular-paragraph">{{ trans('courses/create.reqs-what-users-need') }}</span>                      
                        </h4>
                        <div class="margin-top-20 clearfix requirements-box">
							<?php $i = 1;?>
                            @if($values = json2Array($course->requirements))
                                @foreach($values as $val)
                                <div class="relative clonable-input clearfix clonable-req-{{time().$i}}">
                                    <span class="cloned-number">{{$i}}</span>
                                    <!--<input type='text' name='requirements[]' data-clonable-max='5' value='{{$val}}' class="clonable clonable-{{time().$i}}"  /><br />-->
                                    <!--<a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"><i class="fa fa-times"></i></a>-->
                                    <input type='text' name='requirements[]' class='click-on-enter' data-callback="cloneStep1Box"  data-click='.clonable-req-click' value='{{$val}}' /><br />
                                    <a href="#" tabindex="-1" data-delete=".clonable-req-{{time().$i}}"
                                       class="style-one delete-clonable">
                                        <i class="fa fa-times" data-delete=".clonable-req-{{time().$i}}"></i>
                                    </a>
                                 </div>
                                    <?php ++$i; ?>
                                @endforeach
                            @endif
        
                            <div class="relative clonable-input clearfix clonable-req-{{time().$i}}">
                                <span class="cloned-number">{{$i}}</span>     
                                    <input type='text' name='requirements[]' class='click-on-enter' data-callback="cloneStep1Box"   data-click='.clonable-req-click' 
                                   @if(count($values)==0) required @endif /> 
                                    <a href="#" tabindex="-1" class="style-one delete-clonable"  data-delete=".clonable-req-{{time().$i}}">
                                        <i class="fa fa-times"  data-delete=".clonable-req-{{time().$i}}"></i>
                                    </a>
                            </div>
                        </div>
                        <a href="#" class="clone-field clonable-req-click" onclick="cloneBox(event)" data-class="clonable-req"
                           data-name="requirements[]" data-target=".requirements-box">
                            <i class="fa fa-plus"></i> {{ trans('courses/create.add-requirement') }}
                        </a>
                    </div>
                    <div class="margin-top-80">
                        <h4>{{ trans('courses/general.who_is_this_for') }}
                        	<span class="lead regular-paragraph">{{ trans('courses/create.who-benefits-most') }}</span>
                        </h4>
                        <div class="margin-top-20 clearfix who-box">
                            <?php $i = 1;?>
                            @if($values = json2Array($course->who_is_this_for))
                                @foreach($values as $val)
                                <div class="relative clearfix clonable-input clonable-who-{{time().$i}}">
                                    <span class="cloned-number">{{$i}}</span>
                                    <input type='text' name='who_is_this_for[]' class='click-on-enter' data-callback="cloneStep1Box"  data-click='.clonable-who-click' 
                                           value='{{$val}}' /><br />
                                     <a href="#" tabindex="-1" data-delete=".clonable-who-{{time().$i}}"
                                       class="style-one delete-clonable">
                                        <i class="fa fa-times" data-delete=".clonable-who-{{time().$i}}"></i>
                                    </a>
                                 </div>
                                    <?php ++$i; ?>
                                @endforeach
                            @endif
                            
                            <div class="relative clearfix clonable-input clonable-who-{{time().$i}}">
                                <span class="cloned-number">{{$i}}</span>
                                <input type='text' name='who_is_this_for[]' class='click-on-enter'  data-callback="cloneStep1Box"  data-click='.clonable-who-click' /><br />
                                 <a href="#" tabindex="-1" data-delete=".clonable-who-{{time().$i}}"
                                   class="style-one delete-clonable">
                                    <i class="fa fa-times" data-delete=".clonable-who-{{time().$i}}"></i>
                                </a>
                             </div>
                        </div>
                        
                        <a href="#" class="clone-field clonable-who-click" onclick="cloneBox(event)" data-class="clonable-who"
                           data-name="who_is_this_for[]" data-target=".who-box">
                            <i class="fa fa-plus"></i> {{ trans('courses/create.add-requirement') }}
                        </a>
                        
                    </div>
                    <div class="margin-top-80">
                        <h4>
                                {{ trans('courses/general.by_the_end') }}
                            <span class="lead regular-paragraph">{{ trans('courses/general.skills_to_be_learnt') }}</span>
                        </h4>
                        <div class="margin-top-20 clearfix what-box">
                            <?php $i = 1;?>
                            @if($values = json2Array($course->what_will_you_achieve))
                                @foreach($values as $val)
                                    <div class="relative clearfix clonable-input clonable-what-{{time().$i}}">
                                        <span class="cloned-number">{{$i}}</span>
                                        <input type='text' name='what_will_you_achieve[]' class='click-on-enter'  data-callback="cloneStep1Box"   data-click='.clonable-what-click' 
                                               value='{{$val}}' /><br />
                                         <a href="#" tabindex="-1" data-delete=".clonable-what-{{time().$i}}"
                                           class="style-one delete-clonable">
                                            <i class="fa fa-times" data-delete=".clonable-what-{{time().$i}}"></i>
                                        </a>
                                     </div>
                                    <?php ++$i; ?>
                                @endforeach
                            @endif

                            <div class="relative clearfix clonable-input clonable-what-{{time().$i}}">
                                <span class="cloned-number">{{$i}}</span>
                                <input type='text' name='what_will_you_achieve[]' class='click-on-enter' data-callback="cloneStep1Box"   data-click='.clonable-what-click'  /><br />
                                 <a href="#" tabindex="-1" data-delete=".clonable-what-{{time().$i}}"
                                   class="style-one delete-clonable">
                                    <i class="fa fa-times" data-delete=".clonable-what-{{time().$i}}"></i>
                                </a>
                            </div>  
                        </div> 
                        <a href="#" class="clone-field clonable-what-click" onclick="cloneBox(event)" data-class="clonable-what"
                           data-name="what_will_you_achieve[]" data-target=".what-box">
                            <i class="fa fa-plus"></i> {{ trans('courses/create.add-requirement') }}
                        </a>            
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 side-info">
                	<h4>{{ trans('courses/create.tips')}}</h4>
                    <p class="regular-paragraph">{{ trans('courses/create.reqs-tips') }}</p>
                </div>
        </div>
    </div>
    <div class="row next-step-button">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
        	<button type='button' class="blue-button large-button step-1-save-btn" onclick="saveStep1Form()">{{ trans('courses/general.saving-button') }}</button>
            
            <button type='button' onclick="saveAndNextTab(null)" class="blue-button large-button">{{ trans('courses/general.next-step') }}</button>
        </div>
    </div>

    
    
    
<!--</form>-->
{{ Form::close() }}


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
<script src='{{url('js/Gibberish-AES.js')}}'></script>

<script type="text/javascript">
        $(document).ready(function(){
            fixModalJerk();
        })

        function cloneStep1Box(e){
           e.preventDefault();
           link = $(e.target).attr('data-click');
           
           target = $(link).attr('data-target'); 
           name = $(link).attr('data-name'); 
           cssClass = $(link).attr('data-class'); 
           if( $("[name='"+name+"']").filter(function () { return this.value.length == 0}).length > 0 ) return false;
           $(link).click();
        }
        
        function cloneBox(e){
           e.preventDefault();
           target = $(e.target).attr('data-target'); 
           name = $(e.target).attr('data-name'); 
           cssClass = $(e.target).attr('data-class'); 
                     
           cssClass += '-'+uniqueId();
           $target = $(target);
           newBox = $target.find('.relative').last().clone();
           newBox.removeClass();
           newBox.addClass('relative clonable-input clearfix '+cssClass);
           newBox.find('input').val('');
           newBox.find('.delete-clonable').attr('data-delete', '.'+cssClass);
           newBox.find('.delete-clonable .fa').attr('data-delete', '.'+cssClass);
           $target.append(newBox);
           $(newBox).find('input').focus();
           reorderClonable(name);
        }
        
        $(function (){

             $(window).on('beforeunload', function() {
                changed = '';
                if( form1Changed && isModifiedForm('#edit-course-form') ){
                    changed += _('Step 1');
                }
                if( form3Changed && isModifiedForm('#edit-course-form-s3') ){
                    if(changed!='') changed+= ', ';
                    changed += _(' Step 3');
                }
                if(changed!='') return changed +_(" changes haven't been saved");
             });
            
            $('.course-description-video-preview').click(function(){
                $('#course-video-anchor').click();
            });
            function checkStep1(){
                if( $('.step-1-form').parsley().isValid() && tinyMCE.get('description').getContent() !='' && $('.step-1-filled').val()=='0' ) {
                    $('.step-1-filled').val('1');
                    updateStepsRemaining();
                }
            }
            
            $('.step-1-form input').change(function(){
                checkStep1();
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
                        $('.course-description-video-preview').html("<img onclick='showVideoPreview(this)' data-video-url='"+$video.formats[0].video_url+"' src='" +  $video.formats[0].thumbnail + "' />");
                    });
                    return;
                }

                //lesson video
                if ($lessonId !== undefined && $videoId !== undefined){

                    $.post('/lessons/blocks/' + $lessonId + '/video/assign',{videoId : $videoId}, function ($video){
                        var $lessonWrapper = $('#lesson-wrapper-' + $lessonId);
                        $lessonWrapper.find('.video-preview').attr('src',$video.formats[0].thumbnail);
                        $lessonWrapper.find('.video-preview').attr('data-video-url',$video.formats[0].video_url);
                    },'json');
                }

            });
            enableFileUploader( $('#upload-preview-image') );
            enableFileUploader( $('#upload-banner-image') );
            
            $('textarea').each(function(){
                if( $(this).attr('id') != 'short_description' ){
                    enableRTE( '#'+$(this).attr('id'), function(){
                        checkStep1();
                    } );
                }
            });

            $('#btn-close-previews').on('click', function (){
                $('#selected-previews').html('');
                if($('.image-thumb-box input:radio:checked').length > 0){
                        console.log($('.image-thumb-box input:radio:checked').parent().parent().find('img').attr('src'));
                        $('.course-listing-image-preview').html("<img src='" +  $('.image-thumb-box input:radio:checked').parent().parent().find('img').attr('src') + "' />");
                        var $courseId = $('.course-id').val();
                        val = $('[name="course_preview_image_id"]:checked').val();
                        $.post('/courses/'+ $courseId +'/set-field/',{name: 'course_preview_image_id', val: val});
                }
                //$('.thumb-container').each(function (){
                   // console.log($(this).find('img').attr('src'));
                        //$('#selected-previews').append("<img width='100' src='" +  $(this).parent().find('img').attr('src') + "' />");
                    //$('.course-listing-image-preview').html("<img src='" +  $(this).find('img').attr('src') + "' />");
                //});
            });

            $('#btn-close-previews-banner').on('click', function (){
                $('#video-selected-previews').html('');
                $('.display-border').each(function (){
                    console.log($(this).parent().find('img').attr('src'));
                    $('#video-selected-previews').append("<img width='100' src='" +  $(this).parent().find('img').attr('src') + "' />");
                });
            });


     
    var $courseVideoInterval;
        var formData = $('#form-aws-credentials').serialize();
        var $vidUpload = jQuery('#upload-course-video');
        $vidUpload.fileupload({
            dropzone:null,
            url: '{{UploadHelper::AWSVideosInputURL()}}',
            formData: {
                key:$('#form-aws-credentials').find('input[name=key]').val(),
                AWSAccessKeyId:$('#form-aws-credentials').find('input[name=AWSAccessKeyId]').val(),
                acl:$('#form-aws-credentials').find('input[name=acl]').val(),
                success_action_status:$('#form-aws-credentials').find('input[name=success_action_status]').val(),
                policy:$('#form-aws-credentials').find('input[name=policy]').val(),
                signature:$('#form-aws-credentials').find('input[name=signature]').val()
            }
        }).bind('fileuploadadd', function (e, data) {

            var uploadErrors = [];
            var acceptedFileTypes =  ['video/mp4', 'video/flv', 'video/wmv', 'video/avi', 'video/mpg', 'video/mpeg', 'video/MP4', 'video/FLV', 'video/WMV', 'video/AVI', 'video/MPG', 'video/MPEG' ,'video/mov', 'video/MOV','video/quicktime'];
            //console.log(data.originalFiles[0].type);
            if(acceptedFileTypes.indexOf(data.originalFiles[0].type) < 0) {
                uploadErrors.push(_('Not an accepted file type'));
            }
            if(data.originalFiles[0].size && data.originalFiles[0].size > 2000000000) {//75654966 / 1000000000
                uploadErrors.push(_('Filesize is too big'));
            }
            if(uploadErrors.length > 0) {
                alert(uploadErrors.join("\n"));
                return false;
            } else {
                $('#introduction-video-wrapper').find('.upload-progress-wrapper').removeClass('hidden');
                $('#introduction-video-wrapper').find('.upload-dropdown-wrapper').addClass('hidden');
                data.submit();
            }
            window.reloadConfirm = true;

        }).on('fileuploadprogress', function ($e, $data) {

            var $progress = parseInt($data.loaded / $data.total * 100, 10);
            $('.upload-label-progress-bar-preview-img').html($progress + '%');
            $('#progress-course-video').css('width',$progress + '%');
            $('#progress-course-video-percent-complete').html($progress + '%');

        }).bind('fileuploaddone', function ($e, $data) {
            window.reloadConfirm = false;
            //$('.course-video-upload-button-progress').addClass('hidden');
            //$('.course-video-upload-processing').removeClass('hidden');
            $('#introduction-video-wrapper').find('.upload-progress-wrapper').addClass('hidden');
            $('#introduction-video-wrapper').find('.processing-wrapper').removeClass('hidden');


            $('.course-video-thumb').addClass('hidden');
            var count = 0;

            setInterval(function(){
                count++;
                //document.getElementById('video-transcoding-indicator-course-description').innerHTML = _("Video Currently Processing") + new Array(count % 4).join('.');
            }, 500);

            if ($data.jqXHR.status == 201){
                if ($data.files[0].name !== undefined){
                    var $elem = $(this)[0];
                    var $courseId = $('.course-id').val();

                    $.post('/video/add-by-filename',{videoFilename: $data.files[0].name, uniqueKey: $data.uniqueKey}, function ($response){
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
                                        $('.course-description-video-preview').html("<img onclick='showVideoPreview(this)' data-video-url='"+$video.formats[0].video_url+"' src='" +  $video.formats[0].thumbnail + "' />");
                                        $('.course-video-thumb').removeClass('hidden');
                                        $('.course-video-upload-button-progress').removeClass('hidden');
                                        $('#progress-course-video').css('width','0%');

                                        $('#introduction-video-wrapper').find('.upload-progress-wrapper').addClass('hidden');
                                        $('#introduction-video-wrapper').find('.processing-wrapper').addClass('hidden');
                                        $('#introduction-video-wrapper').find('.upload-dropdown-wrapper').removeClass('hidden');

                                        console.log('CHANGED THUMBNAIL!');
                                        console.log($video);
                                    }
                                }
                            });
                        },5000);
                    },'json');
                }
            }
        });
        
           });
        
        

</script>



@stop