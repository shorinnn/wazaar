<div class="row">
        <div class="col-md-12">
        <div class="users-comments" id='convo'>
            <div class="clearfix">
                @foreach($comments as $comment)
                    {{ View::make('courses.classroom.conversations.conversation')->withComment( $comment ) }}
                @endforeach
                @if($comments == null || $comments->count()==0 )
                    Be the first to leave your comment (PLEASE USE LOCALIZATION MAX)
                @endif
            </div>
        </div>                        
    </div>
</div>