{{ View::make('courses.classroom.conversations.all')->withComments( $lesson->comments ) }}
<br />
<div class="text-center load-remote" data-target='.ajax-content'>
    {{ $lesson->comments->links() }}
</div>
</div>
