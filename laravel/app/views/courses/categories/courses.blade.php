<div class="course-main-container">
	@if(count($courses) >= 1)
	    @foreach($courses as $course)
	        {{ View::make('courses.course_box')->with( compact('course', 'wishlisted') ) }}
	    @endforeach
	    <div class="clearfix"></div>
	@else

		@if(isset($search) && !empty($search))
			<div class="text-center">
				{{ trans('courses/general.no-search-result')}}
			</div>
		@else
			@if(isset($subcategory->name) && !empty($subcategory->name))
				<div class="text-center">
					{{ trans('courses/general.no-course', ['cat' => $subcategory->name] )}}<br />
					<a href="{{action('CoursesController@create')}}"> {{ trans('courses/general.teach-new-course', ['cat' => $subcategory->name] )}}</a><br /><br />
	                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/teach_small.jpg" class="img-responsive" style="margin:0px auto;" />
				</div>
			@else
				<div class="text-center">
					{{ trans('courses/general.no-course', ['cat' => $category->name] )}}<br />
					<a href="{{action('CoursesController@create')}}"> {{ trans('courses/general.teach-new-course', ['cat' => $category->name] )}}</a><br /><br />
	                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/teach_small.jpg" class="img-responsive" style="margin:0px auto;" />
				</div>
			@endif		
		@endif
	@endif
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
