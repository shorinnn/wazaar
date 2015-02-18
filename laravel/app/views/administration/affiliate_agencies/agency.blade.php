<li id='category-{{$agency->id}}'>
	<div class="input-wrapper">
    	<div>
            <input type="text" value="{{$agency->name}}" class='ajax-updatable block' 
                   data-url='{{action('AffiliateAgenciesController@update', $agency->id )}}' data-name='name' />
            
            @if( $agency->ltcAffiliates->count() == 0 )
                {{ Form::open(array('action' => ['AffiliateAgenciesController@update', $agency->id], 'method' => 'delete', 
                            'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#category-'.$agency->id )) }}
                        <button type="submit" name="delete-category-{{$agency->id}}" class="btn btn-danger btn-mini delete-button" 
                                data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
                {{ Form::close() }}
            @else
                <a href="{{ action('AffiliateAgenciesController@affiliates', $agency->id) }}" 
                   data-url="{{ action('AffiliateAgenciesController@affiliates', $agency->id) }}" 
                   data-target="#affiliates-list-{{ $agency->id }}" class="load-remote-cache">
                    {{ $agency->ltcAffiliates->count()}} {{ Lang::choice( 'general.affiliates', $agency->ltcAffiliates->count()) }}
                </a>
                <br /><br />
                <div><div id="affiliates-list-{{ $agency->id }}"></div></div>
            @endif

        </div>
    </div>

</li>