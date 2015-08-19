{{ $courses->appends(Input::only('sort','difficulty'))->links() }}
<div class="container load-remote">
    @foreach($courses as $course)
    {{ cycle(["<div class='row cat-row-$category->color_scheme'>",'','']) }}
    {{ View::make('courses.course_box')->with(compact('course')) }}
    {{ cycle(['','','</div>']) }}
    @endforeach
</div>
@if($courses->count() % 3!=0)
</div>
@endif
{{ $courses->appends(Input::only('sort','difficulty'))->links() }}