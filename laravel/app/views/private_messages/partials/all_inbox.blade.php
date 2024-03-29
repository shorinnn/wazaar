
<div class="row">
    <div class="col-md-12">
        <div class="users-comments" id='ask-teacher'>
            <div class="clearfix clearfix-inbox">
                @foreach($comments->reverse() as $comment)
                    {{ View::make('private_messages.conversation')->withMessage( $comment )->withStudent($student) }}
                @endforeach
            </div>
            
            @if( $comments->first()->type=='ask_teacher' )

                {{ View::make('private_messages.partials.ask_teacher_form')->withLesson( $comments->first()->lesson )->withStudent($student)
                            ->withDestination("#message-content-$id .users-comments > .clearfix-inbox")->withThread($comments->first()->thread()) }}

            @elseif( $comments->first()->type == 'student_conversation' )

                {{ View::make('private_messages.partials.student_form')->withDestination("#message-content-$id .users-comments > .clearfix-inbox")
                    ->withStudent($student)->withThread($comments->first()->thread())->withRecipient($comments->first()->sender_id) }}

            @endif
            
        <div class="text-center load-remote" data-target='#message-content-{{$id}} td' data-load-method="fade">
            {{$comments->links()}}
        </div>
        </div>                        
    </div>
</div>