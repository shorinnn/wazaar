<div class="row comment-section clearfix comment-form">
    <div class="col-md-12">
        <div class="comment-box clearfix">
            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-1.png" 
                 class="img-circle img-responsive" alt="">
            {{ Form::open( [ 'action' => 'ConversationsController@store', 'class' => 'ajax-form', 'data-callback' =>'postedComment', 
                    'data-destination' => '#convo.users-comments > .clearfix', 'id' => 'add-comment-form'] ) }}
            <textarea name="content" class="form-control" placeholder="Share your thoughts"></textarea>
            <input type="hidden" name="lesson" value="{{ $lesson->id }}" />
            <input type="hidden" name="reply_to" class='reply-to' value="{{ $replyto or '' }}" />
            <br />
            <button type="submit" class="btn btn-primary">Comment</button>
            {{ Form::close() }}
        </div>
    </div>
</div>