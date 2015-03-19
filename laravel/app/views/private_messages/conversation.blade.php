<div class="comment clearfix clear comment-{{ $message->id }}" id="pm-{{$message->id}}">
    <div class="info clearfix clear">
        <span class="name"> 
            @if($message->type=='student_conversation')
                {{ $message->sender->commentName('student') }}
            @else
                @if($message->sender->id == Course::find($message->course_id)->instructor->id)
                    {{ $message->sender->commentName('instructor') }}
                @else
                    {{ $message->sender->commentName('student') }}
                @endif
            @endif
        </span>
        
        
        <span class="time-of-reply">{{ $message->created_at->diffForHumans() }}</span>
    </div>
    <div class="main clearfix clear">
        <img class="img-responsive img-circle" alt="" 
             src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">
        <span>
            {{{ $message->content }}}
            {{ $message->markRead( Auth::user()->id ) }}
        </span>
    </div>
</div>