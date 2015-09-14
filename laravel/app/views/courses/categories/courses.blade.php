<div class="container">
	<div class='row cat-row-$category->color_scheme'>
    @foreach($courses as $course)
        {{ View::make('courses.course_box')->with( compact('course', 'wishlisted') ) }}
    @endforeach
    </div>
</div>  
    @if($courses->count() % 3!=0)
    </div>
    @endif
<div class="container no-padding">
{{ $courses->appends(Input::only('sort','difficulty'))->links() }}
</div>