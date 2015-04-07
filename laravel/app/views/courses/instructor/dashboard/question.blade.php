<div class="comment clearfix clear question-{{ $question->id }}" id="question-{{$question->id}}" style="border:1px solid silver; padding:20px">
    <div class="info clearfix clear">
        <h5>{{trans('conversations/general.lesson') }}: {{ $question->lesson->name }}</h5>
        
        <span class="name"> 
            {{ $question->sender->commentName('student') }}
        </span>
        
        
        <span class="time-of-reply">{{ $question->created_at->diffForHumans() }}</span>
    </div>
    <div class="main clearfix clear">
        <img class="img-responsive img-circle" alt="" 
             src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/avaters/comment-avater-2.png">
        <span>
            {{{ $question->content }}}
            <br />
            <a target='_blank' 
               href='{{ action('PrivateMessagesController@index') }}?page={{ $question->inboxPage() }}'>
                <i class="fa fa-external-link"></i>
                {{trans('conversations/general.view-in-inbox') }}</a> 
            <br />
        </span>
    </div>
    <form method="post" action="{{ action('CoursesController@markResolved') }}" class="ajax-form" data-callback="deleteItem" 
          data-delete="#question-{{$question->id}}">
        <button type="submit" class="btn btn-primary">{{trans('conversations/general.mark-as-resolved') }}</button>
        <input type="hidden" name="id" value="{{$question->id}}" />
        <input type="hidden" name="type" value="question" />
    </form>
    
    <button class="btn btn-primary show-reply-form" data-type='question' data-id='{{$question->id}}'
            data-delete='#question-{{$question->id}}'
            >{{trans('conversations/general.Reply') }}</button>
</div>