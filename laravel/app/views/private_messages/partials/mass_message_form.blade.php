<div class="row comment-section clearfix comment-form">
    <div class="col-md-12">
        <div class="comment-box clearfix">
            <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-1.png" 
                 class="img-circle img-responsive" alt="">

                {{ Form::open( [ 'action' => 'PrivateMessagesController@store', 'class' => 'ajax-form', 'data-callback' =>'postedComment', 
                        'data-destination' => $destination, 'id' => 'ask-comment-form'] ) }}

            <textarea name="content" class="form-control" placeholder="What's on your mind?"></textarea>
             
            <input type="hidden" name="type" value="mass_message" />
            <input type="hidden" name="course_id" value="{{$course->id}}" />
            <br />
            <button type="submit" class="btn btn-primary">Comment</button>
            {{ Form::close() }}
        </div>
    </div>
</div>