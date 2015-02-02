<div class="comment clearfix clear comment-{{ $comment->id }}" id="comment-{{$comment->id}}">
    <div class="info clearfix clear">
        <span class="name"> 
            @if( trim($comment->poster->first_name)=='' )
                {{ $comment->poster->email }}
            @else
                {{$comment->poster->first_name.' '.$comment->poster->last_name}}
            @endif
        </span>
        
        <a href="{{ action( 'ConversationsController@replyTo', $comment->id ) }}" class="reply-link reply-to" data-field='.reply-to'
           data-id='{{ $comment->reply_to or $comment->id }}' data-reply-to="{{$comment->id}}">Reply</a>
        
       
        @if($comment->reply_to == 0)
        <a class="number-of-replies load-remote" data-url='{{action('ConversationsController@replies', ['id' => $comment->id, 'skip' => 1])}}' 
           href='{{action('ConversationsController@viewReplies', $comment->id)}}' target="_blank" data-load-method='prepend'
           data-target='.comment-{{$comment->id}} > .replies' data-callback="collapseComments">{{ $comment->replies->count() }} {{Lang::choice('general.reply', $comment->replies->count() )}}</a>
        @endif
        
        
        <span class="time-of-reply">{{ $comment->created_at->diffForHumans() }}</span>
    </div>
    <div class="main clearfix clear">
        <img class="img-responsive img-circle" alt="" 
             src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">
        <span>
            @if($comment->original_reply_to > 0)
                <p class='is-reply-to'>
                 @if( trim($comment->poster->first_name)=='' )
                    {{ '@'.$comment->original->poster->email }}
                 @else
                    {{ '@'.$comment->original->poster->first_name.' '.$comment->original->poster->last_name }}
                 @endif
                 - originally posted {{ $comment->original->created_at->diffForHumans() }}
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