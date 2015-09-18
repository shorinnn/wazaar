<div class="row conversing-with">
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="avatar">
                                @if( $discussion->lesson->module->course->instructor_id == $discussion->student_id 
                                    || $discussion->lesson->module->course->assigned_instructor_id == $discussion->student_id )
                                    <img src="{{ $discussion->student->commentPicture('Instructor') }}" alt="" class="img-responsive">
                                @else
                                    <img src="{{ $discussion->student->commentPicture('Student') }}" alt="" class="img-responsive">
                                @endif
                            </div>
                            <p class="regular-paragraph"><span class="name">{{ $discussion->student->fullName() }}</span>
                            @if( $discussion->student->commentTitle("Student") !='' )
                            , {{ $discussion->student->commentTitle("Student") }}</p>      
                            @endif
                        </div>
                    </div>
                    
                    <div class="row conversation">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                        	<span class="date"><em>{{$discussion->created_at->diffForHumans() }}</em></span>                        
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row margin-bottom-25">
                            	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                    <div class="avatar">
                                        @if( $discussion->lesson->module->course->instructor_id == $discussion->student_id 
                                            || $discussion->lesson->module->course->assigned_instructor_id == $discussion->student_id )
                                            <img src="{{ $discussion->student->commentPicture('Instructor') }}" alt="" class="img-responsive">
                                        @else
                                            <img src="{{ $discussion->student->commentPicture('Student') }}" alt="" class="img-responsive">
                                        @endif
                                    </div>
                                    <div class="replies-box">
                                        {{ $discussion->student->fullName() }}:
                                        <p class="regular-paragraph" style='font-weight: bold'>{{ $discussion->title }}</p>
                                        <p class="regular-paragraph">{{ $discussion->content }}</p>
                                        
                                        <span class="arrow-left"> </span>
                                    </div> 
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-md-offset-1 col-lg-offset-1 no-padding">
                                	<span class="message-time">{{ $discussion->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- hurr -->
<!--                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                        	<span class="date"><em>Yesterday</em></span>                        
                        </div>-->
                        <?php $timeDif = '';?>
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @foreach($discussion->replies as $reply)
                            <?php 
                                $newDif = $reply->created_at->diffForHumans();
                                if( time() - strtotime( $reply->created_at ) < 60*60*24 ){
                                    if($reply->created_at->format('d') == date('d') ) $newDif = trans('general.today');
                                    else $newDif = trans('general.yesterday');
                                }
                            ?>
                                @if( $newDif != $timeDif )
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                                            <span class="date"><em>{{  $newDif }}</em></span>                        
                                    </div>
                                    <?php $timeDif =  $newDif;?>
                                @endif
                                @if($reply->student_id == $discussion->student_id)
                                    <div class="row margin-bottom-25">
                                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                                            <div class="avatar">
                                                @if( $discussion->lesson->module->course->instructor_id == $discussion->student_id 
                                                    || $discussion->lesson->module->course->assigned_instructor_id == $discussion->student_id )
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
                                                        <div class="role teacher">Teacher</div>
                                                @else
                                                    <span class="name">{{ $reply->student->fullName() }}</span>
                                                @endif:
                                                <p class="regular-paragraph">{{ $reply->content }}</p>

                                                <span class="arrow-right"> </span>
                                            </div> 
                                            
                                        </div>
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 no-padding">
                                            <span class="message-time">{{ $reply->created_at->format('H:i') }}</span>
                                            <div class="avatar">
                                                @if( $discussion->lesson->module->course->instructor_id == $discussion->student_id 
                                                    || $discussion->lesson->module->course->assigned_instructor_id == $discussion->student_id )
                                                    <img src="{{ $discussion->student->commentPicture('Instructor') }}" alt="" class="img-responsive">
                                                @else
                                                    <img src="{{ $discussion->student->commentPicture('Student') }}" alt="" class="img-responsive">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <!-- hurr -->
<?php /*

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
<!--        <img class="img-responsive img-circle" alt="" 
             src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">-->
            @if( $comment->poster && $comment->poster->profile )
                <img style="height: 50px; width: 50px; border-radius: 50px;"  class="img-circle img-responsive"
                     src="{{cloudfrontUrl( $comment->poster->profile->photo ) }}" alt="">
            @else
                <img style="height: 50px; width: 50px; border-radius: 50px;"  class="img-circle img-responsive"
                     src="{{cloudfrontUrl('//s3-ap-northeast-1.amazonaws.com/profile_pictures/avatar-placeholder.jpg')}}" alt="">
            @endif
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
 * 
 */