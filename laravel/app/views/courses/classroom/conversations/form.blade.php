<div class="row comment-section clearfix comment-form">
    <div class="col-md-12">
        <div class="comment-box clearfix">
<!--            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-1.png" 
                 class="img-circle img-responsive" alt="">-->
            
            @if( $student && $student->profile )
                <img class="img-circle img-responsive"
                     src="{{cloudfrontUrl( Student::find(Auth::user()->id)->profile->photo ) }}" alt="">
               
            @else
                <img class="img-circle img-responsive"
                     src="{{cloudfrontUrl('//s3-ap-northeast-1.amazonaws.com/profile_pictures/avatar-placeholder.jpg')}}" alt="">
            @endif
            {{ Form::open( [ 'action' => 'ConversationsController@store', 'class' => 'ajax-form', 'data-callback' =>'postedComment', 
                    'data-destination' => '#convo.users-comments > .clearfix', 'id' => 'add-comment-form'] ) }}
            <textarea name="content" class="form-control" placeholder="{{ trans('courses/student_dash.say-something') }}"></textarea>
            @if( isset($lesson) )
                <input type="hidden" name="lesson" value="{{ $lesson->id }}" />
            @else
                <input type="hidden" name="course" value="{{ $course->id }}" />
            @endif
            <input type="hidden" name="reply_to" class='reply-to' value="{{ $replyto or '' }}" />
            <br />
            <button type="submit" class="btn btn-primary">{{ trans('courses/student_dash.comment') }}</button>
            {{ Form::close() }}
        </div>
    </div>
</div>