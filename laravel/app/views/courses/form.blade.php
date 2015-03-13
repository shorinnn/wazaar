@extends('layouts.default')
@section('page_title')
    {{ $course->name }} - Edit -
@stop

@section('content')
<style>
    #save-indicator{
        border:1px solid black;
        background-color:white;
        width:90px;
        height:30px;
        position:fixed;
        top:100px;
        left:-100px;
        text-align: right;
        padding-right: 10px;
    }
</style>
@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if (Session::get('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
<div class="container instructor-course-editor">
	<div class="row">
    	<div class="col-md-12">

            <div role="tabpanel">
                <div class="header clearfix">
                    <a href='{{action("CoursesController@myCourses")}}' class="all-my-courses btn btn-link">{{ trans('courses/general.all_my_courses') }}</a>
                
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills" id="instructor-editor" role="tablist">
                        <li role="presentation" class="active right-twenty-margin">
                            <a href="#course-edit" aria-controls="course-edit" role="tab" data-toggle="tab">Course Edit</a>
                        </li>
                        <li role="presentation">
                            <a href="#curriculum-tab" aria-controls="curriculum-tab" role="tab" data-toggle="tab">Curriculum</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                  <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Course Edit contents here -->
                    <div role="tabpanel" class="tab-pane fade in active" id="course-edit">
                    	<div class="row">
                        	<div class="col-md-12">
                            	<div id="top-form">
                                    {{ Form::model($course, ['action' => ['CoursesController@update', $course->slug], 'id' =>'create-form', 
                                                'files' => true, 'method' => 'PUT', 'class' => 'ajax-form', 'data-callback'=>'formSaved'])}}
                            
                                    <div class="clearfix">
                                    	<label>{{ trans('courses/general.privacy_status') }} </label>
                                        <span class="custom-dropdown">
                                            {{ Form::select('privacy_status', [ 'private' => 'Private', 'public' => 'Public']) }}
                                        </span>
                                    </div>    
                                                
                                    <div class="clearfix">
                                    	<label>{{ trans('courses/general.enable_ask_coach') }} </label>
                                        <span class="custom-dropdown">
                                            {{ Form::select('ask_teacher', [ 'enabled' => 'Yes', 'disabled' => 'No']) }}
                                        </span>
                                    </div>    
                                    
                                    <div class="clearfix">
                                    	<label>{{ trans('courses/general.category') }}</label>                                        
                                        <span class="custom-dropdown">
                                            {{ Form::select('course_category_id', $categories, $course->course_category_id, 
                                    ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 
                                                    'data-url'=> action('CoursesCategoriesController@subcategories'), 'required']) }}
                                                    
                                        </span>
                                    </div>   
                                    
                                    <div class="clearfix">
                                    	<label>{{ trans('courses/general.subcategory') }}</label> 
                                        <span class="custom-dropdown">
                                            {{ Form::select('course_subcategory_id', $subcategories, $course->course_subcategory_id,
                                    ['id'=>'course_subcategory_id'] ) }}
                                        </span>
                                    </div>    
                                    <div class="course-level btn-group clearfix" data-toggle="buttons">
                                        <span>{{ trans('courses/general.difficulty') }}</span>
                                        	<div>
                                                 @foreach($difficulties as $key=>$difficulty)
                                                 <?php
                                                    $checked = ($key==$course->course_difficulty_id) ? 'checked="checked"' : '';
                                                    $active = ($key==$course->course_difficulty_id) ? 'active' : '';
                                                 ?>
                                                    <label class="btn btn-primary {{$active}}">
                                                        <input type='radio' name='course_difficulty_id' id="option{{$key}}" 
                                                        autocomplete="off" value='{{$key}}' 
                                                        required {{$checked}} /> {{$difficulty}}
                                                    </label>
                                                 @endforeach
                                             </div>
                                    </div>
                            
                                    <div>
                                        <label>{{ trans('crud/labels.name') }} </label>
                                        {{ Form::text( 'name', null, ['class' => 'has-slug', 'data-slug-target' => '#slug' ]) }}
                                        {{ Form::hidden( 'slug', null, ['id'=>'slug'] ) }}
                                    </div>
                                                
                                    <div>
                                        <label>{{ trans('crud/labels.assigned_instructor') }} 
                                            <small>( will refactor so it doesnt list all instructors ever )</small></label>
                                         <span class="custom-dropdown">
                                            {{ Form::select( 'assigned_instructor_id', $assignableInstructors) }}
                                         </span>
                                    </div>
                                    <div>
                                        <label>{{ trans('crud/labels.display_instructor') }} </label>
                                        <span class="custom-dropdown">
                                            {{ Form::select( 'details_displays', ['instructor' => 'Course Owner Instructor', 
                                                                                'assigned_instructor' => 'Assigned Instructor' ] ) }}
                                        </span>
                                    </div>
                                    <div>
                                        <label>{{ trans('crud/labels.display_bio') }} </label> 
                                        <span class="custom-dropdown">
                                            {{ Form::select( 'show_bio', ['default' => 'Default Instructor Bio', 'custom' => 'Custom Course Bio' ] ) }}
                                        </span>
                                    </div>
                                    <div>
                                        <label>{{ trans('crud/labels.custom_bio') }} </label>
                                        {{ Form::textarea( 'custom_bio' ) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-12">
                                <div class="image-upload">
                                	<h3>{{ trans('courses/general.preview_image') }}</h3>
                                    <!--<label for="upload-preview-image">
                                            <div class="upload-file-button">{{ trans('crud/labels.upload_your_file') }}</div>
                                    </label>-->
                                     
                                    <label for="upload-preview-image" class="uploadFile">
                                    	<span>Upload</span>
                                    	<input type="file" hidden="" class='upload-preview-image' name="preview_image" data-dropzone='.dropzone-preview'
                                           data-progress-bar='.progress-bar-preview' data-callback='courseImageUploaded' data-target='.use-existing-preview' />
                                    	
                                    </label>
                                    <!--<input disabled="disabled" placeholder="Choose File" id="uploadFile">
                                    <div class="fileUpload btn btn-primary">
                                        <span>Browse</span>
                                        <input type="file" data-callback="replaceElementWithUploaded" data-progress-bar=".progress-bar-1" class="ajax-file-uploader upload" data-replace="#category-graphics-1" data-dropzone="" id="file-upload-1" name="file">
                                    </div>-->
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped active progress-bar-preview" role="progressbar" aria-valuenow="0" aria-valuemin="0" 
                                                 aria-valuemax="100" style="width: 0%;">
                                                <span></span>
                                            </div>
                                        </div>
                                        
                                        
                                        <span class="use-existing use-existing-preview">
                                        @if($images->count() > 0)
                                        <span class="use-existing">{{ trans('crud/labels.or_use_existing') }}:</span>
                                        	<div class="row">
                                            	<div class="radio-buttons clearfix">
                                            @foreach($images as $img)
                                                {{ View::make('courses.preview_image')->with(compact('img')) }}
                                            @endforeach
                                            	</div>
                                            </div>
                                        @endif
                                        </span>                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-12">
                                <div class="image-upload">
                                	<h3>{{ trans('courses/general.details_page_banner_image') }}</h3>
                                    <label for="upload-banner-image" class="uploadFile">
                                            <!--<div class="upload-file-button">{{ trans('crud/labels.upload_your_file') }}</div>-->
                                            <span>Upload</span> 
                                             <input type="file" class='upload-banner-image' name="banner_image" data-dropzone='.dropzone-preview'
                                             data-progress-bar='.progress-bar-banner' data-callback='courseImageUploaded' 
                                             data-target='.use-existing-banner' />
	                                    	
                                    </label>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped active progress-bar-banner" role="progressbar" aria-valuenow="0" aria-valuemin="0" 
                                                 aria-valuemax="100" style="width: 0%;">
                                                <span></span>
                                            </div>
                                        </div>
                                        
                                        <span class="use-existing use-existing-preview">
                                            @if($bannerImages->count() > 0)
                                            <span class="use-existing">{{ trans('crud/labels.or_use_existing') }}:</span>
                                        		<div class="row">
                                            		<div class="radio-buttons clearfix">
                                                @foreach($bannerImages as $img)
                                                    {{ View::make('courses.preview_image')->with(compact('img')) }}
                                                @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </span>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-12">
                                <div class="who-its-for">
                                	<h3>{{ trans('courses/general.who_is_this_for') }}</h3>
                                        <?php $i = 1;?>
                                        @if($values = json2Array($course->who_is_this_for))
                                            @foreach($values as $val)
                                            <div class="clonable-{{time().$i}}">
                                                 <span>{{$i}}</span>
                                                 <input type='text' name='who_is_this_for[]' value='{{$val}}' class="clonable clonable-{{time().$i}}" />
                                                 <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
                                             </div>
                                                <?php ++$i; ?>
                                            @endforeach
                                        @endif
                                            <div class="clonable-{{time().$i}}">
                                                 <span>{{$i}}</span>
                                                 <input type='text' name='who_is_this_for[]' class="clonable clonable-{{time().$i}}" />
                                                 <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
                                             </div>
                                    </div>    
                                <div class="what-you-will-achieve">
                                	<h3>{{ trans('courses/general.what_will_you_achieve') }} </h3>
                                        @if($values = json2Array($course->what_will_you_achieve))
                                         <?php $i = 1;?>
                                            @foreach($values as $val)
                                            <div class="clonable-{{time().$i}}">
                                                 <span>{{$i}}</span>
                                                <input type='text' name='what_will_you_achieve[]' value='{{$val}}' class="clonable clonable-{{time().$i}}"  /><br />
                                                 <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
                                             </div>
                                                <?php ++$i; ?>
                                            @endforeach
                                        @endif
                                            <div class="clonable-{{time().$i}}">
                                                 <span>{{$i}}</span>
                                                 <input type='text' name='what_will_you_achieve[]' class="clonable clonable-{{time().$i}}" />
                                                 <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
                                            </div>
                                    </div>    
                                <div class="description-editor-box">
                                	<h3>{{ trans('crud/labels.description') }} </h3>
                                	<div class="description-box">{{ Form::textarea('description', null,['id'=>'description'] ) }}</div>
                                </div>    
                                <div>
                                	<h3>{{ trans('crud/labels.short_description') }} </h3>
                                	<div class="description-box">{{ Form::textarea('short_description', null,['id'=>'short_description'] ) }}</div>
                                </div>    
                                
                                <div class="payment-section">
                                    <div class="clear clearfix margin-bottom-20">
                                    	<label>{{ trans('courses/general.payment_type') }} </label>
                                        <span class="custom-dropdown">
                                        {{ Form::select('payment_type', [ 'one_time' => trans('courses/general.one_time'), 
                                        'subscription' =>  trans('courses/general.subscription') ] ) }}
                                        </span>
                                    </div>    
                                    <div class="clear clearfix margin-bottom-20">
                                    	<label>{{ trans('courses/general.price') }}</label> 
                                        {{  Form::text( 'price', money_val($course->price) ) }}
                                    </div>    
                                    
                                    <div class="clear clearfix">
                                    	<div class="percentage-slider">
                                            <label>{{ trans('courses/general.affiliate_percentage') }}  </label>   
                                            <div>                                   
                                                <input type="text" class='span2 clear right' name='affiliate_percentage' id='affiliate_percentage' 
                                                    value="{{ $course->affiliate_percentage }}" data-slider-min="0" data-slider-max="70" 
                                                    data-slider-step="1" data-slider-value="{{ $course->affiliate_percentage }}" 
                                                    data-slider-orientation="horizontal" 
                                                    data-slider-selection="after" data-slider-tooltip="show" data-label="#affiliate_percentage_output" 
                                                    data-target-input='1' />
                                                
                                                <input type='number' id='affiliate_percentage_output' class='set-slider clear margin-bottom-20' max="70" min="0"
                                                       value='{{ $course->affiliate_percentage }}' data-slider='#affiliate_percentage' />%
                                             </div>
                                         </div>
                                        <div class="clear clearfix margin-bottom-20">
                                        	<label>{{ trans('courses/general.discount') }} </label>
                                                {{ Form::text('sale', money_val($course->sale)) }}
                                                <div class="custom-dropdown discount margin-top-20">
                                                	{{ Form::select('sale_kind', ['amount' => '$', 'percentage' => '%'] ) }}
                                                </div>
                                        </div>    
                                        <div class="clear clearfix margin-bottom-20">
                                            <label>{{ trans('courses/general.sale_ends_on') }}</label>  
                                            {{ Form::text('sale_ends_on') }}
                                        </div>    
                                        <div class="clear clearfix margin-bottom-20">
                                               <button type="submit" class="btn btn-primary submit-button">{{ trans('crud/labels.update') }}</button>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                       </div>	 
                   </div>        
                   
                <!-- Curriculum contents here -->
                <div role="tabpanel" class="tab-pane fade" id="curriculum-tab">
                    <div class="container course-editor">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class='icon'>{{$course->name}}</h1>   
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="what-to-achieve">
                                    <h3>{{ trans('courses/create.by_the_end') }}</h3>
                                    @foreach( json2Array($course->what_will_you_achieve) as $skill)
                                        <ul>
                                            <li>{{ $skill }}</li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="who-for">
                                    <h3>{{ trans('courses/curriculum.for_those_who') }}</h3>
                                    @foreach( json2Array($course->who_is_this_for) as $for)
                                        <ul>
                                            <li>{{ $for }}</li>
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="plan-your-curriculum">
                                    <h2>{{ trans('courses/curriculum.plan_out') }}
                                    <span>{{ trans('courses/curriculum.outline_modules') }}</span>
                                    </h2>
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
                        </div>
                </div>
                @include('videos.archiveModal')
                </div>
                </div>
                
            </div>
		</div>
	</div>
</div>
@stop

@section('extra_js')
<script src="{{url('plugins/uploader/js/vendor/jquery.ui.widget.js')}}"></script>
<script src="{{url('plugins/uploader/js/jquery.iframe-transport.js')}}"></script>
<script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}"></script>
<script src="{{url('plugins/slider/js/bootstrap-slider.js')}}"></script>
<script src="{{url('js/videoUploader.js')}}" type="text/javascript"></script>
<script src="{{url('js/videoLookup.js')}}" type="text/javascript"></script>
<script type="text/javascript">
        $(function (){
            enableFileUploader( $('#upload-preview-image') );
            enableFileUploader( $('#upload-banner-image') );
            enableSlider('#affiliate_percentage');
            $('textarea').each(function(){
                enableRTE( '#'+$(this).attr('id') );
            });
            videoLookup.initialize(function ($lessonId, $videoId){
                $.post('/lessons/blocks/' + $lessonId + '/video/assign', {videoId : $videoId}, function (){

                    $('#video-link-' + $lessonId).trigger('click');
                });
            });
        });
</script>
@stop