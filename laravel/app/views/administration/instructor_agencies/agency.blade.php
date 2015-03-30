<li id='category-{{$agency->id}}'>
	<div class="input-wrapper">
    	<div>
            <input type="text" value="{{$agency->username}}" class='ajax-updatable block' 
                   data-url='{{action('InstructorAgenciesController@update', $agency->id )}}' data-name='username' />
            
            @if( $agency->instructors->count() == 0 )
                {{ Form::open(array('action' => ['InstructorAgenciesController@update', $agency->id], 'method' => 'delete', 
                            'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#category-'.$agency->id )) }}
                        <button type="submit" name="delete-agency-{{$agency->id}}" class="btn btn-danger btn-mini delete-button" 
                                data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
                {{ Form::close() }}
            @else
                <a href="{{ action('InstructorAgenciesController@instructors', $agency->id) }}" 
                   data-url="{{ action('InstructorAgenciesController@instructors', $agency->id) }}" 
                   data-target="#affiliates-list-{{ $agency->id }}" class="load-remote-cache">
                    {{ $agency->instructors->count()}} {{ Lang::choice( 'general.instructors', $agency->instructors->count()) }}
                </a>
                <br /><br />
                <div><div id="affiliates-list-{{ $agency->id }}"></div></div>
            @endif
        </div>
    </div>

</li>