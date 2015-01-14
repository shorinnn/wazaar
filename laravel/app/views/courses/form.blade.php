@extends('layouts.default')
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
<a href='{{action("CoursesController@myCourses")}}' class="all-my-courses btn btn-link">{{ trans('courses/general.all_my_courses') }}</a>
<div class="table-responsive">
        {{ Form::model($course, ['action' => ['CoursesController@update', $course->slug], 'id' =>'create-form', 
                    'files' => true, 'method' => 'PUT', 'class' => 'ajax-form', 'data-callback'=>'formSaved'])}}

        <div>{{ trans('courses/general.privacy_status') }} <span class="custom-dropdown">{{ Form::select('privacy_status', [ 'private' => 'Private', 'public' => 'Public']) }}</span></div>    
        <div>{{ trans('courses/general.category') }} <span class="custom-dropdown">{{ Form::select('course_category_id', $categories, $course->course_category_id, 
        ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 
                        'data-url'=> action('CoursesCategoriesController@subcategories'), 'required']) }}</span></div>   
        
        <div>{{ trans('courses/general.subcategory') }} <span class="custom-dropdown">{{ Form::select('course_subcategory_id', $subcategories, $course->course_subcategory_id,
        ['id'=>'course_subcategory_id'] ) }}</span></div>    
        <div>{{ trans('courses/general.difficulty') }} <span class="custom-dropdown">{{ Form::select('course_difficulty_id', $difficulties) }}</span></div>    
        <div>{{ trans('crud/labels.name') }} {{ Form::text( 'name', null, ['class' => 'has-slug', 'data-slug-target' => '#slug' ]) }}
        {{ Form::hidden( 'slug', null, ['id'=>'slug'] ) }}</div>
        <div>{{ trans('courses/general.preview_image') }}
            <label for="upload-preview-image">
                    <div class="upload-file-button">{{ trans('crud/labels.upload_your_file') }}</div>
                </label>
                <input type="file" id='upload-preview-image' name="preview_image" data-dropzone='.dropzone-preview'
                   data-progress-bar='.progress-bar-preview' data-callback='courseImageUploaded' data-target='.use-existing-preview' />
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active progress-bar-preview" role="progressbar" aria-valuenow="0" aria-valuemin="0" 
                         aria-valuemax="100" style="width: 0%;">
                        <span></span>
                    </div>
                </div>
                
                <span class="use-existing use-existing-preview">
                @if($images->count() > 0)
                {{ trans('crud/labels.or_use_existing') }}:<br />
                    @foreach($images as $img)
                        {{ View::make('courses.preview_image')->with(compact('img')) }}
                    @endforeach
                @endif
                </span>
            
        <br class='clear' />
        </div>
        <div>{{ trans('courses/general.details_page_banner_image') }}
            <label for="upload-banner-image">
                    <div class="upload-file-button">{{ trans('crud/labels.upload_your_file') }}</div>
                </label>
             <input type="file" id='upload-banner-image' name="banner_image" data-dropzone='.dropzone-preview'
                   data-progress-bar='.progress-bar-banner' data-callback='courseImageUploaded' data-target='.use-existing-banner' />
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active progress-bar-banner" role="progressbar" aria-valuenow="0" aria-valuemin="0" 
                         aria-valuemax="100" style="width: 0%;">
                        <span></span>
                    </div>
                </div>
                
                <span class="use-existing-banner">
                    @if($bannerImages->count() > 0)
                    {{ trans('crud/labels.or_use_existing') }}:<br />
                        @foreach($bannerImages as $img)
                            {{ View::make('courses.preview_image')->with(compact('img')) }}
                        @endforeach
                    @endif
                </span>
             <br class="clear" />
            </div>
        
        <div class="who-its-for">{{ trans('courses/general.who_is_this_for') }}<br />
                @if($values = json2Array($course->who_is_this_for))
                <?php $i = 1;?>
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
        <div class="what-you-will-achieve">{{ trans('courses/general.what_will_you_achieve') }} <br />
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
        <div>{{ trans('crud/labels.description') }} <div class="description-box">{{ Form::textarea('description') }}</div></div>    
        <div>{{ trans('courses/general.price') }} {{ Form::text('price') }}</div>    
        <div>{{ trans('courses/general.affiliate_percentage') }} 
            
                <input type="text" class='span2' name='affiliate_percentage' id='affiliate_percentage' value="{{ $course->affiliate_percentage }}" data-slider-min="0" data-slider-max="70" 
                       data-slider-step="1" data-slider-value="{{ $course->affiliate_percentage }}" data-slider-orientation="horizontal" 
                       data-slider-selection="after" data-slider-tooltip="show" data-label="#affiliate_percentage_output" />
                <span id='affiliate_percentage_output'>{{ $course->affiliate_percentage }}%</span>
                
        <div>{{ trans('courses/general.discount') }} 
                {{ Form::text('sale') }}
                <div class="custom-dropdown discount">{{ Form::select('sale_kind', ['amount' => '$', 'percentage' => '%'] ) }}</div>
            </div>    
        <div>{{ trans('courses/general.sale_ends_on') }}  {{ Form::text('sale_ends_on') }}</div>    
        <div>
                <button type="submit" class="btn btn-primary">{{ trans('crud/labels.update') }}</button>
            </div>
        {{ Form::close() }}
</div>
@stop

@section('extra_js')
<script src="{{url('plugins/uploader/js/vendor/jquery.ui.widget.js')}}"></script>
<script src="{{url('plugins/uploader/js/jquery.iframe-transport.js')}}"></script>
<script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}"></script>
<script src="{{url('plugins/slider/js/bootstrap-slider.js')}}"></script>
<script type="text/javascript">
        $(function (){
            enableFileUploader( $('#upload-preview-image') );
            enableFileUploader( $('#upload-banner-image') );
            enableSlider('#affiliate_percentage');
        });
</script>
@stop