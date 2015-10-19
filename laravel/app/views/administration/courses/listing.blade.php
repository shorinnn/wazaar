<div>
	@foreach($courses as $course)
	<div class="course-container">
		<div class="col-md-2 col-md-offset-0 col-sm-4 col-sm-offset-4 col-xs-12">photos</div>
		<div class="col-md-8 col-sm-12 col-xs-12">
			<h2>{{$course->name}}</h2>
			Category: {{$course->course_category}}<br />
			Subcategoru: {{$course->course_subcategory}}<br />
			Instructor: {{$course->instructor_name}}<br />
			Instructor Email: {{$course->instructor_email}}<br />
		</div>
		<div class="col-md-2 col-sm-12 col-xs-12">
			<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
				<button class="btn btn-block btn-info">edit</button>
			</div>
			<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
				<button class="btn btn-block btn-success">approve</button>
			</div>
			<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
				<button class="btn btn-block btn-danger">disapprove</button>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	@endforeach
</div>
<div class="container no-padding">
{{ $courses->links() }}
</div>