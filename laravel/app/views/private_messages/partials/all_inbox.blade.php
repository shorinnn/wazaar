@if( $comments->first()->type=='ask_teacher' )

    {{ View::make('private_messages.partials.ask_teacher_form')->withLesson( $comments->first()->lesson )
                ->withDestination("#message-content-$id .users-comments > .clearfix")->withThread($comments->first()->thread()) }}
                
@elseif( $comments->first()->type == 'student_conversation' )

    {{ View::make('private_messages.partials.student_form')->withDestination("#message-content-$id .users-comments > .clearfix")
                ->withThread($comments->first()->thread())->withRecipient($comments->first()->sender_id) }}
                
@endif
<div class="row">
    <div class="col-md-12">
        <div class="users-comments" id='ask-teacher'>
                <div class="clearfix">
                @foreach($comments as $comment)
                    {{ View::make('private_messages.conversation')->withMessage( $comment ) }}
                @endforeach
            </div>
        <div class="text-center load-remote" data-target='#message-content-{{$id}} td' data-load-method="fade">
            {{$comments->links()}}
        </div>
        </div>                        
    </div>
</div>