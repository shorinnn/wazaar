<!--<form method='post' class='ajax-form' id="create-form" data-callback='followRedirect' 
                  action='{{action('CoursesController@store')}}' data-parsley-validate>-->
<input type='hidden' class='course-id' value='{{ $course->id }}' />

    {{ Form::model($course, ['action' => ['CoursesController@update', $course->slug], 'data-parsley-validate' => '1',
                'id'=>'edit-course-form', 'files' => true, 'method' => 'PUT', 'class' => 'ajax-form step-1-form',  'data-callback'=>'saveAndNextTab']) }}
@include('videos.archiveModal')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 left-content">
    <div class="row">
        
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <p class="intro-paragraph">{{ trans('courses/general.details_for_public_course_page') }}</p>
                <h4>
                {{ trans('courses/create.give-title') }}
                </h4>
                    {{ Form::text( 'name', null, ['class' => 'has-slug', 'placeholder'=>'Course Name', 'data-slug-target' => '#slug' ]) }}
                    {{ Form::hidden( 'slug', null, ['id'=>'slug'] ) }}
            </div>
    </div>
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!--<p class="intro-paragraph">{{ trans('courses/general.details_for_public_course_page') }}</p>-->
            <h4>
            {{ trans('courses/general.short_description') }}
            <span class="lead">{{ trans('courses/general.used_on_listings_description') }}</span>
            </h4>
            {{ Form::textarea('short_description', null,['id'=>'short_description'] ) }}       
        	</div>
    </div>
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>
            {{ trans('courses/general.full_description') }}
            <span class="lead">{{ trans('courses/general.used_on_description_page') }}</span>
            </h4>
			{{ Form::textarea('description', null,['id'=>'description'] ) }}        
            </div>
    </div>
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 who-its-for">
                <h4>{{ trans('courses/create.course-requirements') }}
                    <span class="lead">{{ trans('courses/create.what-users-should-know') }}</span>
                </h4>
                    
                    <?php $i = 1;?>
                    @if($values = json2Array($course->requirements))
                        @foreach($values as $val)
                        <div class="relative clonable-{{time().$i}}">
                            <span>{{$i}}</span>
                            <input type='text' name='requirements[]' data-clonable-max='5' value='{{$val}}' class="clonable clonable-{{time().$i}}"  /><br />
                             <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
                         </div>
                            <?php ++$i; ?>
                        @endforeach
                    @endif

                    <div class="relative clonable-{{time().$i}}">
                        <span>{{$i}}</span>     
                            <input type='text' name='requirements[]' data-clonable-max='5' class="clonable clonable-{{time().$i}}"
                           @if(count($values)==0) required @endif /> 
                            <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
                    </div>
            </div>
    </div>
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 who-its-for">
            <h4>{{ trans('courses/general.who_is_this_for') }}
                    <span class="lead">{{ trans('courses/general.who-benefits-most') }}</span>
            </h4>
                
                <?php $i = 1;?>
                @if($values = json2Array($course->who_is_this_for))
                    @foreach($values as $val)
                    <div class="relative clonable-{{time().$i}}">
                        <span>{{$i}}</span>
                        <input type='text' name='who_is_this_for[]' data-clonable-max='5' value='{{$val}}' class="clonable clonable-{{time().$i}}"  /><br />
                         <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
                     </div>
                        <?php ++$i; ?>
                    @endforeach
                @endif
                
            <div class="relative">
                    <span>{{$i}}</span>  
                    <input type='text' name='who_is_this_for[]'  class="clonable clonable-{{time().$i}}"  
                           @if(count($values)==0) required @endif />
                    <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 what-you-will-achieve">
            <h4>
                    {{ trans('courses/general.by_the_end') }}
                <span class="lead">{{ trans('courses/general.skills_to_be_learnt') }}</span>
            </h4>
                <?php $i = 1;?>
                @if($values = json2Array($course->what_will_you_achieve))
                    @foreach($values as $val)
                        <div class="relative clonable-{{time().$i}}">
                            <span>{{$i}}</span>
                            <input type='text' name='what_will_you_achieve[]' data-clonable-max='5' value='{{$val}}' class="clonable clonable-{{time().$i}}"  /><br />
                             <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
                         </div>
                        <?php ++$i; ?>
                    @endforeach
                @endif
            <div class="relative">
                    <span>{{$i}}</span>  
                    <input type='text' name='what_will_you_achieve[]'  class="clonable clonable-{{time().$i}}"  
                           @if(count($values)==0) required @endif /> 
                    <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
            </div>
            <!--<a href="#" class="transparent-button add-input">add</a>-->
        </div>
    </div>
</div>
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 right-content">
    <div class="row category-row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <p class="regular-paragraph">{{ trans('courses/general.category') }}</p>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <p class="regular-paragraph semibold-text">
                        <!--{{$course->courseCategory->name}}-->
                        {{ Form::select('course_category_id', $categories, $course->course_category_id, ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 
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
                        <!--{{$course->courseSubcategory->name}}-->
                        {{ Form::select('course_subcategory_id', $subcategories, $course->course_subcategory_id,
                                    ['id'=>'course_subcategory_id', 'class'=>'']) }}
                    </p>
                </div>
            </div>
        </div>
        <!--<a href="#" class="edit-button">Edit</a>-->
    </div>
    <div class="row margin-top-40 listing-image">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>
            {{ trans('courses/general.listing_image_thumbnail') }}
            <span class="lead">{{ trans('courses/general.listing_image_tip') }}</span>
            </h4>
            <div class="file-details">
                <p class="regular-paragraph">{{ trans('courses/general.recommended_image_size') }}</p>
                <p class="regular-paragraph">{{ trans('courses/general.available_formats') }}</p>
                <label for="upload-preview-image" class="default-button large-button">
                    <span>{{ trans('courses/general.upload_image') }}</span>
                    <input type="file" hidden="" class='upload-preview-image' 
                           id="upload-preview-image" name="preview_image" data-dropzone='.dropzone-preview'
                       data-progress-bar='.progress-bar-preview' data-callback='courseImageUploaded' 
                       data-targez='#use-existing-preview > div > .radio-buttons'
                       data-target='#selected-previews'/>
                </label>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active progress-bar-preview" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        <span></span>
                    </div>
                </div>
                @if($images->count() > 0)
                    <span class="use-existing use-existing-preview" id="use-existing-preview">
                        <span class="use-existing">
                            <em class="or-text"> {{ trans('site/login.or') }}</em>
                            <a href="#" onclick="$('#existing-previews-modal').modal('show'); return false;">
                                    {{trans('video.selectExisting')}}
                            </a> 
                        </span>
                        @include('courses.previewsModal')
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="row margin-top-40 listing-video">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h4>
             {{ trans('courses/general.introduction_video') }}
                    <span class="lead">{{ trans('courses/general.introduction_video_tip') }}</span>
            </h4>
                <div class="file-details">
                    @include('courses.video.index')
                </div>
                
               <?php
                /*
            <div class="file-details">
                <p class="regular-paragraph">{{ trans('courses/general.video_size') }}</p>
                <label for="upload-banner-image" class="default-button large-button">
                        <!--<div class="upload-file-button">{{ trans('crud/labels.upload_your_file') }}</div>-->
                        <span>{{ trans('courses/general.upload_video') }}</span>
                         <input type="file" class='upload-banner-image' name="banner_image" data-dropzone='.dropzone-preview'
                         data-progress-bar='.progress-bar-banner' data-callback='courseImageUploaded' id="upload-banner-image"
                         data-targezt='#use-existing-banner > div > .radio-buttons'
                         data-target='#video-selected-previews' />

                </label>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active progress-bar-banner" role="progressbar" aria-valuenow="0" aria-valuemin="0" 
                         aria-valuemax="100" style="width: 0%;">
                        <span></span>
                    </div>
                </div>
                <span class="use-existing use-existing-preview" id="use-existing-banner">
                    <span class="use-existing">
                        <em class="or-text"> {{ trans('site/login.or') }}</em>
                        <a href="#" onclick="$('#video-banner-existing-previews-modal').modal('show'); return false;">
                                {{trans('video.selectExisting')}}
                        </a> 
                    </span>
                    @include('courses.videoBannerpreviewsModal')
                        <div class="row">
                            <div class="radio-buttons clearfix">
                                <?php
//                              	@if($bannerImages->count() > 0)
//                                  @foreach($bannerImages as $img)
//                                  	{{ View::make('courses.preview_image')->with(compact('img')) }}
//                                  @endforeach
//                                  @endif
                                ?>
                        </div>
                    </div>
                </span>
            </div>*/
                ?>
        </div>
    </div>
    <div class="row next-step-button">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <button class="blue-button extra-large-button">{{ trans('courses/general.next-step') }}</button>
        </div>
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
<script type="text/javascript">

        $(function (){
            
            $('.step-1-form input').change(function(){
                if( $('.step-1-form').parsley().isValid() && $('.step-1-filled').val()=='0' ) {
                    $('.step-1-filled').val('1');
                    updateStepsRemaining();
                    
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
            });
            enableFileUploader( $('#upload-preview-image') );
            enableFileUploader( $('#upload-banner-image') );
            
            $('textarea').each(function(){
                if( $(this).attr('id') != 'short_description' ){
                    enableRTE( '#'+$(this).attr('id') );
                }
            });
                $('#btn-close-previews').on('click', function (){
                    $('#selected-previews').html('');
                    $('.display-border').each(function (){
                        console.log($(this).parent().find('img').attr('src'));
                        $('#selected-previews').append("<img width='100' src='" +  $(this).parent().find('img').attr('src') + "' />");
                    });
                });
                
                $('#btn-close-previews-banner').on('click', function (){
                    $('#video-selected-previews').html('');
                    $('.display-border').each(function (){
                        console.log($(this).parent().find('img').attr('src'));
                        $('#video-selected-previews').append("<img width='100' src='" +  $(this).parent().find('img').attr('src') + "' />");
                    });
                });


        });
</script>



@stop