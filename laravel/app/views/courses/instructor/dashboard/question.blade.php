<div class="comment clearfix clear comment-{{ $question->id }}" id="pm-{{$question->id}}">
    <div class="info clearfix clear">
        <span class="name"> 
            {{ $question->sender->commentName('student') }}
        </span>
        
        
        <span class="time-of-reply">{{ $question->created_at->diffForHumans() }}</span>
    </div>
    <div class="main clearfix clear">
        <img class="img-responsive img-circle" alt="" 
             src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">
        <span>
            {{{ $question->content }}}
            <br />
            <a target='_blank' 
               href='{{ action('PrivateMessagesController@index') }}?page={{ $question->inboxPage() }}'>
                <i class="fa fa-external-link"></i>
                View In Inbox</a> 
            <br />
        </span>
    </div>
</div>