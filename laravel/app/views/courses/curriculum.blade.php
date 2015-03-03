@extends('layouts.default')
@section('content')	
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
@stop

@section('extra_js')
    <script src="{{url('plugins/uploader/js/vendor/jquery.ui.widget.js')}}" type="text/javascript"></script>
    <script src="{{url('plugins/uploader/js/jquery.iframe-transport.js')}}" type="text/javascript"></script>
    <script src="{{url('plugins/uploader/js/jquery.fileupload.js')}}" type="text/javascript"></script>
    <script src="{{url('js/videoUploader.js')}}" type="text/javascript"></script>
    <script src="{{url('js/videoLookup.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            videoLookup.initialize(function ($lessonId, $videoId){
                $.post('/lessons/blocks/' + $lessonId + '/video/assign', {videoId : $videoId}, function (){

                    $('#video-link-' + $lessonId).trigger('click');
                });
            });
        });
    </script>
@stop