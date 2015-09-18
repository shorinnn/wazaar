<?php
$newDif = $reply->created_at->diffForHumans();
if (time() - strtotime($reply->created_at) < 60 * 60 * 24) {
    if ($reply->created_at->format('d') == date('d'))
        $newDif = trans('general.today');
    else
        $newDif = trans('general.yesterday');
}
?>
@if( $newDif != $timeDif->timeDif && !isset($noTimeLine) )
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
        <span class="date"><em>{{  $newDif }}</em></span>                        
    </div>
    <?php $timeDif->timeDif = $newDif; ?>
@endif
@if($reply->student_id == $discussion->student_id)
<div class="row margin-bottom-25">
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="avatar">
            @if( $discussion->lesson->module->course->instructor_id == $reply->student_id 
            || $discussion->lesson->module->course->assigned_instructor_id == $reply->student_id )
            <img src="{{ $discussion->student->commentPicture('Instructor') }}" alt="" class="img-responsive">
            @else
            <img src="{{ $discussion->student->commentPicture('Student') }}" alt="" class="img-responsive">
            @endif
        </div>
        <div class="replies-box">
            {{ $discussion->student->fullName() }}:
            <p class="regular-paragraph">{{ $reply->content }}</p>

            <span class="arrow-left"> </span>
        </div> 
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-md-offset-1 col-lg-offset-1 no-padding">
        <span class="message-time">{{ $reply->created_at->format('H:i') }}</span>
    </div>
</div>
@else
<div class="row margin-bottom-25">
    <div class="col-xs-10 col-sm-10 col-md-11 col-lg-11">

        <div class="student-reply">
            @if( $course->instructor_id == $reply->student_id || $course->assigned_instructor_id == $reply->student_id )
            <span class="name">{{ $reply->student->commentName('Instructor') }}</span>
            @else
            <span class="name">{{ $reply->student->fullName() }}</span>
            @endif
            :
            <p class="regular-paragraph">{{ $reply->content }}</p>

            <span class="arrow-right"> </span>
        </div> 

    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 no-padding">
        <span class="message-time">{{ $reply->created_at->format('H:i') }}</span>
        <div class="avatar">
            @if( $discussion->lesson->module->course->instructor_id == $reply->student_id 
            || $discussion->lesson->module->course->assigned_instructor_id == $reply->student_id )
                <img src="{{ $discussion->lesson->module->course->instructor->commentPicture('Instructor') }}" alt="" class="img-responsive">
            @else
                <img src="{{ $discussion->student->commentPicture('Student') }}" alt="" class="img-responsive">
            @endif
        </div>
    </div>
</div>
@endif