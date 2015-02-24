@extends('layouts.default')
@section('content')	
<style>
	.course-categories h1{
		text-align: center;
		color: #0099ff;
		margin: 90px 0 40px;
	}
	
	#items-list{
		border-radius: 5px 5px 0 0;
		padding: 0;
		margin: 0;
		background: #e2e1e5;
		border: solid #ccc;
		border-width: 1px 1px 0 1px;
	}
	
	#items-list button:focus{
		outline: none;
	}
	
    #items-list > li{
        padding: 40px 20px;
    }

    #items-list > li + li{
        border-top:1px solid #ccc;
	}
	
    #items-list > li button{
		padding: 4px 12px;
		position: relative;
		top: -1px;
	}
	

    #items-list > li div.options-div{
		max-width: 69%;
		margin: 30px auto 0;
		color: #0099ff;
		font-size: 18px;
	}

    #items-list > li div.options-div textarea{
		display: block;
		width: 91.6%;
		resize: none;
		height: 90px;
		border-radius: 5px;
		margin-top: 10px;
		margin-bottom: 10px;
		color: #849598;
		padding: 10px;
		font-size: 14px;
		border: solid 1px #849598;
	}
	
    #items-list > li div.options-div form{
		margin-top: 10px;
	}

    #items-list > li div.options-div form .radio-buttons{
		margin: 0;
	}

    #items-list > li div.options-div form .radio-checkbox.radio-checked{
		float: left;
	}
	
    .first-sub > li input[type='text'],
	#items-list > li input[type='text']{
		height: 30px;
		font-size: 14px;
		color: #849598;
		border: solid 1px #849598;
		padding-left: 8px; 
		width: 288px;
		border-radius: 5px;
	}

    .first-sub{
		width: 69%;
		clear: both;
		margin: 0 auto;
		padding: 0;
	}
    
    .first-sub > li{
        padding:10px 0 10px 0;
        border: none;
    }

	.input-wrapper > div form ~ button,
    .first-sub > li input ~ form button,
    .first-sub > li input + input{
		margin-left: 5px;
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
        
    .color-scheme-thumb{
        height:40px; 
        width: 40px;
		border-radius: 5px;
        display: inline-block;
    }
	
	.input-wrapper{
		position: relative;
	}

	.input-wrapper > div{
		width: 69%;
		margin: 0 auto 10px;
	}

	.subcategory input[type='text'],
	.input-wrapper > div > input{
		width: 91.6% !important;
		margin-bottom: 10px;
	}

	.subcategory {
		margin-top: 10px !important;
	}
	
	.fileUpload {
		overflow: hidden;
		background: #b0bfc1;
		border: none;
		color: #fff;
		position: relative;
		float: left;
		font-size: 12px;
		height: 30px;
		border-radius: 0 5px 5px 0;
		text-transform: uppercase;
		transition: all 0.2s ease-out 0s;
		width: 97px;
	}
	
	.fileUpload:hover {
		background: #849598 !important;
	}

	.progress{
		margin: 10px 0 0;
		background: none;
		box-shadow: none;
	}
	
	.fileUpload input.upload {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		font-size: 20px;
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
	}

	#uploadFile{
		height: 30px;
		font-size: 14px;
		color: #849598;
		border: solid #849598;
		border-width: 1px 0 1px 1px;
		padding-left: 8px; 
		width: 250px;
		float: left;
		background: #fff;
		border-radius: 5px 0 0 5px;
	}

	.category-graphics{
		margin-top: 10px;
	}
	
	.category-graphics img{
		display: block;
		margin-top: 10px;
	}

	#add-category-form{
		max-width: 970px;
		margin: 0 auto 50px;
		border-radius: 0 0 5px 5px;
		padding: 0 0 50px;
		background: #e2e1e5;
		border: solid #ccc;
		border-width: 0 1px 1px 1px;
	}

	#add-category-form div{
		max-width: 66%;
		margin: 0 auto;
	}

	#add-category-form div input{
		width: 92%;
		display: block;
		height: 30px;
		font-size: 14px;
		color: #849598;
		border: solid 1px #849598;
		padding-left: 8px;
		margin-bottom: 10px; 
		border-radius: 5px;
	}

    </style>
    <div class="container course-categories">
    	<div class="row">
        	<div class="col-md-12">
                <h1 class='icon'>Course Categories</h1>    
                
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
                        <input type='text' name='name' placeholder="{{ trans('name') }}" />
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