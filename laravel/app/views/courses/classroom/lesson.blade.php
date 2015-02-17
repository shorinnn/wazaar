@extends('layouts.default')

@section('content')
<style>
    .replies:not(:empty){
        border:1px solid silver;
        width:80%;
        min-width: 600px;
    }
    
    .comment-form-reply{
        min-width: 500px
    }
    .is-reply-to{
        font-style: italic;
        font-size: 12px;
    }
    
    .fa-animated{
        -webkit-transition: all 0.3s; /* For Safari 3.1 to 6.0 */
        transition: all 0.3s;
    }
    
    .reply-to-label{
        border: 1px solid silver;
        border-radius: 5px;
        padding: 2px;
        background-color: #19B5DA;
        color: white;
        position: absolute;
        z-index: 10;
        margin-left: 90px;
        margin-top: 15px;
    }
    a.load-remote > *{
        pointer-events: none;
    }
    
    .overlay-loading{
        position:absolute;
        margin-left:auto;
        margin-right:auto;
        left:0;
        right:0;
        z-index: 10;
        width:32px;
        height:32px;
        background-image:url('http://www.mytreedb.com/uploads/mytreedb/loader/ajax_loader_blue_32.gif');
    }
</style>
    <h1>Course: {{ $course->name }}</h1>
    <h2>Lesson: {{ $lesson->name }}</h2>
    
    @if( $video != null)
        <div class="text-center" style="border:1px solid gray; padding: 30px; margin:30px; background-color:silver">
            @if( Agent::isMobile() )
                <video controls><source src="{{ $video->video()->formats()->where('resolution', 'Custom Preset for Mobile Devices')
                            ->first()->video_url }}" type="video/mp4"></video>
            @else
            <video controls><source src="{{ $video->video()->formats()->where('resolution', 'Custom Preset for Desktop Devices')
                            ->first()->video_url }}" type="video/mp4"></video>
            @endif
        </div>
    @endif
    
    @foreach($lesson->blocks as $block)
        @if($block->type=='text')
            <div class="well">{{ $block->content }}</div>
        @endif
    @endforeach
    
    
    @foreach($lesson->blocks as $block)
        @if($block->type=='file')
            <p><a href='{{ $block->content }}' target='_blank'><i class="fa fa-cloud-download"></i> {{ $block->name }}</a></p>
        @endif
    @endforeach
   
    <h2>Conversations:</h2>
    <section class="classroom-content container">
    @if( Auth::check() )
        {{ View::make('courses.classroom.conversations.form')->with( compact('lesson') ) }}
    @endif
    
        <div class='ajax-content fa-animated'>
            {{ View::make('courses.classroom.conversations.all')->withComments( $lesson->comments ) }}

           <!-- <a href='{{ action('ConversationsController@lesson', [$lesson->module->course->slug, $lesson->slug] )}}' class="load-more-comments load-more-ajax" 
               data-url='{{action('ConversationsController@loadMore')}}' 
               data-target='.users-comments' data-skip='2' data-post-field='lesson' data-id='{{$lesson->id}}'>LOAD MORE</a>
            -->
            <br />
            <div class="text-center load-remote" data-target='.ajax-content' data-load-method="fade">
                
                {{ $lesson->comments->links() }}
                <!--<a href='{{ action('ConversationsController@lesson', [$lesson->module->course->slug, $lesson->module->slug, $lesson->slug] )}}'>View All Comments Ever</a>-->
            </div>
        </div>
    </div>
    
@stop