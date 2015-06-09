<div class="row">
        <div class="col-md-12">
        <div class="users-comments" id='convo'>
            <div class="clearfix">
                @foreach($comments as $comment)
                    {{ View::make('courses.classroom.conversations.conversation')->withComment( $comment ) }}
                @endforeach
                @if($comments == null || $comments->count()==0 )
                    <p class="leave-comment-first">{{ trans('courses/student_dash.leave-comments-first') }}</p>
                    <style>
                        .users-comments > div .leave-comment-first{
                            text-align: center;
                            color: #0099ff;
                            margin: 0;
                            font-size: 16px;
                        }
                    </style>
                @endif
            </div>
        </div>                        
    </div>
</div>