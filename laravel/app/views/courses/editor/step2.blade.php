
<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 left-content">
       			<p class="intro-paragraph">{{ trans('courses/general.step2-title') }}</p>
                <div class="plan-your-curriculum">
                    <ul id="modules-list">
                        @foreach($course->modules()->orderBy('order','ASC')->get() as $module)
                            {{ View::make('courses.modules.module')->with(compact('module')) }}
                        @endforeach
                    </ul>                    
                    <form method='post' class='ajax-form' id="modules-form" data-callback='addModule'
                          action='{{ action('ModulesController@store',[$course->id] )}}'>
                        <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                        <button type='submit' class='add-new-module'>{{ trans('crud/labels.add_module') }}</button>
                    </form>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 right-content">
                {{ Form::model($course, ['action' => ['CoursesController@update', $course->slug], 'data-parsley-validate' => '1',
                'id'=>'edit-course-form', 'files' => true, 'method' => 'PUT', 'class' => 'ajax-form',  'data-callback'=>'saveAndNextTab']) }}
            	<h2>{{ trans('courses/general.course_summary') }}</h2>
            	<div class="row category-row">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">{{ trans('courses/general.category') }}</p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">
                                    {{ Form::select('course_category_id', $categories, $course->course_category_id, ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id_2', 
                                    'data-url'=> action('CoursesCategoriesController@subcategories_instructor'), 'required', 'class'=>'']) }}
                                </p>
                            </div>
                        </div>
                    	<div class="row">
                        	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            	<p class="regular-paragraph">{{ trans('courses/general.subcategory') }}</p>
                            </div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            	<p class="regular-paragraph semibold-text">
                                {{ Form::select('course_subcategory_id', $subcategories, $course->course_subcategory_id,
                                    ['id'=>'course_subcategory_id_2', 'class'=>'']) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--<a href="#" class="edit-button">Edit</a>-->
                </div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>{{ trans('courses/general.description') }}:</h4>
                        <p class="regular-paragraph text-left">
                             {{ strip_tags($course->description) }}
                        </p>
                    </div>
                </div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>{{ trans('courses/general.who_is_this_for?') }}:</h4>
                        <ul>
                        	@if($values = json2Array($course->who_is_this_for))
                                    @foreach($values as $val)
                                        <li>{{$val}}</li>
                                    @endforeach
                                @endif
                        </ul>
                    </div>
               	</div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>{{ trans('courses/general.requirements') }}:</h4>
                        <ul>
                        	@if($values = json2Array($course->requirements))
                                    @foreach($values as $val)
                                        <li>{{$val}}</li>
                                    @endforeach
                                @endif
                        </ul>
                    </div>
               	</div>
				<div class="row margin-top-40">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<h4>{{ trans('courses/general.by_the_end') }}:</h4>
                        <ul>
                        	@if($values = json2Array($course->what_will_you_achieve))
                                    @foreach($values as $val)
                                        <li>{{$val}}</li>
                                    @endforeach
                                @endif
                        </ul>
                    </div>
               	</div>
                <div class="row next-step-button">
                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    	<button class="blue-button extra-large-button">{{ trans('courses/general.next-step') }}</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>



<script type="text/javascript">
//        $(function (){
setTimeout(function(){
               $('.lesson-no-video .video .a-add-video').click();
	       $('.lesson-no-video .video .a-add-video').attr('data-loaded', 1);
            
            enableFileUploader( $('#upload-preview-image') );
            enableFileUploader( $('#upload-banner-image') );
//            enableSlider('#affiliate_percentage');
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

}, 50);



//        });
</script>

<script type="text/javascript">



    
    var $courseVideoInterval;
//
////    jQuery(function(){
//
setTimeout(function(){
        var formData = $('#form-aws-credentials').serialize();

        jQuery('#upload-course-video').fileupload({
            url: '//s3-ap-southeast-1.amazonaws.com/videosinput',
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
        }, 50);

</script>

