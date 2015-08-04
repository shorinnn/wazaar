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
    </div>
</div>