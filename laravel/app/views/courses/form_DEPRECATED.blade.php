@extends('layouts.default')
@section('page_title')
    {{ $course->name }} - {{ trans('courses/general.edit') }} -
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
    
    #publish-status-header{
        font-size:15px;
    }
</style>

@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if (Session::get('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
@include('videos.archiveModal')
<div class="container-fluid instructor-course-editor">
    <div role="tabpanel">
        <div class="header clearfix">
            <a href='{{action("CoursesController@myCourses")}}' class="blue-button large-button round-button">{{ trans('courses/general.all_my_courses') }}</a>
            
            <a href='{{action("CoursesController@show", $course->slug)}}' target='_blank' class="blue-button large-button round-button">
                {{ trans('courses/general.course-description-preview') }}
            </a>
        
            <!-- Nav tabs -->
            <ul class="nav nav-pills" id="instructor-editor" role="tablist">
                <li role="presentation" class="active right-twenty-margin">
                    <a href="#curriculum-tab" class="blue-button large-button round-button" aria-controls="curriculum-tab" role="tab" data-toggle="tab">{{ trans('courses/general.curriculum') }}</a>
                </li>
                <li role="presentation">
                    <a href="#course-edit" class="blue-button large-button round-button" aria-controls="course-edit" role="tab" data-toggle="tab">{{ trans('courses/general.course-edit') }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container instructor-course-editor">
	<div class="row">
    	<div class="col-md-12">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                  <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Curriculum contents here -->
                    <div role="tabpanel" class="tab-pane fade in active" id="curriculum-tab">
                        <div class="container course-editor">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class='icon'>
                                    	<span>Course Editor</span>
                                   		{{$course->name}}
                                    </h1>   
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="what-to-achieve">
                                        <h3>{{ trans('courses/create.by_the_end') }}</h3>
                                        @foreach( json2Array($course->what_will_you_achieve) as $skill)
                                            <ul>
                                                <li>{{ $skill }}</li>
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="who-for">
                                        <h3>{{ trans('courses/curriculum.for_those_who') }}</h3>
                                        @foreach( json2Array($course->who_is_this_for) as $for)
                                            <ul>
                                                <li>{{ $for }}</li>
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4">
                                    <div class="who-for">
                                        <h3>{{ trans('courses/create.course-requirements') }}</h3>
                                        @foreach( json2Array($course->requirements) as $for)
                                            <ul>
                                                <li>{{ $for }}</li>
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
	                        <span class="course-editor-horizontal-line"></span>
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
                                        
                                        @if($course->publish_status=='unsubmitted')
                                            <br />
                                            <center>
                                                <a href="#" class="btn btn-primary" onclick="courseSettings()">
                                                    {{ trans('courses/general.next-step') }}
                                                </a>
                                            </center>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    

                    </div>
                    <!-- Curriculum End -->
                    
                    <!-- Course Edit contents here -->
                    <div role="tabpanel" class="tab-pane fade" id="course-edit">
                        <div class="row well well-sm text-center">
                            <h3 id='publish-status-header'>
                                {{ trans('courses/general.approval-status') }}: 
                                <span class="approved">{{ ucfirst( trans( 'courses/statuses.'.$course->publish_status ) ) }}</span>
                            </h3>
                            
                            @if( $course->publish_status!='approved' && $course->publish_status!='pending' )
                             {{ Form::model($course, ['action' => ['CoursesController@submitForApproval', $course->slug], 'method' => 'PUT',
                                     'class' => 'ajax-form',  'data-callback'=>'submitForApproval', 'data-delete' => '#submit-publish-btn'])}}
                                 <!--<input class='btn btn-danger' id='submit-publish-btn' type='submit'--> 
                                 <input class='blue-button round-button large-blue-button' id='submit-publish-btn' type='submit' 
                                        value='{{ trans('courses/statuses.submit-for-approval')}}' />
                                 <input type='hidden' name='publish_status' value='pending' />
                             {{ Form::close() }}
                            @endif
                        </div>
                        
                        
                        {{ Form::model($course, ['action' => ['CoursesController@update', $course->slug], 'id' =>'create-form', 'id'=>'edit-course-form', 'files' => true, 'method' => 'PUT', 'class' => 'ajax-form',  'data-callback'=>'formSaved'])}}
                     	<div class="row">
                            <div class="col-md-12">
                            	<div id="top-form">
                            
                                    <!-- general settings -->
                                    <div class="clearfix">
                                    	<label class="label-name">{{ ucwords( trans('courses/statuses.public') ) }} </label>
                                        <div class="ui-select">
                                        {{ Form::select('privacy_status', [ 'private' => trans('courses/general.no'), 
                                        'public' => trans('courses/general.yes')], null,['class'=>'']) }}
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix">
                                       <label class="label-name">{{ trans('crud/labels.name') }} </label>
                                        {{ Form::text( 'name', null, ['class' => 'has-slug', 'placeholder'=>'Course Name', 'data-slug-target' => '#slug' ]) }}
                                        {{ Form::hidden( 'slug', null, ['id'=>'slug'] ) }}
                                    </div>
                                    
                                    <div class="clearfix">
                                    	<label class="label-name">{{ trans('courses/general.category') }}</label>                                        
                                        <div class="ui-select">
                                            {{ Form::select('course_category_id', $categories, $course->course_category_id, ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 
                                                    'data-url'=> action('CoursesCategoriesController@subcategories_instructor'), 'required', 'class'=>'']) }}
                                                    
                                        </div>
                                    </div>   
                                    
                                    <div class="clearfix">
                                    	<label class="label-name">{{ trans('courses/general.subcategory') }}</label> 
                                        <div class="ui-select">
                                            {{ Form::select('course_subcategory_id', $subcategories, $course->course_subcategory_id,
                                    ['id'=>'course_subcategory_id', 'class'=>'']) }}
                                        </div>
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
                                                        required {{$checked}} /> {{ trans('general.'.$difficulty) }}
                                                    </label>
                                                 @endforeach
                                             </div>
                                    </div>
                                    
                                    <div class="clearfix">
                                    	<label class="label-name">{{ trans('courses/curriculum.enable-ask-coach') }} </label>
                                        <div class="ui-select">
                                            {{ Form::select('ask_teacher', [ 'enabled' => trans('courses/curriculum.yes'), 'disabled' => trans('courses/curriculum.no')], null,['class'=>'']) }}
                                        </div>
                                    </div> 
                            
                                    <!-- /general settings -->
                                    <hr />
                                    
                                    
                                    
                                    <!-- description settings -->
                                    
                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <div class="image-upload">
                                                <h3>{{ trans('courses/general.course_listings_image') }}</h3>
                                                <p class="tip">{{ trans('courses/create.course-listing-image') }}
                                                    <i class='fa fa-question-circle tooltipable' data-placement="top" 
                                                       title='<img src="{{ url('images/course_examples/listing-image.png') }}" />' 
                                                       data-html='true'></i></p>
                                                  <div id="selected-previews">
                                                             @if($course->previewImage!=null)
                                                                <img src="{{$course->previewImage->url}}" height="100" />
                                                            @endif
                                                    </div>

                                                <label for="upload-preview-image" class="uploadFile">
                                                    <span>{{ trans('courses/curriculum.upload') }}</span>
                                                    <input type="file" hidden="" class='upload-preview-image' 
                                                           id="upload-preview-image" name="preview_image" data-dropzone='.dropzone-preview'
                                                       data-progress-bar='.progress-bar-preview' data-callback='courseImageUploaded' 
                                                       data-targez='#use-existing-preview > div > .radio-buttons'
                                                       data-target='#selected-previews'/>
                                                </label>
                                                <!--<input disabled="disabled" placeholder="Choose File" id="uploadFile">
                                                <div class="fileUpload btn btn-primary">
                                                    <span>Browse</span>
                                                    <input type="file" data-callback="replaceElementWithUploaded" data-progress-bar=".progress-bar-1" class="ajax-file-uploader upload" data-replace="#category-graphics-1" data-dropzone="" id="file-upload-1" name="file">
                                                </div>-->
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
                                    
                                    <div class='text-center clearfix'>
                                            <h3>{{ trans('crud/labels.short_description') }} </h3>
                                            <p class="tip">Description displayed on course listing
                                             <i class="fa fa-question-circle tooltipable" data-placement="top" title=""  data-html="true" 
                                            data-original-title="<img src='{{ url('images/course_examples/short-desc.png') }}' />"></i>
                                            </p>
                                            <div class="description-box">{{ Form::textarea('short_description', null,['id'=>'short_description'] ) }}</div>
                                    </div>
                                    
                                    <div class="description-editor-box">
                                            <h3>{{ trans('crud/labels.description') }} </h3>
                                            <p class="tip">Description on the course description page 
                                             <i class="fa fa-question-circle tooltipable" data-placement="top" title=""  data-html="true" 
                                            data-original-title="<img  height='400' width='600' src='{{ url('images/course_examples/long-desc.png') }}' />"></i>
                                            </p>
                                            <div class="description-box">{{ Form::textarea('description', null,['id'=>'description'] ) }}</div>
                                    </div>  
                                    
                                    
                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <div class="image-upload">
                                                <h3>{{ trans('courses/general.course_description_video_image') }}</h3>
                                                <p class="tip">{{ trans('courses/create.course-video-image') }}</p>
                                            <label for="upload-banner-image" class="uploadFile">
                                                    <!--<div class="upload-file-button">{{ trans('crud/labels.upload_your_file') }}</div>-->
                                                    <span>{{ trans('courses/curriculum.upload') }}</span> 
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
        //                                                    @if($bannerImages->count() > 0)
        //                                                        @foreach($bannerImages as $img)
        //                                                            {{ View::make('courses.preview_image')->with(compact('img')) }}
        //                                                        @endforeach
        //                                                    @endif
                                                                    ?>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                    </div>
                                </div>
                                    
                                    @include('courses.video.index')
                                    
                                   
                                                
                                    <div class="clearfix">
                                        <label class="label-name">{{ trans('crud/labels.assigned_instructor') }}
                                            @if($assignedInstructor!=null)
                                                <i class="fa fa-check assigned-check"></i>
                                            @endif
                                        </label>
                                            <input type='text' class='delayed-keyup'
                                                   id='assign-instructor' placeholder="Enter instructor username/email."
                                                   data-delay='300'
                                                   data-callback='assignInstructor'
                                                   @if($assignedInstructor!=null)
                                                   value="{{ $assignedInstructor->email }}"
                                                   @endif
                                                   />
                                                    <span></span>
                                            {{ Form::hidden('assigned_instructor_id', null, [ 'id'=>'assigned_instructor_id' ] ) }}
                                    </div>
                                    <div class="clearfix display-instructor" 
                                         @if($assignedInstructor==null)
                                             style='display:none'
                                         @endif
                                         >
                                        <label class="label-name">{{ trans('crud/labels.display_instructor') }} </label>
                                        <div class="ui-select">
                                            {{ Form::select( 'details_displays', 
                                                ['instructor' => trans('courses/curriculum.course-owner-instructor'), 
                                                'assigned_instructor' => trans('courses/curriculum.assigned-instructor') ], null,['class'=>''] ) }}
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <label class="label-name">{{ trans('crud/labels.display_bio') }} </label> 
                                        <div class="ui-select">
                                            {{ Form::select( 'show_bio', 
                                                ['default' => trans('courses/curriculum.default-instructor-bio'), 
                                                'custom' => trans('courses/curriculum.custom-course-bio') ], null,
                                                    ['class'=>'' , 'onchange'=>'toggleElementViaOther(event)', 'data-hide-on' => 'default',
                                                'data-destination' => '.custom-bio-box'] ) }}
                                        </div>
                                    </div>
                                    <div class="clearfix custom-bio-box"
                                         @if($course->show_bio=='default')
                                            style="display:none"
                                         @endif
                                         >
                                        <label class="label-name">{{ trans('crud/labels.custom_bio') }} </label>
                                        {{ Form::textarea( 'custom_bio', null, ['placeholder'=>'Enter bio to display on course description page.'] ) }}
                                    </div>
                                </div>
                            <!--</div>-->
                        </div>
                                    
                        
                        <div class="row">
                        	<div class="col-md-12">
                                    <div class="what-you-will-achieve">
                                	<h3>{{ trans('courses/create.course-requirements') }} </h3>
                                        <?php $i = 1;?>
                                        @if($values = json2Array($course->requirements))
                                            @foreach($values as $val)
                                            <div class="clonable-{{time().$i}}">
                                                 <span>{{$i}}</span>
                                                <input type='text' name='requirements[]' data-clonable-max='5' value='{{$val}}' class="clonable clonable-{{time().$i}}"  /><br />
                                                 <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
                                             </div>
                                                <?php ++$i; ?>
                                            @endforeach
                                        @endif
                                            <div class="clonable-{{time().$i}}">
                                                 <span>{{$i}}</span>
                                                 <input type='text' name='requirements[]' data-clonable-max='5' class="clonable clonable-{{time().$i}}" />
                                                 <a href="#" tabindex="-1" class="style-one delete-clonable clonable-{{time().$i}}"></a>
                                            </div>
                                    </div>
                                    
                                <div class="who-its-for">
                                	<h3>{{ trans('courses/general.who_is_this_for') }}</h3>
                                        <p class="tip">{{ trans('courses/create.tip-if-student') }}</p>
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
                                	<h3>{{ trans('courses/create.by_the_end') }} </h3>
                                    <p class="tip">{{ trans('courses/create.make_it_results') }}</p>
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
                                    
                                    
                                 <!-- /description settings -->

                                
                                <!-- sales settings -->
                                
                                <div class="payment-section">
                                    <div class="clear clearfix margin-bottom-20">
                                    	<label class="label-name">{{ trans('courses/curriculum.payment-type') }} </label>
                                        <div class="ui-select">
                                        {{ Form::select('payment_type', [ 'one_time' => trans('courses/general.one_time'), 
                                        'subscription' =>  trans('courses/general.subscription') ], null,['class'=>''] ) }}
                                        </div>
                                    </div>    
                                    <div class="clear clearfix margin-bottom-20">
                                    	<label class="label-name">{{ trans('courses/general.price') }}</label> 
                                        {{  Form::text( 'price', money_val($course->price),
                                            ['class' => 'delayed-keyup', 'data-delay' => '5000', 'data-callback' => 'adjustPrice'] ) }}
                                    </div>    
                                    
                                    <div class="clear clearfix">
                                    	<div class="percentage-slider">
                                            <label class="label-name">{{ trans('courses/general.affiliate_percentage') }}  </label>   
                                            
                                            <div>                                   
                                                <input type="text" class='span2 clear right' name='affiliate_percentage' id='affiliate_percentage' 
                                                    value="{{ $course->affiliate_percentage }}" data-slider-min="0" data-slider-max="68" 
                                                    data-slider-step="1" data-slider-value="{{ intval( $course->affiliate_percentage ) }}" 
                                                    data-slider-orientation="horizontal" 
                                                    data-slider-selection="after" data-slider-tooltip="show" data-label="#affiliate_percentage_output" 
                                                    data-target-input='1' />
                                                
                                                <input type='number' id='affiliate_percentage_output' class='set-slider clear margin-bottom-20'
                                                   max="68" min="0" value='{{ intval( $course->affiliate_percentage ) }}' data-slider='#affiliate_percentage' />%
                                                <br />
                                                <a class="btn btn-primary btn-xs" href='{{action('CoursesController@customPercentage', $course->slug ) }}'> 
                                                Manage Custom Affiliate Percentage </a>
                                                <br />
                                             </div>
                                         </div>
                                        
                                        
                                        <div class="clear clearfix margin-bottom-20">
                                        	<label class="label-name">{{ trans('courses/general.discount') }} </label>
                                                {{ Form::text('sale', money_val($course->sale),
                                                    ['onkeyup' => 'toggleElementViaOther(event)', 
                                                    'class' => 'delayed-keyup', 'data-delay' => '5000', 'data-callback' => 'adjustDiscount',
                                                    'data-saleType' => 'sale_kind',
                                                    'data-destination'=>'.sale-ends-on', 'data-hide-on' => '0', 'data-is-int' => 1 ]) }}
                                                    
                                                <div class="ui-select discount margin-top-20">
                                                	{{ Form::select('sale_kind', ['amount' => '¥', 'percentage' => '%'], null,
                                                ['class'=>''] ) }}
                                                </div>
                                        </div>    
                                        <div class='sale-ends-on'
                                             @if($course->sale==0)
                                                    style='display:none'
                                                @endif
                                                >
                                            <div class="clear clearfix margin-bottom-20 input-group date">
                                                <label class="label-name">{{ trans('courses/general.sale_starts_on') }}</label>  
                                                {{ Form::text('sale_starts_on', null, ['class'=>'form-control sales-end-calender datetimepicker']) }}
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <div class="clear clearfix margin-bottom-20 input-group date">
                                                <label class="label-name">{{ trans('courses/general.sale_ends_on') }}</label>  
                                                {{ Form::text('sale_ends_on', null, ['class'=>'form-control sales-end-calender datetimepicker']) }}
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="clear clearfix margin-bottom-20">
                                               <button type="submit" class="btn btn-primary submit-button">{{ trans('crud/labels.update') }}</button>
                                        </div>
                                    </div>
                                </div>
                                    
                            </div>
                       </div>	 
                                    {{ Form::close() }}
                   </div>        
               </div>
                
            </div>
		</div>
	</div>
</div>

<input class="course-id" type="hidden" value="{{$course->id}}"/>
<form id="form-aws-credentials" action="">
    <input type="hidden" name="key" value="{{$uniqueKey}}-${filename}">
    <input type="hidden" name="AWSAccessKeyId" value="{{Config::get('aws::config.key')}}">
    <input type="hidden" name="acl" value="private">
    <input type="hidden" name="success_action_status" value="201">
    <input type="hidden" name="policy" value="{{$awsPolicySig['base64Policy']}}">
    <input type="hidden" name="signature" value="{{$awsPolicySig['signature']}}">
</form>
@include('videos.playerModal')
@stop

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
           $('.lesson-no-video .video .a-add-video').click();
	       $('.lesson-no-video .video .a-add-video').attr('data-loaded', 1);
            
            enableFileUploader( $('#upload-preview-image') );
            enableFileUploader( $('#upload-banner-image') );
            enableSlider('#affiliate_percentage');
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

<script type="text/javascript">



    
    var $courseVideoInterval;

    jQuery(function(){
        
        $('.datetimepicker').datetimepicker( { 
            sideBySide:true,
            extraFormats: ['YYYY-MM-DD hh:mm:s']
        } );
        
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

        /*videoLookup.initialize($('.course-video-select-existing-anchor'), function ($lessonId, $videoId){
            alert($videoId);
        });*/
    });
</script>
@stop