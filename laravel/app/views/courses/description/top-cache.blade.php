<div class="column-1">
    <div class="number-of-lessons">
        <span>{{ trans("general.lessons") }}</span>
        <em>{{ $course->lessonCount(false) }}</em>

    </div>
    <div class="number-of-students">
        <span>{{Lang::choice('general.student_count', $course->student_count)}}</span>
        <em>{{ $course->student_count }} </em>

    </div>
    <div class="number-of-videos">
        <span>{{ trans("general.time") }}</span>
        <em>{{ $course->videoDuration() }}</em>

    </div>
    <div class="recommends">
        <span>{{ trans("general.recommends") }}</span>
        @if ($course->total_review == 0)
            <em>{{trans('general.na')}}</em>
        @else
            <em>{{ $course->reviews_positive_score }}%</em>
        @endif

    </div>
    <div class="difficulty-level">
        <span>{{ trans("general.difficulty") }}</span>
        <em> {{ trans('general.'.$course->courseDifficulty->name) }}</em>

    </div>
</div>