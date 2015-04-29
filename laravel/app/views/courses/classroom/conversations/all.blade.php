<div class="row">
        <div class="col-md-12">
        <div class="users-comments" id='convo'>
                <div class="clearfix">
                @foreach($comments as $comment)
                    {{ View::make('courses.classroom.conversations.conversation')->withComment( $comment ) }}
                @endforeach
                <p class="leave-comment-first">Be the first to leave your comment!</p>
                <style>
					.users-comments > div .leave-comment-first{
						text-align: center;
						color: #0099ff;
						margin: 0;
						font-size: 16px;
					}
				</style>
            </div>
        </div>                        
    </div>
</div>