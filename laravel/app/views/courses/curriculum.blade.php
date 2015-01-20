@extends('layouts.default')
@section('content')	
<style>
    #modules-list > li{
        border:1px solid gray;
        background-color:silver;
        padding:10px;
    }
    
    .lessons > li{
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
    .lesson-options{
        display:none;
    }
        .upload-drop-zone {
            height: 200px;
            border-width: 2px;
            margin-bottom: 20px;
        }

        /* skin.css Style*/
        .upload-drop-zone {
            color: #ccc;
            border-style: dashed;
            border-color: #ccc;
            line-height: 200px;
            text-align: center
        }
        .upload-drop-zone.drop {
            color: #222;
            border-color: #222;
        }

        /* Videos list thumbs*/
    .video-list-thumbs{}
    .video-list-thumbs > li{
        margin-bottom:12px
    }
    .video-list-thumbs > li:last-child{}
    .video-list-thumbs > li > a{
        display:block;
        position:relative;
        background-color: #212121;
        color: #fff;
        padding: 8px;
        border-radius:3px
    }
    .video-list-thumbs > li > a:hover{
        background-color:#000;
        transition:all 500ms ease;
        box-shadow:0 2px 4px rgba(0,0,0,.3);
        text-decoration:none
    }
    .video-list-thumbs h2{
        bottom: 0;
        font-size: 14px;
        height: 33px;
        margin: 8px 0 0;
    }
    .video-list-thumbs .glyphicon-play-circle{
        font-size: 60px;
        opacity: 0.6;
        position: absolute;
        right: 39%;
        top: 31%;
        text-shadow: 0 1px 3px rgba(0,0,0,.5);
    }
    .video-list-thumbs > li > a:hover .glyphicon-play-circle{
        color:#fff;
        opacity:1;
        text-shadow:0 1px 3px rgba(0,0,0,.8);
        transition:all 500ms ease;
    }
    .video-list-thumbs .duration{
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 2px;
        color: #fff;
        font-size: 11px;
        font-weight: bold;
        left: 12px;
        line-height: 13px;
        padding: 2px 3px 1px;
        position: absolute;
        top: 12px;
    }
    .video-list-thumbs > li > a:hover .duration{
        background-color:#000;
        transition:all 500ms ease;
    }
    @media (min-width:320px) and (max-width: 480px) {
        .video-list-thumbs .glyphicon-play-circle{
            font-size: 35px;
            right: 36%;
            top: 27%;
        }
        .video-list-thumbs h2{
            bottom: 0;
            font-size: 12px;
            height: 22px;
            margin: 8px 0 0;
        }
    }
    </style>
<h1 class='icon'>{{$course->name}}</h1>    
<div>
    <div class="col-lg-6">
        {{ trans('courses/create.by_the_end') }}
        @foreach( json2Array($course->what_will_you_achieve) as $skill)
            <p>{{ $skill }}</p>
        @endforeach
    </div>
    <div class="col-lg-6">
        {{ trans('courses/curriculum.for_those_who') }}
        @foreach( json2Array($course->who_is_this_for) as $for)
            <p>{{ $for }}</p>
        @endforeach
    </div>
</div>
<h3>{{ trans('courses/curriculum.plan_out') }}</h3>
<h4>{{ trans('courses/curriculum.outline_modules') }}</h4>
<ul id="modules-list">
    @foreach($course->modules()->orderBy('order','ASC')->get() as $module)
        {{ View::make('courses.modules.module')->with(compact('module')) }}
    @endforeach
</ul>

<form method='post' class='ajax-form' id="modules-form" data-callback='addModule'
      action='{{ action('ModulesController@store',[$course->id] )}}'>
    <input type='hidden' name='_token' value='{{ csrf_token() }}' />
    <button type='submit' class='btn btn-primary'>{{ trans('crud/labels.add_module') }}</button>
</form>

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
                    $('#video-link-' + $lessonId).attr('data-loaded', '0');
                    $('#video-link-' + $lessonId).trigger('click');
                });
            });
        });
    </script>
@stop