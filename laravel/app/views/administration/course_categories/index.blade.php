@extends('layouts.default')
@section('content')	
<style>

    </style>
    <div class="container course-categories">
    	<div class="row">
        	<div class="col-md-12">
                <h1 class='icon'>{{ trans('administration.course-categories') }}</h1>    
                
                <ul id='items-list'>
                    @foreach(CourseCategory::all() as $category)
                        {{ View::make('administration.course_categories.category')->with( compact('category') ) }}
                    @endforeach
                </ul>            
            </div>
        </div>
    </div>
    <div class="container">
    	<div class="row">
        	<div class="col-md-12">
                <form method='post' class='ajax-form' id="add-category-form" data-callback='addToList' data-destination='#items-list'
                      action='{{ action('CoursesCategoriesController@store') }}'>
                    <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                    <div>
                        <input type='text' name='name' placeholder="{{ trans('crud/labels.name') }}" />
                        <button type='submit' class='btn btn-primary'>{{ trans('crud/labels.add_category') }}</button>
                    </div>
                </form>
    		</div>
    	</div>
    </div>

@stop

@section('extra_js')
    <script src="{{url('plugins/uploader/js/vendor/jquery.ui.widget.js')}}" type="text/javascript"></script>
    <script src="{{url('plugins/uploader/js/jquery.iframe-transport.js')}}" type="text/javascript"></script>
    <script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $('.ajax-file-uploader').each(function(){
                enableFileUploader( $(this) );
            });
        });
		document.getElementById("file-upload-{{$category->id}}").onchange = function () {
		document.getElementById("uploadFile").value = this.value;
		};

    </script>
@stop