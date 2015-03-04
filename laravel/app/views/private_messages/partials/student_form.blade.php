<div class="row comment-section clearfix comment-form">
    <div class="col-md-12">
        @if( isset($new) )
            PM for {{ Student::find($recipient)->commentName('student') }}
        @endif
        <div class="comment-box clearfix">
            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-1.png" 
                 class="img-circle img-responsive" alt="">

            @if( isset($new) )
                {{ Form::open( [ 'action' => 'PrivateMessagesController@store', 'class' => 'ajax-form', 'data-callback' =>'postedStudentPM', 
                    'id' => 'start-pm-form'] ) }}
                    
            @else
                {{ Form::open( [ 'action' => 'PrivateMessagesController@store', 'class' => 'ajax-form', 'data-callback' =>'postedComment', 
                        'data-destination' => $destination, 'id' => 'ask-comment-form'] ) }}
            @endif

            <textarea name="content" class="form-control" placeholder="What's on your mind?"></textarea>
            @if( isset($thread) )
                <input type="hidden" name="thread_id" value="{{ $thread }}" />
            @endif                
            <input type="hidden" name="type" value="student_conversation" />
            <input type="hidden" name="recipient_id" value="{{$recipient}}" />
            
            <br />
            <button type="submit" class="btn btn-primary">Comment</button>
            {{ Form::close() }}
        </div>
    </div>
</div>