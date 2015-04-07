<div class="comment clearfix clear discussion-{{ $comment->id }}" id="discussion-{{$comment->id}}" style="border:1px solid silver; padding:20px">
    <div class="info clearfix clear">
        @if($comment->lesson !=null )
            <h5>{{trans('conversations/general.lesson') }}: {{ $question->lesson->name }}</h5>
        @endif
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
    
    <form method="post" action="{{ action('CoursesController@markResolved') }}" class="ajax-form" data-callback="deleteItem" 
          data-delete="#discussion-{{$comment->id}}">
        <button type="submit" class="btn btn-primary">{{trans('conversations/general.mark-as-resolved') }}</button>
        <input type="hidden" name="id" value="{{$comment->id}}" />
        <input type="hidden" name="type" value="discussion" />
    </form>
    
    {{ Form::close() }}
    <button class="btn btn-primary  show-reply-form" data-type='discussion' data-id='{{$comment->id}}'
            data-delete='#discussion-{{$comment->id}}'>{{trans('conversations/general.Reply') }}</button>
</div>