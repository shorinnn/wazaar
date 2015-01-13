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
<a href='{{action("CoursesController@myCourses")}}' class="all-my-courses btn btn-link">All My Courses</a>
<div class="table-responsive">
        {{ Form::model($course, ['action' => ['CoursesController@update', $course->slug], 'id' =>'create-form', 
                    'files' => true, 'method' => 'PUT', 'class' => 'ajax-form', 'data-callback'=>'formSaved'])}}

        <div>Privacy Status <span class="custom-dropdown">{{ Form::select('privacy_status', [ 'private' => 'Private', 'public' => 'Public']) }}</span></div>    
        <div>Category <span class="custom-dropdown">{{ Form::select('course_category_id', $categories, $course->course_category_id, 
        ['onChange'=>'populateDropdown(this)', 'data-target'=>'#course_subcategory_id', 
                        'data-url'=> action('CoursesCategoriesController@subcategories'), 'required']) }}</span></div>   
        
        <div>Sub Category <span class="custom-dropdown">{{ Form::select('course_subcategory_id', $subcategories, $course->course_subcategory_id,
        ['id'=>'course_subcategory_id'] ) }}</span></div>    
        <div>Difficulty <span class="custom-dropdown">{{ Form::select('course_difficulty_id', $difficulties) }}</span></div>    
        <div>Name {{ Form::text( 'name', null, ['class' => 'has-slug', 'data-slug-target' => '#slug' ]) }}
        {{ Form::hidden( 'slug', null, ['id'=>'slug'] ) }}</div>
        <div>Preview Image
            <label for="upload-preview-image">
                    <div class="upload-file-button">Upload Your File</div>
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
                Or Use existing:<br />
                    @foreach($images as $img)
                        {{ View::make('courses.preview_image')->with(compact('img')) }}
                    @endforeach
                @endif
                </span>
            
        <br class='clear' />
        </div>
        <div>Details Page Banner Image
            <label for="upload-banner-image">
                    <div class="upload-file-button">Upload Your File</div>
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
                    Or Use existing:<br />
                        @foreach($bannerImages as $img)
                            {{ View::make('courses.preview_image')->with(compact('img')) }}
                        @endforeach
                    @endif
                </span>
             <br class="clear" />
            </div>
        
        <div class="who-its-for">Who Is This For<br />
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
        <div class="what-you-will-achieve">What you will achieve at the end of the course <br />
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
        <div>Description <div class="description-box">{{ Form::textarea('description') }}</div></div>    
        <div>Price {{ Form::text('price') }}</div>    
        <div>Affiliate Percentage 
            <!--<div class="custom-dropdown affiliate-percentage">-->
                <input type="text" class='span2' name='affiliate_percentage' id='affiliate_percentage' value="{{ $course->affiliate_percentage }}" data-slider-min="0" data-slider-max="70" 
                       data-slider-step="1" data-slider-value="{{ $course->affiliate_percentage }}" data-slider-orientation="horizontal" 
                       data-slider-selection="after" data-slider-tooltip="show" />
                <span id='affiliate_percentage_output'>{{ $course->affiliate_percentage }}%</span>
                <!--{{ Form::select('affiliate_percentage', range(0,70)) }}</div>%</div>-->    
        <div>Discount
                {{ Form::text('sale') }}
                <div class="custom-dropdown discount">{{ Form::select('sale_kind', ['amount' => '$', 'percentage' => '%'] ) }}</div>
            </div>    
        <div>Sale Ends On {{ Form::text('sale_ends_on') }}</div>    
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
            $('#affiliate_percentage').slider().on('slide', function(ev){
                    $('#affiliate_percentage_output').html(ev.value+"%");
              });
        });
</script>
@stop