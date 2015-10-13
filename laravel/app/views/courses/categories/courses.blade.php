<div class="course-main-container">
	@if(count($courses) >= 1)
	    @foreach($courses as $course)
	        {{ View::make('courses.course_box')->with( compact('course', 'wishlisted') ) }}
	    @endforeach
	    <div class="clearfix"></div>
	@else
		<div class="no-results-container">
			@if(isset($search) && !empty($search))
				<div class="text-center light-gray-text">
					{{ trans('courses/general.no-search-result')}}
				</div>
			@else
				@if(isset($subcategory->name) && !empty($subcategory->name) && !empty($subcategory))
					<div class="text-center">
						<div class="light-gray-text">{{ trans('courses/general.no-course', ['cat' => $subcategory->name] )}}</div>
						<a class="blue-link" href="{{action('CoursesController@create')}}"> {{ trans('courses/general.teach-new-course', ['cat' => $subcategory->name] )}}</a>
						<div class="teach-img-container">
		                	<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/teach_small.jpg" class="img-responsive" />
		                </div>
					</div>
				@else
					<div class="text-center">
						{{ trans('courses/general.no-course', ['cat' => $category->name] )}}<br />
						<a href="{{action('CoursesController@create')}}"> {{ trans('courses/general.teach-new-course', ['cat' => $category->name] )}}</a><br /><br />
		                <img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/misc-images/teach_small.jpg" class="img-responsive" style="margin:0px auto;" />
					</div>
				@endif		
			@endif
		</div>
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
	setTimeout(function(){
		makeFluid();
	}, 1000);
</script>
@endif
