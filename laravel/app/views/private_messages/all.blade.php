<div class="row">
    <div class="col-md-12">
        <div class="users-comments" id='ask-teacher'>
                <div class="clearfix">
                @foreach($comments as $comment)
                    {{ View::make('private_messages.conversation')->withMessage( $comment ) }}
                @endforeach
            </div>
        </div>                        
    </div>
</div>