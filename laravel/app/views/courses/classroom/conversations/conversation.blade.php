<div class="comment clearfix clear comment-{{ $comment->id }}">
    <div class="info clearfix clear">
        <span class="name"> 
            @if( trim($comment->poster->first_name)=='' )
                {{ $comment->poster->email }}
            @else
                {{$comment->poster->first_name.' '.$comment->poster->last_name}}
            @endif
        </span>
        
        <a href="{{ action( 'ConversationsController@replyTo', $comment->id ) }}" class="reply-link reply-to" data-field='.reply-to'
           data-id='{{ $comment->id }}'>Reply</a>
        
       
        <a class="number-of-replies load-remote" data-url='{{action('ConversationsController@replies', $comment->id)}}' 
           href='{{action('ConversationsController@viewReplies', $comment->id)}}' target="_blank"
           data-target='.comment-{{$comment->id}} > .replies'>
                {{ $comment->replies->count() }}
                {{Lang::choice('general.reply', $comment->replies->count() )}}
            </a>
        
        
        <span class="time-of-reply">{{ $comment->created_at->diffForHumans() }}</span>
    </div>
    <div class="main clearfix clear">
        <img class="img-responsive img-circle" alt="" 
             src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">
        <span>
            {{ $comment->content }}
        </span>
    </div>
    <div class='replies pull-right'>@if($comment->reply_to==0 && $comment->replies->count() > 0)
            {{View::make('courses.classroom.conversations.conversation')->withComment( $comment->replies()->first() ) }}
        @endif</div>
</div>