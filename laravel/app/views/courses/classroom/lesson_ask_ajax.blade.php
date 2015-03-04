{{ View::make('private_messages.all')->withComments( $lesson->ask_teacher_messages ) }}
<br />
<div class="text-center load-remote" data-target='.ask-content' data-load-method="fade">
    {{ $lesson->ask_teacher_messages->appends( [ 'ask' => 1 ] )->links() }}
</div>
</div>