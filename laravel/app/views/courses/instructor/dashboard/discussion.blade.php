<div class="question-answer-wrap">
    <div class="row question-answer">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row question no-margin">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="avatar">
                        @if( $discussion->lesson->module->course->instructor_id == $discussion->student_id
                            || $discussion->lesson->module->course->assigned_instructor_id == $discussion->student_id )
                            <img src="{{ $discussion->student->commentPicture('Instructor') }}" alt="" class="img-responsive">
                        @else
                            <img src="{{ $discussion->student->commentPicture('Student') }}" alt="" class="img-responsive">
                        @endif
                    </div>
                    <div class="replies-box">
                        <div class="clearfix">
                            <span class="name">{{ $discussion->student->fullName() }} <em class="lead"> asks</em></span>
                            <span class="date">{{$discussion->created_at->diffForHumans() }}</span>
                        </div>
                        <h2>{{ $discussion->title }}</h2>
                        <p class="reply">{{ $discussion->content }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
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
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
</div>

</div>



