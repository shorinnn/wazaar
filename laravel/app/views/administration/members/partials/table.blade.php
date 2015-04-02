<div class="container members-area  ajax-content">
	<div class="row">
    	<div class="col-md-12 clearfix">
	        <div class="button-wrapper clearfix">
                <div class="submit-button">
                    <a href="?{{ $url_filters['student'] }}" class="submit submit-button-2 load-remote
                       @if(Input::get('type')=='student')
                       .submit-button-active
                       @endif
                       "
                       data-url="?{{ $url_filters['student'] }}" data-target='.ajax-content' data-load-method="fade">{{trans('administration.students')}}</a>
                    
                    <a href="?{{ $url_filters['instructor'] }}" class="submit submit-button-2 load-remote
                       @if(Input::get('type')=='instructor')
                       .submit-button-active
                       @endif
                       "
                       data-url="?{{ $url_filters['instructor'] }}"data-target='.ajax-content' data-load-method="fade">{{trans('administration.teachers')}}</a>
                    
                    <a href="?{{ $url_filters['affiliate'] }}" class="submit submit-button-2 load-remote
                       @if(Input::get('type')=='affiliate')
                       .submit-button-active
                       @endif
                       "
                       data-url="?{{ $url_filters['affiliate'] }}" data-target='.ajax-content' data-load-method="fade">{{trans('administration.affiliates')}}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
            <div class="member-search-box clearfix clear">
                <form method="get" action="{{ action( 'MembersController@index' ) }}" class="form-to-remote-link"
                       data-target='.ajax-content' data-load-method="fade">
                    <input type="search" name="search" placeholder="{{trans('administration.search-for-user')}}" value="{{Input::get('search')}}" />
                    <button>{{trans('administration.search')}}</button>
                </form>
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
                        @foreach($members as $member)
                        <tr>
                            <td class="hidden-xs">
                            {{$member->email}}
                            </td>
                            <td>
                            	{{ $member->firstName() }}, {{ $member->lastName() }}
                            </td>
                            <td class="hidden-xs">
                                @foreach($member->roles as $role)
                                    <span class="label label-info">{{$role->name}}</span>
                                @endforeach
                            </td>
                            <td class="view">
                                    <a href="{{ action('MembersController@show', $member->id) }}">
                                    	<i class="fa fa-eye fa-4"></i>
                                    	<span>{{ trans('crud/labels.view') }}</span>
                                    </a>
                                <!--<span class="icon-container visible-xs">
                                	{{link_to_action('MembersController@show', trans('crud/labels.view'), $member->id)}}
                                    <img class="img-responsive" src="" alt="">
                                </span>-->
                            </td>
                            <td class="edit">
                            	<a href="{{ action('MembersController@edit', $member->id) }}">
                                	<i class="fa fa-pencil-square-o fa-4"></i>
                                	<span>{{trans('crud/labels.edit')}}</span>
                                </a>
                            </td>
                            <td class="delete">
                                {{ Form::open(array('action' => array('MembersController@destroy', $member->id), 'method' => 'delete', 'id'=>'member-form-'.$member->id)) }}
                                <button class="btn btn-danger delete-button" data-message="Are you sure you want to delete? (msg coming from btn)"
                                type="submit">
                                	<i class="fa fa-trash fa-4"></i>
                                	<span>{{trans('crud/labels.delete')}}</span>
                                </button>
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
    		{{ $members->appends( ['view' => Input::get('view'), 'type' => Input::get('type') ] )->links() }}
    	</div>
	</div>
</div>