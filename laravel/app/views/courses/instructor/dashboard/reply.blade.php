<?php
$newDif = $reply->created_at->diffForHumans();
if (time() - strtotime($reply->created_at) < 60 * 60 * 24) {
    if ($reply->created_at->format('d') == date('d'))
        $newDif = trans('general.today');
    else
        $newDif = trans('general.yesterday');
}
?>
@if($reply->student_id == $discussion->student_id)
    <div class="row answer">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="avatar">
                @if( $discussion->lesson->module->course->instructor_id == $reply->student_id
                || $discussion->lesson->module->course->assigned_instructor_id == $reply->student_id )
                <img src="{{ $discussion->student->commentPicture('Instructor') }}" alt="" class="img-responsive">
                @else
                <img src="{{ $discussion->student->commentPicture('Student') }}" alt="" class="img-responsive">
                @endif
            </div>
            <div class="replies-box">
                <div class="clearfix">
                    <span class="name">{{ $discussion->student->fullName() }}</span>
                    <div class="role others">Co-founder @ trydesignlab.com</div>

                    @if( $newDif != $timeDif->timeDif && !isset($noTimeLine) )
                        <span class="date">{{ $reply->created_at->format('H:i') }}</span>
                        <?php $timeDif->timeDif = $newDif; ?>
                    @endif

                </div>
                <p class="reply">{{ $reply->content }}</p>
                <div class="clearfix vote-reply">
                    <span class="vote-count">45</span>
                    <a href="#"><i class="wa-chevron-down"></i></a> |
                    <a href="#"><i class="wa-chevron-up"></i></a>
                    <a href="#" class="reply-button">Reply</a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row answer">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="avatar">
                @if( $discussion->lesson->module->course->instructor_id == $reply->student_id
                || $discussion->lesson->module->course->assigned_instructor_id == $reply->student_id )
                    <img src="{{ $discussion->lesson->module->course->instructor->commentPicture('Instructor') }}" alt="" class="img-responsive">
                @else
                    <img src="{{ $discussion->student->commentPicture('Student') }}" alt="" class="img-responsive">
                @endif
            </div>
            <div class="replies-box">
                <div class="clearfix">
                @if( $course->instructor_id == $reply->student_id || $course->assigned_instructor_id == $reply->student_id )
                    <span class="name">{{ $reply->student->commentName('Instructor') }}</span>
                    <div class="role others">Co-founder @ trydesignlab.com</div>
                @else
                <span class="name">{{ $reply->student->fullName() }}</span>
                @endif

                @if( $newDif != $timeDif->timeDif && !isset($noTimeLine) )
                    <span class="date">{{ $reply->created_at->format('H:i') }}</span>
                    <?php $timeDif->timeDif = $newDif; ?>
                @endif

            </div>
            <p class="reply">{{ $reply->content }}</p>
            <div class="clearfix vote-reply">
                <span class="vote-count">45</span>
                <a href="#"><i class="wa-chevron-down"></i></a> |
                <a href="#"><i class="wa-chevron-up"></i></a>
                <a href="#" class="reply-button">Reply</a>
            </div>
        </div>
    </div>
</div>
@endif