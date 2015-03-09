{{ View::make('courses.classroom.conversations.all')->withComments( $course->comments ) }}
<br />
<div class="text-center load-remote" data-target='.ajax-content' data-load-method="fade">
    {{ $course->comments->links() }}
</div>