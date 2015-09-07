<div class="container">
    
    @foreach($courses as $course)
    {{ cycle(["<div class='row cat-row-$category->color_scheme'>",'','']) }}
        {{ View::make('courses.course_box')->with( compact('course', 'wishlisted') ) }}
    {{ cycle(['','','</div>']) }}
    @endforeach
</div>  
    @if($courses->count() % 3!=0)
    </div>
    @endif
<div class="container">
{{ $courses->appends(Input::only('sort','difficulty'))->links() }}
</div>