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
                            {{ trans('crud/labels.filter') }}
                        </button>
                        <ul id="table-header-dropdown"
                            data-target='.ajax-content' data-load-method="fade"
                            aria-labelledby="btnGroupDrop1" role="menu" class="dropdown-menu  load-remote">
                            <li>
                                <a class="profile-button" href="?{{ appendToQueryString('filter', 'all' ) }}">All</a>
                                <a class="profile-button" href="?{{ appendToQueryString('filter', 'approved' ) }}">Approved</a>
                                <a class="profile-button" href="?{{ appendToQueryString('filter', 'promo' ) }}">Has Promo Video</a>
                                <a class="profile-button" href="?{{ appendToQueryString('filter', 'video' ) }}">+5 min Video</a>
                            </li>
     
                        </ul>
                    </div>               
                     <div class="activate-dropdown" style='right:140px;'>
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
                                 ( {{ $course->videoMinutes }} Vid. Minutes )
                            
                                 <br />
                                 {{ $course->created_at }}
                            </td>
                            <td class="hidden-xs">
                                @if($course->instructor == null)
                                 Invalid Instructor # {{ $course->instructor_id }}
                                @else
                                 {{ $course->instructor->commentName('instructor') }}
                                @endif
                                <br />
                                {{ $course->instructor->email }}
                            </td>
                            <td>
                                <a href="{{action('CoursesController@show', $course->slug)}}" target="_blank">
                                    {{ trans('crud/labels.view') }}
                                </a>
                                
                                <a href="{{action('CoursesController@edit', $course->slug)}}" target="_blank">
                                    {{ trans('crud/labels.edit') }}
                                </a>
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