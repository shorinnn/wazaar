<div>
	@if(count($courses) >= 1)
		@foreach($courses as $course)
		<div class="course-container">
			<div class="col-md-2 col-md-offset-0 col-sm-4 col-sm-offset-4 col-xs-12">
				@if(isset($course->previewImage->url) && !empty($course->previewImage->url))
				<img src="{{$course->previewImage->url}}" class="img-responsive" />
				@else
				<img src="{{ url('splash/logo.png') }}" class="img-responsive" />
				@endif
			</div>
			<div class="col-md-8 col-sm-12 col-xs-12">
				<h2>{{$course->name}}</h2>
				<label>{{ trans('administration.courses.label.category' )}}</label>: {{$course->course_category}}<br />
				<label>{{ trans('administration.courses.label.subcategory' )}}</label>: {{$course->course_subcategory}}<br />
				@if($course->free == 'no')
					<label>{{ trans('administration.courses.label.price' )}}</label>: ¥ {{number_format($course->price)}}<br />
				@else
					<label>{{ trans('administration.courses.label.price' )}}</label>: {{ trans('administration.courses.label.free' )}}<br />
				@endif
				<label>{{ trans('administration.courses.label.lesson_duration' )}}</label>: {{$course->videoDuration()}}<br />
				<label>{{ trans('administration.courses.label.instructor' )}}</label>: {{$course->instructor_name}}<br />
				<label>{{ trans('administration.courses.label.instructor_email' )}}</label>: {{$course->instructor_email}}<br />
				<label>{{ trans('administration.courses.label.date_submitted' )}}</label>: {{$course->created_at->format('M d, Y h:i A \\(l\\)')}}<br />
				<label>{{ trans('administration.courses.label.revenue' )}}</label>: ¥ {{number_format($course->total_revenue)}}<br />
			</div>
			<div class="col-md-2 col-sm-12 col-xs-12">
				<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
					<a href="{{action('CoursesController@edit', [$course->slug, ''])}}" class="btn btn-block btn-info">{{ trans('administration.courses.label.edit' )}}</a>
				</div>
				<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
					@if($course->publish_status != 'approved')
					<button class="btn btn-block btn-success">{{ trans('administration.courses.label.approve' )}}</button>
					@endif
				</div>
				<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
					@if($course->publish_status != 'rejected')
					<button class="btn btn-block btn-danger">{{ trans('administration.courses.label.disapprove' )}}</button>
					@endif
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		@endforeach
	@else
		<p class="text-center">No Course Found</p>
	@endif
</div>
<div class="container no-padding">
{{ $courses->appends(Input::only('search','price','course_category','course_sub_category','sale_amount_low','sale_amount_high','filter', 'sort_data'))->links() }}
</div>