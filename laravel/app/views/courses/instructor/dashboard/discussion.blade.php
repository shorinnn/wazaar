

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
                            <span class="close-tab right-bar-close" data-target=".full-messages"><i class="fa fa-times"></i></span>
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
<!--                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding">
                        	<span class="date"><em>Yesterday</em></span>                        
                        </div>-->
                        <?php 
                            $timeDif = new StdClass();
                            $timeDif->timeDif = '';
                        ?>
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 replies-holder">
                            @foreach($discussion->replies as $reply)
                                {{ View::make('courses.instructor.dashboard.reply')->with( compact( 'course', 'timeDif', 'discussion',  'reply' ) ) }}
                            @endforeach
                        </div>
                    </div>

<div class="row discussion-sidebar-footer-wrap">
    <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
        <div class="discussion-sidebar-footer clearfix">
            <div class="avatar">
                <img src="{{ $course->instructor->commentPicture('Instructor') }}" alt="" class="img-responsive">
            </div>
            {{ Form::open( ['action' => 'CoursesController@storeDiscussionReply', 'class'=>'ajax-form', 'data-callback'=>'addToList', 
                                'data-destination' => '.replies-holder'] ) }}
                <textarea name="content"  placeholder="{{ trans('conversations/general.classroom.write-your-answer')}}"></textarea>
                <input type="hidden" name="lesson_discussion_id" value="{{$discussion->id}}" />
                <button type="submit" class="submit-for-approval blue-button extra-large-button">{{ trans('conversations/general.classroom.post')}}</button>
                <input type="hidden" name="instructor-ui" value="1" />
            {{ Form::close() }}
        </div>  
    </div>
</div>