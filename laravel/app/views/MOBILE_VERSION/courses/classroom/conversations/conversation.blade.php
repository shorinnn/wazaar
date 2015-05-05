<div class="comment clearfix clear comment-{{ $comment->id }}" id="comment-{{$comment->id}}">
    <div class="info clearfix clear">
        <span class="name"> 
            {{ $comment->poster->commentName() }}
            @if(Auth::user()->id != $comment->poster->id)
                <a href="{{ url('private-messages/?send-to='.$comment->poster->id) }}">[{{ trans('conversations/general.pm') }}]</a>
            @endif
        </span>
        
        <a href="{{ action( 'ConversationsController@replyTo', $comment->id ) }}" class="reply-link reply-to" data-field='.reply-to'
           data-id='{{ $comment->reply_to or $comment->id }}' data-reply-to="{{$comment->id}}">
            {{ trans('conversations/general.Reply') }}
        </a>
        
       
        @if($comment->reply_to == 0)
        <a class="number-of-replies load-remote" data-url='{{action('ConversationsController@replies', ['id' => $comment->id, 'skip' => 1])}}' 
           href='{{action('ConversationsController@viewReplies', $comment->id)}}' target="_blank" data-load-method='prepend'
           data-target='.comment-{{$comment->id}} > .replies' data-callback="collapseComments">{{ $comment->replies->count() }}
            {{Lang::choice('general.reply', $comment->replies->count() )}}
            @if($comment->replies->count() > 0)
                <i class='fa fa-arrow-down fa-animated'></i>
            @endif
        </a>
        @endif
        
        
        <span class="time-of-reply">{{ $comment->created_at->diffForHumans() }}</span>
    </div>
    <div class="main clearfix clear">
<!--        <img class="img-responsive img-circle" alt="" 
             src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">-->
            @if( $comment->poster && $comment->poster->profile )
                <img style="height: 50px; width: 50px; border-radius: 50px;"  class="img-circle img-responsive"
                     src="{{cloudfrontUrl( $comment->poster->profile->photo ) }}" alt="">
            @else
                <img style="height: 50px; width: 50px; border-radius: 50px;"  class="img-circle img-responsive"
                     src="{{cloudfrontUrl('//s3-ap-northeast-1.amazonaws.com/profile_pictures/avatar-placeholder.jpg')}}" alt="">
            @endif
        <span>
            @if($comment->original_reply_to > 0)
                <p class='is-reply-to'>
                    {{ '@'.$comment->original->poster->commentName() }}
                 - {{ trans('conversations/general.originally_posted') }} {{ $comment->original->created_at->diffForHumans() }}
                </p>
            @endif
            {{ $comment->content }}
        </span>
    </div>
    @if($comment->reply_to == 0)
    <div class='replies pull-right replies-comment-{{$comment->id}}'>@if($comment->reply_to==0 && $comment->replies->count() > 0)
            {{View::make('courses.classroom.conversations.conversation')->withComment( $comment->replies()->orderBy('id','desc')->limit(1)->first() ) }}
        @endif</div>
    @endif
</div>