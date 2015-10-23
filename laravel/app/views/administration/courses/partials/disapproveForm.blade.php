{{ Form::open( ['action' => array('SubmissionsController@update', $course_id), 'method' => 'PUT', 'id'=>'reject-form-'.$course_id, 'class' => 'ajax-form', 'data-callback' => 'closeModalAndUpdateSearchOrder'] ) }}
	<p>{{ trans('administration.courses.what-reason-for-disapproval' )}}</p>
	<input type="hidden" name="value" value="rejected" />	                        
	<textarea name='reject_reason'></textarea>
<button type="submit" name='reject_course' class="btn btn-block btn-danger delete-button" data-message="{{ trans('administration.sure-reject') }}?">{{ trans('administration.courses.label.disapprove' )}}</button>
{{ Form::close() }}