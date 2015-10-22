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
			<div class="col-md-7 col-sm-12 col-xs-12">
				<h2><a href="{{action('CoursesController@adminShowCourse', [$course->slug])}}" class="wazaar-blue-text">{{$course->name}}</a></h2>
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
				<div class="clearfix"></div>
			</div>
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
					<a href="{{action('CoursesController@edit', [$course->slug, ''])}}" class="btn btn-block btn-info">{{ trans('administration.courses.label.edit' )}}</a>
				</div>
				<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
					@if($course->publish_status != 'approved')
						{{ Form::open( ['action' => array('SubmissionsController@update', $course->id), 
                                    'method' => 'PUT', 'id'=>'approve-form-'.$course->id, 'class' => 'ajax-form',
                                'data-callback' => 'updateSearchOrder'] ) }}
                            <input type="hidden" name="value" value="approved" />
                            <button type="submit" name='approve-course' data-message="{{ trans('administration.sure-approve') }}?" class="btn btn-block btn-success delete-button">{{ trans('administration.courses.label.approve' )}}</button>
                        {{ Form::close() }}
					@endif
				</div>
				<div class="col-md-12 col-sm-4 col-xs-4 action-btn-container">
					@if($course->publish_status != 'rejected')
						{{ Form::open( ['action' => array('SubmissionsController@update', $course->id), 
	                                'method' => 'PUT', 'id'=>'reject-form-'.$course->id, 'class' => 'ajax-form',
	                            'data-callback' => 'updateSearchOrder'] ) }}
	                        <input type="hidden" name="value" value="rejected" />	                        
	                        <div class="form-group">
	                        	<button class='btn btn-default btn-block slide-toggler' data-target='#reason-box-{{$course->id}}'>[Reason]</button>
	                        </div>

	                        <div id='reason-box-{{$course->id}}' style='display:none;'>
	                            @if($course->instructor != null)
	                                @if( $course->instructor->profile!=null)
	                                    <h3 class="text-center">{{ $course->instructor->profile->email }}</h3>
	                                @else
	                                    <h3 class="text-center">{{ $course->instructor->email }}</h3>
	                                @endif
	                            @endif
	                            <textarea id='reason-{{$course->id}}' name='reject_reason' style='background:white; height:100px'></textarea>
	                        </div>
	                        <button type="submit" name='reject_course' class="btn btn-block btn-danger delete-button" data-message="{{ trans('administration.sure-reject') }}?">{{ trans('administration.courses.label.disapprove' )}}</button>
	                    {{ Form::close() }}
					
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