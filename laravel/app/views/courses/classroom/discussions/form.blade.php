<div class='well'>
    <p class='blade-location'>courses.classroom.discussions.form</p>
    {{ Form::open( ['action' => 'DiscussionsController@store', 'class' =>'ajax-form', 'data-callback'=>'addToList', 
            'data-destination' => '.question-holder', 'data-prepend' => 'true'  ] ) }}
        <input type="text" name="title" class="form-control" placeholder="Your Question" />
        <input type="hidden" name="lesson_id" value="{{$lesson->id}}" />
        <button class="submit-for-approval blue-button extra-large-button">Post</button>
    {{ Form::close() }}
</div>