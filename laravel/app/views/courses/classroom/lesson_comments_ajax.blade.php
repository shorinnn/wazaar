{{ View::make('courses.classroom.conversations.all')->withComments( $lesson->comments ) }}
<br />
<div class="text-center load-remote" data-target='.ajax-content' data-load-method="fade">
    {{ $lesson->comments->links() }}
</div>
<!--</div>-->
