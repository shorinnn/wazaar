<div class="row">
        <div class="col-md-12">
        <div class="users-comments" id='convo'>
                <div class="clearfix">
                @foreach($comments as $comment)
                    {{ View::make('courses.classroom.conversations.conversation')->withComment( $comment ) }}
                @endforeach
            </div>
        </div>                        
    </div>
</div>