<!--<p class='blade-location'>courses.classroom.discussions.replies</p>-->
<div class='replies-holder'>
    @foreach($discussion->replies()->orderBy('created_at','Desc')->orderBy('upvotes','desc')->get() as $reply)
        {{ View::make('courses.classroom.discussions.reply')->with( compact('reply') ) }}
    @endforeach
</div>
<br />
{{ Form::open( ['action' => 'DiscussionRepliesController@store', 'class'=>'ajax-form', 'data-callback'=>'addToList', 
            'data-destination' => '.replies-holder', 'data-prepend' => 'true' ] ) }}
    <textarea name="content" class="form-control" placeholder="Your Reply"></textarea>
    <input type="hidden" name="lesson_discussion_id" value="{{$discussion->id}}" />
    <button class="submit-for-approval blue-button extra-large-button">Post</button>
{{ Form::close() }}
