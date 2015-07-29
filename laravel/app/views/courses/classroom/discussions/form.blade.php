<div class="ask-question">
    <div class="img-container">
        <img src="{{Auth::user()->commentPicture('student')}}" alt="" class="img-responsive">
    </div>
    <span>Ask a question</span>
    <br /><br />
    {{ Form::open( ['action' => 'DiscussionsController@store', 'class' =>'ajax-form', 'data-callback'=>'addToList', 
            'data-destination' => '.question-holder', 'data-prepend' => 'true'  ] ) }}
        <textarea name="title" class="form-control" placeholder="Your Question"></textarea>
        <input type="hidden" name="lesson_id" value="{{$lesson->id}}" />
        <center>
            <button class="submit-for-approval blue-button extra-large-button">Post</button>
        </center>
    {{ Form::close() }}
</div>