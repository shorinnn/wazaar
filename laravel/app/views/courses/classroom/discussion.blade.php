<div class="row question-answer">
    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
        <div class="row question no-margin">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3>{{ $discussion->title }}</h3>
                <p class="regular-paragraph">{{ $discussion->content }}</p>
            </div>
        </div>
        @foreach($discussion->replies as $reply)
            <div class="row answer no-margin">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="avatar">
                        @if( $course->instructor_id == $reply->student_id || $course->assigned_instructor_id == $reply->student_id )
                            <img src="{{ $reply->student->commentPicture('Instructor') }}" alt="" class="img-responsive">
                        @else
                            <img src="{{ $reply->student->commentPicture('Student') }}" alt="" class="img-responsive">
                        @endif
                    </div>
                    <div class="replies-box">
                        <div class="clearfix">
                            @if( $course->instructor_id == $reply->student_id || $course->assigned_instructor_id == $reply->student_id )
                                <span class="name">{{ $reply->student->commentName('Instructor') }}</span>
                                    <div class="role teacher">{{ trans('conversations/general.teacher') }}</div>
                            @else
                                <span class="name">{{ $reply->student->fullName() }}</span>
                                <div class="role others">
                                    @if($reply->student->profile !=null)
                                        {{ $reply->student->profile->title }}
                                    @endif
                                </div>
                            @endif
                        </div>
                        <p class="reply">{{ $reply->content }}</p>
                    </div>                                
                </div>
            </div>
        @endforeach
    </div>
</div>