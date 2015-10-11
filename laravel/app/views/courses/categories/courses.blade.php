<div class="course-main-container">
    @foreach($courses as $course)
        {{ View::make('courses.course_box')->with( compact('course', 'wishlisted') ) }}
    @endforeach
    <div class="clearfix"></div>
</div>  
    <!-- @if($courses->count() % 3!=0)
    </div>
    @endif -->
<div class="container-fluid">
{{ $courses->appends(Input::only('sort','difficulty','filter'))->links() }}
</div>
@if(Request::ajax())
<script>
	makeFluid();
</script>
@endif