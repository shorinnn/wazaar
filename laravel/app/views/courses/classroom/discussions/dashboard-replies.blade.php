<!--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 no-padding">-->
<div class="no-padding" style='border-bottom:1px solid silver;'>
            	<div class="discussion-sidebar">
                    <div class="discussion-sidebar-header">
                    	<h2>{{ $discussion->title }}</h2>
                    </div>
                    <div class="questioner">
                    	<div class="questioner-info">
                            <div class="avatar">
                                @if( $discussion->lesson->module->course->instructor_id == $discussion->student_id 
                                    || $discussion->lesson->module->course->assigned_instructor_id == $discussion->student_id )
                                    <img src="{{ $discussion->student->commentPicture('Instructor') }}" alt="" class="img-responsive">
                                @else
                                    <img src="{{ $discussion->student->commentPicture('Student') }}" alt="" class="img-responsive">
                                @endif
                            </div>
                            @if( $discussion->lesson->module->course->instructor_id == $discussion->student_id 
                                    || $discussion->lesson->module->course->assigned_instructor_id == $discussion->student_id )
                                <span class="name block">{{ $discussion->student->commentName('Instructor')  }}</span>
                                <span class="role clearfix">{{ $discussion->student->commentTitle('Instructor') }}</span>
                            @else
                                <span class="name block">{{ $discussion->student->fullName() }}</span>
                               <span class="role clearfix">
                                    @if($discussion->student->profile !=null)
                                       {{ $discussion->student->profile->title }}
                                   @endif
                               </span>
                            @endif
                            <div class="question clear">
                                <p class="regular-paragraph">{{ $discussion->content }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="replies-holder scroll-pane" style='max-height: 500px; overflow-y: scroll'>
                        @foreach($discussion->replies()->orderBy('upvotes','desc')->orderBy('created_at','Desc')->get() as $reply)
                            {{ View::make('courses.classroom.discussions.reply')->with( compact('reply', 'course') ) }}
                        @endforeach
                    </div>

                    <div class="discussion-sidebar-footer" style='padding:20px; padding-bottom: 60px'>
                        <div class="avatar">
                            @if( $course->instructor_id == Auth::user()->id || $course->assigned_instructor_id == Auth::user()->id )
                                <img src="{{ Auth::user()->commentPicture('instructor') }}" alt="" class="img-responsive">
                            @else
                                <img src="{{ Auth::user()->commentPicture('student') }}" alt="" class="img-responsive">
                            @endif
                        </div>
                        
                        {{ Form::open( ['action' => 'DiscussionRepliesController@store', 'class'=>'ajax-form', 'data-callback'=>'addToList', 
                                    'data-destination' => '.replies-holder', 'data-prepend' => 'true' ] ) }}
                            <textarea name="content" class="form-control" placeholder="{{ trans('conversations/general.classroom.write-your-answer')}}"></textarea>
                            <input type="hidden" name="lesson_discussion_id" value="{{$discussion->id}}" />
                            <button class="submit-for-approval blue-button extra-large-button">{{ trans('conversations/general.classroom.post')}}</button>
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
