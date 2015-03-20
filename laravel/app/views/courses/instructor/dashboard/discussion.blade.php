<div class="comment clearfix clear comment-{{ $comment->id }}" id="pm-{{$comment->id}}">
    <div class="info clearfix clear">
        <span class="name"> 
            @if($comment->poster->id == Course::find($comment->course_id)->instructor->id
            ||
            $comment->poster->id == Course::find($comment->course_id)->assigned_instructor_id )
                {{ $comment->poster->commentName('instructor') }}
            @else
                {{ $comment->poster->commentName('student') }}
            @endif
        </span>
        
        
        <span class="time-of-reply">{{ $comment->created_at->diffForHumans() }}</span>
    </div>
    <div class="main clearfix clear">
        <img class="img-responsive img-circle" alt="" 
             src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">
        <span>
            {{{ $comment->content }}}
            <br />
<!--            <a target='_blank' 
               href='{{ action('ClassroomController@dashboard', $comment->course->slug) }}?page={{$comment->page()}}#conversations'>-->
            <a target='_blank' 
               href='{{ action('CoursesController@viewDiscussion', $comment->id) }}'>
                <i class="fa fa-external-link"></i>
                View In Course</a> 
            <br />
        </span>
    </div>
</div>