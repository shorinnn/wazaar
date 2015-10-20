<div>
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
			Category: {{$course->course_category}}<br />
			Subcategoru: {{$course->course_subcategory}}<br />
			@if($course->free == 'no')
				Price: ¥ {{number_format($course->price)}}<br />
			@else
				Price: Free<br />
			@endif
			Lesson Duration: {{$course->videoDuration()}}<br />
			Instructor: {{$course->instructor_name}}<br />
			Instructor Email: {{$course->instructor_email}}<br />
			Date Submitted: {{$course->created_at->format('M d, Y h:i A \\(l\\)')}}<br />
			Date Revenue: ¥ {{number_format($course->total_revenue)}}<br />
		</div>
		<div class="col-md-2 col-sm-12 col-xs-12">
			<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
				<button class="btn btn-block btn-info">edit</button>
			</div>
			<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
				@if($course->publish_status != 'approved')
				<button class="btn btn-block btn-success">approve</button>
				@endif
			</div>
			<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
				@if($course->publish_status == 'pending')
				<button class="btn btn-block btn-danger">disapprove</button>
				@endif
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	@endforeach
</div>
<div class="container no-padding">
{{ $courses->appends(Input::only('search','price','course_category','course_sub_category','sale_amount_low','sale_amount_high','filter'))->links() }}
</div>