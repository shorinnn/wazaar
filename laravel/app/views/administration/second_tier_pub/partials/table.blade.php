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
                    </div>               
                </span>
                <table class="table table-bordered table-striped">
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td class="hidden-xs">
                                {{$member->email}}
                                <a href="{{ action('MembersController@show',$member->id ) }}">View</a>
                            </td>
                            <td>
                            	{{ $member->firstName() }}, {{ $member->lastName() }}
                            </td>
                            <td class="hidden-xs">
                                {{ date('d-m-Y', strtotime( $member->created_at ) ) }}
                            </td>
                            <td class="delete">
                                <div class="buttons publish">
                                    <div class="switch-buttons">
                                        <label class="switch">
                                          <input type="checkbox" class="switch-input ajax-updatable"  
                                                 value='Yes'
                                                 data-checked-val='Yes' data-unchecked-val='No'
                                                 data-url='{{action('SecondTierPublishersController@update', $member->id )}}'
                                                 data-name='sti_approved' name="sti_approved"
                                                 @if($member->sti_approved=='yes')
                                                     checked="checked"
                                                 @endif
                                                 />
                                          <span data-off="{{ trans('courses/curriculum.no') }}" data-on="{{ trans('courses/curriculum.yes') }}" class="switch-label"></span>
                                          <span class="switch-handle"></span>
                                        </label>
                                    </div>
                                </div>
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
    		{{ $members->links() }}
    	</div>
	</div>
</div>