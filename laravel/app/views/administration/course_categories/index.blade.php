@extends('layouts.default')
@section('content')	
<style>
    #items-list > li{
        border:1px solid gray;
        background-color:silver;
        padding:10px;
    }
    
    .first-sub > li{
        background-color: white;
        padding:10px;
        border-bottom: 1px solid gray;
    }
    .inline-block{
        display:inline-block;
    }
    
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
    .options-div{
        display:none;
    }
        
    </style>
<h1 class='icon'>Course Categories</h1>    

<ul id='items-list'>
    @foreach(CourseCategory::all() as $category)
        {{ View::make('administration.course_categories.category')->with( compact('category') ) }}
    @endforeach
</ul>

<form method='post' class='ajax-form' id="add-category-form" data-callback='addToList' data-destination='#items-list'
      action='{{ action('CoursesCategoriesController@store') }}'>
    <input type='hidden' name='_token' value='{{ csrf_token() }}' />
    <input type='text' name='name' placeholder="{{ trans('name') }}" />
    <button type='submit' class='btn btn-primary'>{{ trans('crud/labels.add_category') }}</button>
</form>

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
    </script>
@stop