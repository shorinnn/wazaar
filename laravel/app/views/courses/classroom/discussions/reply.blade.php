<div class="replies-container clearfix">
    <div class="avatar">
        @if( $course->instructor_id == $reply->student_id || $course->assigned_instructor_id == $reply->student_id )
            <img src="{{ $reply->student->commentPicture('instructor') }}" alt="" class="img-responsive">
        @else
            <img src="{{ $reply->student->commentPicture('student') }}" alt="" class="img-responsive">
        @endif
    </div>
    <div class="replies-box">
        <div class="clearfix">
            <span class="name">{{ $reply->student->fullName() }}</span>
            @if( $course->instructor_id == $reply->student_id || $course->assigned_instructor_id == $reply->student_id )
                <div class="role teacher">Teacher</div>
            @else
            <div class="role others">
                @if($reply->student->profile !=null)
                    {{ $reply->student->profile->title }}
                @endif
            </div>
            @endif
        </div>
        <p class="reply"> {{ $reply->content }} </p>
                <div class='pull-right'>
                    <span class='reply-votes-{{$reply->id}}'>{{ (int)$reply->upvotes }}</span>
                    <a href='{{ action( 'DiscussionRepliesController@vote',[ $reply->id, 'up' ] ) }}' class='link-to-remote' data-callback='updateHTML' data-property='votes'
                       data-url='{{ action( 'DiscussionRepliesController@vote',[ $reply->id, 'up' ] ) }}' data-target='.reply-votes-{{$reply->id}}'>
                        <i class="fa fa-angle-up"></i>
                    </a> |
                    <a href='{{ action( 'DiscussionRepliesController@vote',[ $reply->id, 'down' ] ) }}' class='link-to-remote' data-callback='updateHTML' data-property='votes'
                       data-url='{{ action( 'DiscussionRepliesController@vote',[ $reply->id, 'down' ] ) }}'data-target='.reply-votes-{{$reply->id}}'>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
    </div>
</div>