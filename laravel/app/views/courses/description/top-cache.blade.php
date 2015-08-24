<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 column-1">
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
        <em>{{ $course->reviews_positive_score }}%</em>

    </div>
    <div class="difficulty-level">
        <span>{{ trans("general.difficulty") }}</span>
        <em> {{ trans('general.'.$course->courseDifficulty->name) }}</em>

    </div>
</div>