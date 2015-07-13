<div class="container members-area  ajax-content">
	<div class="row">
    	<div class="col-md-12 clearfix">
	        <div class="button-wrapper clearfix">
                <div class="submit-button">
                   
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    	<div class="col-md-12">
            <div class="table-wrapper table-responsive clear">
                <span class="table-title">
                     <div class="activate-dropdown">
                        <button aria-expanded="false" data-toggle="dropdown" 
                                class="btn btn-default dropdown-toggle" type="button" id="btnGroupDrop1">
                            {{ trans('crud/labels.view') }}
                        </button>
                        <ul id="table-header-dropdown"
                            data-target='.ajax-content' data-load-method="fade"
                            aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu  load-remote">
                            <?php
                                $per_page = [1, 2, 10, 20, 30, 40];
                            ?>
                            @foreach($per_page as $number)
                                <li>
                                    <a class="profile-button" href="?{{ appendToQueryString('view', $number ) }}">{{$number}}s</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>               
                </span>
                <table class="table table-bordered table-striped">
                    <tbody>
                        @foreach($submissions as $course)
                        <tr id='row-{{$course->id}}'>
                            <td class="hidden-xs">
                                 {{ $course->name}}
                                 @if($course->pre_submit_data!='')
                                     <hr />
                                     <b>Previous:</b><br />
                                    <?php
                                       $old = @json_decode($course->pre_submit_data);
                                    ?>
                                    {{ trans('courses/general.price') }}: {{$old->price}}¥ | 
                                    {{ trans('courses/general.affiliate_percentage') }}: {{$old->affiliate_percentage}}% |
                                    {{ trans('courses/general.discount') }}: {{$old->sale}}¥
                                 @endif
                            </td>
                            <td class="hidden-xs">
                                 {{ $course->instructor->commentName('instructor') }}
                            </td>
                            <td>
                                <a href="{{action('CoursesController@show', $course->slug)}}" target="_blank">
                                    {{ trans('crud/labels.view') }}
                                </a>
                                
                                <a href="{{action('CoursesController@edit', $course->slug)}}" target="_blank">
                                    {{ trans('crud/labels.edit') }}
                                </a>
                                @if($course->pre_submit_data!='')
                                    <a href="{{action('CoursesController@show', $course->slug)}}?view-old-version=1" target="_blank">
                                        {{ trans('crud/labels.view-old-version') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ Form::open( ['action' => array('SubmissionsController@update', $course->id), 
                                            'method' => 'PUT', 'id'=>'approve-form-'.$course->id, 'class' => 'ajax-form',
                                        'data-callback' => 'deleteItem', 'data-delete' => '#row-'.$course->id] ) }}
                                    <input type="hidden" name="value" value="approved" />
                                    <button type="submit" name='approve-course' class="btn btn-primary delete-button" 
                                            data-message="{{ trans('administration.sure-approve') }}?">{{ trans('administration.approve') }}</button>
                                {{ Form::close() }}
                            </td>
                            <td>
                            {{ Form::open( ['action' => array('SubmissionsController@update', $course->id), 
                                            'method' => 'PUT', 'id'=>'reject-form-'.$course->id, 'class' => 'ajax-form',
                                        'data-callback' => 'deleteItem', 'data-delete' => '#row-'.$course->id] ) }}
                                    <input type="hidden" name="value" value="rejected" />
                                    <button type="submit" name='reject-course'  class="btn btn-danger delete-button" 
                                            data-message="{{ trans('administration.sure-reject') }}?">{{ trans('administration.reject') }}</button>
                                {{ Form::close() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12 load-remote" data-target='.ajax-content' data-load-method="fade">
    		{{ $submissions->appends( ['view' => Input::get('view') ] )->links() }}
    	</div>
	</div>
</div>